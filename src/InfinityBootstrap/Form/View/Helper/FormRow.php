<?php

namespace InfinityBootstrap\Form\View\Helper;

use SxBootstrap\View\Helper\Bootstrap\FormDescription;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as FormRowHelper;

class FormRow extends FormRowHelper
{

    /**
     * @var SxBootstrap\View\Helper\Bootstrap\FormDescription
     */
    protected $descriptionHelper;

    /**
     * @var string
     */
    protected $groupWrapper = '<div class="control-group%s" id="control-group-%s">%s</div>';

    /**
     * @var string
     */
    protected $controlWrapper = '<div class="controls" id="controls-%s">%s%s%s</div>';

    /**
     * Set Description Helper
     *
     * @param SxBootstrap\View\Helper\Bootstrap\FormDescription
     * @return FormElement
     */
    public function setDescriptionHelper(FormDescription $descriptionHelper)
    {
        $descriptionHelper->setView($this->getView());
        $this->descriptionHelper = $descriptionHelper;
        return $this;
    }

    /**
     * Get Description Helper
     *
     * @return SxBootstrap\View\Helper\Bootstrap\FormDescription
     */
    public function getDescriptionHelper()
    {
        if (!$this->descriptionHelper) {
            $this->setDescriptionHelper($this->view->plugin('sxbFormDescription'));
        }
        return $this->descriptionHelper;
    }

    /**
     * Set Group Wrapper
     *
     * @param string $groupWrapper
     * @return FormElement
     */
    public function setGroupWrapper($groupWrapper)
    {
        $this->groupWrapper = (string) $groupWrapper;
        return $this;
    }

    /**
     * Get Group Wrapper
     *
     * @return string
     */
    public function getGroupWrapper()
    {
        return $this->groupWrapper;
    }

    /**
     * Set Control Wrapper
     *
     * @param string $controlWrapper;
     * @return FormElement
     */
    public function setControlWrapper($controlWrapper)
    {
        $this->controlWrapper = (string) $controlWrapper;
        return $this;
    }

    /**
     * Get Control Wrapper
     *
     * @return string
     */
    public function getControlWrapper()
    {
        return $this->controlWrapper;
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param ElementInterface $element
     * @param string $groupWrapper
     * @param string $controlWrapper
     * @return string
     * @throws \Zend\Form\Exception\DomainException
     */
    public function render(ElementInterface $element, $groupWrapper = null, $controlWrapper = null)
    {
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();
        $descriptionHelper   = $this->getDescriptionHelper();
        $groupWrapper        = $groupWrapper ? : $this->groupWrapper;
        $controlWrapper      = $controlWrapper ? : $this->controlWrapper;
        $renderer            = $elementHelper->getView();

        $id = $element->getAttribute('id') ? : $element->getAttribute('name');

        $label = $element->getLabel();
        if (null === $label) {
            $label = $element->getOption('label') ? : $element->getAttribute('label');
        }

        if (method_exists($renderer, 'plugin')) {
            if ($element instanceof \Zend\Form\Element\Radio) {
                $renderer->plugin('form_radio')->setLabelAttributes(array(
                    'class' => 'radio',
                ));
            }
        }

        $elementString       = $elementHelper->render($element);
        $descriptionString   = $descriptionHelper->render($element);
        $elementErrorsString = $this->renderErrors ? $elementErrorsHelper->render($element) : null;

        $controlMarkup = sprintf($controlWrapper, $id, $elementString, $descriptionString, $elementErrorsString);

        if ($label) {
            $element->setLabelAttributes(array('class' => 'control-label'));
            $labelString = $labelHelper($element, $label);

            switch ($this->labelPosition) {
                case self::LABEL_PREPEND:
                    $controlMarkup = $labelString . $controlMarkup;
                    break;
                case self::LABEL_APPEND:
                default:
                    $controlMarkup .= $labelString;
                    break;
            }
        }

        $addtClass   = $element->getMessages() ? ' error' : '';
        $groupMarkup = sprintf($groupWrapper, $addtClass, $id, $controlMarkup);

        return $groupMarkup;
    }

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param null|ElementInterface $element
     * @param null|string           $labelPosition
     * @param null|bool             $renderErrors
     * @param null|string           $groupWrapper
     * @param null|string           $controlWrapper
     * @return string|FormRow
     */
    public function __invoke(ElementInterface $element = null, $labelPosition = null, $renderErrors = null, $groupWrapper = null, $controlWrapper = null)
    {
        if (!$element) {
            return $this;
        }

        if ($labelPosition !== null) {
            $this->setLabelPosition($labelPosition);
        } else {
            $this->setLabelPosition(self::LABEL_PREPEND);
        }

        if ($renderErrors !== null) {
            $this->setRenderErrors($renderErrors);
        }

        return $this->render($element, $groupWrapper, $controlWrapper);
    }

}

