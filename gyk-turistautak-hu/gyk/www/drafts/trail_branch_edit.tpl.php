<?php
	// This is the HTML template include file (.tpl.php) for the trail_branch_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('TrailBranch') . ' - ' . $this->mctTrailBranch->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctTrailBranch->TitleVerb); ?></h2>
		<h1><?php _t('TrailBranch')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblBranchId->RenderWithName(); ?>

		<?php $this->lstBranchTrail->RenderWithName(); ?>

		<?php $this->lstBranchFromNode->RenderWithName(); ?>

		<?php $this->lstBranchToNode->RenderWithName(); ?>

		<?php $this->txtBranchTrailmark->RenderWithName(); ?>

		<?php $this->txtBranchModality->RenderWithName(); ?>

		<?php $this->txtBranchLengthProjection->RenderWithName(); ?>

		<?php $this->txtBranchLengthSlope->RenderWithName(); ?>

		<?php $this->txtBranchAscentTo->RenderWithName(); ?>

		<?php $this->txtBranchAscentFrom->RenderWithName(); ?>

		<?php $this->txtBranchMinutesTo->RenderWithName(); ?>

		<?php $this->txtBranchMinutesFrom->RenderWithName(); ?>

		<?php $this->txtBranchSegments->RenderWithName(); ?>

		<?php $this->txtBranchSegmentsRev->RenderWithName(); ?>

		<?php $this->txtBranchPoints->RenderWithName(); ?>

		<?php $this->txtBranchPointsRev->RenderWithName(); ?>

		<?php $this->txtBranchRemark->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>