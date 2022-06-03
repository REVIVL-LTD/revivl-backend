<?php

namespace App\Form;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class BuyType extends AbstractType
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'pattern' => '[A-Z][a-z]*'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'pattern' => '[A-Z][a-z]*'
                ]
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Male' => true,
                    'Female' => false
                ],
                'label' => 'Gender'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Phone number',
                'attr' => [
                    'pattern' => '[+44][0-9]{10}',
                    'placeholder' => '+44XXXXXXXXXX'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
            ])
//            todo сделать валидацию пост кода https://design-system.service.gov.uk/patterns/addresses/
            ->add('postcode', TextType::class, [
                'mapped' => false,
                'label' => 'Postcode',
            ])
            ->add('city', TextType::class, [
                'mapped' => false,
                'label' => 'City'
            ])
            ->add('address', TextType::class, [
                'mapped' => false,
                'label' => 'Address Line'
            ])
            ->add('promocode', TextType::class, [
                'mapped' => false,
                'label' => 'Promocode',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}