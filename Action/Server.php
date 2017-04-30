<?php
/**
 * Server actions are handled through a full-page postback.
 *
 * @package                                        Actions
 * @property-read string $MethodName               Name of the associated action handling method
 * @property-read mixed  $CausesValidationOverride An override for CausesValidation property (if supplied)
 * @property-read string $JsReturnParam            The parameter to be returned
 *                                                 (overrides the Control's ActionParameter)
 */
class QServerAction extends QAction {
    /** @var string Name of the method in the form to be called */
    protected $strMethodName;
    /**
     * @var mixed A constant from QCausesValidation enumeration class
     *            It is set in the constructor via the corresponding argument
     */
    protected $mixCausesValidationOverride;
    /** @var string An over-ride for the Control's ActionParameter */
    protected $strJsReturnParam;

    /**
     * @param string $strMethodName                The method name which is to be assigned as the event handler
     *                                             (for the event being created)
     * @param string $mixCausesValidationOverride  A constant from QCausesValidation
     *                                             (or $this or an array of QControls)
     * @param string $strJsReturnParam             The parameter to be returned when this event occurs
     *                                             (this is an override for the control's ActionParameter)
     */
    public function __construct($strMethodName = null, $mixCausesValidationOverride = null,
        $strJsReturnParam = '') {
        $this->strMethodName = $strMethodName;
        $this->mixCausesValidationOverride = $mixCausesValidationOverride;
        $this->strJsReturnParam = $strJsReturnParam;
    }

    /**
     * PHP Magic function to get the property values of an object of the class
     *
     * @param string $strName Name of the property
     *
     * @return mixed|null|string
     * @throws QCallerException
     */
    public function __get($strName) {
        switch ($strName) {
            case 'MethodName':
                return $this->strMethodName;
            case 'CausesValidationOverride':
                return $this->mixCausesValidationOverride;
            case 'JsReturnParam':
                return $this->strJsReturnParam;
            default:
                try {
                    return parent::__get($strName);
                } catch (QCallerException $objExc) {
                    $objExc->IncrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * Determines the ActionParameter associated with the action and returns it
     *
     * @param QControlBase $objControl
     *
     * @return string The action parameter
     */
    protected function getActionParameter($objControl) {
        if ($objActionParameter = $this->strJsReturnParam) {
            return $objActionParameter;
        }
        if ($objActionParameter = $this->objEvent->JsReturnParam) {
            return $objActionParameter;
        }
        $objActionParameter = $objControl->ActionParameter;
        if ($objActionParameter instanceof QJsClosure) {
            return '(' . $objActionParameter->toJsObject() . ').call(this)';
        }

        return "'" . addslashes($objActionParameter) . "'";
    }

    /**
     * Returns the JS which will be called on the client side
     * which will result in the event handler being called
     *
     * @param QControl $objControl
     *
     * @return string
     */
    public function RenderScript(QControl $objControl) {
        return sprintf("qc.pB('%s', '%s', '%s', %s);",
            $objControl->Form->FormId, $objControl->ControlId, get_class($this->objEvent), $this->getActionParameter($objControl));
    }
}
