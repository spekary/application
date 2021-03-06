<?php
    /** @var QSqlTable $objTable */
use QCubed\Project\Codegen\CodegenBase;
use QCubed as Q;

/** @var \QCubed\Codegen\DatabaseCodeGen $objCodeGen */

    global $_TEMPLATE_SETTINGS;

    $strPropertyName = CodegenBase::dataListPropertyName($objTable);

    $_TEMPLATE_SETTINGS = array(
        'OverwriteFlag' => true,
        'DirectorySuffix' => '',
        'TargetDirectory' => QCUBED_PROJECT_PANEL_GEN_DIR,
        'TargetFileName' => $strPropertyName . 'EditPanel.tpl.php'
    );
?>
<?php print("<?php\n"); ?>
	/**
	 * This is a draft template file for the <?= $strPropertyName ?>EditPanel.
	 * This file will be overwritten every time you do a code generation. If you would like to make manual modifications
	 * to this file, you should move it out of this directory and into another location, and then modify the
     * Template property of the <?= $strPropertyName ?>EditPanel to point to the new location.
	 **/
?>

<?php
foreach ($objTable->ColumnArray as $objColumn) {
    if (!isset($objColumn->Options['FormGen']) || $objColumn->Options['FormGen'] != Q\ModelConnector\Options::FORMGEN_NONE) {
        print('<?= _r($this->' . $objCodeGen->modelConnectorVariableName($objColumn) . '); ?>' . "\n");
    }
}
foreach ($objTable->ReverseReferenceArray as $objReverseReference) {
    if ($objReverseReference->Unique) {
        if (!isset($objReverseReference->Options['FormGen']) || $objReverseReference->Options['FormGen'] != Q\ModelConnector\Options::FORMGEN_NONE) {
            print('<?= _r($this->' . $objCodeGen->modelConnectorVariableName($objReverseReference) . '); ?>' . "\n");
        }
    }
}
foreach ($objTable->ManyToManyReferenceArray as $objManyToManyReference) {
    if (!isset($objManyToManyReference->Options['FormGen']) || $objManyToManyReference->Options['FormGen'] != Q\ModelConnector\Options::FORMGEN_NONE) {
        print('<?= _r($this->' . $objCodeGen->modelConnectorVariableName($objManyToManyReference) . '); ?>' . "\n");
    }
}
