<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailSectionBidir class.  It uses the code-generated
	 * TrailSectionBidirMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailSectionBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_bidir_edit.php AND
	 * trail_section_bidir_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionBidirEditPanel extends QPanel {
		// Local instance of the TrailSectionBidirMetaControl
		protected $mctTrailSectionBidir;

		// Controls for TrailSectionBidir's Data Fields
		public $lblTrailSectionId;
		public $lstTrail;
		public $lstFromNode;
		public $lstToNode;
		public $txtParamName;
		public $txtValue;
		public $chkIsOneway;
		public $chkWithBranch;
		public $lstRevTrailSection;
		public $lstAbsTrailSection;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References
		public $lstTrailSectionStat;

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intTrailSectionId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TrailSectionBidirEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailSectionBidirMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSectionBidir = TrailSectionBidirMetaControl::Create($this, $intTrailSectionId);

			// Call MetaControl's methods to create qcontrols based on TrailSectionBidir's data fields
			$this->lblTrailSectionId = $this->mctTrailSectionBidir->lblTrailSectionId_Create();
			$this->lstTrail = $this->mctTrailSectionBidir->lstTrail_Create();
			$this->lstFromNode = $this->mctTrailSectionBidir->lstFromNode_Create();
			$this->lstToNode = $this->mctTrailSectionBidir->lstToNode_Create();
			$this->txtParamName = $this->mctTrailSectionBidir->txtParamName_Create();
			$this->txtValue = $this->mctTrailSectionBidir->txtValue_Create();
			$this->chkIsOneway = $this->mctTrailSectionBidir->chkIsOneway_Create();
			$this->chkWithBranch = $this->mctTrailSectionBidir->chkWithBranch_Create();
			$this->lstRevTrailSection = $this->mctTrailSectionBidir->lstRevTrailSection_Create();
			$this->lstAbsTrailSection = $this->mctTrailSectionBidir->lstAbsTrailSection_Create();
			$this->lstTrailSectionStat = $this->mctTrailSectionBidir->lstTrailSectionStat_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSectionBidir') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSectionBidir->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailSectionBidirMetaControl
			$this->mctTrailSectionBidir->SaveTrailSectionBidir();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionBidirMetaControl
			$this->mctTrailSectionBidir->DeleteTrailSectionBidir();
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