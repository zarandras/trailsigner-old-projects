<?php
	// This is the HTML template include file (.tpl.php) for signpostEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblSignpostId->RenderWithName(); ?>

		<?php $_CONTROL->txtSignpostCode->RenderWithName(); ?>

		<?php $_CONTROL->lstNoi->RenderWithName(); ?>

		<?php $_CONTROL->txtLat->RenderWithName(); ?>

		<?php $_CONTROL->txtLon->RenderWithName(); ?>

		<?php $_CONTROL->txtSignpostType->RenderWithName(); ?>

		<?php $_CONTROL->txtDirection->RenderWithName(); ?>

		<?php $_CONTROL->txtAngle->RenderWithName(); ?>

		<?php $_CONTROL->txtMaterial->RenderWithName(); ?>

		<?php $_CONTROL->txtSubtype->RenderWithName(); ?>

		<?php $_CONTROL->txtContent->RenderWithName(); ?>

		<?php $_CONTROL->txtStatus->RenderWithName(); ?>

		<?php $_CONTROL->txtCondition->RenderWithName(); ?>

		<?php $_CONTROL->calInstalled->RenderWithName(); ?>

		<?php $_CONTROL->calChecked->RenderWithName(); ?>

		<?php $_CONTROL->txtMaintainer->RenderWithName(); ?>

		<?php $_CONTROL->txtSponsor->RenderWithName(); ?>

		<?php $_CONTROL->txtRemark->RenderWithName(); ?>

		<?php $_CONTROL->lstParent->RenderWithName(); ?>

		<?php $_CONTROL->chkIsVirtual->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
