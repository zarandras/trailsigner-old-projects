<?php
	// This is the HTML template include file (.tpl.php) for the signpost_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('Signpost') . ' - ' . $this->mctSignpost->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctSignpost->TitleVerb); ?></h2>
		<h1><?php _t('Signpost')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblSignpostId->RenderWithName(); ?>

		<?php $this->txtSignpostCode->RenderWithName(); ?>

		<?php $this->lstNoi->RenderWithName(); ?>

		<?php $this->txtLat->RenderWithName(); ?>

		<?php $this->txtLon->RenderWithName(); ?>

		<?php $this->txtSignpostType->RenderWithName(); ?>

		<?php $this->txtDirection->RenderWithName(); ?>

		<?php $this->txtAngle->RenderWithName(); ?>

		<?php $this->txtMaterial->RenderWithName(); ?>

		<?php $this->txtSubtype->RenderWithName(); ?>

		<?php $this->txtContent->RenderWithName(); ?>

		<?php $this->txtStatus->RenderWithName(); ?>

		<?php $this->txtCondition->RenderWithName(); ?>

		<?php $this->calInstalled->RenderWithName(); ?>

		<?php $this->calChecked->RenderWithName(); ?>

		<?php $this->txtMaintainer->RenderWithName(); ?>

		<?php $this->txtSponsor->RenderWithName(); ?>

		<?php $this->txtRemark->RenderWithName(); ?>

		<?php $this->lstParent->RenderWithName(); ?>

		<?php $this->chkIsVirtual->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>