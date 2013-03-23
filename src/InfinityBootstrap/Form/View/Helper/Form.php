<?php

namespace InfinityBootstrap\Form\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\View\Helper\Form as FormHelper;

/**
 * View helper plugin to prepare and render the entire form
 */
class Form extends FormHelper
{

    /**
     * Render the entire form
     *
     * @param FormInterface $form
     * @return Form|string
     */
    public function __invoke(FormInterface $form = null)
    {
        if ($form) {
            return $this->getView()->sxbForm($form);
        }
        
        return $this;
    }

}