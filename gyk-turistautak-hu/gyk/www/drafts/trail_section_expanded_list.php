<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TrailSectionExpanded class.  It uses the code-generated
	 * TrailSectionExpandedDataGrid control which has meta-methods to help with
	 * easily creating/defining TrailSectionExpanded columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_expanded_list.php AND
	 * trail_section_expanded_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionExpandedListForm extends QForm {
		// Local instance of the Meta DataGrid to list TrailSectionExpandeds
		protected $dtgTrailSectionExpandeds;

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
			$this->dtgTrailSectionExpandeds = new TrailSectionExpandedDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionExpandeds->CssClass = 'datagrid';
			$this->dtgTrailSectionExpandeds->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionExpandeds->Paginator = new QPaginator($this->dtgTrailSectionExpandeds);
			$this->dtgTrailSectionExpandeds->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_expanded_edit.php';
			$this->dtgTrailSectionExpandeds->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_expanded's properties, or you
			// can traverse down QQN::trail_section_expanded() to display fields that are down the hierarchy)
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->TrailSection);
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->TrailNode);
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->Trail);
			$this->dtgTrailSectionExpandeds->MetaAddColumn('NodeIdx');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('BranchId');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('NoiId');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Name');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Picto');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Priority');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('PriorityRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectTrailmark');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectModality');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectAscentTo');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectSegments');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectPoints');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectPointsRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectRemark');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('DefinedAsFirst');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('DefinedAsLast');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('UseBranchDir');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// trail_section_expanded_list.tpl.php as the included HTML template file
	TrailSectionExpandedListForm::Run('TrailSectionExpandedListForm');
?>