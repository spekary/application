<?php
/**
 * This action works as a if-else stopper for another action.
 * This action should be added to a control with the same event type before another action of that event type
 * Doing so brings up a JavaScript Confirmation box in front of the user.
 * If the user clicks on 'OK', then the next next action is executed (and any actions after that as well)
 * If the user clicks on 'Cancel', then next/rest of the action(s) are not executed
 * @package Actions
 */
class QConfirmAction extends QAction {
    /** @var string Message to be shown to the user on the confirmation prompt */
    protected $strMessage;

    /**
     * Constructor of the function
     * @param string $strMessage Message which is to be set as the confirmation prompt message
     */
    public function __construct($strMessage) {
        $this->strMessage = $strMessage;
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
            case 'Message':
                return $this->strMessage;
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
     * Returns the JS to be executed on the client side
     * @param QControl $objControl
     *
     * @return string The JS to be executed
     */
    public function RenderScript(QControl $objControl) {
        $strMessage = JavaScriptHelper::toJsObject($this->strMessage);

        return sprintf("if (!confirm(%s)) return false;", $strMessage);
    }
}

