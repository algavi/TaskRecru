<?php
declare(strict_types=1);

namespace App\Process\Api;

use App\Exception\ApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GetAllJobsProcess {

	private string $cacheKey = "recruitis_jobs_payload";
	private string $endpoint = 'https://app.recruitis.io/api2/jobs';
	private string $token = '89d985c4b1c25c26fe3b1595b4ef3137a0ebb549.11169.dd37716503850db285a143eeef3dd663';

	public function __construct(
		private readonly ClientInterface $httpClient,
		private readonly LoggerInterface $logger,
		private readonly CacheInterface  $cache,
	) {
	}

	public function run(): array {
		try {
			return $this->cache->get($this->cacheKey, function (ItemInterface $item) {
				$item->expiresAfter(600); // 10 minuut
				$response = $this->httpClient->request('GET', $this->endpoint, [
					'headers' => [
						'Authorization' => 'Bearer ' . $this->token,
						'Accept'        => 'application/json',
						'Content-Type'  => 'application/json',
						'User-Agent'    => 'MyApp/1.0',
					],
				]);
				$data = json_decode($response->getBody()->getContents(), true);

				if (!isset($data['payload'])) {
					throw new \RuntimeException('Odpověď nemá očekávanou strukturu.');
				}

				return $data['payload'];
			});
		} catch (GuzzleException $e) {
			$this->logger->error('Chyba při volání Recruitis API: ' . $e->getMessage());
			throw new ApiException("Chyba při volání Recruitis AP");
		}
	}
}