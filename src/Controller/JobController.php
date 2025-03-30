<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\__core\BaseController;
use App\Exception\ApiException;
use App\Form\CreateNewCandidateForm;
use App\ProcessManager\ApiRecruitisProcessManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends BaseController {

	public function __construct(
		private readonly ApiRecruitisProcessManager $apiPM,
	) {

	}

	#[Route('/', name: 'jobs')]
	public function jobs(): Response {
		return $this->render('Jobs/default.html.twig');
	}

	#[Route('/prace/{id}', name: 'job_detail')]
	public function jobDetail(int $id, Request $request): Response {
		try {
			$data = $this->apiPM->getJobDetail($id);
		} catch (ApiException $e) {
			$data = [];
			$this->addFlash('error', $e->getMessage());
		}

		// Formulář - vytvoření nového kandidáta
		// TODO: podívat se jeslti to nejde napsat jako componenta v nette
		$form = $this->createForm(CreateNewCandidateForm::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			try {
				$dataForm = $form->getData();
				$this->apiPM->createAnswerProcess($dataForm,$id);
				$this->addFlash('success', 'Vaše žádanka byla poslána');
			} catch (ApiException $e) {
				$this->addFlash('error', $e->getMessage());
			}
		}

		return $this->render('Jobs/detail.html.twig', [
			'job'  => $data,
			'form' => $form->createView(),
		]);
	}

}