<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the Noi class.  It uses the code-generated
	 * NoiMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Noi columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both noi_edit.php AND
	 * noi_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class NoiEditPanel extends QPanel {
		// Local instance of the NoiMetaControl
		protected $mctNoi;

		// Controls for Noi's Data Fields
		public $lblNoiId;
		public $txtName;
		public $txtName2;
		public $txtName3;
		public $txtPicto;
		public $txtTuhuId;
		public $txtOmpId;
		public $txtLat;
		public $txtLon;
		public $txtAlt;
		public $txtUrl;
		public $txtCategories;
		public $txtDescription;
		public $txtDefPriority;
		public $lstParent;
		public $chkIsVirtual;
		public $txtCountry;
		public $txtRegion;
		public $txtTown;
		public $txtLandowner;
		public $txtHrsz;
		public $txtGroup;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intNoiId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'NoiEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the NoiMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctNoi = NoiMetaControl::Create($this, $intNoiId);

			// Call MetaControl's methods to create qcontrols based on Noi's data fields
			$this->lblNoiId = $this->mctNoi->lblNoiId_Create();
			$this->txtName = $this->mctNoi->txtName_Create();
			$this->txtName2 = $this->mctNoi->txtName2_Create();
			$this->txtName3 = $this->mctNoi->txtName3_Create();
			$this->txtPicto = $this->mctNoi->txtPicto_Create();
			$this->txtTuhuId = $this->mctNoi->txtTuhuId_Create();
			$this->txtOmpId = $this->mctNoi->txtOmpId_Create();
			$this->txtLat = $this->mctNoi->txtLat_Create();
			$this->txtLon = $this->mctNoi->txtLon_Create();
			$this->txtAlt = $this->mctNoi->txtAlt_Create();
			$this->txtUrl = $this->mctNoi->txtUrl_Create();
			$this->txtCategories = $this->mctNoi->txtCategories_Create();
			$this->txtDescription = $this->mctNoi->txtDescription_Create();
			$this->txtDefPriority = $this->mctNoi->txtDefPriority_Create();
			$this->lstParent = $this->mctNoi->lstParent_Create();
			$this->chkIsVirtual = $this->mctNoi->chkIsVirtual_Create();
			$this->txtCountry = $this->mctNoi->txtCountry_Create();
			$this->txtRegion = $this->mctNoi->txtRegion_Create();
			$this->txtTown = $this->mctNoi->txtTown_Create();
			$this->txtLandowner = $this->mctNoi->txtLandowner_Create();
			$this->txtHrsz = $this->mctNoi->txtHrsz_Create();
			$this->txtGroup = $this->mctNoi->txtGroup_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Noi') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctNoi->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the NoiMetaControl
			$this->mctNoi->SaveNoi();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the NoiMetaControl
			$this->mctNoi->DeleteNoi();
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