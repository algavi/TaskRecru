<?php
declare(strict_types=1);

namespace App\Process\Api;

use App\Exception\ApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class CreateAnswerProcess {

	private string $createCandidateEndpoint = 'https://app.recruitis.io/api2/answers';
	private string $token = '89d985c4b1c25c26fe3b1595b4ef3137a0ebb549.11169.dd37716503850db285a143eeef3dd663';

	public function __construct(
		private ClientInterface $httpClient,
		private LoggerInterface $logger
	) {
	}

	/**
	 * Odešle data pro vytvoření kandidáta do Recruitis API.
	 *
	 * @throws \App\Exception\ApiException
	 */
	public function run(array $answerData, int $jobId): array {
		$payload = [
			'job_id'            => $jobId, // Zde případně dynamicky nastavit podle kontextu
			'name'              => $answerData['name'] ?? '',
			'email'             => $answerData['email'] ?? null,
			'skype'             => null,
			'linkedin'          => null,
			'facebook'          => null,
			'twitter'           => null,
			'phone'             => $answerData['phone'] ?? '',
			// Uchováváme poznámku jako položku v poli "extra" se strukturou, která se uloží jako poznámka uchazeče
			'extra'             => [
				[
					'note' => $answerData['poznamka'] ?? '',
				],
			],
			'send_notification' => false,
		];

		try {
			$response = $this->httpClient->request('POST', $this->createCandidateEndpoint, [
				'headers' => [
					'Authorization' => 'Bearer ' . $this->token,
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json',
					'User-Agent'    => 'MyApp/1.0',
				],
				'json'    => $payload,
			]);

			$body = (string)$response->getBody();
			$data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);


			if (!isset($data['payload'])) {
				throw new ApiException('Odpověď z API neobsahuje očekávaný "payload".');
			}

			return $data['payload'];
		} catch (GuzzleException $e) {
			$this->logger->error('Chyba při volání Recruitis API: ' . $e->getMessage(), [
				'answerData' => $answerData,
			]);
			throw new ApiException("Chyba při volání Recruitis API: " . $e->getMessage());
		}
	}
}
