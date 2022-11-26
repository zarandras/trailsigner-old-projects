<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailNodeBidir class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailNodeBidir objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailNodeBidirListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailNodeBidirListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailNodeBidirs
		public $dtgTrailNodeBidirs;

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
			$this->Template = 'TrailNodeBidirListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailNodeBidirs = new TrailNodeBidirDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailNodeBidirs->CssClass = 'datagrid';
			$this->dtgTrailNodeBidirs->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailNodeBidirs->Paginator = new QPaginator($this->dtgTrailNodeBidirs);
			$this->dtgTrailNodeBidirs->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailNodeBidirs->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_node_bidir's properties, or you
			// can traverse down QQN::trail_node_bidir() to display fields that are down the hierarchy)
			$this->dtgTrailNodeBidirs->MetaAddColumn('TrailNodeId');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Trail);
			$this->dtgTrailNodeBidirs->MetaAddColumn('NodeIdx');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Branch);
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->Noi);
			$this->dtgTrailNodeBidirs->MetaAddColumn('Name');
			$this->dtgTrailNodeBidirs->MetaAddColumn('Picto');
			$this->dtgTrailNodeBidirs->MetaAddColumn('Priority');
			$this->dtgTrailNodeBidirs->MetaAddColumn('PriorityRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectTrailmark');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectModality');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectAscentTo');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectSegments');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectPoints');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectPointsRev');
			$this->dtgTrailNodeBidirs->MetaAddColumn('SectRemark');
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->AbsWptNode);
			$this->dtgTrailNodeBidirs->MetaAddColumn(QQN::TrailNodeBidir()->AbsSectNode);

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailNodeBidir');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailNodeBidirEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailNodeBidirEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>