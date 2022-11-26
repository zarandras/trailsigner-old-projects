<?php
	// This is the HTML template include file (.tpl.php) for signpost_rowEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblSignpostRowId->RenderWithName(); ?>

		<?php $_CONTROL->lstSignpost->RenderWithName(); ?>

		<?php $_CONTROL->txtRowIdx->RenderWithName(); ?>

		<?php $_CONTROL->txtRowType->RenderWithName(); ?>

		<?php $_CONTROL->chkHasBranchline->RenderWithName(); ?>

		<?php $_CONTROL->lstTrail->RenderWithName(); ?>

		<?php $_CONTROL->lstFromNode->RenderWithName(); ?>

		<?php $_CONTROL->txtOffsetLength->RenderWithName(); ?>

		<?php $_CONTROL->txtOffsetMinutes->RenderWithName(); ?>

		<?php $_CONTROL->lstToNode->RenderWithName(); ?>

		<?php $_CONTROL->txtContentText->RenderWithName(); ?>

		<?php $_CONTROL->txtContentText2->RenderWithName(); ?>

		<?php $_CONTROL->txtPicto->RenderWithName(); ?>

		<?php $_CONTROL->txtLengthSlope->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesTo->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesRounded->RenderWithName(); ?>

		<?php $_CONTROL->txtTrailmark->RenderWithName(); ?>

		<?php $_CONTROL->txtModality->RenderWithName(); ?>

		<?php $_CONTROL->chkIsHidden->RenderWithName(); ?>

		<?php $_CONTROL->txtTechRemark->RenderWithName(); ?>

		<?php $_CONTROL->lstSignpostRowActualStat->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
