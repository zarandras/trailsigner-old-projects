<?php
	// This is the HTML template include file (.tpl.php) for trail_bidirEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblTrailId->RenderWithName(); ?>

		<?php $_CONTROL->txtTrailCode->RenderWithName(); ?>

		<?php $_CONTROL->txtTrailmark->RenderWithName(); ?>

		<?php $_CONTROL->txtModality->RenderWithName(); ?>

		<?php $_CONTROL->txtName->RenderWithName(); ?>

		<?php $_CONTROL->txtNameExt->RenderWithName(); ?>

		<?php $_CONTROL->txtNameExtRev->RenderWithName(); ?>

		<?php $_CONTROL->txtDescription->RenderWithName(); ?>

		<?php $_CONTROL->txtDescriptionRev->RenderWithName(); ?>

		<?php $_CONTROL->txtRemark->RenderWithName(); ?>

		<?php $_CONTROL->txtGeodbService->RenderWithName(); ?>

		<?php $_CONTROL->lstRevTrail->RenderWithName(); ?>

		<?php $_CONTROL->lstAbsTrail->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
