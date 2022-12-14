<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the Trail class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of Trail objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list Trails
		public $dtgTrails;

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
			$this->Template = 'TrailListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrails = new TrailDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrails->CssClass = 'datagrid';
			$this->dtgTrails->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrails->Paginator = new QPaginator($this->dtgTrails);
			$this->dtgTrails->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrails->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail's properties, or you
			// can traverse down QQN::trail() to display fields that are down the hierarchy)
			$this->dtgTrails->MetaAddColumn('TrailId');
			$this->dtgTrails->MetaAddColumn('TrailCode');
			$this->dtgTrails->MetaAddColumn('Trailmark');
			$this->dtgTrails->MetaAddColumn('Modality');
			$this->dtgTrails->MetaAddColumn('Name');
			$this->dtgTrails->MetaAddColumn('NameExt');
			$this->dtgTrails->MetaAddColumn('NameExtRev');
			$this->dtgTrails->MetaAddColumn('Description');
			$this->dtgTrails->MetaAddColumn('DescriptionRev');
			$this->dtgTrails->MetaAddColumn('Remark');
			$this->dtgTrails->MetaAddColumn('GeodbService');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('Trail');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>