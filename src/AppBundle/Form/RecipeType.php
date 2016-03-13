<?php
/**
 * Created by PhpStorm.
 * User: Ilie
 * Date: 12/3/2016
 * Time: 12:49 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('boxType')
            ->add('title')
            ->add('shortTitle')
            ->add('marketingDescription')
            ->add('caloriesKcal')
            ->add('proteinGrams')
            ->add('fatGrams')
            ->add('carbsGrams')
            ->add('bulletPoint1')
            ->add('bulletPoint2')
            ->add('bulletPoint3')
            ->add('recipeDietTypeId')
            ->add('season')
            ->add('base')
            ->add('proteinSource')
            ->add('preparationTimeMinutes')
            ->add('shelfLifeDays')
            ->add('equipmentNeeded')
            ->add('originCountry')
            ->add('recipeCuisine')
            ->add('inYourBox')
            ->add('goustoReference')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Model\Recipe',
            'csrf_protection'   => false
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'recipe';
    }
}
