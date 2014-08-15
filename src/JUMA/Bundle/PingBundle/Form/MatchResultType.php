<?php

namespace JUMA\Bundle\PingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatchResultType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $teamOptions = array(
            'expanded' => true,
            'class' => 'JUMAPingBundle:Team'
        );

        $builder
            ->add('playDate', 'date', array('widget' => 'single_text'))
            ->add('localTeam', 'entity', $teamOptions)
            ->add('versusTeam', 'entity', $teamOptions)
            ->add('winnerTeam', 'entity', $teamOptions)
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JUMA\Bundle\PingBundle\Entity\MatchResult'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'juma_bundle_pingbundle_matchresult';
    }
}
