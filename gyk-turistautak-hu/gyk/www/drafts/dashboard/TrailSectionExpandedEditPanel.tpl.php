<?php
	// This is the HTML template include file (.tpl.php) for trail_section_expandedEditPanel.
	// Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the drafts/dashboard subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.
?>
	<div id="formControls">
		<?php $_CONTROL->lstTrailSection->RenderWithName(); ?>

		<?php $_CONTROL->lstTrailNode->RenderWithName(); ?>

		<?php $_CONTROL->lstTrail->RenderWithName(); ?>

		<?php $_CONTROL->txtNodeIdx->RenderWithName(); ?>

		<?php $_CONTROL->txtBranchId->RenderWithName(); ?>

		<?php $_CONTROL->txtNoiId->RenderWithName(); ?>

		<?php $_CONTROL->txtName->RenderWithName(); ?>

		<?php $_CONTROL->txtPicto->RenderWithName(); ?>

		<?php $_CONTROL->txtPriority->RenderWithName(); ?>

		<?php $_CONTROL->txtPriorityRev->RenderWithName(); ?>

		<?php $_CONTROL->txtSectTrailmark->RenderWithName(); ?>

		<?php $_CONTROL->txtSectModality->RenderWithName(); ?>

		<?php $_CONTROL->txtSectLengthProjection->RenderWithName(); ?>

		<?php $_CONTROL->txtSectLengthSlope->RenderWithName(); ?>

		<?php $_CONTROL->txtSectAscentTo->RenderWithName(); ?>

		<?php $_CONTROL->txtSectAscentFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtSectMinutesTo->RenderWithName(); ?>

		<?php $_CONTROL->txtSectMinutesFrom->RenderWithName(); ?>

		<?php $_CONTROL->txtSectSegments->RenderWithName(); ?>

		<?php $_CONTROL->txtSectSegmentsRev->RenderWithName(); ?>

		<?php $_CONTROL->txtSectPoints->RenderWithName(); ?>

		<?php $_CONTROL->txtSectPointsRev->RenderWithName(); ?>

		<?php $_CONTROL->txtSectRemark->RenderWithName(); ?>

		<?php $_CONTROL->chkDefinedAsFirst->RenderWithName(); ?>

		<?php $_CONTROL->chkDefinedAsLast->RenderWithName(); ?>

		<?php $_CONTROL->txtUseBranchDir->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $_CONTROL->btnSave->Render(); ?></div>
		<div id="cancel"><?php $_CONTROL->btnCancel->Render(); ?></div>
		<div id="delete"><?php $_CONTROL->btnDelete->Render(); ?></div>
	</div>
