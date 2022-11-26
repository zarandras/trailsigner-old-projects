<?php
	// This is the HTML template include file (.tpl.php) for the noi_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('Noi') . ' - ' . $this->mctNoi->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctNoi->TitleVerb); ?></h2>
		<h1><?php _t('Noi')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblNoiId->RenderWithName(); ?>

		<?php $this->txtName->RenderWithName(); ?>

		<?php $this->txtName2->RenderWithName(); ?>

		<?php $this->txtName3->RenderWithName(); ?>

		<?php $this->txtPicto->RenderWithName(); ?>

		<?php $this->txtTuhuId->RenderWithName(); ?>

		<?php $this->txtOmpId->RenderWithName(); ?>

		<?php $this->txtLat->RenderWithName(); ?>

		<?php $this->txtLon->RenderWithName(); ?>

		<?php $this->txtAlt->RenderWithName(); ?>

		<?php $this->txtUrl->RenderWithName(); ?>

		<?php $this->txtCategories->RenderWithName(); ?>

		<?php $this->txtDescription->RenderWithName(); ?>

		<?php $this->txtDefPriority->RenderWithName(); ?>

		<?php $this->lstParent->RenderWithName(); ?>

		<?php $this->chkIsVirtual->RenderWithName(); ?>

		<?php $this->txtCountry->RenderWithName(); ?>

		<?php $this->txtRegion->RenderWithName(); ?>

		<?php $this->txtTown->RenderWithName(); ?>

		<?php $this->txtLandowner->RenderWithName(); ?>

		<?php $this->txtHrsz->RenderWithName(); ?>

		<?php $this->txtGroup->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>