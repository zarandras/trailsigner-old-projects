<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
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
	class TrailNodeBidirEditForm extends QForm {
		// Local instance of the TrailNodeBidirMetaControl
		protected $mctTrailNodeBidir;

		// Controls for TrailNodeBidir's Data Fields
		protected $lblTrailNodeId;
		protected $lstTrail;
		protected $txtNodeIdx;
		protected $lstBranch;
		protected $lstNoi;
		protected $txtName;
		protected $txtPicto;
		protected $txtPriority;
		protected $txtPriorityRev;
		protected $txtSectTrailmark;
		protected $txtSectModality;
		protected $txtSectLengthProjection;
		protected $txtSectLengthSlope;
		protected $txtSectAscentTo;
		protected $txtSectAscentFrom;
		protected $txtSectMinutesTo;
		protected $txtSectMinutesFrom;
		protected $txtSectSegments;
		protected $txtSectSegmentsRev;
		protected $txtSectPoints;
		protected $txtSectPointsRev;
		protected $txtSectRemark;
		protected $lstAbsWptNode;
		protected $lstAbsSectNode;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		protected $btnSave;
		protected $btnDelete;
		protected $btnCancel;

		// Create QForm Event Handlers as Needed

//		protected function Form_Exit() {}
//		protected function Form_Load() {}
//		protected function Form_PreRender() {}

		protected function Form_Run() {
			// Security check for ALLOW_REMOTE_ADMIN
			// To allow access REGARDLESS of ALLOW_REMOTE_ADMIN, simply remove the line below
			QApplication::CheckRemoteAdmin();
		}

		protected function Form_Create() {
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the TrailNodeBidirMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailNodeBidir = TrailNodeBidirMetaControl::CreateFromPathInfo($this);

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
			$this->btnSave->AddAction(new QClickEvent(), new QAjaxAction('btnSave_Click'));
			$this->btnSave->CausesValidation = true;

			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QAjaxAction('btnCancel_Click'));

			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailNodeBidir') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailNodeBidir->EditMode;
		}

		/**
		 * This Form_Validate event handler allows you to specify any custom Form Validation rules.
		 * It will also Blink() on all invalid controls, as well as Focus() on the top-most invalid control.
		 */
		protected function Form_Validate() {
			// By default, we report that Custom Validations passed
			$blnToReturn = true;

			// Custom validation rules goes here 
			// Be sure to set $blnToReturn to false if any custom validation fails!

			$blnFocused = false;
			foreach ($this->GetErrorControls() as $objControl) {
				// Set Focus to the top-most invalid control
				if (!$blnFocused) {
					$objControl->Focus();
					$blnFocused = true;
				}

				// Blink on ALL invalid controls
				$objControl->Blink();
			}

			return $blnToReturn;
		}

		// Button Event Handlers

		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailNodeBidirMetaControl
			$this->mctTrailNodeBidir->SaveTrailNodeBidir();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailNodeBidirMetaControl
			$this->mctTrailNodeBidir->DeleteTrailNodeBidir();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_node_bidir_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// trail_node_bidir_edit.tpl.php as the included HTML template file
	TrailNodeBidirEditForm::Run('TrailNodeBidirEditForm');
?>