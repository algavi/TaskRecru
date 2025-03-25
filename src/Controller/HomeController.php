<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\__core\BaseController;
use App\ProcessManager\ApiProcessManager;
use App\ProcessManager\HomeProcessManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController {

	public function __construct(
		private readonly HomeProcessManager $homePM,
		private readonly ApiProcessManager  $apiPM,
	) {

	}

	#[Route('/', name: 'homepage')]
	public function homepage(): Response {
		$data = $this->apiPM->getAllJobs();
		return $this->render('Home/default.html.twig', [
			'test' => $data,
		]);
	}

}