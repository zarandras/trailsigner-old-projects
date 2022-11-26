<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TmpTrailBackup class.  It uses the code-generated
	 * TmpTrailBackupMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TmpTrailBackup columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both tmp_trail_backup_edit.php AND
	 * tmp_trail_backup_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TmpTrailBackupEditPanel extends QPanel {
		// Local instance of the TmpTrailBackupMetaControl
		protected $mctTmpTrailBackup;

		// Controls for TmpTrailBackup's Data Fields
		public $lblTrailId;
		public $txtTrailCode;
		public $txtTrailmark;
		public $txtModality;
		public $txtName;
		public $txtNameExt;
		public $txtNameExtRev;
		public $txtDescription;
		public $txtDescriptionRev;
		public $txtRemark;
		public $txtGeodbService;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intTrailId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TmpTrailBackupEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TmpTrailBackupMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTmpTrailBackup = TmpTrailBackupMetaControl::Create($this, $intTrailId);

			// Call MetaControl's methods to create qcontrols based on TmpTrailBackup's data fields
			$this->lblTrailId = $this->mctTmpTrailBackup->lblTrailId_Create();
			$this->txtTrailCode = $this->mctTmpTrailBackup->txtTrailCode_Create();
			$this->txtTrailmark = $this->mctTmpTrailBackup->txtTrailmark_Create();
			$this->txtModality = $this->mctTmpTrailBackup->txtModality_Create();
			$this->txtName = $this->mctTmpTrailBackup->txtName_Create();
			$this->txtNameExt = $this->mctTmpTrailBackup->txtNameExt_Create();
			$this->txtNameExtRev = $this->mctTmpTrailBackup->txtNameExtRev_Create();
			$this->txtDescription = $this->mctTmpTrailBackup->txtDescription_Create();
			$this->txtDescriptionRev = $this->mctTmpTrailBackup->txtDescriptionRev_Create();
			$this->txtRemark = $this->mctTmpTrailBackup->txtRemark_Create();
			$this->txtGeodbService = $this->mctTmpTrailBackup->txtGeodbService_Create();

			// Create Buttons and Actions on this Form
			$this->btnSave = new QButton($this);
			$this->btnSave->Text = QApplication::Translate('Save');
			$this->btnSave->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnSave_Click'));
			$this->btnSave->CausesValidation = $this;

			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCancel_Click'));

			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TmpTrailBackup') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTmpTrailBackup->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TmpTrailBackupMetaControl
			$this->mctTmpTrailBackup->SaveTmpTrailBackup();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TmpTrailBackupMetaControl
			$this->mctTmpTrailBackup->DeleteTmpTrailBackup();
			$this->CloseSelf(true);
		}

		public function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->CloseSelf(false);
		}

		// Close Myself and Call ClosePanelMethod Callback
		protected function CloseSelf($blnChangesMade) {
			$strMethod = $this->strClosePanelMethod;
			$this->objForm->$strMethod($blnChangesMade);
		}
	}
?>