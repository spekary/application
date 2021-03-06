<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Action;

use QCubed\Exception\Caller;
use QCubed\Jqui\Event\AbstractProperty;
use QCubed\ObjectBase;
use QCubed\Type;
use QCubed\Project\Control\ControlBase as QControl;
use QCubed\Project\Application;


/**
 * Base class for all other Actions.
 *
 * @package Actions
 * @property \QCubed\Event\Base $Event Any QEvent derivated class instance
 * @was QAction
 */
abstract class ActionBase extends ObjectBase
{
    /**
     * Abstract method, implemented in derived classes. Returns the JS needed for the action to work
     *
     * @param QControl $objControl
     *
     * @return mixed
     */
    abstract public function renderScript(QControl $objControl);

    /** @var \QCubed\Event\EventBase Event object which will fire this action */
    protected $objEvent;

    /**
     * @param QControl $objControl QControl for which the actions have to be rendered
     * @param string $strEventName Name of the event for which the actions have to be rendered
     * @param ActionBase[] $objActions Array of actions
     *
     * @return null|string
     * @throws \Exception
     */
    public static function renderActions(QControl $objControl, $strEventName, $objActions)
    {
        $strToReturn = '';
        $strJqUiProperty = null;

        if ($objControl->ActionsMustTerminate) {
            $strToReturn .= ' event.preventDefault();' . _nl();
        }

        if ($objActions && count($objActions)) {
            foreach ($objActions as $objAction) {
                if ($objAction->objEvent->EventName != $strEventName) {
                    throw new Exception('Invalid Action Event in this entry in the ActionArray');
                }

                if ($objAction->objEvent->Delay > 0) {
                    $strCode = sprintf(" qcubed.setTimeout('%s', \$j.proxy(function(){%s},this), %s);",
                        $objControl->ControlId,
                        _nl() . _indent(trim($objAction->renderScript($objControl))) . _nl(),
                        $objAction->objEvent->Delay);
                } else {
                    $strCode = ' ' . $objAction->renderScript($objControl);
                }

                // Add Condition (if applicable)
                if (strlen($objAction->objEvent->Condition)) {
                    $strCode = sprintf(' if (%s) {%s}', $objAction->objEvent->Condition,
                        _nl() . _indent(trim($strCode)) . _nl());
                }

                $strCode .= _nl();

                // Append it to the Return Value
                $strToReturn .= $strCode;
            }
        }

        if (strlen($strToReturn)) {
            if ($objAction->objEvent->Block) {
                $strToReturn .= 'qc.blockEvents = true;';
            }
            $strToReturn = _nl() . _indent($strToReturn);


            if ($objControl instanceof \QCubed\Control\Proxy) {
                $strOut = sprintf('$j("#%s").on("%s", "[data-qpxy=\'%s\']", function(event, ui){%s});',
                    $objControl->Form->FormId, $strEventName, $objControl->ControlId, $strToReturn);
            } else {
                $strOut = sprintf('$j("#%s").on("%s", function(event, ui){%s});',
                    $objControl->getJqControlId(),
                    $strEventName, $strToReturn);
            }

            if (isset($strOut)) {
                if (!Application::instance()->minimize()) {
                    // Render a comment
                    $strOut = _nl() . _nl() .
                        sprintf('/*** Event: %s  Control Type: %s, Control Name: %s, Control Id: %s  ***/',
                            $strEventName, get_class($objControl), $objControl->Name, $objControl->ControlId) .
                        _nl() .
                        _indent($strOut) .
                        _nl() . _nl();
                }
                return $strOut;
            }
        }

        return null;
    }

    /**
     * PHP Magic function to set the property values of an object of the class
     * In this case, we only have 'Event' property to be set
     *
     * @param string $strName Name of the property
     * @param string $mixValue Value of the property
     *
     * @throws Caller
     * @return void
     */
    public function __set($strName, $mixValue)
    {
        switch ($strName) {
            case 'Event':
                $this->objEvent = Type::cast($mixValue, '\QCubed\Event\EventBase');
                break;

            default:
                try {
                    parent::__set($strName, $mixValue);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }

    /**
     * PHP Magic function to get the property values of an object of the class
     * In this case, we only have 'Event' property to be set
     *
     * @param string $strName Name of the property
     *
     * @return mixed
     * @throws Caller
     */
    public function __get($strName)
    {
        switch ($strName) {
            case 'Event':
                return $this->objEvent;
            default:
                try {
                    return parent::__get($strName);
                } catch (Caller $objExc) {
                    $objExc->incrementOffset();
                    throw $objExc;
                }
        }
    }
}
