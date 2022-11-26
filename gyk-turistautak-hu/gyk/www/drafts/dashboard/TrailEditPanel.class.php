<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the Trail class.  It uses the code-generated
	 * TrailMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Trail columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_edit.php AND
	 * trail_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailEditPanel extends QPanel {
		// Local instance of the TrailMetaControl
		protected $mctTrail;

		// Controls for Trail's Data Fields
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
			$this->strTemplate = 'TrailEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrail = TrailMetaControl::Create($this, $intTrailId);

			// Call MetaControl's methods to create qcontrols based on Trail's data fields
			$this->lblTrailId = $this->mctTrail->lblTrailId_Create();
			$this->txtTrailCode = $this->mctTrail->txtTrailCode_Create();
			$this->txtTrailmark = $this->mctTrail->txtTrailmark_Create();
			$this->txtModality = $this->mctTrail->txtModality_Create();
			$this->txtName = $this->mctTrail->txtName_Create();
			$this->txtNameExt = $this->mctTrail->txtNameExt_Create();
			$this->txtNameExtRev = $this->mctTrail->txtNameExtRev_Create();
			$this->txtDescription = $this->mctTrail->txtDescription_Create();
			$this->txtDescriptionRev = $this->mctTrail->txtDescriptionRev_Create();
			$this->txtRemark = $this->mctTrail->txtRemark_Create();
			$this->txtGeodbService = $this->mctTrail->txtGeodbService_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Trail') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrail->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailMetaControl
			$this->mctTrail->SaveTrail();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailMetaControl
			$this->mctTrail->DeleteTrail();
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