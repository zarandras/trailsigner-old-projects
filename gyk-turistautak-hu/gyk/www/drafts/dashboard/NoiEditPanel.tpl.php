<?php
	// This is the HTML template include file (.tpl.php) for noiEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lblNoiId->RenderWithName(); ?>

		<?php $_CONTROL->txtName->RenderWithName(); ?>

		<?php $_CONTROL->txtName2->RenderWithName(); ?>

		<?php $_CONTROL->txtName3->RenderWithName(); ?>

		<?php $_CONTROL->txtPicto->RenderWithName(); ?>

		<?php $_CONTROL->txtTuhuId->RenderWithName(); ?>

		<?php $_CONTROL->txtOmpId->RenderWithName(); ?>

		<?php $_CONTROL->txtLat->RenderWithName(); ?>

		<?php $_CONTROL->txtLon->RenderWithName(); ?>

		<?php $_CONTROL->txtAlt->RenderWithName(); ?>

		<?php $_CONTROL->txtUrl->RenderWithName(); ?>

		<?php $_CONTROL->txtCategories->RenderWithName(); ?>

		<?php $_CONTROL->txtDescription->RenderWithName(); ?>

		<?php $_CONTROL->txtDefPriority->RenderWithName(); ?>

		<?php $_CONTROL->lstParent->RenderWithName(); ?>

		<?php $_CONTROL->chkIsVirtual->RenderWithName(); ?>

		<?php $_CONTROL->txtCountry->RenderWithName(); ?>

		<?php $_CONTROL->txtRegion->RenderWithName(); ?>

		<?php $_CONTROL->txtTown->RenderWithName(); ?>

		<?php $_CONTROL->txtLandowner->RenderWithName(); ?>

		<?php $_CONTROL->txtHrsz->RenderWithName(); ?>

		<?php $_CONTROL->txtGroup->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
