<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailNode class.  It uses the code-generated
	 * TrailNodeDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailNode columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_node_list.php AND
	 * trail_node_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailNodeListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailNodes
		protected $dtgTrailNodes;

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
			$this->dtgTrailNodes = new TrailNodeDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailNodes->CssClass = 'datagrid';
			$this->dtgTrailNodes->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailNodes->Paginator = new QPaginator($this->dtgTrailNodes);
			$this->dtgTrailNodes->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_node_edit.php';
			$this->dtgTrailNodes->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_node's properties, or you
			// can traverse down QQN::trail_node() to display fields that are down the hierarchy)
			$this->dtgTrailNodes->MetaAddColumn('TrailNodeId');
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Trail);
			$this->dtgTrailNodes->MetaAddColumn('NodeIdx');
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Branch);
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Noi);
			$this->dtgTrailNodes->MetaAddColumn('Name');
			$this->dtgTrailNodes->MetaAddColumn('Picto');
			$this->dtgTrailNodes->MetaAddColumn('Priority');
			$this->dtgTrailNodes->MetaAddColumn('PriorityRev');
			$this->dtgTrailNodes->MetaAddColumn('SectTrailmark');
			$this->dtgTrailNodes->MetaAddColumn('SectModality');
			$this->dtgTrailNodes->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailNodes->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailNodes->MetaAddColumn('SectAscentTo');
			$this->dtgTrailNodes->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailNodes->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailNodes->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailNodes->MetaAddColumn('SectSegments');
			$this->dtgTrailNodes->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailNodes->MetaAddColumn('SectPoints');
			$this->dtgTrailNodes->MetaAddColumn('SectPointsRev');
			$this->dtgTrailNodes->MetaAddColumn('SectRemark');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_node_list.tpl.php as the included HTML template file
	TrailNodeListForm::Run('TrailNodeListForm');
?>