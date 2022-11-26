<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
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
	class TrailSectionBidirEditForm extends QForm {
		// Local instance of the TrailSectionBidirMetaControl
		protected $mctTrailSectionBidir;

		// Controls for TrailSectionBidir's Data Fields
		protected $lblTrailSectionId;
		protected $lstTrail;
		protected $lstFromNode;
		protected $lstToNode;
		protected $txtParamName;
		protected $txtValue;
		protected $chkIsOneway;
		protected $chkWithBranch;
		protected $lstRevTrailSection;
		protected $lstAbsTrailSection;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References
		protected $lstTrailSectionStat;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the TrailSectionBidirMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSectionBidir = TrailSectionBidirMetaControl::CreateFromPathInfo($this);

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
			$this->btnSave->AddAction(new QClickEvent(), new QAjaxAction('btnSave_Click'));
			$this->btnSave->CausesValidation = true;

			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QAjaxAction('btnCancel_Click'));

			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSectionBidir') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSectionBidir->EditMode;
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
			// Delegate "Save" processing to the TrailSectionBidirMetaControl
			$this->mctTrailSectionBidir->SaveTrailSectionBidir();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionBidirMetaControl
			$this->mctTrailSectionBidir->DeleteTrailSectionBidir();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_section_bidir_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// trail_section_bidir_edit.tpl.php as the included HTML template file
	TrailSectionBidirEditForm::Run('TrailSectionBidirEditForm');
?>