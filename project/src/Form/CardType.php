<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('image_url')
            ->add('desc_image')
            ->add('link_url')
            ->add('description')
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->getTags()
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'card_class' => Card::class
        ]);
    }

    public function getName(): string
    {
        return ('card');
    }

    public function getTags()
    {
        return $this->entityManager->getRepository(Tag::class)->findAll();
    }

}
