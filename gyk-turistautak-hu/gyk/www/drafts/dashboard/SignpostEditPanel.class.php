<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the Signpost class.  It uses the code-generated
	 * SignpostMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Signpost columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_edit.php AND
	 * signpost_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostEditPanel extends QPanel {
		// Local instance of the SignpostMetaControl
		protected $mctSignpost;

		// Controls for Signpost's Data Fields
		public $lblSignpostId;
		public $txtSignpostCode;
		public $lstNoi;
		public $txtLat;
		public $txtLon;
		public $txtSignpostType;
		public $txtDirection;
		public $txtAngle;
		public $txtMaterial;
		public $txtSubtype;
		public $txtContent;
		public $txtStatus;
		public $txtCondition;
		public $calInstalled;
		public $calChecked;
		public $txtMaintainer;
		public $txtSponsor;
		public $txtRemark;
		public $lstParent;
		public $chkIsVirtual;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intSignpostId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'SignpostEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the SignpostMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctSignpost = SignpostMetaControl::Create($this, $intSignpostId);

			// Call MetaControl's methods to create qcontrols based on Signpost's data fields
			$this->lblSignpostId = $this->mctSignpost->lblSignpostId_Create();
			$this->txtSignpostCode = $this->mctSignpost->txtSignpostCode_Create();
			$this->lstNoi = $this->mctSignpost->lstNoi_Create();
			$this->txtLat = $this->mctSignpost->txtLat_Create();
			$this->txtLon = $this->mctSignpost->txtLon_Create();
			$this->txtSignpostType = $this->mctSignpost->txtSignpostType_Create();
			$this->txtDirection = $this->mctSignpost->txtDirection_Create();
			$this->txtAngle = $this->mctSignpost->txtAngle_Create();
			$this->txtMaterial = $this->mctSignpost->txtMaterial_Create();
			$this->txtSubtype = $this->mctSignpost->txtSubtype_Create();
			$this->txtContent = $this->mctSignpost->txtContent_Create();
			$this->txtStatus = $this->mctSignpost->txtStatus_Create();
			$this->txtCondition = $this->mctSignpost->txtCondition_Create();
			$this->calInstalled = $this->mctSignpost->calInstalled_Create();
			$this->calChecked = $this->mctSignpost->calChecked_Create();
			$this->txtMaintainer = $this->mctSignpost->txtMaintainer_Create();
			$this->txtSponsor = $this->mctSignpost->txtSponsor_Create();
			$this->txtRemark = $this->mctSignpost->txtRemark_Create();
			$this->lstParent = $this->mctSignpost->lstParent_Create();
			$this->chkIsVirtual = $this->mctSignpost->chkIsVirtual_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Signpost') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctSignpost->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the SignpostMetaControl
			$this->mctSignpost->SaveSignpost();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the SignpostMetaControl
			$this->mctSignpost->DeleteSignpost();
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