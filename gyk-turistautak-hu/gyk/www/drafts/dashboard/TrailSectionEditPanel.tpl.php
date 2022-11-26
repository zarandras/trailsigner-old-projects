<?php
	// This is the HTML template include file (.tpl.php) for trail_sectionEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblTrailSectionId->RenderWithName(); ?>

		<?php $_CONTROL->lstTrail->RenderWithName(); ?>

		<?php $_CONTROL->lstFromNode->RenderWithName(); ?>

		<?php $_CONTROL->lstToNode->RenderWithName(); ?>

		<?php $_CONTROL->txtParamName->RenderWithName(); ?>

		<?php $_CONTROL->txtValue->RenderWithName(); ?>

		<?php $_CONTROL->chkIsOneway->RenderWithName(); ?>

		<?php $_CONTROL->chkWithBranch->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
