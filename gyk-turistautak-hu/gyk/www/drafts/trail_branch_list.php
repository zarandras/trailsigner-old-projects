<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailBranch class.  It uses the code-generated
	 * TrailBranchDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailBranch columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_branch_list.php AND
	 * trail_branch_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailBranchListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailBranches
		protected $dtgTrailBranches;

		// Create QForm Event Handlers as Needed

//		protected function Form_Exit() {}
//		protected function Form_Load() {}
//		protected function Form_PreRender() {}
//		protected function Form_Validate() {}

		protected function Form_Run() {
			// Security check for ALLOW_REMOTE_ADMIN
			// To allow access REGARDLESS of ALLOW_REMOTE_ADMIN, simply remove the line below
			QApplication::CheckRemoteAdmin();
		}

		protected function Form_Create() {
			// Instantiate the Meta DataGrid
			$this->dtgTrailBranches = new TrailBranchDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailBranches->CssClass = 'datagrid';
			$this->dtgTrailBranches->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailBranches->Paginator = new QPaginator($this->dtgTrailBranches);
			$this->dtgTrailBranches->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_branch_edit.php';
			$this->dtgTrailBranches->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_branch's properties, or you
			// can traverse down QQN::trail_branch() to display fields that are down the hierarchy)
			$this->dtgTrailBranches->MetaAddColumn('BranchId');
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchTrail);
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchFromNode);
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchToNode);
			$this->dtgTrailBranches->MetaAddColumn('BranchTrailmark');
			$this->dtgTrailBranches->MetaAddColumn('BranchModality');
			$this->dtgTrailBranches->MetaAddColumn('BranchLengthProjection');
			$this->dtgTrailBranches->MetaAddColumn('BranchLengthSlope');
			$this->dtgTrailBranches->MetaAddColumn('BranchAscentTo');
			$this->dtgTrailBranches->MetaAddColumn('BranchAscentFrom');
			$this->dtgTrailBranches->MetaAddColumn('BranchMinutesTo');
			$this->dtgTrailBranches->MetaAddColumn('BranchMinutesFrom');
			$this->dtgTrailBranches->MetaAddColumn('BranchSegments');
			$this->dtgTrailBranches->MetaAddColumn('BranchSegmentsRev');
			$this->dtgTrailBranches->MetaAddColumn('BranchPoints');
			$this->dtgTrailBranches->MetaAddColumn('BranchPointsRev');
			$this->dtgTrailBranches->MetaAddColumn('BranchRemark');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_branch_list.tpl.php as the included HTML template file
	TrailBranchListForm::Run('TrailBranchListForm');
?>