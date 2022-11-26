<?php
	// This is the HTML template include file (.tpl.php) for the signpost_row_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('SignpostRow') . ' - ' . $this->mctSignpostRow->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctSignpostRow->TitleVerb); ?></h2>
		<h1><?php _t('SignpostRow')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblSignpostRowId->RenderWithName(); ?>

		<?php $this->lstSignpost->RenderWithName(); ?>

		<?php $this->txtRowIdx->RenderWithName(); ?>

		<?php $this->txtRowType->RenderWithName(); ?>

		<?php $this->chkHasBranchline->RenderWithName(); ?>

		<?php $this->lstTrail->RenderWithName(); ?>

		<?php $this->lstFromNode->RenderWithName(); ?>

		<?php $this->txtOffsetLength->RenderWithName(); ?>

		<?php $this->txtOffsetMinutes->RenderWithName(); ?>

		<?php $this->lstToNode->RenderWithName(); ?>

		<?php $this->txtContentText->RenderWithName(); ?>

		<?php $this->txtContentText2->RenderWithName(); ?>

		<?php $this->txtPicto->RenderWithName(); ?>

		<?php $this->txtLengthSlope->RenderWithName(); ?>

		<?php $this->txtMinutesTo->RenderWithName(); ?>

		<?php $this->txtMinutesRounded->RenderWithName(); ?>

		<?php $this->txtTrailmark->RenderWithName(); ?>

		<?php $this->txtModality->RenderWithName(); ?>

		<?php $this->chkIsHidden->RenderWithName(); ?>

		<?php $this->txtTechRemark->RenderWithName(); ?>

		<?php $this->lstSignpostRowActualStat->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>