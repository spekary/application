<?php require(QCUBED_PROJECT_CONFIGURATION_DIR . '/header.inc.php'); ?>
<?php $this->renderBegin(); ?>
<div>
<?php $this->dtg->Render(); ?>
<?php $this->txtCount->RenderWithName(); ?>
<?php $this->txtPageSize->RenderWithName(); ?>
</div>
<?php $this->renderEnd(); ?>
<?php require(QCUBED_PROJECT_CONFIGURATION_DIR . '/footer.inc.php'); ?>