<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailSection class.  It uses the code-generated
	 * TrailSectionMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailSection columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_edit.php AND
	 * trail_section_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionEditPanel extends QPanel {
		// Local instance of the TrailSectionMetaControl
		protected $mctTrailSection;

		// Controls for TrailSection's Data Fields
		public $lblTrailSectionId;
		public $lstTrail;
		public $lstFromNode;
		public $lstToNode;
		public $txtParamName;
		public $txtValue;
		public $chkIsOneway;
		public $chkWithBranch;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

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
			$this->strTemplate = 'TrailSectionEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailSectionMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSection = TrailSectionMetaControl::Create($this, $intTrailSectionId);

			// Call MetaControl's methods to create qcontrols based on TrailSection's data fields
			$this->lblTrailSectionId = $this->mctTrailSection->lblTrailSectionId_Create();
			$this->lstTrail = $this->mctTrailSection->lstTrail_Create();
			$this->lstFromNode = $this->mctTrailSection->lstFromNode_Create();
			$this->lstToNode = $this->mctTrailSection->lstToNode_Create();
			$this->txtParamName = $this->mctTrailSection->txtParamName_Create();
			$this->txtValue = $this->mctTrailSection->txtValue_Create();
			$this->chkIsOneway = $this->mctTrailSection->chkIsOneway_Create();
			$this->chkWithBranch = $this->mctTrailSection->chkWithBranch_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSection') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSection->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailSectionMetaControl
			$this->mctTrailSection->SaveTrailSection();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionMetaControl
			$this->mctTrailSection->DeleteTrailSection();
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