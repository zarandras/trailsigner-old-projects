<?php
	// This is the HTML template include file (.tpl.php) for the trail_section_stat_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('TrailSectionStat') . ' - ' . $this->mctTrailSectionStat->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctTrailSectionStat->TitleVerb); ?></h2>
		<h1><?php _t('TrailSectionStat')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lstTrailSection->RenderWithName(); ?>

		<?php $this->lstTrail->RenderWithName(); ?>

		<?php $this->txtNodeCount->RenderWithName(); ?>

		<?php $this->txtTrailmark->RenderWithName(); ?>

		<?php $this->txtModality->RenderWithName(); ?>

		<?php $this->txtLengthProjection->RenderWithName(); ?>

		<?php $this->txtLengthSlope->RenderWithName(); ?>

		<?php $this->txtAscentTo->RenderWithName(); ?>

		<?php $this->txtAscentFrom->RenderWithName(); ?>

		<?php $this->txtMinutesTo->RenderWithName(); ?>

		<?php $this->txtMinutesFrom->RenderWithName(); ?>

		<?php $this->txtSegments->RenderWithName(); ?>

		<?php $this->txtPoints->RenderWithName(); ?>

		<?php $this->txtRemark->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>