<?php
	/**
	 * This is a quick-and-dirty draft QPanel object to do Create, Edit, and Delete functionality
	 * of the TrailSectionStat class.  It uses the code-generated
	 * TrailSectionStatMetaControl class, which has meta-methods to help with
	 * easily creating/defining controls to modify the fields of a TrailSectionStat columns.
	 *
	 * Any display customizations and presentation-tier logic can be implemented
	 * here by overriding existing or implementing new methods, properties and variables.
	 * 
	 * NOTE: This file is overwritten on any code regenerations.  If you want to make
	 * permanent changes, it is STRONGLY RECOMMENDED to move both trail_section_stat_edit.php AND
	 * trail_section_stat_edit.tpl.php out of this Form Drafts directory.
	 *
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 */
	class TrailSectionStatEditPanel extends QPanel {
		// Local instance of the TrailSectionStatMetaControl
		protected $mctTrailSectionStat;

		// Controls for TrailSectionStat's Data Fields
		public $lstTrailSection;
		public $lstTrail;
		public $txtNodeCount;
		public $txtTrailmark;
		public $txtModality;
		public $txtLengthProjection;
		public $txtLengthSlope;
		public $txtAscentTo;
		public $txtAscentFrom;
		public $txtMinutesTo;
		public $txtMinutesFrom;
		public $txtSegments;
		public $txtPoints;
		public $txtRemark;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Other Controls
		public $btnSave;
		public $btnDelete;
		public $btnCancel;

		// Callback
		protected $strClosePanelMethod;

		public function __construct($objParentObject, $strClosePanelMethod, $intTrailSectionId = null, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Setup Callback and Template
			$this->strTemplate = 'TrailSectionStatEditPanel.tpl.php';
			$this->strClosePanelMethod = $strClosePanelMethod;

			// Construct the TrailSectionStatMetaControl
			// MAKE SURE we specify "$this" as the MetaControl's (and thus all subsequent controls') parent
			$this->mctTrailSectionStat = TrailSectionStatMetaControl::Create($this, $intTrailSectionId);

			// Call MetaControl's methods to create qcontrols based on TrailSectionStat's data fields
			$this->lstTrailSection = $this->mctTrailSectionStat->lstTrailSection_Create();
			$this->lstTrail = $this->mctTrailSectionStat->lstTrail_Create();
			$this->txtNodeCount = $this->mctTrailSectionStat->txtNodeCount_Create();
			$this->txtTrailmark = $this->mctTrailSectionStat->txtTrailmark_Create();
			$this->txtModality = $this->mctTrailSectionStat->txtModality_Create();
			$this->txtLengthProjection = $this->mctTrailSectionStat->txtLengthProjection_Create();
			$this->txtLengthSlope = $this->mctTrailSectionStat->txtLengthSlope_Create();
			$this->txtAscentTo = $this->mctTrailSectionStat->txtAscentTo_Create();
			$this->txtAscentFrom = $this->mctTrailSectionStat->txtAscentFrom_Create();
			$this->txtMinutesTo = $this->mctTrailSectionStat->txtMinutesTo_Create();
			$this->txtMinutesFrom = $this->mctTrailSectionStat->txtMinutesFrom_Create();
			$this->txtSegments = $this->mctTrailSectionStat->txtSegments_Create();
			$this->txtPoints = $this->mctTrailSectionStat->txtPoints_Create();
			$this->txtRemark = $this->mctTrailSectionStat->txtRemark_Create();

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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(QApplication::Translate('Are you SURE you want to DELETE this') . ' ' . QApplication::Translate('TrailSectionStat') . '?'));
			$this->btnDelete->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnDelete_Click'));
			$this->btnDelete->Visible = $this->mctTrailSectionStat->EditMode;
		}

		// Control AjaxAction Event Handlers
		public function btnSave_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Save" processing to the TrailSectionStatMetaControl
			$this->mctTrailSectionStat->SaveTrailSectionStat();
			$this->CloseSelf(true);
		}

		public function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			// Delegate "Delete" processing to the TrailSectionStatMetaControl
			$this->mctTrailSectionStat->DeleteTrailSectionStat();
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