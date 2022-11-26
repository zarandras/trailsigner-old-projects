<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailBidir class.  It uses the code-generated
	 * TrailBidirMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_bidir_edit.php AND
	 * trail_bidir_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailBidirEditPanel extends QPanel {
		// Local instance of the TrailBidirMetaControl
		protected $mctTrailBidir;

		// Controls for TrailBidir's Data Fields
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
		public $lstRevTrail;
		public $lstAbsTrail;

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
			$this->strTemplate = 'TrailBidirEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailBidirMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailBidir = TrailBidirMetaControl::Create($this, $intTrailId);

			// Call MetaControl's methods to create qcontrols based on TrailBidir's data fields
			$this->lblTrailId = $this->mctTrailBidir->lblTrailId_Create();
			$this->txtTrailCode = $this->mctTrailBidir->txtTrailCode_Create();
			$this->txtTrailmark = $this->mctTrailBidir->txtTrailmark_Create();
			$this->txtModality = $this->mctTrailBidir->txtModality_Create();
			$this->txtName = $this->mctTrailBidir->txtName_Create();
			$this->txtNameExt = $this->mctTrailBidir->txtNameExt_Create();
			$this->txtNameExtRev = $this->mctTrailBidir->txtNameExtRev_Create();
			$this->txtDescription = $this->mctTrailBidir->txtDescription_Create();
			$this->txtDescriptionRev = $this->mctTrailBidir->txtDescriptionRev_Create();
			$this->txtRemark = $this->mctTrailBidir->txtRemark_Create();
			$this->txtGeodbService = $this->mctTrailBidir->txtGeodbService_Create();
			$this->lstRevTrail = $this->mctTrailBidir->lstRevTrail_Create();
			$this->lstAbsTrail = $this->mctTrailBidir->lstAbsTrail_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailBidir') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailBidir->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailBidirMetaControl
			$this->mctTrailBidir->SaveTrailBidir();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailBidirMetaControl
			$this->mctTrailBidir->DeleteTrailBidir();
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