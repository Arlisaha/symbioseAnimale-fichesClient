<?php

namespace AppBundle\Form\Animal;

use AppBundle\Entity\Animal\Cat;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatType extends AnimalType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder
			->add('breed', BreedType::class, [
				'class'    => 'AppBundle\Entity\Animal\CatBreed',
				'required' => true,
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Cat::class,
		]);
	}

	public function getName()
	{
		return 'cat';
	}
}