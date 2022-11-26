<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
	 * of the Trail class.  It uses the code-generated
	 * TrailMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Trail columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_edit.php AND
	 * trail_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailEditForm extends QForm {
		// Local instance of the TrailMetaControl
		protected $mctTrail;

		// Controls for Trail's Data Fields
		protected $lblTrailId;
		protected $txtTrailCode;
		protected $txtTrailmark;
		protected $txtModality;
		protected $txtName;
		protected $txtNameExt;
		protected $txtNameExtRev;
		protected $txtDescription;
		protected $txtDescriptionRev;
		protected $txtRemark;
		protected $txtGeodbService;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the TrailMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrail = TrailMetaControl::CreateFromPathInfo($this);

			// Call MetaControl's methods to create qcontrols based on Trail's data fields
			$this->lblTrailId = $this->mctTrail->lblTrailId_Create();
			$this->txtTrailCode = $this->mctTrail->txtTrailCode_Create();
			$this->txtTrailmark = $this->mctTrail->txtTrailmark_Create();
			$this->txtModality = $this->mctTrail->txtModality_Create();
			$this->txtName = $this->mctTrail->txtName_Create();
			$this->txtNameExt = $this->mctTrail->txtNameExt_Create();
			$this->txtNameExtRev = $this->mctTrail->txtNameExtRev_Create();
			$this->txtDescription = $this->mctTrail->txtDescription_Create();
			$this->txtDescriptionRev = $this->mctTrail->txtDescriptionRev_Create();
			$this->txtRemark = $this->mctTrail->txtRemark_Create();
			$this->txtGeodbService = $this->mctTrail->txtGeodbService_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Trail') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrail->EditMode;
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
			// Delegate "Save" processing to the TrailMetaControl
			$this->mctTrail->SaveTrail();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailMetaControl
			$this->mctTrail->DeleteTrail();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/trail_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// trail_edit.tpl.php as the included HTML template file
	TrailEditForm::Run('TrailEditForm');
?>