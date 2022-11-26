<?php
	// This is the HTML template include file (.tpl.php) for signpost_row_actual_statEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lstSignpostRow->RenderWithName(); ?>

		<?php $_CONTROL->txtContentTextDef->RenderWithName(); ?>

		<?php $_CONTROL->txtPictoDef->RenderWithName(); ?>

		<?php $_CONTROL->txtLengthSlope->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesTo->RenderWithName(); ?>

		<?php $_CONTROL->txtMinutesRounded->RenderWithName(); ?>

		<?php $_CONTROL->txtAllTrailmarks->RenderWithName(); ?>

		<?php $_CONTROL->txtAllModalities->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
