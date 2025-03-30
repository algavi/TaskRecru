<?php
declare(strict_types=1);

namespace App\Tests\Process\Api;

use App\Exception\ApiException;
use App\Kernel;
use App\Process\Api\GetAllJobsProcess;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetAllJobsProcessTest extends KernelTestCase
{
	/**
	 * @dataProvider provideTokens
	 */
	public function testRunWithTokens(string $token, bool $expectSuccess): void
	{
		self::bootKernel();
		$container = static::getContainer();

		/** @var GetAllJobsProcess $process */
		$process = $container->get(GetAllJobsProcess::class);
		$refObject = new \ReflectionObject($process);
		$tokenProp = $refObject->getProperty('token');
		$tokenProp->setAccessible(true);
		$tokenProp->setValue($process, $token);

		if (!$expectSuccess) {
			$this->expectException(ApiException::class);
		}

		$result = $process->run();

		if ($expectSuccess) {
			$this->assertIsArray($result, 'Výsledek by měl být pole.');
			$this->assertNotEmpty($result, 'Mělo by to obsahovat alespoň jeden inzerát.');
		}
	}

	protected static function getKernelClass(): string
	{
		return Kernel::class;
	}

	/**
	 * Poskytne data pro vícenásobný test – např. platný vs. neplatný token.
	 */
	public function provideTokens(): array
	{
		return [
			'valid-token' => [
				$_ENV['RECRUITIS_TOKEN_VALID'] ?? '89d985c4b1c25c26fe3b1595b4ef3137a0ebb549.11169.dd37716503850db285a143eeef3dd663',
				true
			],
			'invalid-token' => [
				'falesny-token-HAHA',
				false
			],
		];
	}
}
