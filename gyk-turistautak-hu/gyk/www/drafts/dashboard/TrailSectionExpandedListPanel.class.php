<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailSectionExpanded class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailSectionExpanded objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailSectionExpandedListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailSectionExpandedListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailSectionExpandeds
		public $dtgTrailSectionExpandeds;

		// Other public QControls in this panel
		public $btnCreateNew;
		public $pxyEdit;

		// Callback Method Names
		protected $strSetEditPanelMethod;
		protected $strCloseEditPanelMethod;
		
		public function __construct($objParentObject, $strSetEditPanelMethod, $strCloseEditPanelMethod, $strControlId = null) {
			// Call the Parent
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Record Method Callbacks
			$this->strSetEditPanelMethod = $strSetEditPanelMethod;
			$this->strCloseEditPanelMethod = $strCloseEditPanelMethod;

			// Setup the Template
			$this->Template = 'TrailSectionExpandedListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailSectionExpandeds = new TrailSectionExpandedDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionExpandeds->CssClass = 'datagrid';
			$this->dtgTrailSectionExpandeds->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionExpandeds->Paginator = new QPaginator($this->dtgTrailSectionExpandeds);
			$this->dtgTrailSectionExpandeds->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailSectionExpandeds->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_expanded's properties, or you
			// can traverse down QQN::trail_section_expanded() to display fields that are down the hierarchy)
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->TrailSection);
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->TrailNode);
			$this->dtgTrailSectionExpandeds->MetaAddColumn(QQN::TrailSectionExpanded()->Trail);
			$this->dtgTrailSectionExpandeds->MetaAddColumn('NodeIdx');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('BranchId');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('NoiId');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Name');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Picto');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('Priority');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('PriorityRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectTrailmark');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectModality');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectAscentTo');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectSegments');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectPoints');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectPointsRev');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('SectRemark');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('DefinedAsFirst');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('DefinedAsLast');
			$this->dtgTrailSectionExpandeds->MetaAddColumn('UseBranchDir');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailSectionExpanded');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailSectionExpandedEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0], $strParameterArray[1]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailSectionExpandedEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>