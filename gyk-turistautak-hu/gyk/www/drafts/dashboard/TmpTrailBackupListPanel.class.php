<?php
	/**
	 * This is the abstract Panel class for the List All functionality
	 * of the TmpTrailBackup class.  This code-generated class
	 * contains a datagrid to display an HTML page that can
	 * list a collection of TmpTrailBackup objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new QPanel which extends this TmpTrailBackupListPanelBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package GyalogutKataszter
	 * @subpackage Drafts
	 * 
	 */
	class TmpTrailBackupListPanel extends QPanel {
		// Local instance of the Meta DataGrid to list TmpTrailBackups
		public $dtgTmpTrailBackups;

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
			$this->Template = 'TmpTrailBackupListPanel.tpl.php';

			// Instantiate the Meta DataGrid
			$this->dtgTmpTrailBackups = new TmpTrailBackupDataGrid($this);

			// Style the DataGrid (if desired)
			$this->dtgTmpTrailBackups->CssClass = 'datagrid';
			$this->dtgTmpTrailBackups->AlternateRowStyle->CssClass = 'alternate';

			// Add Pagination (if desired)
			$this->dtgTmpTrailBackups->Paginator = new QPaginator($this->dtgTmpTrailBackups);
			$this->dtgTmpTrailBackups->ItemsPerPage = 8;

			// Use the MetaDataGrid functionality to add Columns for this datagrid

			// Create an Edit Column
			$this->pxyEdit = new QControlProxy($this);
			$this->pxyEdit->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'pxyEdit_Click'));
			$this->dtgTmpTrailBackups->MetaAddEditProxyColumn($this->pxyEdit, 'Edit', 'Edit');

			// Create the Other Columns (note that you can use strings for tmp_trail_backup's properties, or you
			// can traverse down QQN::tmp_trail_backup() to display fields that are down the hierarchy)
			$this->dtgTmpTrailBackups->MetaAddColumn('TrailId');
			$this->dtgTmpTrailBackups->MetaAddColumn('TrailCode');
			$this->dtgTmpTrailBackups->MetaAddColumn('Trailmark');
			$this->dtgTmpTrailBackups->MetaAddColumn('Modality');
			$this->dtgTmpTrailBackups->MetaAddColumn('Name');
			$this->dtgTmpTrailBackups->MetaAddColumn('NameExt');
			$this->dtgTmpTrailBackups->MetaAddColumn('NameExtRev');
			$this->dtgTmpTrailBackups->MetaAddColumn('Description');
			$this->dtgTmpTrailBackups->MetaAddColumn('DescriptionRev');
			$this->dtgTmpTrailBackups->MetaAddColumn('Remark');
			$this->dtgTmpTrailBackups->MetaAddColumn('GeodbService');

			// Setup the Create New button
			$this->btnCreateNew = new QButton($this);
			$this->btnCreateNew->Text = QApplication::Translate('Create a New') . ' ' . QApplication::Translate('TmpTrailBackup');
			$this->btnCreateNew->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'btnCreateNew_Click'));
		}

		public function pxyEdit_Click($strFormId, $strControlId, $strParameter) {
			$strParameterArray = explode(',', $strParameter);
			$objEditPanel = new TmpTrailBackupEditPanel($this, $this->strCloseEditPanelMethod, $strParameterArray[0]);

			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}

		public function btnCreateNew_Click($strFormId, $strControlId, $strParameter) {
			$objEditPanel = new TmpTrailBackupEditPanel($this, $this->strCloseEditPanelMethod, null);
			$strMethodName = $this->strSetEditPanelMethod;
			$this->objForm->$strMethodName($objEditPanel);
		}
	}
?>