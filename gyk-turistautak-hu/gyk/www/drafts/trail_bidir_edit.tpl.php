<?php
	// This is the HTML template include file (.tpl.php) for the trail_bidir_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('TrailBidir') . ' - ' . $this->mctTrailBidir->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctTrailBidir->TitleVerb); ?></h2>
		<h1><?php _t('TrailBidir')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblTrailId->RenderWithName(); ?>

		<?php $this->txtTrailCode->RenderWithName(); ?>

		<?php $this->txtTrailmark->RenderWithName(); ?>

		<?php $this->txtModality->RenderWithName(); ?>

		<?php $this->txtName->RenderWithName(); ?>

		<?php $this->txtNameExt->RenderWithName(); ?>

		<?php $this->txtNameExtRev->RenderWithName(); ?>

		<?php $this->txtDescription->RenderWithName(); ?>

		<?php $this->txtDescriptionRev->RenderWithName(); ?>

		<?php $this->txtRemark->RenderWithName(); ?>

		<?php $this->txtGeodbService->RenderWithName(); ?>

		<?php $this->lstRevTrail->RenderWithName(); ?>

		<?php $this->lstAbsTrail->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>