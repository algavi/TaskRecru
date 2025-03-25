<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\__core\BaseController;
use App\ProcessManager\HomeProcessManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController {

	public function __construct(
		private readonly HomeProcessManager $homeProcessManager
	) {

	}

	#[Route('/', name: 'homepage')]
	public function homepage(): Response {
		// Následně vracíte odpověď – obvykle se vykreslí twig šablona
		return $this->render('Home/default.html.twig', [
			'test' => $this->homeProcessManager->test(),
		]);
	}

}