<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TrailBranch class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TrailBranch objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TrailBranchListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TrailBranchListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TrailBranches
		public $dtgTrailBranches;

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
			$this->Template = 'TrailBranchListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTrailBranches = new TrailBranchDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTrailBranches->CssClass = 'datagrid';
			$this->dtgTrailBranches->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTrailBranches->Paginator = new QPaginator($this->dtgTrailBranches);
			$this->dtgTrailBranches->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTrailBranches->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for trail_branch's properties, or you
			// can traverse down QQN::trail_branch() to display fields that are down the hierarchy)
			$this->dtgTrailBranches->MetaAddColumn('BranchId');
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchTrail);
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchFromNode);
			$this->dtgTrailBranches->MetaAddColumn(QQN::TrailBranch()->BranchToNode);
			$this->dtgTrailBranches->MetaAddColumn('BranchTrailmark');
			$this->dtgTrailBranches->MetaAddColumn('BranchModality');
			$this->dtgTrailBranches->MetaAddColumn('BranchLengthProjection');
			$this->dtgTrailBranches->MetaAddColumn('BranchLengthSlope');
			$this->dtgTrailBranches->MetaAddColumn('BranchAscentTo');
			$this->dtgTrailBranches->MetaAddColumn('BranchAscentFrom');
			$this->dtgTrailBranches->MetaAddColumn('BranchMinutesTo');
			$this->dtgTrailBranches->MetaAddColumn('BranchMinutesFrom');
			$this->dtgTrailBranches->MetaAddColumn('BranchSegments');
			$this->dtgTrailBranches->MetaAddColumn('BranchSegmentsRev');
			$this->dtgTrailBranches->MetaAddColumn('BranchPoints');
			$this->dtgTrailBranches->MetaAddColumn('BranchPointsRev');
			$this->dtgTrailBranches->MetaAddColumn('BranchRemark');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TrailBranch');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TrailBranchEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TrailBranchEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>