<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailSectionExpanded class.  It uses the code-generated
	 * TrailSectionExpandedMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailSectionExpanded columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_expanded_edit.php AND
	 * trail_section_expanded_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionExpandedEditPanel extends QPanel {
		// Local instance of the TrailSectionExpandedMetaControl
		protected $mctTrailSectionExpanded;

		// Controls for TrailSectionExpanded's Data Fields
		public $lstTrailSection;
		public $lstTrailNode;
		public $lstTrail;
		public $txtNodeIdx;
		public $txtBranchId;
		public $txtNoiId;
		public $txtName;
		public $txtPicto;
		public $txtPriority;
		public $txtPriorityRev;
		public $txtSectTrailmark;
		public $txtSectModality;
		public $txtSectLengthProjection;
		public $txtSectLengthSlope;
		public $txtSectAscentTo;
		public $txtSectAscentFrom;
		public $txtSectMinutesTo;
		public $txtSectMinutesFrom;
		public $txtSectSegments;
		public $txtSectSegmentsRev;
		public $txtSectPoints;
		public $txtSectPointsRev;
		public $txtSectRemark;
		public $chkDefinedAsFirst;
		public $chkDefinedAsLast;
		public $txtUseBranchDir;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intTrailSectionId = null, $intTrailNodeId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TrailSectionExpandedEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailSectionExpandedMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSectionExpanded = TrailSectionExpandedMetaControl::Create($this, $intTrailSectionId, $intTrailNodeId);

			// Call MetaControl's methods to create qcontrols based on TrailSectionExpanded's data fields
			$this->lstTrailSection = $this->mctTrailSectionExpanded->lstTrailSection_Create();
			$this->lstTrailNode = $this->mctTrailSectionExpanded->lstTrailNode_Create();
			$this->lstTrail = $this->mctTrailSectionExpanded->lstTrail_Create();
			$this->txtNodeIdx = $this->mctTrailSectionExpanded->txtNodeIdx_Create();
			$this->txtBranchId = $this->mctTrailSectionExpanded->txtBranchId_Create();
			$this->txtNoiId = $this->mctTrailSectionExpanded->txtNoiId_Create();
			$this->txtName = $this->mctTrailSectionExpanded->txtName_Create();
			$this->txtPicto = $this->mctTrailSectionExpanded->txtPicto_Create();
			$this->txtPriority = $this->mctTrailSectionExpanded->txtPriority_Create();
			$this->txtPriorityRev = $this->mctTrailSectionExpanded->txtPriorityRev_Create();
			$this->txtSectTrailmark = $this->mctTrailSectionExpanded->txtSectTrailmark_Create();
			$this->txtSectModality = $this->mctTrailSectionExpanded->txtSectModality_Create();
			$this->txtSectLengthProjection = $this->mctTrailSectionExpanded->txtSectLengthProjection_Create();
			$this->txtSectLengthSlope = $this->mctTrailSectionExpanded->txtSectLengthSlope_Create();
			$this->txtSectAscentTo = $this->mctTrailSectionExpanded->txtSectAscentTo_Create();
			$this->txtSectAscentFrom = $this->mctTrailSectionExpanded->txtSectAscentFrom_Create();
			$this->txtSectMinutesTo = $this->mctTrailSectionExpanded->txtSectMinutesTo_Create();
			$this->txtSectMinutesFrom = $this->mctTrailSectionExpanded->txtSectMinutesFrom_Create();
			$this->txtSectSegments = $this->mctTrailSectionExpanded->txtSectSegments_Create();
			$this->txtSectSegmentsRev = $this->mctTrailSectionExpanded->txtSectSegmentsRev_Create();
			$this->txtSectPoints = $this->mctTrailSectionExpanded->txtSectPoints_Create();
			$this->txtSectPointsRev = $this->mctTrailSectionExpanded->txtSectPointsRev_Create();
			$this->txtSectRemark = $this->mctTrailSectionExpanded->txtSectRemark_Create();
			$this->chkDefinedAsFirst = $this->mctTrailSectionExpanded->chkDefinedAsFirst_Create();
			$this->chkDefinedAsLast = $this->mctTrailSectionExpanded->chkDefinedAsLast_Create();
			$this->txtUseBranchDir = $this->mctTrailSectionExpanded->txtUseBranchDir_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSectionExpanded') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSectionExpanded->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailSectionExpandedMetaControl
			$this->mctTrailSectionExpanded->SaveTrailSectionExpanded();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionExpandedMetaControl
			$this->mctTrailSectionExpanded->DeleteTrailSectionExpanded();
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