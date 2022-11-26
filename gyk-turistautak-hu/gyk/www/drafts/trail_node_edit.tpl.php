<?php
	// This is the HTML template include file (.tpl.php) for the trail_node_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.

	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent 
	// code re-generations do not overwrite your changes.

	$strPageTitle = QApplication::Translate('TrailNode') . ' - ' . $this->mctTrailNode->TitleVerb;
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>

	<div id="titleBar">
		<h2><?php _p($this->mctTrailNode->TitleVerb); ?></h2>
		<h1><?php _t('TrailNode')?></h1>
	</div>

	<div id="formControls">
		<?php $this->lblTrailNodeId->RenderWithName(); ?>

		<?php $this->lstTrail->RenderWithName(); ?>

		<?php $this->txtNodeIdx->RenderWithName(); ?>

		<?php $this->lstBranch->RenderWithName(); ?>

		<?php $this->lstNoi->RenderWithName(); ?>

		<?php $this->txtName->RenderWithName(); ?>

		<?php $this->txtPicto->RenderWithName(); ?>

		<?php $this->txtPriority->RenderWithName(); ?>

		<?php $this->txtPriorityRev->RenderWithName(); ?>

		<?php $this->txtSectTrailmark->RenderWithName(); ?>

		<?php $this->txtSectModality->RenderWithName(); ?>

		<?php $this->txtSectLengthProjection->RenderWithName(); ?>

		<?php $this->txtSectLengthSlope->RenderWithName(); ?>

		<?php $this->txtSectAscentTo->RenderWithName(); ?>

		<?php $this->txtSectAscentFrom->RenderWithName(); ?>

		<?php $this->txtSectMinutesTo->RenderWithName(); ?>

		<?php $this->txtSectMinutesFrom->RenderWithName(); ?>

		<?php $this->txtSectSegments->RenderWithName(); ?>

		<?php $this->txtSectSegmentsRev->RenderWithName(); ?>

		<?php $this->txtSectPoints->RenderWithName(); ?>

		<?php $this->txtSectPointsRev->RenderWithName(); ?>

		<?php $this->txtSectRemark->RenderWithName(); ?>

	</div>

	<div id="formActions">
		<div id="save"><?php $this->btnSave->Render(); ?></div>
		<div id="cancel"><?php $this->btnCancel->Render(); ?></div>
		<div id="delete"><?php $this->btnDelete->Render(); ?></div>
	</div>

	<?php $this->RenderEnd() ?>	

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>