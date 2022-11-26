<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the Signpost class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of Signpost objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this SignpostListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class SignpostListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list Signposts
		public $dtgSignposts;

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
			$this->Template = 'SignpostListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgSignposts = new SignpostDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgSignposts->CssClass = 'datagrid';
			$this->dtgSignposts->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgSignposts->Paginator = new QPaginator($this->dtgSignposts);
			$this->dtgSignposts->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgSignposts->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for signpost's properties, or you
			// can traverse down QQN::signpost() to display fields that are down the hierarchy)
			$this->dtgSignposts->MetaAddColumn('SignpostId');
			$this->dtgSignposts->MetaAddColumn('SignpostCode');
			$this->dtgSignposts->MetaAddColumn(QQN::Signpost()->Noi);
			$this->dtgSignposts->MetaAddColumn('Lat');
			$this->dtgSignposts->MetaAddColumn('Lon');
			$this->dtgSignposts->MetaAddColumn('SignpostType');
			$this->dtgSignposts->MetaAddColumn('Direction');
			$this->dtgSignposts->MetaAddColumn('Angle');
			$this->dtgSignposts->MetaAddColumn('Material');
			$this->dtgSignposts->MetaAddColumn('Subtype');
			$this->dtgSignposts->MetaAddColumn('Content');
			$this->dtgSignposts->MetaAddColumn('Status');
			$this->dtgSignposts->MetaAddColumn('Condition');
			$this->dtgSignposts->MetaAddColumn('Installed');
			$this->dtgSignposts->MetaAddColumn('Checked');
			$this->dtgSignposts->MetaAddColumn('Maintainer');
			$this->dtgSignposts->MetaAddColumn('Sponsor');
			$this->dtgSignposts->MetaAddColumn('Remark');
			$this->dtgSignposts->MetaAddColumn(QQN::Signpost()->Parent);
			$this->dtgSignposts->MetaAddColumn('IsVirtual');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('Signpost');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new SignpostEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new SignpostEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>