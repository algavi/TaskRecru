<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\__core\BaseController;
use App\Exception\ApiException;
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
		try {
			$data = $this->apiPM->getAllJobs();
		} catch (ApiException $e) {
			$data = [];
			$this->addFlash('error', 'Nastala chyba při získávání uživatelů.');
		}

		return $this->render('Home/default.html.twig', [
			'jobs' => $data,
		]);
	}

}