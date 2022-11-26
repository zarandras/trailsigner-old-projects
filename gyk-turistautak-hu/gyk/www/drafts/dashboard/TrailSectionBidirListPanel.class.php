<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailSectionBidir class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailSectionBidir objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailSectionBidirListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailSectionBidirListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailSectionBidirs
		public $dtgTrailSectionBidirs;

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
			$this->Template = 'TrailSectionBidirListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailSectionBidirs = new TrailSectionBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailSectionBidirs->CssClass = 'datagrid';
			$this->dtgTrailSectionBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailSectionBidirs->Paginator = new QPaginator($this->dtgTrailSectionBidirs);
			$this->dtgTrailSectionBidirs->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailSectionBidirs->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_section_bidir's properties, or you
			// can traverse down QQN::trail_section_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailSectionBidirs->MetaAddColumn('TrailSectionId');
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->Trail);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->FromNode);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->ToNode);
			$this->dtgTrailSectionBidirs->MetaAddColumn('ParamName');
			$this->dtgTrailSectionBidirs->MetaAddColumn('Value');
			$this->dtgTrailSectionBidirs->MetaAddColumn('IsOneway');
			$this->dtgTrailSectionBidirs->MetaAddColumn('WithBranch');
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->RevTrailSection);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->AbsTrailSection);
			$this->dtgTrailSectionBidirs->MetaAddColumn(QQN::TrailSectionBidir()->TrailSectionStat);

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailSectionBidir');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailSectionBidirEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailSectionBidirEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>