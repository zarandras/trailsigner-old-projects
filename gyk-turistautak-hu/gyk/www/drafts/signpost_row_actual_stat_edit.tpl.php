<?php
	// This is the HTML template include file (.tpl.php) for the signpost_row_actual_stat_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('SignpostRowActualStat') . ' - ' . $this->mctSignpostRowActualStat->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctSignpostRowActualStat->TitleVerb); ?></h2>
		<h1><?php _t('SignpostRowActualStat')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lstSignpostRow->RenderWithName(); ?>

		<?php $this->txtContentTextDef->RenderWithName(); ?>

		<?php $this->txtPictoDef->RenderWithName(); ?>

		<?php $this->txtLengthSlope->RenderWithName(); ?>

		<?php $this->txtMinutesTo->RenderWithName(); ?>

		<?php $this->txtMinutesRounded->RenderWithName(); ?>

		<?php $this->txtAllTrailmarks->RenderWithName(); ?>

		<?php $this->txtAllModalities->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>