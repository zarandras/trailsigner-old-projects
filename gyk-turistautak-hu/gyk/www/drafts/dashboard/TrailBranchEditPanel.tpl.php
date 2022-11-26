<?php
	// This is the HTML template include file (.tpl.php) for trail_branchEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblBranchId->RenderWithName(); ?>

		<?php $_CONTROL->lstBranchTrail->RenderWithName(); ?>

		<?php $_CONTROL->lstBranchFromNode->RenderWithName(); ?>

		<?php $_CONTROL->lstBranchToNode->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchTrailmark->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchModality->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchLengthProjection->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchLengthSlope->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchAscentTo->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchAscentFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchMinutesTo->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchMinutesFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchSegments->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchSegmentsRev->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchPoints->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchPointsRev->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchRemark->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
