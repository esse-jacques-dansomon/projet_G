<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class,
                [    'required'   => true,'label' => false, 'attr' => ['placeholder' => 'email ']])
            ->add('firstname', TextType::class,
                ['required'   => true,'label' => false, 'attr' => ['placeholder' => 'Prenom ']])
            ->add('lastname', TextType::class,
                ['required'   => true,'label' => false, 'attr' => ['placeholder' => 'Nom ']])
            ->add('telephone', TextType::class,
                ['required'   => true,'label' => false, 'attr' => ['placeholder' => 'telephone ']])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'required'   => true,
                'attr' => ['autocomplete' => 'new-password', 'placeholder'=>'mot de passe'],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),

                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
