<?php
	// This is the HTML template include file (.tpl.php) for trail_section_statEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lstTrailSection->RenderWithName(); ?>

		<?php $_CONTROL->lstTrail->RenderWithName(); ?>

		<?php $_CONTROL->txtNodeCount->RenderWithName(); ?>

		<?php $_CONTROL->txtTrailmark->RenderWithName(); ?>

		<?php $_CONTROL->txtModality->RenderWithName(); ?>

		<?php $_CONTROL->txtLengthProjection->RenderWithName(); ?>

		<?php $_CONTROL->txtLengthSlope->RenderWithName(); ?>

		<?php $_CONTROL->txtAscentTo->RenderWithName(); ?>

		<?php $_CONTROL->txtAscentFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesTo->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtSegments->RenderWithName(); ?>

		<?php $_CONTROL->txtPoints->RenderWithName(); ?>

		<?php $_CONTROL->txtRemark->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
