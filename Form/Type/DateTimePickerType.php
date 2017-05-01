<?php

namespace Admingenerator\FormExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * See `Resources/doc/bootstrap-datetimepicker/overview.md` for documentation
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class DateTimePickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['width'] = $options['width'];
        $view->vars['config'] = array_replace($options['config'], array(
            'icons'         => array(
                'time'  => "fa fa-clock-o",
                'date'  => "fa fa-calendar",
                'up'    => "fa fa-arrow-up",
                'down'  => "fa fa-arrow-down"
            )
        ));

        if ($view->vars['value']) {
            $value = new \DateTime($view->vars['value']);
            $view->vars['widget_value'] = $value->format('Y-m-d\TH:i:sP');
            if("Invalid date" == $view->vars['value']) {
                $view->vars['widget_value'] = null;
                $view->vars['value'] = null;
            } else {
                $value = new \DateTime($view->vars['value']);
                $view->vars['widget_value'] = $value->format('d.m.Y H:i');//'y-M-d\TH:i:sP');
                $view->vars['value'] = $value->format('d.m.Y H:i');//'y-M-d\TH:i:sP');
            }
        }

        $view->vars['widget_format'] = 'DD.MM.YYYY HH:mm'; //'YYYY-MM-DDTHH:mm:ssZ';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget'    => 'single_text',
            'format'    => DateTimeType::HTML5_FORMAT,
            'width'     => null,
            'config'    => array(
                'sideBySide'    => false,
                'icons'     => array(
                    'time'  => "fa fa-clock-o",
                    'date'  => "fa fa-calendar",
                    'up'    => "fa fa-arrow-up",
                    'down'  => "fa fa-arrow-down"
                )
            )
        ));

        $resolver->setAllowedTypes(array(
            'width'  => array('null', 'integer'),
            'config' => array('array')
        ));

        $resolver->setAllowedValues(array(
            'widget' => array('single_text'),
            'format' => array(DateTimeType::HTML5_FORMAT)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 's2a_datetime_picker';
    }
}
