<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailNode class.  It uses the code-generated
	 * TrailNodeMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailNode columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_node_edit.php AND
	 * trail_node_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailNodeEditPanel extends QPanel {
		// Local instance of the TrailNodeMetaControl
		protected $mctTrailNode;

		// Controls for TrailNode's Data Fields
		public $lblTrailNodeId;
		public $lstTrail;
		public $txtNodeIdx;
		public $lstBranch;
		public $lstNoi;
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

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intTrailNodeId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TrailNodeEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailNodeMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailNode = TrailNodeMetaControl::Create($this, $intTrailNodeId);

			// Call MetaControl's methods to create qcontrols based on TrailNode's data fields
			$this->lblTrailNodeId = $this->mctTrailNode->lblTrailNodeId_Create();
			$this->lstTrail = $this->mctTrailNode->lstTrail_Create();
			$this->txtNodeIdx = $this->mctTrailNode->txtNodeIdx_Create();
			$this->lstBranch = $this->mctTrailNode->lstBranch_Create();
			$this->lstNoi = $this->mctTrailNode->lstNoi_Create();
			$this->txtName = $this->mctTrailNode->txtName_Create();
			$this->txtPicto = $this->mctTrailNode->txtPicto_Create();
			$this->txtPriority = $this->mctTrailNode->txtPriority_Create();
			$this->txtPriorityRev = $this->mctTrailNode->txtPriorityRev_Create();
			$this->txtSectTrailmark = $this->mctTrailNode->txtSectTrailmark_Create();
			$this->txtSectModality = $this->mctTrailNode->txtSectModality_Create();
			$this->txtSectLengthProjection = $this->mctTrailNode->txtSectLengthProjection_Create();
			$this->txtSectLengthSlope = $this->mctTrailNode->txtSectLengthSlope_Create();
			$this->txtSectAscentTo = $this->mctTrailNode->txtSectAscentTo_Create();
			$this->txtSectAscentFrom = $this->mctTrailNode->txtSectAscentFrom_Create();
			$this->txtSectMinutesTo = $this->mctTrailNode->txtSectMinutesTo_Create();
			$this->txtSectMinutesFrom = $this->mctTrailNode->txtSectMinutesFrom_Create();
			$this->txtSectSegments = $this->mctTrailNode->txtSectSegments_Create();
			$this->txtSectSegmentsRev = $this->mctTrailNode->txtSectSegmentsRev_Create();
			$this->txtSectPoints = $this->mctTrailNode->txtSectPoints_Create();
			$this->txtSectPointsRev = $this->mctTrailNode->txtSectPointsRev_Create();
			$this->txtSectRemark = $this->mctTrailNode->txtSectRemark_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailNode') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailNode->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailNodeMetaControl
			$this->mctTrailNode->SaveTrailNode();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailNodeMetaControl
			$this->mctTrailNode->DeleteTrailNode();
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