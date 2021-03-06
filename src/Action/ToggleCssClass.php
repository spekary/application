<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Action;

use QCubed\Project\Control\ControlBase as QControl;

/**
 * Class ToggleCssClass
 *
 * Toggles the given class on the objects identified by the given jQuery selector. If no selector given, then
 * the trigger control is toggled.
 *
 * @was QToggleCssClassAction
 * @package QCubed\Action
 */
class ToggleCssClass extends ActionBase
{
    protected $strCssClass;
    protected $strTargetSelector;

    public function __construct($strCssClass, $strTargetSelector = null)
    {
        $this->strCssClass = $strCssClass;
        $this->strTargetSelector = $strTargetSelector;
    }

    public function renderScript(QControl $objControl)
    {
        // Specified a Temporary Css Class to use?
        if ($this->strTargetSelector) {
            $strSelector = $this->strTargetSelector;
        } else {
            $strSelector = '#' . $objControl->ControlId;
        }
        return sprintf("jQuery('%s').toggleClass('%s');", $strSelector, $this->strCssClass);
    }
}
