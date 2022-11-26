<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the Noi class.  It uses the code-generated
	 * NoiDataGrid control which has meta-methods to help with
	 * easily creating/defining Noi columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both noi_list.php AND
	 * noi_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class NoiListForm extends QForm {
		// Local instance of the Meta DataGrid to list Nois
		protected $dtgNois;

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
			$this->dtgNois = new NoiDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgNois->CssClass = 'datagrid';
			$this->dtgNois->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgNois->Paginator = new QPaginator($this->dtgNois);
			$this->dtgNois->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/noi_edit.php';
			$this->dtgNois->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for noi's properties, or you
			// can traverse down QQN::noi() to display fields that are down the hierarchy)
			$this->dtgNois->MetaAddColumn('NoiId');
			$this->dtgNois->MetaAddColumn('Name');
			$this->dtgNois->MetaAddColumn('Name2');
			$this->dtgNois->MetaAddColumn('Name3');
			$this->dtgNois->MetaAddColumn('Picto');
			$this->dtgNois->MetaAddColumn('TuhuId');
			$this->dtgNois->MetaAddColumn('OmpId');
			$this->dtgNois->MetaAddColumn('Lat');
			$this->dtgNois->MetaAddColumn('Lon');
			$this->dtgNois->MetaAddColumn('Alt');
			$this->dtgNois->MetaAddColumn('Url');
			$this->dtgNois->MetaAddColumn('Categories');
			$this->dtgNois->MetaAddColumn('Description');
			$this->dtgNois->MetaAddColumn('DefPriority');
			$this->dtgNois->MetaAddColumn(QQN::Noi()->Parent);
			$this->dtgNois->MetaAddColumn('IsVirtual');
			$this->dtgNois->MetaAddColumn('Country');
			$this->dtgNois->MetaAddColumn('Region');
			$this->dtgNois->MetaAddColumn('Town');
			$this->dtgNois->MetaAddColumn('Landowner');
			$this->dtgNois->MetaAddColumn('Hrsz');
			$this->dtgNois->MetaAddColumn('Group');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// noi_list.tpl.php as the included HTML template file
	NoiListForm::Run('NoiListForm');
?>