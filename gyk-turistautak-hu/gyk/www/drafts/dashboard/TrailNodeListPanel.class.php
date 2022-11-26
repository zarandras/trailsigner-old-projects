<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailNode class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailNode objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailNodeListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailNodeListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailNodes
		public $dtgTrailNodes;

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
			$this->Template = 'TrailNodeListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailNodes = new TrailNodeDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailNodes->CssClass = 'datagrid';
			$this->dtgTrailNodes->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailNodes->Paginator = new QPaginator($this->dtgTrailNodes);
			$this->dtgTrailNodes->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailNodes->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_node's properties, or you
			// can traverse down QQN::trail_node() to display fields that are down the hierarchy)
			$this->dtgTrailNodes->MetaAddColumn('TrailNodeId');
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Trail);
			$this->dtgTrailNodes->MetaAddColumn('NodeIdx');
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Branch);
			$this->dtgTrailNodes->MetaAddColumn(QQN::TrailNode()->Noi);
			$this->dtgTrailNodes->MetaAddColumn('Name');
			$this->dtgTrailNodes->MetaAddColumn('Picto');
			$this->dtgTrailNodes->MetaAddColumn('Priority');
			$this->dtgTrailNodes->MetaAddColumn('PriorityRev');
			$this->dtgTrailNodes->MetaAddColumn('SectTrailmark');
			$this->dtgTrailNodes->MetaAddColumn('SectModality');
			$this->dtgTrailNodes->MetaAddColumn('SectLengthProjection');
			$this->dtgTrailNodes->MetaAddColumn('SectLengthSlope');
			$this->dtgTrailNodes->MetaAddColumn('SectAscentTo');
			$this->dtgTrailNodes->MetaAddColumn('SectAscentFrom');
			$this->dtgTrailNodes->MetaAddColumn('SectMinutesTo');
			$this->dtgTrailNodes->MetaAddColumn('SectMinutesFrom');
			$this->dtgTrailNodes->MetaAddColumn('SectSegments');
			$this->dtgTrailNodes->MetaAddColumn('SectSegmentsRev');
			$this->dtgTrailNodes->MetaAddColumn('SectPoints');
			$this->dtgTrailNodes->MetaAddColumn('SectPointsRev');
			$this->dtgTrailNodes->MetaAddColumn('SectRemark');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailNode');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailNodeEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailNodeEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>