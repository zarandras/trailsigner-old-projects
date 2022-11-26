<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
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
	class TrailSectionExpandedEditForm extends QForm {
		// Local instance of the TrailSectionExpandedMetaControl
		protected $mctTrailSectionExpanded;

		// Controls for TrailSectionExpanded's Data Fields
		protected $lstTrailSection;
		protected $lstTrailNode;
		protected $lstTrail;
		protected $txtNodeIdx;
		protected $txtBranchId;
		protected $txtNoiId;
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
		protected $chkDefinedAsFirst;
		protected $chkDefinedAsLast;
		protected $txtUseBranchDir;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the TrailSectionExpandedMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSectionExpanded = TrailSectionExpandedMetaControl::CreateFromPathInfo($this);

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
			$this->btnSave->AddAction(new QClickEvent(), new QAjaxAction('btnSave_Click'));
			$this->btnSave->CausesValidation = true;

			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QAjaxAction('btnCancel_Click'));

			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSectionExpanded') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSectionExpanded->EditMode;
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
			// Delegate "Save" processing to the TrailSectionExpandedMetaControl
			$this->mctTrailSectionExpanded->SaveTrailSectionExpanded();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionExpandedMetaControl
			$this->mctTrailSectionExpanded->DeleteTrailSectionExpanded();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_expanded_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// trail_section_expanded_edit.tpl.php as the included HTML template file
	TrailSectionExpandedEditForm::Run('TrailSectionExpandedEditForm');
?>