<?php
	// This is the HTML template include file (.tpl.php) for the trail_section_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('TrailSection') . ' - ' . $this->mctTrailSection->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctTrailSection->TitleVerb); ?></h2>
		<h1><?php _t('TrailSection')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblTrailSectionId->RenderWithName(); ?>

		<?php $this->lstTrail->RenderWithName(); ?>

		<?php $this->lstFromNode->RenderWithName(); ?>

		<?php $this->lstToNode->RenderWithName(); ?>

		<?php $this->txtParamName->RenderWithName(); ?>

		<?php $this->txtValue->RenderWithName(); ?>

		<?php $this->chkIsOneway->RenderWithName(); ?>

		<?php $this->chkWithBranch->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>