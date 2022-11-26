<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the Noi class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of Noi objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this NoiListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class NoiListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list Nois
		public $dtgNois;

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
			$this->Template = 'NoiListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgNois = new NoiDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgNois->CssClass = 'datagrid';
			$this->dtgNois->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgNois->Paginator = new QPaginator($this->dtgNois);
			$this->dtgNois->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgNois->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for noi's properties, or you
			// can traverse down QQN::noi() to display fields that are down the hierarchy)
			$this->dtgNois->MetaAddColumn('NoiId');
			$this->dtgNois->MetaAddColumn('Name');
			$this->dtgNois->MetaAddColumn('Name2');
			$this->dtgNois->MetaAddColumn('Name3');
			$this->dtgNois->MetaAddColumn('Picto');
			$this->dtgNois->MetaAddColumn('TuhuId');
			$this->dtgNois->MetaAddColumn('OmpId');
			$this->dtgNois->MetaAddColumn('Lat');
			$this->dtgNois->MetaAddColumn('Lon');
			$this->dtgNois->MetaAddColumn('Alt');
			$this->dtgNois->MetaAddColumn('Url');
			$this->dtgNois->MetaAddColumn('Categories');
			$this->dtgNois->MetaAddColumn('Description');
			$this->dtgNois->MetaAddColumn('DefPriority');
			$this->dtgNois->MetaAddColumn(QQN::Noi()->Parent);
			$this->dtgNois->MetaAddColumn('IsVirtual');
			$this->dtgNois->MetaAddColumn('Country');
			$this->dtgNois->MetaAddColumn('Region');
			$this->dtgNois->MetaAddColumn('Town');
			$this->dtgNois->MetaAddColumn('Landowner');
			$this->dtgNois->MetaAddColumn('Hrsz');
			$this->dtgNois->MetaAddColumn('Group');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('Noi');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new NoiEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new NoiEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>