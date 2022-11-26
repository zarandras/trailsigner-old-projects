<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailBidir class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailBidir objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailBidirListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailBidirListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailBidirs
		public $dtgTrailBidirs;

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
			$this->Template = 'TrailBidirListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailBidirs = new TrailBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailBidirs->CssClass = 'datagrid';
			$this->dtgTrailBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailBidirs->Paginator = new QPaginator($this->dtgTrailBidirs);
			$this->dtgTrailBidirs->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailBidirs->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_bidir's properties, or you
			// can traverse down QQN::trail_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailBidirs->MetaAddColumn('TrailId');
			$this->dtgTrailBidirs->MetaAddColumn('TrailCode');
			$this->dtgTrailBidirs->MetaAddColumn('Trailmark');
			$this->dtgTrailBidirs->MetaAddColumn('Modality');
			$this->dtgTrailBidirs->MetaAddColumn('Name');
			$this->dtgTrailBidirs->MetaAddColumn('NameExt');
			$this->dtgTrailBidirs->MetaAddColumn('NameExtRev');
			$this->dtgTrailBidirs->MetaAddColumn('Description');
			$this->dtgTrailBidirs->MetaAddColumn('DescriptionRev');
			$this->dtgTrailBidirs->MetaAddColumn('Remark');
			$this->dtgTrailBidirs->MetaAddColumn('GeodbService');
			$this->dtgTrailBidirs->MetaAddColumn(QQN::TrailBidir()->RevTrail);
			$this->dtgTrailBidirs->MetaAddColumn(QQN::TrailBidir()->AbsTrail);

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailBidir');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailBidirEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailBidirEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>