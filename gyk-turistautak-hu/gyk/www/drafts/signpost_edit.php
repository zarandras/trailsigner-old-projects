<?php
	// Load the Qcodo Development Framework
	require(dirname(__FILE__) . '/../../includes/prepend.inc.php');

	/**
	 * This is a quick-and-dirty draft QForm object to do Create, Edit, and Delete functionality
	 * of the Signpost class.  It uses the code-generated
	 * SignpostMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a Signpost columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_edit.php AND
	 * signpost_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostEditForm extends QForm {
		// Local instance of the SignpostMetaControl
		protected $mctSignpost;

		// Controls for Signpost's Data Fields
		protected $lblSignpostId;
		protected $txtSignpostCode;
		protected $lstNoi;
		protected $txtLat;
		protected $txtLon;
		protected $txtSignpostType;
		protected $txtDirection;
		protected $txtAngle;
		protected $txtMaterial;
		protected $txtSubtype;
		protected $txtContent;
		protected $txtStatus;
		protected $txtCondition;
		protected $calInstalled;
		protected $calChecked;
		protected $txtMaintainer;
		protected $txtSponsor;
		protected $txtRemark;
		protected $lstParent;
		protected $chkIsVirtual;

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
			// Use the CreateFromPathInfo shortcut (this can also be done manually using the SignpostMetaControl constructor)
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctSignpost = SignpostMetaControl::CreateFromPathInfo($this);

			// Call MetaControl's methods to create qcontrols based on Signpost's data fields
			$this->lblSignpostId = $this->mctSignpost->lblSignpostId_Create();
			$this->txtSignpostCode = $this->mctSignpost->txtSignpostCode_Create();
			$this->lstNoi = $this->mctSignpost->lstNoi_Create();
			$this->txtLat = $this->mctSignpost->txtLat_Create();
			$this->txtLon = $this->mctSignpost->txtLon_Create();
			$this->txtSignpostType = $this->mctSignpost->txtSignpostType_Create();
			$this->txtDirection = $this->mctSignpost->txtDirection_Create();
			$this->txtAngle = $this->mctSignpost->txtAngle_Create();
			$this->txtMaterial = $this->mctSignpost->txtMaterial_Create();
			$this->txtSubtype = $this->mctSignpost->txtSubtype_Create();
			$this->txtContent = $this->mctSignpost->txtContent_Create();
			$this->txtStatus = $this->mctSignpost->txtStatus_Create();
			$this->txtCondition = $this->mctSignpost->txtCondition_Create();
			$this->calInstalled = $this->mctSignpost->calInstalled_Create();
			$this->calChecked = $this->mctSignpost->calChecked_Create();
			$this->txtMaintainer = $this->mctSignpost->txtMaintainer_Create();
			$this->txtSponsor = $this->mctSignpost->txtSponsor_Create();
			$this->txtRemark = $this->mctSignpost->txtRemark_Create();
			$this->lstParent = $this->mctSignpost->lstParent_Create();
			$this->chkIsVirtual = $this->mctSignpost->chkIsVirtual_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('Signpost') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxAction('btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctSignpost->EditMode;
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
			// Delegate "Save" processing to the SignpostMetaControl
			$this->mctSignpost->SaveSignpost();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the SignpostMetaControl
			$this->mctSignpost->DeleteSignpost();
			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		// Other Methods
		
		protected function RedirectToListPage() {
			QApplication::Redirect(__VIRTUAL_DIRECTORY__ . __FORM_DRAFTS__ . '/signpost_list.php');
		}
	}

	// Go ahead and run this form object to render the page and its event handlers, implicitly using
	// signpost_edit.tpl.php as the included HTML template file
	SignpostEditForm::Run('SignpostEditForm');
?>