<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailNodeBidir class.  It uses the code-generated
	 * TrailNodeBidirMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailNodeBidir columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_node_bidir_edit.php AND
	 * trail_node_bidir_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailNodeBidirEditPanel extends QPanel {
		// Local instance of the TrailNodeBidirMetaControl
		protected $mctTrailNodeBidir;

		// Controls for TrailNodeBidir's Data Fields
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
		public $lstAbsWptNode;
		public $lstAbsSectNode;

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
			$this->strTemplate = 'TrailNodeBidirEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailNodeBidirMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailNodeBidir = TrailNodeBidirMetaControl::Create($this, $intTrailNodeId);

			// Call MetaControl's methods to create qcontrols based on TrailNodeBidir's data fields
			$this->lblTrailNodeId = $this->mctTrailNodeBidir->lblTrailNodeId_Create();
			$this->lstTrail = $this->mctTrailNodeBidir->lstTrail_Create();
			$this->txtNodeIdx = $this->mctTrailNodeBidir->txtNodeIdx_Create();
			$this->lstBranch = $this->mctTrailNodeBidir->lstBranch_Create();
			$this->lstNoi = $this->mctTrailNodeBidir->lstNoi_Create();
			$this->txtName = $this->mctTrailNodeBidir->txtName_Create();
			$this->txtPicto = $this->mctTrailNodeBidir->txtPicto_Create();
			$this->txtPriority = $this->mctTrailNodeBidir->txtPriority_Create();
			$this->txtPriorityRev = $this->mctTrailNodeBidir->txtPriorityRev_Create();
			$this->txtSectTrailmark = $this->mctTrailNodeBidir->txtSectTrailmark_Create();
			$this->txtSectModality = $this->mctTrailNodeBidir->txtSectModality_Create();
			$this->txtSectLengthProjection = $this->mctTrailNodeBidir->txtSectLengthProjection_Create();
			$this->txtSectLengthSlope = $this->mctTrailNodeBidir->txtSectLengthSlope_Create();
			$this->txtSectAscentTo = $this->mctTrailNodeBidir->txtSectAscentTo_Create();
			$this->txtSectAscentFrom = $this->mctTrailNodeBidir->txtSectAscentFrom_Create();
			$this->txtSectMinutesTo = $this->mctTrailNodeBidir->txtSectMinutesTo_Create();
			$this->txtSectMinutesFrom = $this->mctTrailNodeBidir->txtSectMinutesFrom_Create();
			$this->txtSectSegments = $this->mctTrailNodeBidir->txtSectSegments_Create();
			$this->txtSectSegmentsRev = $this->mctTrailNodeBidir->txtSectSegmentsRev_Create();
			$this->txtSectPoints = $this->mctTrailNodeBidir->txtSectPoints_Create();
			$this->txtSectPointsRev = $this->mctTrailNodeBidir->txtSectPointsRev_Create();
			$this->txtSectRemark = $this->mctTrailNodeBidir->txtSectRemark_Create();
			$this->lstAbsWptNode = $this->mctTrailNodeBidir->lstAbsWptNode_Create();
			$this->lstAbsSectNode = $this->mctTrailNodeBidir->lstAbsSectNode_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailNodeBidir') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailNodeBidir->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailNodeBidirMetaControl
			$this->mctTrailNodeBidir->SaveTrailNodeBidir();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailNodeBidirMetaControl
			$this->mctTrailNodeBidir->DeleteTrailNodeBidir();
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