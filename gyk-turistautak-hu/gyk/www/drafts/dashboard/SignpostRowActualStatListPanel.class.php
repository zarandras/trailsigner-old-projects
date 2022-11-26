<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the SignpostRowActualStat class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of SignpostRowActualStat objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this SignpostRowActualStatListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class SignpostRowActualStatListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list SignpostRowActualStats
		public $dtgSignpostRowActualStats;

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
			$this->Template = 'SignpostRowActualStatListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgSignpostRowActualStats = new SignpostRowActualStatDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignpostRowActualStats->CssClass = 'datagrid';
			$this->dtgSignpostRowActualStats->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignpostRowActualStats->Paginator = new QPaginator($this->dtgSignpostRowActualStats);
			$this->dtgSignpostRowActualStats->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgSignpostRowActualStats->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost_row_actual_stat's properties, or you
			// can traverse down QQN::signpost_row_actual_stat() to display fields that are down the hierarchy)
			$this->dtgSignpostRowActualStats->MetaAddColumn(QQN::SignpostRowActualStat()->SignpostRow);
			$this->dtgSignpostRowActualStats->MetaAddColumn('ContentTextDef');
			$this->dtgSignpostRowActualStats->MetaAddColumn('PictoDef');
			$this->dtgSignpostRowActualStats->MetaAddColumn('LengthSlope');
			$this->dtgSignpostRowActualStats->MetaAddColumn('MinutesTo');
			$this->dtgSignpostRowActualStats->MetaAddColumn('MinutesRounded');
			$this->dtgSignpostRowActualStats->MetaAddColumn('AllTrailmarks');
			$this->dtgSignpostRowActualStats->MetaAddColumn('AllModalities');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('SignpostRowActualStat');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new SignpostRowActualStatEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new SignpostRowActualStatEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>