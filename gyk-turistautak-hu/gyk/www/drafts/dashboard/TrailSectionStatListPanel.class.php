<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailSectionStat class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailSectionStat objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailSectionStatListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailSectionStatListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailSectionStats
		public $dtgTrailSectionStats;

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
			$this->Template = 'TrailSectionStatListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailSectionStats = new TrailSectionStatDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionStats->CssClass = 'datagrid';
			$this->dtgTrailSectionStats->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionStats->Paginator = new QPaginator($this->dtgTrailSectionStats);
			$this->dtgTrailSectionStats->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailSectionStats->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_stat's properties, or you
			// can traverse down QQN::trail_section_stat() to display fields that are down the hierarchy)
			$this->dtgTrailSectionStats->MetaAddColumn(QQN::TrailSectionStat()->TrailSection);
			$this->dtgTrailSectionStats->MetaAddColumn(QQN::TrailSectionStat()->Trail);
			$this->dtgTrailSectionStats->MetaAddColumn('NodeCount');
			$this->dtgTrailSectionStats->MetaAddColumn('Trailmark');
			$this->dtgTrailSectionStats->MetaAddColumn('Modality');
			$this->dtgTrailSectionStats->MetaAddColumn('LengthProjection');
			$this->dtgTrailSectionStats->MetaAddColumn('LengthSlope');
			$this->dtgTrailSectionStats->MetaAddColumn('AscentTo');
			$this->dtgTrailSectionStats->MetaAddColumn('AscentFrom');
			$this->dtgTrailSectionStats->MetaAddColumn('MinutesTo');
			$this->dtgTrailSectionStats->MetaAddColumn('MinutesFrom');
			$this->dtgTrailSectionStats->MetaAddColumn('Segments');
			$this->dtgTrailSectionStats->MetaAddColumn('Points');
			$this->dtgTrailSectionStats->MetaAddColumn('Remark');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailSectionStat');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailSectionStatEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailSectionStatEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>