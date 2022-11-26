<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailNodeBidir class.  It uses the code-generated
	 * TrailNodeBidirDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailNodeBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_node_bidir_list.php AND
	 * trail_node_bidir_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailNodeBidirListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailNodeBidirs
		protected $dtgTrailNodeBidirs;

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
			$this->dtgTrailNodeBidirs = new TrailNodeBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailNodeBidirs->CssClass = 'datagrid';
			$this->dtgTrailNodeBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailNodeBidirs->Paginator = new QPaginator($this->dtgTrailNodeBidirs);
			$this->dtgTrailNodeBidirs->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_node_bidir_edit.php';
			$this->dtgTrailNodeBidirs->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_node_bidir's properties, or you
			// can traverse down QQN::trail_node_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailNodeBidirs->MetaAddColumn('TrailNodeId');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Trail);
			$this->dtgTrailNodeBidirs->MetaAddColumn('NodeIdx');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Branch);
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Noi);
			$this->dtgTrailNodeBidirs->MetaAddColumn('Name');
			$this->dtgTrailNodeBidirs->MetaAddColumn('Picto');
			$this->dtgTrailNodeBidirs->MetaAddColumn('Priority');
			$this->dtgTrailNodeBidirs->MetaAddColumn('PriorityRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectTrailmark');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectModality');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectAscentTo');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectSegments');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectPoints');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectPointsRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectRemark');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->AbsWptNode);
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->AbsSectNode);
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_node_bidir_list.tpl.php as the included HTML template file
	TrailNodeBidirListForm::Run('TrailNodeBidirListForm');
?>