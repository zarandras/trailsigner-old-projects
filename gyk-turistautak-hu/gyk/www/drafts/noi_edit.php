<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
	 * of the Noi class.  It uses the code-generated
	 * NoiMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Noi columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both noi_edit.php AND
	 * noi_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class NoiEditForm extends QForm {
		// Local instance of the NoiMetaControl
		protected $mctNoi;

		// Controls for Noi's Data Fields
		protected $lblNoiId;
		protected $txtName;
		protected $txtName2;
		protected $txtName3;
		protected $txtPicto;
		protected $txtTuhuId;
		protected $txtOmpId;
		protected $txtLat;
		protected $txtLon;
		protected $txtAlt;
		protected $txtUrl;
		protected $txtCategories;
		protected $txtDescription;
		protected $txtDefPriority;
		protected $lstParent;
		protected $chkIsVirtual;
		protected $txtCountry;
		protected $txtRegion;
		protected $txtTown;
		protected $txtLandowner;
		protected $txtHrsz;
		protected $txtGroup;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the NoiMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctNoi = NoiMetaControl::CreateFromPathInfo($this);

			// Call MetaControl's methods to create qcontrols based on Noi's data fields
			$this->lblNoiId = $this->mctNoi->lblNoiId_Create();
			$this->txtName = $this->mctNoi->txtName_Create();
			$this->txtName2 = $this->mctNoi->txtName2_Create();
			$this->txtName3 = $this->mctNoi->txtName3_Create();
			$this->txtPicto = $this->mctNoi->txtPicto_Create();
			$this->txtTuhuId = $this->mctNoi->txtTuhuId_Create();
			$this->txtOmpId = $this->mctNoi->txtOmpId_Create();
			$this->txtLat = $this->mctNoi->txtLat_Create();
			$this->txtLon = $this->mctNoi->txtLon_Create();
			$this->txtAlt = $this->mctNoi->txtAlt_Create();
			$this->txtUrl = $this->mctNoi->txtUrl_Create();
			$this->txtCategories = $this->mctNoi->txtCategories_Create();
			$this->txtDescription = $this->mctNoi->txtDescription_Create();
			$this->txtDefPriority = $this->mctNoi->txtDefPriority_Create();
			$this->lstParent = $this->mctNoi->lstParent_Create();
			$this->chkIsVirtual = $this->mctNoi->chkIsVirtual_Create();
			$this->txtCountry = $this->mctNoi->txtCountry_Create();
			$this->txtRegion = $this->mctNoi->txtRegion_Create();
			$this->txtTown = $this->mctNoi->txtTown_Create();
			$this->txtLandowner = $this->mctNoi->txtLandowner_Create();
			$this->txtHrsz = $this->mctNoi->txtHrsz_Create();
			$this->txtGroup = $this->mctNoi->txtGroup_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Noi') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctNoi->EditMode;
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
			// Delegate "Save" processing to the NoiMetaControl
			$this->mctNoi->SaveNoi();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the NoiMetaControl
			$this->mctNoi->DeleteNoi();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/noi_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// noi_edit.tpl.php as the included HTML template file
	NoiEditForm::Run('NoiEditForm');
?>