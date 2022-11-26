<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the SignpostRowActualStat class.  It uses the code-generated
	 * SignpostRowActualStatMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a SignpostRowActualStat columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both signpost_row_actual_stat_edit.php AND
	 * signpost_row_actual_stat_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class SignpostRowActualStatEditPanel extends QPanel {
		// Local instance of the SignpostRowActualStatMetaControl
		protected $mctSignpostRowActualStat;

		// Controls for SignpostRowActualStat's Data Fields
		public $lstSignpostRow;
		public $txtContentTextDef;
		public $txtPictoDef;
		public $txtLengthSlope;
		public $txtMinutesTo;
		public $txtMinutesRounded;
		public $txtAllTrailmarks;
		public $txtAllModalities;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intSignpostRowId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'SignpostRowActualStatEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the SignpostRowActualStatMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctSignpostRowActualStat = SignpostRowActualStatMetaControl::Create($this, $intSignpostRowId);

			// Call MetaControl's methods to create qcontrols based on SignpostRowActualStat's data fields
			$this->lstSignpostRow = $this->mctSignpostRowActualStat->lstSignpostRow_Create();
			$this->txtContentTextDef = $this->mctSignpostRowActualStat->txtContentTextDef_Create();
			$this->txtPictoDef = $this->mctSignpostRowActualStat->txtPictoDef_Create();
			$this->txtLengthSlope = $this->mctSignpostRowActualStat->txtLengthSlope_Create();
			$this->txtMinutesTo = $this->mctSignpostRowActualStat->txtMinutesTo_Create();
			$this->txtMinutesRounded = $this->mctSignpostRowActualStat->txtMinutesRounded_Create();
			$this->txtAllTrailmarks = $this->mctSignpostRowActualStat->txtAllTrailmarks_Create();
			$this->txtAllModalities = $this->mctSignpostRowActualStat->txtAllModalities_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('SignpostRowActualStat') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctSignpostRowActualStat->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the SignpostRowActualStatMetaControl
			$this->mctSignpostRowActualStat->SaveSignpostRowActualStat();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the SignpostRowActualStatMetaControl
			$this->mctSignpostRowActualStat->DeleteSignpostRowActualStat();
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