<?php

// Config file for travis build

if (!defined('SERVER_INSTANCE')) {
	// The Server Instance constant is used to help ease web applications with multiple environments.
	// Feel free to use, change or ignore.
	define('SERVER_INSTANCE', 'dev');
	define('ALLOW_REMOTE_ADMIN', true);

	// In the travis test build, the vendor directory is install inside the application directory
    define ('QCUBED_BASE_DIR',  dirname(dirname(__DIR__)) . '/vendor/qcubed');

    // for travis build only, we point to the project directory inside the install directory
	define ('QCUBED_PROJECT_DIR', dirname(dirname(__DIR__)) . '/install/project');


    // Destination for Code Generated class files
	define ('__MODEL__', __INCLUDES__ . '/model' );
	define ('__MODEL_GEN__', __PROJECT__ . '/generated/model_base' );

	require_once (getenv("DB") . '.inc.php');

	define ('MAX_DB_CONNECTION_INDEX', 1);

	/** The value for QApplication::$EncodingType constant */
	define('__APPLICATION_ENCODING_TYPE__', 'UTF-8');

}
