<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\__core\BaseController;
use App\Exception\ApiException;
use App\ProcessManager\ApiProcessManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends BaseController {

	public function __construct(
		private readonly ApiProcessManager  $apiPM,
	) {

	}

	#[Route('/', name: 'jobs')]
	public function jobs(): Response {
		try {
			$data = $this->apiPM->getAllJobs();
		} catch (ApiException $e) {
			$data = [];
			$this->addFlash('error', 'Nastala chyba při získávání uživatelů.');
		}

		return $this->render('Jobs/default.html.twig', [
			'jobs' => $data,
		]);
	}

	#[Route('/prace/{id}', name: 'job_detail')]
	public function jobDetail(int $id): Response {
		return $this->render('Jobs/detail.html.twig', [
			'job' => [],
		]);
	}

}