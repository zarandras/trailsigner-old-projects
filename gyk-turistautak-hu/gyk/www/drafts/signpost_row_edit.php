<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
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
	class SignpostRowEditForm extends QForm {
		// Local instance of the SignpostRowMetaControl
		protected $mctSignpostRow;

		// Controls for SignpostRow's Data Fields
		protected $lblSignpostRowId;
		protected $lstSignpost;
		protected $txtRowIdx;
		protected $txtRowType;
		protected $chkHasBranchline;
		protected $lstTrail;
		protected $lstFromNode;
		protected $txtOffsetLength;
		protected $txtOffsetMinutes;
		protected $lstToNode;
		protected $txtContentText;
		protected $txtContentText2;
		protected $txtPicto;
		protected $txtLengthSlope;
		protected $txtMinutesTo;
		protected $txtMinutesRounded;
		protected $txtTrailmark;
		protected $txtModality;
		protected $chkIsHidden;
		protected $txtTechRemark;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References
		protected $lstSignpostRowActualStat;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the SignpostRowMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctSignpostRow = SignpostRowMetaControl::CreateFromPathInfo($this);

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
			$this->btnSave->AddAction(new QClickEvent(), new QAjaxAction('btnSave_Click'));
			$this->btnSave->CausesValidation = true;

			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QAjaxAction('btnCancel_Click'));

			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('SignpostRow') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctSignpostRow->EditMode;
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
			// Delegate "Save" processing to the SignpostRowMetaControl
			$this->mctSignpostRow->SaveSignpostRow();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the SignpostRowMetaControl
			$this->mctSignpostRow->DeleteSignpostRow();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/signpost_row_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// signpost_row_edit.tpl.php as the included HTML template file
	SignpostRowEditForm::Run('SignpostRowEditForm');
?>