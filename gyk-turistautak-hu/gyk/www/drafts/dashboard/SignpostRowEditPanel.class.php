<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the SignpostRow class.  It uses the code-generated
	 * SignpostRowMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a SignpostRow columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_row_edit.php AND
	 * signpost_row_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostRowEditPanel extends QPanel {
		// Local instance of the SignpostRowMetaControl
		protected $mctSignpostRow;

		// Controls for SignpostRow's Data Fields
		public $lblSignpostRowId;
		public $lstSignpost;
		public $txtRowIdx;
		public $txtRowType;
		public $chkHasBranchline;
		public $lstTrail;
		public $lstFromNode;
		public $txtOffsetLength;
		public $txtOffsetMinutes;
		public $lstToNode;
		public $txtContentText;
		public $txtContentText2;
		public $txtPicto;
		public $txtLengthSlope;
		public $txtMinutesTo;
		public $txtMinutesRounded;
		public $txtTrailmark;
		public $txtModality;
		public $chkIsHidden;
		public $txtTechRemark;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References
		public $lstSignpostRowActualStat;

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intSignpostRowId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'SignpostRowEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the SignpostRowMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctSignpostRow = SignpostRowMetaControl::Create($this, $intSignpostRowId);

			// Call MetaControl's methods to create qcontrols based on SignpostRow's data fields
			$this->lblSignpostRowId = $this->mctSignpostRow->lblSignpostRowId_Create();
			$this->lstSignpost = $this->mctSignpostRow->lstSignpost_Create();
			$this->txtRowIdx = $this->mctSignpostRow->txtRowIdx_Create();
			$this->txtRowType = $this->mctSignpostRow->txtRowType_Create();
			$this->chkHasBranchline = $this->mctSignpostRow->chkHasBranchline_Create();
			$this->lstTrail = $this->mctSignpostRow->lstTrail_Create();
			$this->lstFromNode = $this->mctSignpostRow->lstFromNode_Create();
			$this->txtOffsetLength = $this->mctSignpostRow->txtOffsetLength_Create();
			$this->txtOffsetMinutes = $this->mctSignpostRow->txtOffsetMinutes_Create();
			$this->lstToNode = $this->mctSignpostRow->lstToNode_Create();
			$this->txtContentText = $this->mctSignpostRow->txtContentText_Create();
			$this->txtContentText2 = $this->mctSignpostRow->txtContentText2_Create();
			$this->txtPicto = $this->mctSignpostRow->txtPicto_Create();
			$this->txtLengthSlope = $this->mctSignpostRow->txtLengthSlope_Create();
			$this->txtMinutesTo = $this->mctSignpostRow->txtMinutesTo_Create();
			$this->txtMinutesRounded = $this->mctSignpostRow->txtMinutesRounded_Create();
			$this->txtTrailmark = $this->mctSignpostRow->txtTrailmark_Create();
			$this->txtModality = $this->mctSignpostRow->txtModality_Create();
			$this->chkIsHidden = $this->mctSignpostRow->chkIsHidden_Create();
			$this->txtTechRemark = $this->mctSignpostRow->txtTechRemark_Create();
			$this->lstSignpostRowActualStat = $this->mctSignpostRow->lstSignpostRowActualStat_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('SignpostRow') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctSignpostRow->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the SignpostRowMetaControl
			$this->mctSignpostRow->SaveSignpostRow();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the SignpostRowMetaControl
			$this->mctSignpostRow->DeleteSignpostRow();
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