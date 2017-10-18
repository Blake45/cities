<?php

namespace CitiesBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('securite', ChoiceType::class, array(
                'label' => 'Sécurité de la ville',
                'choices' => range(0,10)
            ))
            ->add('loisir', ChoiceType::class, array(
                'label' => 'Loisirs de la ville',
                'choices' => range(0,10)
            ))
            ->add('culture', ChoiceType::class, array(
                'label' => 'Installations, événements et ambiance culturelles',
                'choices' => range(0,10)
            ))
            ->add('emploi', ChoiceType::class, array(
                'label' => "Perpectives, qualité de l'emploi",
                'choices' => range(0,10)
            ))
            ->add('environnement', ChoiceType::class, array(
                'label' => "Qualité de l'environnement (paysage, climat, pollution etc...)",
                'choices' => range(0,10)
            ))
            ->add('enseignement', ChoiceType::class, array(
                'label' => "Qualité de l'enseignement de la ville",
                'choices' => range(0,10)
            ))
            ->add('sante', ChoiceType::class, array(
                'label' => "Santé (Hôpital, Médecins, spécialistes, Centre de soins, maisons de retraites etc...)",
                'choices' => range(0,10)
            ))
            ->add('transport', ChoiceType::class, array(
                'label' => "Qualité des transports en commun",
                'choices' => range(0,10)
            ))
            ->add('commerce', ChoiceType::class, array(
                'label' => "Qualité de la vie commerciale de la ville",
                'choices' => range(0,10)
            ))
            ->add('commentPositif', TextareaType::class, array(
                'label' => "Qu'est ce que vous aimez le plus dans cette ville?",
                'attr' => array(
                    "class" => "form-control",
                    "rows" => "5"
                )
            ))
            ->add('commentNegatif', TextareaType::class, array(
                'label' => "Qu'est ce que vous aimez le moins dans cette ville?",
                'attr' => array(
                    "class" => "form-control",
                    "rows" => "5"
                )
            ))
            ->add('commentGeneral', TextareaType::class, array(
                'label' => "Si vous deviez résumer ce que vous pensez de la ville en une phrase",
                'attr' => array(
                    "class" => "form-control",
                    "rows" => "5"
                )
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CitiesBundle\Entity\Avis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'citiesbundle_avis';
    }


}
