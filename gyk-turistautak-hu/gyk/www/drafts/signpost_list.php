<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the Signpost class.  It uses the code-generated
	 * SignpostDataGrid control which has meta-methods to help with
	 * easily creating/defining Signpost columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_list.php AND
	 * signpost_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostListForm extends QForm {
		// Local instance of the Meta DataGrid to list Signposts
		protected $dtgSignposts;

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
			$this->dtgSignposts = new SignpostDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignposts->CssClass = 'datagrid';
			$this->dtgSignposts->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignposts->Paginator = new QPaginator($this->dtgSignposts);
			$this->dtgSignposts->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/signpost_edit.php';
			$this->dtgSignposts->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost's properties, or you
			// can traverse down QQN::signpost() to display fields that are down the hierarchy)
			$this->dtgSignposts->MetaAddColumn('SignpostId');
			$this->dtgSignposts->MetaAddColumn('SignpostCode');
			$this->dtgSignposts->MetaAddColumn(QQN::Signpost()->Noi);
			$this->dtgSignposts->MetaAddColumn('Lat');
			$this->dtgSignposts->MetaAddColumn('Lon');
			$this->dtgSignposts->MetaAddColumn('SignpostType');
			$this->dtgSignposts->MetaAddColumn('Direction');
			$this->dtgSignposts->MetaAddColumn('Angle');
			$this->dtgSignposts->MetaAddColumn('Material');
			$this->dtgSignposts->MetaAddColumn('Subtype');
			$this->dtgSignposts->MetaAddColumn('Content');
			$this->dtgSignposts->MetaAddColumn('Status');
			$this->dtgSignposts->MetaAddColumn('Condition');
			$this->dtgSignposts->MetaAddColumn('Installed');
			$this->dtgSignposts->MetaAddColumn('Checked');
			$this->dtgSignposts->MetaAddColumn('Maintainer');
			$this->dtgSignposts->MetaAddColumn('Sponsor');
			$this->dtgSignposts->MetaAddColumn('Remark');
			$this->dtgSignposts->MetaAddColumn(QQN::Signpost()->Parent);
			$this->dtgSignposts->MetaAddColumn('IsVirtual');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// signpost_list.tpl.php as the included HTML template file
	SignpostListForm::Run('SignpostListForm');
?>