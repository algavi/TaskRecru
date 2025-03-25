<?php
declare(strict_types=1);

namespace App\ProcessManager;

use App\Process\Api\GetAllJobsProcess;

class ApiProcessManager {

	public function __construct(
		private readonly GetAllJobsProcess $getAllJobsProcess,
	) {}

	/**
	 *  Získání všech pracovních inzerátů.
	 */
	public function getAllJobs() :array {
		return $this->getAllJobsProcess->run();
	}

}