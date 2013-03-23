<?php

namespace InfinityBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as FormRowHelper;

/**
 * View helper plugin to prepare and render a form row
 */
class FormRow extends FormRowHelper
{

    /**
     * Render the form row
     *
     * @param null|ElementInterface $element
     * @param null|string           $labelPosition
     * @param bool                  $renderErrors
     * @return Form|string
     */
    public function __invoke(ElementInterface $element = null, $labelPosition = null, $renderErrors = null)
    {
        if (!$element) {
            return $this;
        }

        if ($labelPosition !== null) {
            $this->setLabelPosition($labelPosition);
        }

        if ($renderErrors !== null){
            $this->setRenderErrors($renderErrors);
        }
        
        if ($element instanceof \Zend\Form\Element\Button) {
            $helper = $this->getView()->plugin('sxbButton');
            if ($element->getAttribute('type') == 'submit') {
                $label = $element->getLabel();
                $element->setName($label);
            }
        } else {
            $helper = $this->getView()->plugin('sxbFormElement');
        }
        return $helper($element);
    }

}