<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the SignpostRow class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of SignpostRow objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this SignpostRowListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class SignpostRowListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list SignpostRows
		public $dtgSignpostRows;

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
			$this->Template = 'SignpostRowListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgSignpostRows = new SignpostRowDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignpostRows->CssClass = 'datagrid';
			$this->dtgSignpostRows->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignpostRows->Paginator = new QPaginator($this->dtgSignpostRows);
			$this->dtgSignpostRows->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgSignpostRows->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost_row's properties, or you
			// can traverse down QQN::signpost_row() to display fields that are down the hierarchy)
			$this->dtgSignpostRows->MetaAddColumn('SignpostRowId');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->Signpost);
			$this->dtgSignpostRows->MetaAddColumn('RowIdx');
			$this->dtgSignpostRows->MetaAddColumn('RowType');
			$this->dtgSignpostRows->MetaAddColumn('HasBranchline');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->Trail);
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->FromNode);
			$this->dtgSignpostRows->MetaAddColumn('OffsetLength');
			$this->dtgSignpostRows->MetaAddColumn('OffsetMinutes');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->ToNode);
			$this->dtgSignpostRows->MetaAddColumn('ContentText');
			$this->dtgSignpostRows->MetaAddColumn('ContentText2');
			$this->dtgSignpostRows->MetaAddColumn('Picto');
			$this->dtgSignpostRows->MetaAddColumn('LengthSlope');
			$this->dtgSignpostRows->MetaAddColumn('MinutesTo');
			$this->dtgSignpostRows->MetaAddColumn('MinutesRounded');
			$this->dtgSignpostRows->MetaAddColumn('Trailmark');
			$this->dtgSignpostRows->MetaAddColumn('Modality');
			$this->dtgSignpostRows->MetaAddColumn('IsHidden');
			$this->dtgSignpostRows->MetaAddColumn('TechRemark');
			$this->dtgSignpostRows->MetaAddColumn(QQN::SignpostRow()->SignpostRowActualStat);

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('SignpostRow');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new SignpostRowEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new SignpostRowEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>