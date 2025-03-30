<?php
declare(strict_types=1);

namespace App\Controller;

use App\ProcessManager\ApiRecruitisProcessManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiVueController extends AbstractController {

	public function __construct(
		private readonly ApiRecruitisProcessManager $apiRecruitisPM
	) {
	}

	#[Route('/api/jobs', name: 'api_jobs', methods: ['GET'])]
	public function getJobs(Request $request): JsonResponse {


		$data = $this->apiRecruitisPM->getAllJobs();

		// Data vrátit
		return $this->json([
			'data' => $data,
		]);
	}
}
