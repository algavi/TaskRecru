<?php
declare(strict_types=1);

namespace App\ProcessManager;

use App\Form\CreateNewCandidateForm;
use App\Process\Api\CreateCandidateProcess;
use App\Process\Api\GetAllJobsProcess;
use App\Process\Api\GetJobDetailProcess;

class ApiRecruitisProcessManager {

	public function __construct(
		private readonly GetAllJobsProcess   $getAllJobsProcess,
		private readonly GetJobDetailProcess $getJobDetailProcess,
		private readonly CreateCandidateProcess $createCandidateProcess,
	) {
	}

	/**
	 *  Získání všech pracovních inzerátů.
	 *
	 * @throws \App\Exception\ApiException Pokud dojde k chybě při volání API
	 */
	public function getAllJobs(): array {
		return $this->getAllJobsProcess->run();
	}

	/**
	 * Načte detail pracovní nabídky podle ID z externího API.
	 *
	 * @throws \App\Exception\ApiException Pokud dojde k chybě při volání API
	 */
	public function getJobDetail(int $jobId): array {
		return $this->getJobDetailProcess->run($jobId);
	}

	/**
	 * Odešle data pro vytvoření kandidáta do Recruitis API.
	 *
	 * @throws \App\Exception\ApiException
	 */
	public function createCandidateProcess(array $data) : void {
		$this->createCandidateProcess->run($data);

	}

}