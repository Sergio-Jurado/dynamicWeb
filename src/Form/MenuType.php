<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Pagina;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etiqueta')
            ->add('destino')
            ->add('subMenu', EntityType::class, [
                'class' => Menu::class,
'choice_label' => 'id',
            ])
            ->add('pagina', EntityType::class, [
                'class' => Pagina::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
