<?php
/**
*
* Part of the QCubed PHP framework.
*
* @license MIT
*
*/

namespace QCubed\Jqui\Event;

/**
 * Class DroppableDeactivate
 *
 * The abstract DroppableDeactivate class defined here is
 * code-generated. The code to generate this file is
 * in the /tools/jquery_ui_gen/jq_control_gen.php file
 * and you can regenerate the files if you need to.
 *
 * The comments in this file are taken from the api reference site, so they do
 * not always make sense with regard to QCubed. They are simply provided
 * as reference.
 * Triggered when an accepted draggable stops dragging.
 * 
 * 	* event Type: Event 
 * 
 * 	* ui Type: Object 
 * 
 * 	* draggable Type: jQuery A jQuery object representing the draggable
 * element.
 * 	* helper Type: jQuery A jQuery object representing the helper that
 * is being dragged.
 * 	* position Type: Object Current CSS position of the draggable helper
 * as { top, left } object.
 * 	* offset Type: Object Current offset position of the draggable
 * helper as { top, left } object.
 * 
 *
 * @was QDroppable_Deactivate */
class DroppableDeactivate extends AbstractBase
{
    const EVENT_NAME = 'dropdeactivate';
}
