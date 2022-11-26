<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailBranch class.  It uses the code-generated
	 * TrailBranchMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailBranch columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_branch_edit.php AND
	 * trail_branch_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailBranchEditPanel extends QPanel {
		// Local instance of the TrailBranchMetaControl
		protected $mctTrailBranch;

		// Controls for TrailBranch's Data Fields
		public $lblBranchId;
		public $lstBranchTrail;
		public $lstBranchFromNode;
		public $lstBranchToNode;
		public $txtBranchTrailmark;
		public $txtBranchModality;
		public $txtBranchLengthProjection;
		public $txtBranchLengthSlope;
		public $txtBranchAscentTo;
		public $txtBranchAscentFrom;
		public $txtBranchMinutesTo;
		public $txtBranchMinutesFrom;
		public $txtBranchSegments;
		public $txtBranchSegmentsRev;
		public $txtBranchPoints;
		public $txtBranchPointsRev;
		public $txtBranchRemark;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intBranchId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TrailBranchEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailBranchMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailBranch = TrailBranchMetaControl::Create($this, $intBranchId);

			// Call MetaControl's methods to create qcontrols based on TrailBranch's data fields
			$this->lblBranchId = $this->mctTrailBranch->lblBranchId_Create();
			$this->lstBranchTrail = $this->mctTrailBranch->lstBranchTrail_Create();
			$this->lstBranchFromNode = $this->mctTrailBranch->lstBranchFromNode_Create();
			$this->lstBranchToNode = $this->mctTrailBranch->lstBranchToNode_Create();
			$this->txtBranchTrailmark = $this->mctTrailBranch->txtBranchTrailmark_Create();
			$this->txtBranchModality = $this->mctTrailBranch->txtBranchModality_Create();
			$this->txtBranchLengthProjection = $this->mctTrailBranch->txtBranchLengthProjection_Create();
			$this->txtBranchLengthSlope = $this->mctTrailBranch->txtBranchLengthSlope_Create();
			$this->txtBranchAscentTo = $this->mctTrailBranch->txtBranchAscentTo_Create();
			$this->txtBranchAscentFrom = $this->mctTrailBranch->txtBranchAscentFrom_Create();
			$this->txtBranchMinutesTo = $this->mctTrailBranch->txtBranchMinutesTo_Create();
			$this->txtBranchMinutesFrom = $this->mctTrailBranch->txtBranchMinutesFrom_Create();
			$this->txtBranchSegments = $this->mctTrailBranch->txtBranchSegments_Create();
			$this->txtBranchSegmentsRev = $this->mctTrailBranch->txtBranchSegmentsRev_Create();
			$this->txtBranchPoints = $this->mctTrailBranch->txtBranchPoints_Create();
			$this->txtBranchPointsRev = $this->mctTrailBranch->txtBranchPointsRev_Create();
			$this->txtBranchRemark = $this->mctTrailBranch->txtBranchRemark_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailBranch') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailBranch->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailBranchMetaControl
			$this->mctTrailBranch->SaveTrailBranch();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailBranchMetaControl
			$this->mctTrailBranch->DeleteTrailBranch();
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