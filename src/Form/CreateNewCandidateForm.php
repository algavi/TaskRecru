<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateNewCandidateForm extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('name', TextType::class, [
				'label' => 'Jméno',
			])
			->add('email', EmailType::class, [
				'label' => 'E-mail',
			])
			->add('phone', TelType::class, [
				'label' => 'Telefon',
			])
			->add('poznamka', TextareaType::class, [
				'label'    => 'Poznámka',
				'required' => false,
			])
			->add('file', FileType::class, [
				'label'    => 'Soubor',
				'required' => false,
				'mapped'   => false,
			]);
	}
}