<?php

/* Relative File Paths for Web Accessible Directories
 *
 * Specify the path that someone was enter into a browser to refer to the files and directories listed.
 * Most commonly, this would be the path from the browser's document root directory, but various web server
 * configurations might make it so that server paths do not correspond to a browser URL path.
 *
 * For some directories (e.g. the Examples site), if you are no longer using it, you STILL need to
 * have the constant defined.  But feel free to define the directory constant as blank (e.g. '') or null.
 *
 * Note that paths must have a leading slash and no ending slash. All defines start with QCUBED_ as a way of
 * "namespacing" the defines. See the config.regex.php file for the transformations that are done to convert to these
 * new defines.
 *
 * For development purposes, you will not likely need to change any of these. Production needs may vary though.
 */

define ('QCUBED_JS_URL', QCUBED_BASE_URL . '/application/assets/js');
define ('QCUBED_CSS_URL', QCUBED_BASE_URL . '/application/assets/css');
define ('QCUBED_PHP_URL', QCUBED_BASE_URL . '/application/assets/php');
define ('QCUBED_IMAGE_URL', QCUBED_BASE_URL . '/application/assets/images');

// Location of the Examples site
define ('QCUBED_EXAMPLES_URL', QCUBED_PHP_URL . '/examples');
define ('QCUBED_EXAMPLES_DIR', QCUBED_BASE_DIR . '/application/assets/php/examples');   // corresponding physical dir

define ('QCUBED_VENDOR_URL', QCUBED_BASE_URL . '/../');

define ('QCUBED_ITEMS_PER_PAGE', 20);

// Location of asset files for your application
define ('QCUBED_PROJECT_JS_URL', QCUBED_PROJECT_ASSETS_URL . '/js');
define ('QCUBED_PROJECT_CSS_URL', QCUBED_PROJECT_ASSETS_URL . '/css');
define ('QCUBED_PROJECT_PHP_URL', QCUBED_PROJECT_ASSETS_URL . '/php');
define ('QCUBED_PROJECT_IMAGE_URL', QCUBED_PROJECT_ASSETS_URL . '/images');

// There are two ways to add jQuery JS files to QCubed. Either by absolute paths (Google CDN of
// the jQuery library is awesome! It's the default option below) - or by using the jQuery
// installation that's local to QCubed (in that case, paths must be relative to __JS_ASSETS__

define ('QCUBED_JQUERY_JS', ' http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
define ('QCUBED_JQUI_JS', ' http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');

// The original, non-minified jQuery for debugging purposes.
//define ('QCUBED_JQUERY', ' http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js');
//define ('QCUBED_JQUI', ' http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js');


/** Specific files */

// The core qcubed javascript file to be used.
// In production or as a performance tweak, you may want to use the compressed "_qc_packed.js" library
define ('QCUBED_JS',  QCUBED_JS_URL . '/qcubed.js');
//define ('QCUBED_JS',  '_qc_packed.js');

define ('QCUBED_JQUI_CSS', QCUBED_CSS_URL . '/jquery-ui-themes/ui-qcubed/jquery-ui.custom.css');


// The following defines are deprecated for various reasons

// Plugins are going away. Everything is just a "qcubed-library" type.
//define ('__PLUGIN_ASSETS__',  __SUBDIRECTORY__ . '/vendor/qcubed/plugin');

// The following defines are for unsupported controls
/*
define ('__IMAGE_CACHE__', __APP_IMAGE_ASSETS__ . '/cache');

define ('__APP_CACHE_ASSETS__', __PROJECT_ASSETS__ . '/cache');
define ('__APP_CACHE__', __DOCROOT__ . __APP_CACHE_ASSETS__);

define ('__APP_IMAGE_CACHE_ASSETS__', __APP_CACHE_ASSETS__ . '/images');
define ('__APP_IMAGE_CACHE__', __DOCROOT__ . __APP_IMAGE_CACHE_ASSETS__);

define ('__APP_UPLOAD_ASSETS__', __PROJECT_ASSETS__ . '/upload');
define ('__APP_UPLOAD__', __DOCROOT__ . __APP_UPLOAD_ASSETS__);
*/


// Location of the QCubed-specific web-based development tools, like start_page.php
define ('QCUBED_APP_TOOLS_URL', QCUBED_BASE_URL . '/application/tools');



// Location of .po translation files
// this is now handled by the qcubed i18n library
// define ('__QI18N_PO_PATH__', QCUBED_PROJECT_INCLUDES_DIR . '/i18n');

