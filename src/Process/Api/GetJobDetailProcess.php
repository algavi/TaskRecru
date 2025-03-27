<?php
declare(strict_types=1);

namespace App\Process\Api;

use App\Exception\ApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class GetJobDetailProcess {

	private string $baseEndpoint = 'https://app.recruitis.io/api2/jobs/';
	private string $token = '89d985c4b1c25c26fe3b1595b4ef3137a0ebb549.11169.dd37716503850db285a143eeef3dd663';

	public function __construct(
		private ClientInterface $httpClient,
		private LoggerInterface $logger
	) {
	}

	/**
	 * Načte detail pracovní nabídky podle ID z externího API.
	 *
	 * @throws \App\Exception\ApiException Pokud dojde k chybě při volání API
	 */
	public function run(int $jobId) : array{
		$url = sprintf('%s/%s', $this->baseEndpoint, urlencode((string)$jobId));

		try {
			$response = $this->httpClient->request('GET', $url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $this->token,
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json',
					'User-Agent'    => 'MyApp/1.0',
				],
			]);

			$body = (string)$response->getBody();
			$data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

			if (!isset($data['payload'])) {
				throw new ApiException('Odpověď z API neobsahuje očekávaný formát.');
			}

			return $data["payload"];
		} catch (GuzzleException $e) {
			$this->logger->error('Chyba při volání Recruitis API: ' . $e->getMessage(), [
				'url' => $url,
				'id' => $jobId,
			]);
			throw new ApiException("Chyba při volání Recruitis AP");
		}
	}
}