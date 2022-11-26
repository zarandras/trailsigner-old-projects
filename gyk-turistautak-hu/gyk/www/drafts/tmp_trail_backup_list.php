<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do the List All functionality
	 * of the TmpTrailBackup class.  It uses the code-generated
	 * TmpTrailBackupDataGrid control which has meta-methods to help with
	 * easily creating/defining TmpTrailBackup columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both tmp_trail_backup_list.php AND
	 * tmp_trail_backup_list.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TmpTrailBackupListForm extends QForm {
		// Local instance of the Meta DataGrid to list TmpTrailBackups
		protected $dtgTmpTrailBackups;

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
			$this->dtgTmpTrailBackups = new TmpTrailBackupDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTmpTrailBackups->CssClass = 'datagrid';
			$this->dtgTmpTrailBackups->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTmpTrailBackups->Paginator = new QPaginator($this->dtgTmpTrailBackups);
			$this->dtgTmpTrailBackups->ItemsPerPage = 20;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$strEditPageUrl = __VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/tmp_trail_backup_edit.php';
			$this->dtgTmpTrailBackups->MetaAddEditLinkColumn($strEditPageUrl, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for tmp_trail_backup's properties, or you
			// can traverse down QQN::tmp_trail_backup() to display fields that are down the hierarchy)
			$this->dtgTmpTrailBackups->MetaAddColumn('TrailId');
			$this->dtgTmpTrailBackups->MetaAddColumn('TrailCode');
			$this->dtgTmpTrailBackups->MetaAddColumn('Trailmark');
			$this->dtgTmpTrailBackups->MetaAddColumn('Modality');
			$this->dtgTmpTrailBackups->MetaAddColumn('Name');
			$this->dtgTmpTrailBackups->MetaAddColumn('NameExt');
			$this->dtgTmpTrailBackups->MetaAddColumn('NameExtRev');
			$this->dtgTmpTrailBackups->MetaAddColumn('Description');
			$this->dtgTmpTrailBackups->MetaAddColumn('DescriptionRev');
			$this->dtgTmpTrailBackups->MetaAddColumn('Remark');
			$this->dtgTmpTrailBackups->MetaAddColumn('GeodbService');
		}
	}

	// Go ahead and run this form object to generate the page and event handlers, implicitly using
	// tmp_trail_backup_list.tpl.php as the included HTML template file
	TmpTrailBackupListForm::Run('TmpTrailBackupListForm');
?>