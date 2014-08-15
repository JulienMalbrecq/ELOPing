<?php

namespace JUMA\Bundle\PingBundle\Form;

use JUMA\Bundle\PingBundle\Form\DataTransformer\TeamToArrayCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuickMatchResultType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teamOptions = array(
            'expanded' => true,
            'multiple' => true,
            'class' => 'HSPasswordLessBundle:Player'
        );

        $entityManager = $options['em'];
        $transformer = new TeamToArrayCollectionTransformer($entityManager);

        $builder->add('playDate', 'date', array('widget' => 'single_text'));

        $builder->add(
            $builder->create('localTeam', 'entity', $teamOptions)
                ->addModelTransformer($transformer)
        );

        $builder->add(
            $builder->create('versusTeam', 'entity', $teamOptions)
                ->addModelTransformer($transformer)
        );

        $builder->add('winnerTeam', 'choice', array('choices'   => array('1' => 'Local', '0' => 'Versus'),));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('em'))
            ->setAllowedTypes(array('em' => 'Doctrine\Common\Persistence\ObjectManager'))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'juma_ping_quick_match';
    }
}
