<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "StandOwnerssmryinfo.php" ?>
<?php

//
// Page class
//

$StandOwners_summary = NULL; // Initialize page object first

class crStandOwners_summary extends crStandOwners {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{3080AF49-5443-4264-8421-3510B6183D7C}";

	// Page object name
	var $PageObjName = 'StandOwners_summary';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (StandOwners)
		if (!isset($GLOBALS["StandOwners"])) {
			$GLOBALS["StandOwners"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["StandOwners"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'StandOwners', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fStandOwnerssummary";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		$this->surname->PlaceHolder = $this->surname->FldCaption();
		$this->file_number->PlaceHolder = $this->file_number->FldCaption();
		$this->office->PlaceHolder = $this->office->FldCaption();
		$this->idnum->PlaceHolder = $this->idnum->FldCaption();
		$this->contact->PlaceHolder = $this->contact->FldCaption();
		$this->location->PlaceHolder = $this->location->FldCaption();
		$this->number->PlaceHolder = $this->number->FldCaption();
		$this->instalments->PlaceHolder = $this->instalments->FldCaption();
		$this->datestatus->PlaceHolder = $this->datestatus->FldCaption();

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = TRUE;
		$item->Visible = TRUE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = TRUE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_StandOwners\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_StandOwners',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fStandOwnerssummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fStandOwnerssummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fStandOwnerssummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_ConvertFullUrl($saveToFile) : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 10; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Set field visibility for detail fields
		$this->name->SetVisibility();
		$this->surname->SetVisibility();
		$this->file_number->SetVisibility();
		$this->office->SetVisibility();
		$this->idnum->SetVisibility();
		$this->contact->SetVisibility();
		$this->location->SetVisibility();
		$this->area->SetVisibility();
		$this->number->SetVisibility();
		$this->price->SetVisibility();
		$this->deposit->SetVisibility();
		$this->instalments->SetVisibility();
		$this->datestatus->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 14;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,TRUE), array(FALSE,FALSE), array(TRUE,TRUE), array(TRUE,TRUE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		$this->surname->SelectionList = "";
		$this->surname->DefaultSelectionList = "";
		$this->surname->ValueList = "";
		$this->file_number->SelectionList = "";
		$this->file_number->DefaultSelectionList = "";
		$this->file_number->ValueList = "";
		$this->office->SelectionList = "";
		$this->office->DefaultSelectionList = "";
		$this->office->ValueList = "";
		$this->idnum->SelectionList = "";
		$this->idnum->DefaultSelectionList = "";
		$this->idnum->ValueList = "";
		$this->contact->SelectionList = "";
		$this->contact->DefaultSelectionList = "";
		$this->contact->ValueList = "";
		$this->location->SelectionList = "";
		$this->location->DefaultSelectionList = "";
		$this->location->ValueList = "";
		$this->area->SelectionList = "";
		$this->area->DefaultSelectionList = "";
		$this->area->ValueList = "";
		$this->number->SelectionList = "";
		$this->number->DefaultSelectionList = "";
		$this->number->ValueList = "";
		$this->price->SelectionList = "";
		$this->price->DefaultSelectionList = "";
		$this->price->ValueList = "";
		$this->deposit->SelectionList = "";
		$this->deposit->DefaultSelectionList = "";
		$this->deposit->ValueList = "";
		$this->instalments->SelectionList = "";
		$this->instalments->DefaultSelectionList = "";
		$this->instalments->ValueList = "";
		$this->datestatus->SelectionList = "";
		$this->datestatus->DefaultSelectionList = "";
		$this->datestatus->ValueList = "";

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = TRUE;

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
			$rs->MoveFirst(); // Move first
				$this->FirstRowData = array();
				$this->FirstRowData['name'] = ewr_Conv($rs->fields('name'), 200);
				$this->FirstRowData['surname'] = ewr_Conv($rs->fields('surname'), 200);
				$this->FirstRowData['file_number'] = ewr_Conv($rs->fields('file_number'), 200);
				$this->FirstRowData['office'] = ewr_Conv($rs->fields('office'), 200);
				$this->FirstRowData['idnum'] = ewr_Conv($rs->fields('idnum'), 200);
				$this->FirstRowData['contact'] = ewr_Conv($rs->fields('contact'), 200);
				$this->FirstRowData['location'] = ewr_Conv($rs->fields('location'), 200);
				$this->FirstRowData['area'] = ewr_Conv($rs->fields('area'), 131);
				$this->FirstRowData['number'] = ewr_Conv($rs->fields('number'), 200);
				$this->FirstRowData['price'] = ewr_Conv($rs->fields('price'), 131);
				$this->FirstRowData['deposit'] = ewr_Conv($rs->fields('deposit'), 131);
				$this->FirstRowData['instalments'] = ewr_Conv($rs->fields('instalments'), 200);
				$this->FirstRowData['datestatus'] = ewr_Conv($rs->fields('datestatus'), 135);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->name->setDbValue($rs->fields('name'));
			$this->surname->setDbValue($rs->fields('surname'));
			$this->file_number->setDbValue($rs->fields('file_number'));
			$this->office->setDbValue($rs->fields('office'));
			$this->idnum->setDbValue($rs->fields('idnum'));
			$this->contact->setDbValue($rs->fields('contact'));
			$this->location->setDbValue($rs->fields('location'));
			$this->area->setDbValue($rs->fields('area'));
			$this->number->setDbValue($rs->fields('number'));
			$this->price->setDbValue($rs->fields('price'));
			$this->deposit->setDbValue($rs->fields('deposit'));
			$this->instalments->setDbValue($rs->fields('instalments'));
			$this->datestatus->setDbValue($rs->fields('datestatus'));
			$this->Val[1] = $this->name->CurrentValue;
			$this->Val[2] = $this->surname->CurrentValue;
			$this->Val[3] = $this->file_number->CurrentValue;
			$this->Val[4] = $this->office->CurrentValue;
			$this->Val[5] = $this->idnum->CurrentValue;
			$this->Val[6] = $this->contact->CurrentValue;
			$this->Val[7] = $this->location->CurrentValue;
			$this->Val[8] = $this->area->CurrentValue;
			$this->Val[9] = $this->number->CurrentValue;
			$this->Val[10] = $this->price->CurrentValue;
			$this->Val[11] = $this->deposit->CurrentValue;
			$this->Val[12] = $this->instalments->CurrentValue;
			$this->Val[13] = $this->datestatus->CurrentValue;
		} else {
			$this->name->setDbValue("");
			$this->surname->setDbValue("");
			$this->file_number->setDbValue("");
			$this->office->setDbValue("");
			$this->idnum->setDbValue("");
			$this->contact->setDbValue("");
			$this->location->setDbValue("");
			$this->area->setDbValue("");
			$this->number->setDbValue("");
			$this->price->setDbValue("");
			$this->deposit->setDbValue("");
			$this->instalments->setDbValue("");
			$this->datestatus->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Build distinct values for surname

			if ($popupname == 'StandOwners_surname') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->surname, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->surname->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->surname->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->surname->setDbValue($rswrk->fields[0]);
					$this->surname->ViewValue = @$rswrk->fields[1];
					if (is_null($this->surname->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->surname->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->surname->ValueList, $this->surname->CurrentValue, $this->surname->ViewValue, FALSE, $this->surname->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->surname->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->surname->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->surname;
			}

			// Build distinct values for file_number
			if ($popupname == 'StandOwners_file_number') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->file_number, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->file_number->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->file_number->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->file_number->setDbValue($rswrk->fields[0]);
					$this->file_number->ViewValue = @$rswrk->fields[1];
					if (is_null($this->file_number->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->file_number->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->file_number->ValueList, $this->file_number->CurrentValue, $this->file_number->ViewValue, FALSE, $this->file_number->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->file_number->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->file_number->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->file_number;
			}

			// Build distinct values for office
			if ($popupname == 'StandOwners_office') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->office, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->office->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->office->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->office->setDbValue($rswrk->fields[0]);
					$this->office->ViewValue = @$rswrk->fields[1];
					if (is_null($this->office->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->office->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->office->ValueList, $this->office->CurrentValue, $this->office->ViewValue, FALSE, $this->office->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->office->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->office->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->office;
			}

			// Build distinct values for idnum
			if ($popupname == 'StandOwners_idnum') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->idnum, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->idnum->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->idnum->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->idnum->setDbValue($rswrk->fields[0]);
					$this->idnum->ViewValue = @$rswrk->fields[1];
					if (is_null($this->idnum->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->idnum->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->idnum->ValueList, $this->idnum->CurrentValue, $this->idnum->ViewValue, FALSE, $this->idnum->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->idnum->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->idnum->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->idnum;
			}

			// Build distinct values for contact
			if ($popupname == 'StandOwners_contact') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->contact, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->contact->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->contact->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->contact->setDbValue($rswrk->fields[0]);
					$this->contact->ViewValue = @$rswrk->fields[1];
					if (is_null($this->contact->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->contact->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->contact->ValueList, $this->contact->CurrentValue, $this->contact->ViewValue, FALSE, $this->contact->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->contact->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->contact->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->contact;
			}

			// Build distinct values for location
			if ($popupname == 'StandOwners_location') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->location, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->location->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->location->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->location->setDbValue($rswrk->fields[0]);
					$this->location->ViewValue = @$rswrk->fields[1];
					if (is_null($this->location->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->location->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->location->ValueList, $this->location->CurrentValue, $this->location->ViewValue, FALSE, $this->location->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->location->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->location->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->location;
			}

			// Build distinct values for area
			if ($popupname == 'StandOwners_area') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->area, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->area->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->area->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->area->setDbValue($rswrk->fields[0]);
					$this->area->ViewValue = @$rswrk->fields[1];
					if (is_null($this->area->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->area->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->area->ValueList, $this->area->CurrentValue, $this->area->ViewValue, FALSE, $this->area->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->area->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->area->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->area;
			}

			// Build distinct values for number
			if ($popupname == 'StandOwners_number') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->number, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->number->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->number->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->number->setDbValue($rswrk->fields[0]);
					$this->number->ViewValue = @$rswrk->fields[1];
					if (is_null($this->number->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->number->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->number->ValueList, $this->number->CurrentValue, $this->number->ViewValue, FALSE, $this->number->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->number->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->number->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->number;
			}

			// Build distinct values for price
			if ($popupname == 'StandOwners_price') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->price, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->price->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->price->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->price->setDbValue($rswrk->fields[0]);
					$this->price->ViewValue = @$rswrk->fields[1];
					if (is_null($this->price->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->price->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->price->ValueList, $this->price->CurrentValue, $this->price->ViewValue, FALSE, $this->price->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->price->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->price->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->price;
			}

			// Build distinct values for deposit
			if ($popupname == 'StandOwners_deposit') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->deposit, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->deposit->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->deposit->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->deposit->setDbValue($rswrk->fields[0]);
					$this->deposit->ViewValue = @$rswrk->fields[1];
					if (is_null($this->deposit->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->deposit->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->deposit->ValueList, $this->deposit->CurrentValue, $this->deposit->ViewValue, FALSE, $this->deposit->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->deposit->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->deposit->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->deposit;
			}

			// Build distinct values for instalments
			if ($popupname == 'StandOwners_instalments') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->instalments, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->instalments->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->instalments->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->instalments->setDbValue($rswrk->fields[0]);
					$this->instalments->ViewValue = @$rswrk->fields[1];
					if (is_null($this->instalments->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->instalments->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->instalments->ValueList, $this->instalments->CurrentValue, $this->instalments->ViewValue, FALSE, $this->instalments->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->instalments->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->instalments->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->instalments;
			}

			// Build distinct values for datestatus
			if ($popupname == 'StandOwners_datestatus') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->datestatus, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->datestatus->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->datestatus->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->datestatus->setDbValue($rswrk->fields[0]);
					$this->datestatus->ViewValue = @$rswrk->fields[1];
					if (is_null($this->datestatus->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->datestatus->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->datestatus->ValueList, $this->datestatus->CurrentValue, $this->datestatus->ViewValue, FALSE, $this->datestatus->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->datestatus->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->datestatus->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->datestatus;
			}

			// Output data as Json
			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ClearSessionSelection('surname');
				$this->ClearSessionSelection('file_number');
				$this->ClearSessionSelection('office');
				$this->ClearSessionSelection('idnum');
				$this->ClearSessionSelection('contact');
				$this->ClearSessionSelection('location');
				$this->ClearSessionSelection('area');
				$this->ClearSessionSelection('number');
				$this->ClearSessionSelection('price');
				$this->ClearSessionSelection('deposit');
				$this->ClearSessionSelection('instalments');
				$this->ClearSessionSelection('datestatus');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get surname selected values

		if (is_array(@$_SESSION["sel_StandOwners_surname"])) {
			$this->LoadSelectionFromSession('surname');
		} elseif (@$_SESSION["sel_StandOwners_surname"] == EWR_INIT_VALUE) { // Select all
			$this->surname->SelectionList = "";
		}

		// Get file_number selected values
		if (is_array(@$_SESSION["sel_StandOwners_file_number"])) {
			$this->LoadSelectionFromSession('file_number');
		} elseif (@$_SESSION["sel_StandOwners_file_number"] == EWR_INIT_VALUE) { // Select all
			$this->file_number->SelectionList = "";
		}

		// Get office selected values
		if (is_array(@$_SESSION["sel_StandOwners_office"])) {
			$this->LoadSelectionFromSession('office');
		} elseif (@$_SESSION["sel_StandOwners_office"] == EWR_INIT_VALUE) { // Select all
			$this->office->SelectionList = "";
		}

		// Get idnum selected values
		if (is_array(@$_SESSION["sel_StandOwners_idnum"])) {
			$this->LoadSelectionFromSession('idnum');
		} elseif (@$_SESSION["sel_StandOwners_idnum"] == EWR_INIT_VALUE) { // Select all
			$this->idnum->SelectionList = "";
		}

		// Get contact selected values
		if (is_array(@$_SESSION["sel_StandOwners_contact"])) {
			$this->LoadSelectionFromSession('contact');
		} elseif (@$_SESSION["sel_StandOwners_contact"] == EWR_INIT_VALUE) { // Select all
			$this->contact->SelectionList = "";
		}

		// Get location selected values
		if (is_array(@$_SESSION["sel_StandOwners_location"])) {
			$this->LoadSelectionFromSession('location');
		} elseif (@$_SESSION["sel_StandOwners_location"] == EWR_INIT_VALUE) { // Select all
			$this->location->SelectionList = "";
		}

		// Get area selected values
		if (is_array(@$_SESSION["sel_StandOwners_area"])) {
			$this->LoadSelectionFromSession('area');
		} elseif (@$_SESSION["sel_StandOwners_area"] == EWR_INIT_VALUE) { // Select all
			$this->area->SelectionList = "";
		}

		// Get number selected values
		if (is_array(@$_SESSION["sel_StandOwners_number"])) {
			$this->LoadSelectionFromSession('number');
		} elseif (@$_SESSION["sel_StandOwners_number"] == EWR_INIT_VALUE) { // Select all
			$this->number->SelectionList = "";
		}

		// Get price selected values
		if (is_array(@$_SESSION["sel_StandOwners_price"])) {
			$this->LoadSelectionFromSession('price');
		} elseif (@$_SESSION["sel_StandOwners_price"] == EWR_INIT_VALUE) { // Select all
			$this->price->SelectionList = "";
		}

		// Get deposit selected values
		if (is_array(@$_SESSION["sel_StandOwners_deposit"])) {
			$this->LoadSelectionFromSession('deposit');
		} elseif (@$_SESSION["sel_StandOwners_deposit"] == EWR_INIT_VALUE) { // Select all
			$this->deposit->SelectionList = "";
		}

		// Get instalments selected values
		if (is_array(@$_SESSION["sel_StandOwners_instalments"])) {
			$this->LoadSelectionFromSession('instalments');
		} elseif (@$_SESSION["sel_StandOwners_instalments"] == EWR_INIT_VALUE) { // Select all
			$this->instalments->SelectionList = "";
		}

		// Get datestatus selected values
		if (is_array(@$_SESSION["sel_StandOwners_datestatus"])) {
			$this->LoadSelectionFromSession('datestatus');
		} elseif (@$_SESSION["sel_StandOwners_datestatus"] == EWR_INIT_VALUE) { // Select all
			$this->datestatus->SelectionList = "";
		}
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 10; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 10; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}

			// Get total from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectAgg(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$sSql = $this->getSqlAggPfx() . $sSql . $this->getSqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandCnt[1] = $this->TotCount;
				$this->GrandCnt[2] = $this->TotCount;
				$this->GrandCnt[3] = $this->TotCount;
				$this->GrandCnt[4] = $this->TotCount;
				$this->GrandCnt[5] = $this->TotCount;
				$this->GrandCnt[6] = $this->TotCount;
				$this->GrandCnt[7] = $this->TotCount;
				$this->GrandCnt[8] = $this->TotCount;
				$this->GrandSmry[8] = $rsagg->fields("sum_area");
				$this->GrandSmry[8] = $rsagg->fields("sum_area");
				$this->GrandMn[8] = $rsagg->fields("min_area");
				$this->GrandMx[8] = $rsagg->fields("max_area");
				$this->GrandCnt[8] = $rsagg->fields("cnt_area");
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandCnt[10] = $this->TotCount;
				$this->GrandSmry[10] = $rsagg->fields("sum_price");
				$this->GrandSmry[10] = $rsagg->fields("sum_price");
				$this->GrandMn[10] = $rsagg->fields("min_price");
				$this->GrandMx[10] = $rsagg->fields("max_price");
				$this->GrandCnt[10] = $rsagg->fields("cnt_price");
				$this->GrandCnt[11] = $this->TotCount;
				$this->GrandSmry[11] = $rsagg->fields("sum_deposit");
				$this->GrandSmry[11] = $rsagg->fields("sum_deposit");
				$this->GrandMn[11] = $rsagg->fields("min_deposit");
				$this->GrandMx[11] = $rsagg->fields("max_deposit");
				$this->GrandCnt[11] = $rsagg->fields("cnt_deposit");
				$this->GrandCnt[12] = $this->TotCount;
				$this->GrandCnt[13] = $this->TotCount;
				$rsagg->Close();
				$bGotSummary = TRUE;
			}

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel); // Set up row class

			// area
			$this->area->SumViewValue = $this->area->SumValue;
			$this->area->SumViewValue = ewr_FormatNumber($this->area->SumViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// area
			$this->area->AvgViewValue = $this->area->AvgValue;
			$this->area->AvgViewValue = ewr_FormatNumber($this->area->AvgViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// area
			$this->area->MinViewValue = $this->area->MinValue;
			$this->area->MinViewValue = ewr_FormatNumber($this->area->MinViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// area
			$this->area->MaxViewValue = $this->area->MaxValue;
			$this->area->MaxViewValue = ewr_FormatNumber($this->area->MaxViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// area
			$this->area->CntViewValue = $this->area->CntValue;
			$this->area->CntViewValue = ewr_FormatNumber($this->area->CntViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// price
			$this->price->SumViewValue = $this->price->SumValue;
			$this->price->SumViewValue = ewr_FormatNumber($this->price->SumViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// price
			$this->price->AvgViewValue = $this->price->AvgValue;
			$this->price->AvgViewValue = ewr_FormatNumber($this->price->AvgViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// price
			$this->price->MinViewValue = $this->price->MinValue;
			$this->price->MinViewValue = ewr_FormatNumber($this->price->MinViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// price
			$this->price->MaxViewValue = $this->price->MaxValue;
			$this->price->MaxViewValue = ewr_FormatNumber($this->price->MaxViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// price
			$this->price->CntViewValue = $this->price->CntValue;
			$this->price->CntViewValue = ewr_FormatNumber($this->price->CntViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// deposit
			$this->deposit->SumViewValue = $this->deposit->SumValue;
			$this->deposit->SumViewValue = ewr_FormatNumber($this->deposit->SumViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// deposit
			$this->deposit->AvgViewValue = $this->deposit->AvgValue;
			$this->deposit->AvgViewValue = ewr_FormatNumber($this->deposit->AvgViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// deposit
			$this->deposit->MinViewValue = $this->deposit->MinValue;
			$this->deposit->MinViewValue = ewr_FormatNumber($this->deposit->MinViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// deposit
			$this->deposit->MaxViewValue = $this->deposit->MaxValue;
			$this->deposit->MaxViewValue = ewr_FormatNumber($this->deposit->MaxViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// deposit
			$this->deposit->CntViewValue = $this->deposit->CntValue;
			$this->deposit->CntViewValue = ewr_FormatNumber($this->deposit->CntViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// name
			$this->name->HrefValue = "";

			// surname
			$this->surname->HrefValue = "";

			// file_number
			$this->file_number->HrefValue = "";

			// office
			$this->office->HrefValue = "";

			// idnum
			$this->idnum->HrefValue = "";

			// contact
			$this->contact->HrefValue = "";

			// location
			$this->location->HrefValue = "";

			// area
			$this->area->HrefValue = "";

			// number
			$this->number->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// deposit
			$this->deposit->HrefValue = "";

			// instalments
			$this->instalments->HrefValue = "";

			// datestatus
			$this->datestatus->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// surname
			$this->surname->ViewValue = $this->surname->CurrentValue;
			$this->surname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// file_number
			$this->file_number->ViewValue = $this->file_number->CurrentValue;
			$this->file_number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// office
			$this->office->ViewValue = $this->office->CurrentValue;
			$this->office->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// idnum
			$this->idnum->ViewValue = $this->idnum->CurrentValue;
			$this->idnum->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// contact
			$this->contact->ViewValue = $this->contact->CurrentValue;
			$this->contact->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// location
			$this->location->ViewValue = $this->location->CurrentValue;
			$this->location->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// area
			$this->area->ViewValue = $this->area->CurrentValue;
			$this->area->ViewValue = ewr_FormatNumber($this->area->ViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// number
			$this->number->ViewValue = $this->number->CurrentValue;
			$this->number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->ViewValue = ewr_FormatNumber($this->price->ViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// deposit
			$this->deposit->ViewValue = $this->deposit->CurrentValue;
			$this->deposit->ViewValue = ewr_FormatNumber($this->deposit->ViewValue, 0, -2, -2, -2);
			$this->deposit->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// instalments
			$this->instalments->ViewValue = $this->instalments->CurrentValue;
			$this->instalments->ViewValue = ewr_FormatNumber($this->instalments->ViewValue, 0, -2, -2, -2);
			$this->instalments->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// datestatus
			$this->datestatus->ViewValue = $this->datestatus->CurrentValue;
			$this->datestatus->ViewValue = ewr_FormatDateTime($this->datestatus->ViewValue, 0);
			$this->datestatus->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// name
			$this->name->HrefValue = "";

			// surname
			$this->surname->HrefValue = "";

			// file_number
			$this->file_number->HrefValue = "";

			// office
			$this->office->HrefValue = "";

			// idnum
			$this->idnum->HrefValue = "";

			// contact
			$this->contact->HrefValue = "";

			// location
			$this->location->HrefValue = "";

			// area
			$this->area->HrefValue = "";

			// number
			$this->number->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// deposit
			$this->deposit->HrefValue = "";

			// instalments
			$this->instalments->HrefValue = "";

			// datestatus
			$this->datestatus->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// area
			$CurrentValue = $this->area->SumValue;
			$ViewValue = &$this->area->SumViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->AvgValue;
			$ViewValue = &$this->area->AvgViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->MinValue;
			$ViewValue = &$this->area->MinViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->MaxValue;
			$ViewValue = &$this->area->MaxViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->CntValue;
			$ViewValue = &$this->area->CntViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->SumValue;
			$ViewValue = &$this->price->SumViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->AvgValue;
			$ViewValue = &$this->price->AvgViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->MinValue;
			$ViewValue = &$this->price->MinViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->MaxValue;
			$ViewValue = &$this->price->MaxViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->CntValue;
			$ViewValue = &$this->price->CntViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->SumValue;
			$ViewValue = &$this->deposit->SumViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->AvgValue;
			$ViewValue = &$this->deposit->AvgViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->MinValue;
			$ViewValue = &$this->deposit->MinViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->MaxValue;
			$ViewValue = &$this->deposit->MaxViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->CntValue;
			$ViewValue = &$this->deposit->CntViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// name
			$CurrentValue = $this->name->CurrentValue;
			$ViewValue = &$this->name->ViewValue;
			$ViewAttrs = &$this->name->ViewAttrs;
			$CellAttrs = &$this->name->CellAttrs;
			$HrefValue = &$this->name->HrefValue;
			$LinkAttrs = &$this->name->LinkAttrs;
			$this->Cell_Rendered($this->name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// surname
			$CurrentValue = $this->surname->CurrentValue;
			$ViewValue = &$this->surname->ViewValue;
			$ViewAttrs = &$this->surname->ViewAttrs;
			$CellAttrs = &$this->surname->CellAttrs;
			$HrefValue = &$this->surname->HrefValue;
			$LinkAttrs = &$this->surname->LinkAttrs;
			$this->Cell_Rendered($this->surname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// file_number
			$CurrentValue = $this->file_number->CurrentValue;
			$ViewValue = &$this->file_number->ViewValue;
			$ViewAttrs = &$this->file_number->ViewAttrs;
			$CellAttrs = &$this->file_number->CellAttrs;
			$HrefValue = &$this->file_number->HrefValue;
			$LinkAttrs = &$this->file_number->LinkAttrs;
			$this->Cell_Rendered($this->file_number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// office
			$CurrentValue = $this->office->CurrentValue;
			$ViewValue = &$this->office->ViewValue;
			$ViewAttrs = &$this->office->ViewAttrs;
			$CellAttrs = &$this->office->CellAttrs;
			$HrefValue = &$this->office->HrefValue;
			$LinkAttrs = &$this->office->LinkAttrs;
			$this->Cell_Rendered($this->office, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// idnum
			$CurrentValue = $this->idnum->CurrentValue;
			$ViewValue = &$this->idnum->ViewValue;
			$ViewAttrs = &$this->idnum->ViewAttrs;
			$CellAttrs = &$this->idnum->CellAttrs;
			$HrefValue = &$this->idnum->HrefValue;
			$LinkAttrs = &$this->idnum->LinkAttrs;
			$this->Cell_Rendered($this->idnum, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// contact
			$CurrentValue = $this->contact->CurrentValue;
			$ViewValue = &$this->contact->ViewValue;
			$ViewAttrs = &$this->contact->ViewAttrs;
			$CellAttrs = &$this->contact->CellAttrs;
			$HrefValue = &$this->contact->HrefValue;
			$LinkAttrs = &$this->contact->LinkAttrs;
			$this->Cell_Rendered($this->contact, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// location
			$CurrentValue = $this->location->CurrentValue;
			$ViewValue = &$this->location->ViewValue;
			$ViewAttrs = &$this->location->ViewAttrs;
			$CellAttrs = &$this->location->CellAttrs;
			$HrefValue = &$this->location->HrefValue;
			$LinkAttrs = &$this->location->LinkAttrs;
			$this->Cell_Rendered($this->location, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->CurrentValue;
			$ViewValue = &$this->area->ViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// number
			$CurrentValue = $this->number->CurrentValue;
			$ViewValue = &$this->number->ViewValue;
			$ViewAttrs = &$this->number->ViewAttrs;
			$CellAttrs = &$this->number->CellAttrs;
			$HrefValue = &$this->number->HrefValue;
			$LinkAttrs = &$this->number->LinkAttrs;
			$this->Cell_Rendered($this->number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->CurrentValue;
			$ViewValue = &$this->price->ViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// deposit
			$CurrentValue = $this->deposit->CurrentValue;
			$ViewValue = &$this->deposit->ViewValue;
			$ViewAttrs = &$this->deposit->ViewAttrs;
			$CellAttrs = &$this->deposit->CellAttrs;
			$HrefValue = &$this->deposit->HrefValue;
			$LinkAttrs = &$this->deposit->LinkAttrs;
			$this->Cell_Rendered($this->deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// instalments
			$CurrentValue = $this->instalments->CurrentValue;
			$ViewValue = &$this->instalments->ViewValue;
			$ViewAttrs = &$this->instalments->ViewAttrs;
			$CellAttrs = &$this->instalments->CellAttrs;
			$HrefValue = &$this->instalments->HrefValue;
			$LinkAttrs = &$this->instalments->LinkAttrs;
			$this->Cell_Rendered($this->instalments, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// datestatus
			$CurrentValue = $this->datestatus->CurrentValue;
			$ViewValue = &$this->datestatus->ViewValue;
			$ViewAttrs = &$this->datestatus->ViewAttrs;
			$CellAttrs = &$this->datestatus->CellAttrs;
			$HrefValue = &$this->datestatus->HrefValue;
			$LinkAttrs = &$this->datestatus->LinkAttrs;
			$this->Cell_Rendered($this->datestatus, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->name->Visible) $this->DtlColumnCount += 1;
		if ($this->surname->Visible) $this->DtlColumnCount += 1;
		if ($this->file_number->Visible) $this->DtlColumnCount += 1;
		if ($this->office->Visible) $this->DtlColumnCount += 1;
		if ($this->idnum->Visible) $this->DtlColumnCount += 1;
		if ($this->contact->Visible) $this->DtlColumnCount += 1;
		if ($this->location->Visible) $this->DtlColumnCount += 1;
		if ($this->area->Visible) $this->DtlColumnCount += 1;
		if ($this->number->Visible) $this->DtlColumnCount += 1;
		if ($this->price->Visible) $this->DtlColumnCount += 1;
		if ($this->deposit->Visible) $this->DtlColumnCount += 1;
		if ($this->instalments->Visible) $this->DtlColumnCount += 1;
		if ($this->datestatus->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = TRUE;
		if ($item->Visible)
			$ReportTypes["pdf"] = $ReportLanguage->Phrase("ReportFormPdf");
		$exportid = session_id();
		$url = $this->ExportPdfUrl;
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"javascript:void(0);\" onclick=\"ewr_ExportCharts(this, '" . $url . "', '" . $exportid . "');\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $gsFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

			// Clear extended filter for field surname
			if ($this->ClearExtFilter == 'StandOwners_surname')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'surname');

			// Clear extended filter for field file_number
			if ($this->ClearExtFilter == 'StandOwners_file_number')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'file_number');

			// Clear extended filter for field office
			if ($this->ClearExtFilter == 'StandOwners_office')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'office');

			// Clear extended filter for field idnum
			if ($this->ClearExtFilter == 'StandOwners_idnum')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'idnum');

			// Clear extended filter for field contact
			if ($this->ClearExtFilter == 'StandOwners_contact')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'contact');

			// Clear extended filter for field location
			if ($this->ClearExtFilter == 'StandOwners_location')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'location');

			// Set/clear dropdown for field area
			if ($this->PopupName == 'StandOwners_area' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->area->DropDownValue = EWR_ALL_VALUE;
				else
					$this->area->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'StandOwners_area') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'area');
			}

			// Clear extended filter for field number
			if ($this->ClearExtFilter == 'StandOwners_number')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'number');

			// Set/clear dropdown for field price
			if ($this->PopupName == 'StandOwners_price' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->price->DropDownValue = EWR_ALL_VALUE;
				else
					$this->price->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'StandOwners_price') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'price');
			}

			// Set/clear dropdown for field deposit
			if ($this->PopupName == 'StandOwners_deposit' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->deposit->DropDownValue = EWR_ALL_VALUE;
				else
					$this->deposit->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'StandOwners_deposit') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'deposit');
			}

			// Clear extended filter for field instalments
			if ($this->ClearExtFilter == 'StandOwners_instalments')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'instalments');

			// Clear extended filter for field datestatus
			if ($this->ClearExtFilter == 'StandOwners_datestatus')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'datestatus');

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->surname->SearchValue, $this->surname->SearchOperator, $this->surname->SearchCondition, $this->surname->SearchValue2, $this->surname->SearchOperator2, 'surname'); // Field surname
			$this->SetSessionFilterValues($this->file_number->SearchValue, $this->file_number->SearchOperator, $this->file_number->SearchCondition, $this->file_number->SearchValue2, $this->file_number->SearchOperator2, 'file_number'); // Field file_number
			$this->SetSessionFilterValues($this->office->SearchValue, $this->office->SearchOperator, $this->office->SearchCondition, $this->office->SearchValue2, $this->office->SearchOperator2, 'office'); // Field office
			$this->SetSessionFilterValues($this->idnum->SearchValue, $this->idnum->SearchOperator, $this->idnum->SearchCondition, $this->idnum->SearchValue2, $this->idnum->SearchOperator2, 'idnum'); // Field idnum
			$this->SetSessionFilterValues($this->contact->SearchValue, $this->contact->SearchOperator, $this->contact->SearchCondition, $this->contact->SearchValue2, $this->contact->SearchOperator2, 'contact'); // Field contact
			$this->SetSessionFilterValues($this->location->SearchValue, $this->location->SearchOperator, $this->location->SearchCondition, $this->location->SearchValue2, $this->location->SearchOperator2, 'location'); // Field location
			$this->SetSessionDropDownValue($this->area->DropDownValue, $this->area->SearchOperator, 'area'); // Field area
			$this->SetSessionFilterValues($this->number->SearchValue, $this->number->SearchOperator, $this->number->SearchCondition, $this->number->SearchValue2, $this->number->SearchOperator2, 'number'); // Field number
			$this->SetSessionDropDownValue($this->price->DropDownValue, $this->price->SearchOperator, 'price'); // Field price
			$this->SetSessionDropDownValue($this->deposit->DropDownValue, $this->deposit->SearchOperator, 'deposit'); // Field deposit
			$this->SetSessionFilterValues($this->instalments->SearchValue, $this->instalments->SearchOperator, $this->instalments->SearchCondition, $this->instalments->SearchValue2, $this->instalments->SearchOperator2, 'instalments'); // Field instalments
			$this->SetSessionFilterValues($this->datestatus->SearchValue, $this->datestatus->SearchOperator, $this->datestatus->SearchCondition, $this->datestatus->SearchValue2, $this->datestatus->SearchOperator2, 'datestatus'); // Field datestatus

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field surname
			if ($this->GetFilterValues($this->surname)) {
				$bSetupFilter = TRUE;
			}

			// Field file_number
			if ($this->GetFilterValues($this->file_number)) {
				$bSetupFilter = TRUE;
			}

			// Field office
			if ($this->GetFilterValues($this->office)) {
				$bSetupFilter = TRUE;
			}

			// Field idnum
			if ($this->GetFilterValues($this->idnum)) {
				$bSetupFilter = TRUE;
			}

			// Field contact
			if ($this->GetFilterValues($this->contact)) {
				$bSetupFilter = TRUE;
			}

			// Field location
			if ($this->GetFilterValues($this->location)) {
				$bSetupFilter = TRUE;
			}

			// Field area
			if ($this->GetDropDownValue($this->area)) {
				$bSetupFilter = TRUE;
			} elseif ($this->area->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_StandOwners_area'])) {
				$bSetupFilter = TRUE;
			}

			// Field number
			if ($this->GetFilterValues($this->number)) {
				$bSetupFilter = TRUE;
			}

			// Field price
			if ($this->GetDropDownValue($this->price)) {
				$bSetupFilter = TRUE;
			} elseif ($this->price->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_StandOwners_price'])) {
				$bSetupFilter = TRUE;
			}

			// Field deposit
			if ($this->GetDropDownValue($this->deposit)) {
				$bSetupFilter = TRUE;
			} elseif ($this->deposit->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_StandOwners_deposit'])) {
				$bSetupFilter = TRUE;
			}

			// Field instalments
			if ($this->GetFilterValues($this->instalments)) {
				$bSetupFilter = TRUE;
			}

			// Field datestatus
			if ($this->GetFilterValues($this->datestatus)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->surname); // Field surname
			$this->GetSessionFilterValues($this->file_number); // Field file_number
			$this->GetSessionFilterValues($this->office); // Field office
			$this->GetSessionFilterValues($this->idnum); // Field idnum
			$this->GetSessionFilterValues($this->contact); // Field contact
			$this->GetSessionFilterValues($this->location); // Field location
			$this->GetSessionDropDownValue($this->area); // Field area
			$this->GetSessionFilterValues($this->number); // Field number
			$this->GetSessionDropDownValue($this->price); // Field price
			$this->GetSessionDropDownValue($this->deposit); // Field deposit
			$this->GetSessionFilterValues($this->instalments); // Field instalments
			$this->GetSessionFilterValues($this->datestatus); // Field datestatus
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->surname, $sFilter, FALSE, TRUE); // Field surname
		$this->BuildExtendedFilter($this->file_number, $sFilter, FALSE, TRUE); // Field file_number
		$this->BuildExtendedFilter($this->office, $sFilter, FALSE, TRUE); // Field office
		$this->BuildExtendedFilter($this->idnum, $sFilter, FALSE, TRUE); // Field idnum
		$this->BuildExtendedFilter($this->contact, $sFilter, FALSE, TRUE); // Field contact
		$this->BuildExtendedFilter($this->location, $sFilter, FALSE, TRUE); // Field location
		$this->BuildDropDownFilter($this->area, $sFilter, $this->area->SearchOperator, FALSE, TRUE); // Field area
		$this->BuildExtendedFilter($this->number, $sFilter, FALSE, TRUE); // Field number
		$this->BuildDropDownFilter($this->price, $sFilter, $this->price->SearchOperator, FALSE, TRUE); // Field price
		$this->BuildDropDownFilter($this->deposit, $sFilter, $this->deposit->SearchOperator, FALSE, TRUE); // Field deposit
		$this->BuildExtendedFilter($this->instalments, $sFilter, FALSE, TRUE); // Field instalments
		$this->BuildExtendedFilter($this->datestatus, $sFilter, FALSE, TRUE); // Field datestatus

		// Save parms to session
		$this->SetSessionFilterValues($this->surname->SearchValue, $this->surname->SearchOperator, $this->surname->SearchCondition, $this->surname->SearchValue2, $this->surname->SearchOperator2, 'surname'); // Field surname
		$this->SetSessionFilterValues($this->file_number->SearchValue, $this->file_number->SearchOperator, $this->file_number->SearchCondition, $this->file_number->SearchValue2, $this->file_number->SearchOperator2, 'file_number'); // Field file_number
		$this->SetSessionFilterValues($this->office->SearchValue, $this->office->SearchOperator, $this->office->SearchCondition, $this->office->SearchValue2, $this->office->SearchOperator2, 'office'); // Field office
		$this->SetSessionFilterValues($this->idnum->SearchValue, $this->idnum->SearchOperator, $this->idnum->SearchCondition, $this->idnum->SearchValue2, $this->idnum->SearchOperator2, 'idnum'); // Field idnum
		$this->SetSessionFilterValues($this->contact->SearchValue, $this->contact->SearchOperator, $this->contact->SearchCondition, $this->contact->SearchValue2, $this->contact->SearchOperator2, 'contact'); // Field contact
		$this->SetSessionFilterValues($this->location->SearchValue, $this->location->SearchOperator, $this->location->SearchCondition, $this->location->SearchValue2, $this->location->SearchOperator2, 'location'); // Field location
		$this->SetSessionDropDownValue($this->area->DropDownValue, $this->area->SearchOperator, 'area'); // Field area
		$this->SetSessionFilterValues($this->number->SearchValue, $this->number->SearchOperator, $this->number->SearchCondition, $this->number->SearchValue2, $this->number->SearchOperator2, 'number'); // Field number
		$this->SetSessionDropDownValue($this->price->DropDownValue, $this->price->SearchOperator, 'price'); // Field price
		$this->SetSessionDropDownValue($this->deposit->DropDownValue, $this->deposit->SearchOperator, 'deposit'); // Field deposit
		$this->SetSessionFilterValues($this->instalments->SearchValue, $this->instalments->SearchOperator, $this->instalments->SearchCondition, $this->instalments->SearchValue2, $this->instalments->SearchOperator2, 'instalments'); // Field instalments
		$this->SetSessionFilterValues($this->datestatus->SearchValue, $this->datestatus->SearchOperator, $this->datestatus->SearchCondition, $this->datestatus->SearchValue2, $this->datestatus->SearchOperator2, 'datestatus'); // Field datestatus

		// Setup filter
		if ($bSetupFilter) {

			// Field surname
			$sWrk = "";
			$this->BuildExtendedFilter($this->surname, $sWrk);
			ewr_LoadSelectionFromFilter($this->surname, $sWrk, $this->surname->SelectionList);
			$_SESSION['sel_StandOwners_surname'] = ($this->surname->SelectionList == "") ? EWR_INIT_VALUE : $this->surname->SelectionList;

			// Field file_number
			$sWrk = "";
			$this->BuildExtendedFilter($this->file_number, $sWrk);
			ewr_LoadSelectionFromFilter($this->file_number, $sWrk, $this->file_number->SelectionList);
			$_SESSION['sel_StandOwners_file_number'] = ($this->file_number->SelectionList == "") ? EWR_INIT_VALUE : $this->file_number->SelectionList;

			// Field office
			$sWrk = "";
			$this->BuildExtendedFilter($this->office, $sWrk);
			ewr_LoadSelectionFromFilter($this->office, $sWrk, $this->office->SelectionList);
			$_SESSION['sel_StandOwners_office'] = ($this->office->SelectionList == "") ? EWR_INIT_VALUE : $this->office->SelectionList;

			// Field idnum
			$sWrk = "";
			$this->BuildExtendedFilter($this->idnum, $sWrk);
			ewr_LoadSelectionFromFilter($this->idnum, $sWrk, $this->idnum->SelectionList);
			$_SESSION['sel_StandOwners_idnum'] = ($this->idnum->SelectionList == "") ? EWR_INIT_VALUE : $this->idnum->SelectionList;

			// Field contact
			$sWrk = "";
			$this->BuildExtendedFilter($this->contact, $sWrk);
			ewr_LoadSelectionFromFilter($this->contact, $sWrk, $this->contact->SelectionList);
			$_SESSION['sel_StandOwners_contact'] = ($this->contact->SelectionList == "") ? EWR_INIT_VALUE : $this->contact->SelectionList;

			// Field location
			$sWrk = "";
			$this->BuildExtendedFilter($this->location, $sWrk);
			ewr_LoadSelectionFromFilter($this->location, $sWrk, $this->location->SelectionList);
			$_SESSION['sel_StandOwners_location'] = ($this->location->SelectionList == "") ? EWR_INIT_VALUE : $this->location->SelectionList;

			// Field area
			ewr_LoadSelectionList($this->area->SelectionList, $this->area->DropDownValue);
			$_SESSION['sel_StandOwners_area'] = ($this->area->SelectionList == "") ? EWR_INIT_VALUE : $this->area->SelectionList;

			// Field number
			$sWrk = "";
			$this->BuildExtendedFilter($this->number, $sWrk);
			ewr_LoadSelectionFromFilter($this->number, $sWrk, $this->number->SelectionList);
			$_SESSION['sel_StandOwners_number'] = ($this->number->SelectionList == "") ? EWR_INIT_VALUE : $this->number->SelectionList;

			// Field price
			ewr_LoadSelectionList($this->price->SelectionList, $this->price->DropDownValue);
			$_SESSION['sel_StandOwners_price'] = ($this->price->SelectionList == "") ? EWR_INIT_VALUE : $this->price->SelectionList;

			// Field deposit
			ewr_LoadSelectionList($this->deposit->SelectionList, $this->deposit->DropDownValue);
			$_SESSION['sel_StandOwners_deposit'] = ($this->deposit->SelectionList == "") ? EWR_INIT_VALUE : $this->deposit->SelectionList;

			// Field instalments
			$sWrk = "";
			$this->BuildExtendedFilter($this->instalments, $sWrk);
			ewr_LoadSelectionFromFilter($this->instalments, $sWrk, $this->instalments->SelectionList);
			$_SESSION['sel_StandOwners_instalments'] = ($this->instalments->SelectionList == "") ? EWR_INIT_VALUE : $this->instalments->SelectionList;

			// Field datestatus
			$sWrk = "";
			$this->BuildExtendedFilter($this->datestatus, $sWrk);
			ewr_LoadSelectionFromFilter($this->datestatus, $sWrk, $this->datestatus->SelectionList);
			$_SESSION['sel_StandOwners_datestatus'] = ($this->datestatus->SelectionList == "") ? EWR_INIT_VALUE : $this->datestatus->SelectionList;
		}

		// Field area
		ewr_LoadDropDownList($this->area->DropDownList, $this->area->DropDownValue);

		// Field price
		ewr_LoadDropDownList($this->price->DropDownList, $this->price->DropDownValue);

		// Field deposit
		ewr_LoadDropDownList($this->deposit->DropDownList, $this->deposit->DropDownValue);
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@") $this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@") $this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if ($FldVal == EWR_NULL_VALUE) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif ($FldVal == EWR_NOT_NULL_VALUE) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif ($FldVal == EWR_EMPTY_VALUE) {
			$sWrk = $FldExpression . " = ''";
		} elseif ($FldVal == EWR_ALL_VALUE) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "") {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID,0,2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewr_StripSlashes(@$_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewr_StripSlashes(@$_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewr_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_StandOwners_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_StandOwners_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_StandOwners_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_StandOwners_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_StandOwners_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_StandOwners_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_StandOwners_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_StandOwners_' . $parm] = $sv;
		$_SESSION['so_StandOwners_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_StandOwners_' . $parm] = $sv1;
		$_SESSION['so_StandOwners_' . $parm] = $so1;
		$_SESSION['sc_StandOwners_' . $parm] = $sc;
		$_SESSION['sv2_StandOwners_' . $parm] = $sv2;
		$_SESSION['so2_StandOwners_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ewr_CheckDateDef($this->datestatus->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->datestatus->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_StandOwners_$parm"] = "";
		$_SESSION["rf_StandOwners_$parm"] = "";
		$_SESSION["rt_StandOwners_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_StandOwners_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_StandOwners_$parm"];
		$fld->RangeTo = @$_SESSION["rt_StandOwners_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/

		// Field area
		$this->area->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->area->DropDownValue = $this->area->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->area, $sWrk, $this->area->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->area, $sWrk, $this->area->DefaultSelectionList);
		if (!$this->SearchCommand) $this->area->SelectionList = $this->area->DefaultSelectionList;

		// Field price
		$this->price->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->price->DropDownValue = $this->price->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->price, $sWrk, $this->price->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->price, $sWrk, $this->price->DefaultSelectionList);
		if (!$this->SearchCommand) $this->price->SelectionList = $this->price->DefaultSelectionList;

		// Field deposit
		$this->deposit->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->deposit->DropDownValue = $this->deposit->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->deposit, $sWrk, $this->deposit->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->deposit, $sWrk, $this->deposit->DefaultSelectionList);
		if (!$this->SearchCommand) $this->deposit->SelectionList = $this->deposit->DefaultSelectionList;
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		// Field surname
		$this->SetDefaultExtFilter($this->surname, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->surname);
		$sWrk = "";
		$this->BuildExtendedFilter($this->surname, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->surname, $sWrk, $this->surname->DefaultSelectionList);
		if (!$this->SearchCommand) $this->surname->SelectionList = $this->surname->DefaultSelectionList;

		// Field file_number
		$this->SetDefaultExtFilter($this->file_number, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->file_number);
		$sWrk = "";
		$this->BuildExtendedFilter($this->file_number, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->file_number, $sWrk, $this->file_number->DefaultSelectionList);
		if (!$this->SearchCommand) $this->file_number->SelectionList = $this->file_number->DefaultSelectionList;

		// Field office
		$this->SetDefaultExtFilter($this->office, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->office);
		$sWrk = "";
		$this->BuildExtendedFilter($this->office, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->office, $sWrk, $this->office->DefaultSelectionList);
		if (!$this->SearchCommand) $this->office->SelectionList = $this->office->DefaultSelectionList;

		// Field idnum
		$this->SetDefaultExtFilter($this->idnum, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->idnum);
		$sWrk = "";
		$this->BuildExtendedFilter($this->idnum, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->idnum, $sWrk, $this->idnum->DefaultSelectionList);
		if (!$this->SearchCommand) $this->idnum->SelectionList = $this->idnum->DefaultSelectionList;

		// Field contact
		$this->SetDefaultExtFilter($this->contact, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->contact);
		$sWrk = "";
		$this->BuildExtendedFilter($this->contact, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->contact, $sWrk, $this->contact->DefaultSelectionList);
		if (!$this->SearchCommand) $this->contact->SelectionList = $this->contact->DefaultSelectionList;

		// Field location
		$this->SetDefaultExtFilter($this->location, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->location);
		$sWrk = "";
		$this->BuildExtendedFilter($this->location, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->location, $sWrk, $this->location->DefaultSelectionList);
		if (!$this->SearchCommand) $this->location->SelectionList = $this->location->DefaultSelectionList;

		// Field number
		$this->SetDefaultExtFilter($this->number, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->number);
		$sWrk = "";
		$this->BuildExtendedFilter($this->number, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->number, $sWrk, $this->number->DefaultSelectionList);
		if (!$this->SearchCommand) $this->number->SelectionList = $this->number->DefaultSelectionList;

		// Field instalments
		$this->SetDefaultExtFilter($this->instalments, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->instalments);
		$sWrk = "";
		$this->BuildExtendedFilter($this->instalments, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->instalments, $sWrk, $this->instalments->DefaultSelectionList);
		if (!$this->SearchCommand) $this->instalments->SelectionList = $this->instalments->DefaultSelectionList;

		// Field datestatus
		$this->SetDefaultExtFilter($this->datestatus, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->datestatus);
		$sWrk = "";
		$this->BuildExtendedFilter($this->datestatus, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->datestatus, $sWrk, $this->datestatus->DefaultSelectionList);
		if (!$this->SearchCommand) $this->datestatus->SelectionList = $this->datestatus->DefaultSelectionList;
		/**
		* Set up default values for popup filters
		*/

		// Field surname
		// $this->surname->DefaultSelectionList = array("val1", "val2");
		// Field file_number
		// $this->file_number->DefaultSelectionList = array("val1", "val2");
		// Field office
		// $this->office->DefaultSelectionList = array("val1", "val2");
		// Field idnum
		// $this->idnum->DefaultSelectionList = array("val1", "val2");
		// Field contact
		// $this->contact->DefaultSelectionList = array("val1", "val2");
		// Field location
		// $this->location->DefaultSelectionList = array("val1", "val2");
		// Field area
		// $this->area->DefaultSelectionList = array("val1", "val2");
		// Field number
		// $this->number->DefaultSelectionList = array("val1", "val2");
		// Field price
		// $this->price->DefaultSelectionList = array("val1", "val2");
		// Field deposit
		// $this->deposit->DefaultSelectionList = array("val1", "val2");
		// Field instalments
		// $this->instalments->DefaultSelectionList = array("val1", "val2");
		// Field datestatus
		// $this->datestatus->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check surname text filter
		if ($this->TextFilterApplied($this->surname))
			return TRUE;

		// Check surname popup filter
		if (!ewr_MatchedArray($this->surname->DefaultSelectionList, $this->surname->SelectionList))
			return TRUE;

		// Check file_number text filter
		if ($this->TextFilterApplied($this->file_number))
			return TRUE;

		// Check file_number popup filter
		if (!ewr_MatchedArray($this->file_number->DefaultSelectionList, $this->file_number->SelectionList))
			return TRUE;

		// Check office text filter
		if ($this->TextFilterApplied($this->office))
			return TRUE;

		// Check office popup filter
		if (!ewr_MatchedArray($this->office->DefaultSelectionList, $this->office->SelectionList))
			return TRUE;

		// Check idnum text filter
		if ($this->TextFilterApplied($this->idnum))
			return TRUE;

		// Check idnum popup filter
		if (!ewr_MatchedArray($this->idnum->DefaultSelectionList, $this->idnum->SelectionList))
			return TRUE;

		// Check contact text filter
		if ($this->TextFilterApplied($this->contact))
			return TRUE;

		// Check contact popup filter
		if (!ewr_MatchedArray($this->contact->DefaultSelectionList, $this->contact->SelectionList))
			return TRUE;

		// Check location text filter
		if ($this->TextFilterApplied($this->location))
			return TRUE;

		// Check location popup filter
		if (!ewr_MatchedArray($this->location->DefaultSelectionList, $this->location->SelectionList))
			return TRUE;

		// Check area extended filter
		if ($this->NonTextFilterApplied($this->area))
			return TRUE;

		// Check area popup filter
		if (!ewr_MatchedArray($this->area->DefaultSelectionList, $this->area->SelectionList))
			return TRUE;

		// Check number text filter
		if ($this->TextFilterApplied($this->number))
			return TRUE;

		// Check number popup filter
		if (!ewr_MatchedArray($this->number->DefaultSelectionList, $this->number->SelectionList))
			return TRUE;

		// Check price extended filter
		if ($this->NonTextFilterApplied($this->price))
			return TRUE;

		// Check price popup filter
		if (!ewr_MatchedArray($this->price->DefaultSelectionList, $this->price->SelectionList))
			return TRUE;

		// Check deposit extended filter
		if ($this->NonTextFilterApplied($this->deposit))
			return TRUE;

		// Check deposit popup filter
		if (!ewr_MatchedArray($this->deposit->DefaultSelectionList, $this->deposit->SelectionList))
			return TRUE;

		// Check instalments text filter
		if ($this->TextFilterApplied($this->instalments))
			return TRUE;

		// Check instalments popup filter
		if (!ewr_MatchedArray($this->instalments->DefaultSelectionList, $this->instalments->SelectionList))
			return TRUE;

		// Check datestatus text filter
		if ($this->TextFilterApplied($this->datestatus))
			return TRUE;

		// Check datestatus popup filter
		if (!ewr_MatchedArray($this->datestatus->DefaultSelectionList, $this->datestatus->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field surname
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->surname, $sExtWrk);
		if (is_array($this->surname->SelectionList))
			$sWrk = ewr_JoinArray($this->surname->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->surname->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field file_number
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->file_number, $sExtWrk);
		if (is_array($this->file_number->SelectionList))
			$sWrk = ewr_JoinArray($this->file_number->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->file_number->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field office
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->office, $sExtWrk);
		if (is_array($this->office->SelectionList))
			$sWrk = ewr_JoinArray($this->office->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->office->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field idnum
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->idnum, $sExtWrk);
		if (is_array($this->idnum->SelectionList))
			$sWrk = ewr_JoinArray($this->idnum->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->idnum->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field contact
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->contact, $sExtWrk);
		if (is_array($this->contact->SelectionList))
			$sWrk = ewr_JoinArray($this->contact->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->contact->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field location
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->location, $sExtWrk);
		if (is_array($this->location->SelectionList))
			$sWrk = ewr_JoinArray($this->location->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->location->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field area
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->area, $sExtWrk, $this->area->SearchOperator);
		if (is_array($this->area->SelectionList))
			$sWrk = ewr_JoinArray($this->area->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->area->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field number
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->number, $sExtWrk);
		if (is_array($this->number->SelectionList))
			$sWrk = ewr_JoinArray($this->number->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->number->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field price
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->price, $sExtWrk, $this->price->SearchOperator);
		if (is_array($this->price->SelectionList))
			$sWrk = ewr_JoinArray($this->price->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->price->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field deposit
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->deposit, $sExtWrk, $this->deposit->SearchOperator);
		if (is_array($this->deposit->SelectionList))
			$sWrk = ewr_JoinArray($this->deposit->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->deposit->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field instalments
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->instalments, $sExtWrk);
		if (is_array($this->instalments->SelectionList))
			$sWrk = ewr_JoinArray($this->instalments->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->instalments->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field datestatus
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->datestatus, $sExtWrk);
		if (is_array($this->datestatus->SelectionList))
			$sWrk = ewr_JoinArray($this->datestatus->SelectionList, ", ", EWR_DATATYPE_DATE, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->datestatus->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info ewDisplayTable\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field surname
		$sWrk = "";
		if ($this->surname->SearchValue <> "" || $this->surname->SearchValue2 <> "") {
			$sWrk = "\"sv_surname\":\"" . ewr_JsEncode2($this->surname->SearchValue) . "\"," .
				"\"so_surname\":\"" . ewr_JsEncode2($this->surname->SearchOperator) . "\"," .
				"\"sc_surname\":\"" . ewr_JsEncode2($this->surname->SearchCondition) . "\"," .
				"\"sv2_surname\":\"" . ewr_JsEncode2($this->surname->SearchValue2) . "\"," .
				"\"so2_surname\":\"" . ewr_JsEncode2($this->surname->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->surname->SelectionList <> EWR_INIT_VALUE) ? $this->surname->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_surname\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field file_number
		$sWrk = "";
		if ($this->file_number->SearchValue <> "" || $this->file_number->SearchValue2 <> "") {
			$sWrk = "\"sv_file_number\":\"" . ewr_JsEncode2($this->file_number->SearchValue) . "\"," .
				"\"so_file_number\":\"" . ewr_JsEncode2($this->file_number->SearchOperator) . "\"," .
				"\"sc_file_number\":\"" . ewr_JsEncode2($this->file_number->SearchCondition) . "\"," .
				"\"sv2_file_number\":\"" . ewr_JsEncode2($this->file_number->SearchValue2) . "\"," .
				"\"so2_file_number\":\"" . ewr_JsEncode2($this->file_number->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->file_number->SelectionList <> EWR_INIT_VALUE) ? $this->file_number->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_file_number\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field office
		$sWrk = "";
		if ($this->office->SearchValue <> "" || $this->office->SearchValue2 <> "") {
			$sWrk = "\"sv_office\":\"" . ewr_JsEncode2($this->office->SearchValue) . "\"," .
				"\"so_office\":\"" . ewr_JsEncode2($this->office->SearchOperator) . "\"," .
				"\"sc_office\":\"" . ewr_JsEncode2($this->office->SearchCondition) . "\"," .
				"\"sv2_office\":\"" . ewr_JsEncode2($this->office->SearchValue2) . "\"," .
				"\"so2_office\":\"" . ewr_JsEncode2($this->office->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->office->SelectionList <> EWR_INIT_VALUE) ? $this->office->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_office\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field idnum
		$sWrk = "";
		if ($this->idnum->SearchValue <> "" || $this->idnum->SearchValue2 <> "") {
			$sWrk = "\"sv_idnum\":\"" . ewr_JsEncode2($this->idnum->SearchValue) . "\"," .
				"\"so_idnum\":\"" . ewr_JsEncode2($this->idnum->SearchOperator) . "\"," .
				"\"sc_idnum\":\"" . ewr_JsEncode2($this->idnum->SearchCondition) . "\"," .
				"\"sv2_idnum\":\"" . ewr_JsEncode2($this->idnum->SearchValue2) . "\"," .
				"\"so2_idnum\":\"" . ewr_JsEncode2($this->idnum->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->idnum->SelectionList <> EWR_INIT_VALUE) ? $this->idnum->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_idnum\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field contact
		$sWrk = "";
		if ($this->contact->SearchValue <> "" || $this->contact->SearchValue2 <> "") {
			$sWrk = "\"sv_contact\":\"" . ewr_JsEncode2($this->contact->SearchValue) . "\"," .
				"\"so_contact\":\"" . ewr_JsEncode2($this->contact->SearchOperator) . "\"," .
				"\"sc_contact\":\"" . ewr_JsEncode2($this->contact->SearchCondition) . "\"," .
				"\"sv2_contact\":\"" . ewr_JsEncode2($this->contact->SearchValue2) . "\"," .
				"\"so2_contact\":\"" . ewr_JsEncode2($this->contact->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->contact->SelectionList <> EWR_INIT_VALUE) ? $this->contact->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_contact\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field location
		$sWrk = "";
		if ($this->location->SearchValue <> "" || $this->location->SearchValue2 <> "") {
			$sWrk = "\"sv_location\":\"" . ewr_JsEncode2($this->location->SearchValue) . "\"," .
				"\"so_location\":\"" . ewr_JsEncode2($this->location->SearchOperator) . "\"," .
				"\"sc_location\":\"" . ewr_JsEncode2($this->location->SearchCondition) . "\"," .
				"\"sv2_location\":\"" . ewr_JsEncode2($this->location->SearchValue2) . "\"," .
				"\"so2_location\":\"" . ewr_JsEncode2($this->location->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->location->SelectionList <> EWR_INIT_VALUE) ? $this->location->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_location\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field area
		$sWrk = "";
		$sWrk = ($this->area->DropDownValue <> EWR_INIT_VALUE) ? $this->area->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_area\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->area->SelectionList <> EWR_INIT_VALUE) ? $this->area->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_area\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field number
		$sWrk = "";
		if ($this->number->SearchValue <> "" || $this->number->SearchValue2 <> "") {
			$sWrk = "\"sv_number\":\"" . ewr_JsEncode2($this->number->SearchValue) . "\"," .
				"\"so_number\":\"" . ewr_JsEncode2($this->number->SearchOperator) . "\"," .
				"\"sc_number\":\"" . ewr_JsEncode2($this->number->SearchCondition) . "\"," .
				"\"sv2_number\":\"" . ewr_JsEncode2($this->number->SearchValue2) . "\"," .
				"\"so2_number\":\"" . ewr_JsEncode2($this->number->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->number->SelectionList <> EWR_INIT_VALUE) ? $this->number->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_number\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field price
		$sWrk = "";
		$sWrk = ($this->price->DropDownValue <> EWR_INIT_VALUE) ? $this->price->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_price\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->price->SelectionList <> EWR_INIT_VALUE) ? $this->price->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_price\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field deposit
		$sWrk = "";
		$sWrk = ($this->deposit->DropDownValue <> EWR_INIT_VALUE) ? $this->deposit->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_deposit\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->deposit->SelectionList <> EWR_INIT_VALUE) ? $this->deposit->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_deposit\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field instalments
		$sWrk = "";
		if ($this->instalments->SearchValue <> "" || $this->instalments->SearchValue2 <> "") {
			$sWrk = "\"sv_instalments\":\"" . ewr_JsEncode2($this->instalments->SearchValue) . "\"," .
				"\"so_instalments\":\"" . ewr_JsEncode2($this->instalments->SearchOperator) . "\"," .
				"\"sc_instalments\":\"" . ewr_JsEncode2($this->instalments->SearchCondition) . "\"," .
				"\"sv2_instalments\":\"" . ewr_JsEncode2($this->instalments->SearchValue2) . "\"," .
				"\"so2_instalments\":\"" . ewr_JsEncode2($this->instalments->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->instalments->SelectionList <> EWR_INIT_VALUE) ? $this->instalments->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_instalments\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field datestatus
		$sWrk = "";
		if ($this->datestatus->SearchValue <> "" || $this->datestatus->SearchValue2 <> "") {
			$sWrk = "\"sv_datestatus\":\"" . ewr_JsEncode2($this->datestatus->SearchValue) . "\"," .
				"\"so_datestatus\":\"" . ewr_JsEncode2($this->datestatus->SearchOperator) . "\"," .
				"\"sc_datestatus\":\"" . ewr_JsEncode2($this->datestatus->SearchCondition) . "\"," .
				"\"sv2_datestatus\":\"" . ewr_JsEncode2($this->datestatus->SearchValue2) . "\"," .
				"\"so2_datestatus\":\"" . ewr_JsEncode2($this->datestatus->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->datestatus->SelectionList <> EWR_INIT_VALUE) ? $this->datestatus->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_datestatus\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ewr_StripSlashes(@$_POST["filter"]), TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field surname
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_surname", $filter) || array_key_exists("so_surname", $filter) ||
			array_key_exists("sc_surname", $filter) ||
			array_key_exists("sv2_surname", $filter) || array_key_exists("so2_surname", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_surname"], @$filter["so_surname"], @$filter["sc_surname"], @$filter["sv2_surname"], @$filter["so2_surname"], "surname");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_surname", $filter)) {
			$sWrk = $filter["sel_surname"];
			$sWrk = explode("||", $sWrk);
			$this->surname->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_surname"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "surname"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "surname");
			$this->surname->SelectionList = "";
			$_SESSION["sel_StandOwners_surname"] = "";
		}

		// Field file_number
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_file_number", $filter) || array_key_exists("so_file_number", $filter) ||
			array_key_exists("sc_file_number", $filter) ||
			array_key_exists("sv2_file_number", $filter) || array_key_exists("so2_file_number", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_file_number"], @$filter["so_file_number"], @$filter["sc_file_number"], @$filter["sv2_file_number"], @$filter["so2_file_number"], "file_number");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_file_number", $filter)) {
			$sWrk = $filter["sel_file_number"];
			$sWrk = explode("||", $sWrk);
			$this->file_number->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_file_number"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "file_number"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "file_number");
			$this->file_number->SelectionList = "";
			$_SESSION["sel_StandOwners_file_number"] = "";
		}

		// Field office
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_office", $filter) || array_key_exists("so_office", $filter) ||
			array_key_exists("sc_office", $filter) ||
			array_key_exists("sv2_office", $filter) || array_key_exists("so2_office", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_office"], @$filter["so_office"], @$filter["sc_office"], @$filter["sv2_office"], @$filter["so2_office"], "office");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_office", $filter)) {
			$sWrk = $filter["sel_office"];
			$sWrk = explode("||", $sWrk);
			$this->office->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_office"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "office"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "office");
			$this->office->SelectionList = "";
			$_SESSION["sel_StandOwners_office"] = "";
		}

		// Field idnum
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_idnum", $filter) || array_key_exists("so_idnum", $filter) ||
			array_key_exists("sc_idnum", $filter) ||
			array_key_exists("sv2_idnum", $filter) || array_key_exists("so2_idnum", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_idnum"], @$filter["so_idnum"], @$filter["sc_idnum"], @$filter["sv2_idnum"], @$filter["so2_idnum"], "idnum");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_idnum", $filter)) {
			$sWrk = $filter["sel_idnum"];
			$sWrk = explode("||", $sWrk);
			$this->idnum->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_idnum"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "idnum"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "idnum");
			$this->idnum->SelectionList = "";
			$_SESSION["sel_StandOwners_idnum"] = "";
		}

		// Field contact
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_contact", $filter) || array_key_exists("so_contact", $filter) ||
			array_key_exists("sc_contact", $filter) ||
			array_key_exists("sv2_contact", $filter) || array_key_exists("so2_contact", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_contact"], @$filter["so_contact"], @$filter["sc_contact"], @$filter["sv2_contact"], @$filter["so2_contact"], "contact");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_contact", $filter)) {
			$sWrk = $filter["sel_contact"];
			$sWrk = explode("||", $sWrk);
			$this->contact->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_contact"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "contact"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "contact");
			$this->contact->SelectionList = "";
			$_SESSION["sel_StandOwners_contact"] = "";
		}

		// Field location
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_location", $filter) || array_key_exists("so_location", $filter) ||
			array_key_exists("sc_location", $filter) ||
			array_key_exists("sv2_location", $filter) || array_key_exists("so2_location", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_location"], @$filter["so_location"], @$filter["sc_location"], @$filter["sv2_location"], @$filter["so2_location"], "location");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_location", $filter)) {
			$sWrk = $filter["sel_location"];
			$sWrk = explode("||", $sWrk);
			$this->location->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_location"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "location"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "location");
			$this->location->SelectionList = "";
			$_SESSION["sel_StandOwners_location"] = "";
		}

		// Field area
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_area", $filter)) {
			$sWrk = $filter["sv_area"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_area"], "area");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_area", $filter)) {
			$sWrk = $filter["sel_area"];
			$sWrk = explode("||", $sWrk);
			$this->area->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_area"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "area"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "area");
			$this->area->SelectionList = "";
			$_SESSION["sel_StandOwners_area"] = "";
		}

		// Field number
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_number", $filter) || array_key_exists("so_number", $filter) ||
			array_key_exists("sc_number", $filter) ||
			array_key_exists("sv2_number", $filter) || array_key_exists("so2_number", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_number"], @$filter["so_number"], @$filter["sc_number"], @$filter["sv2_number"], @$filter["so2_number"], "number");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_number", $filter)) {
			$sWrk = $filter["sel_number"];
			$sWrk = explode("||", $sWrk);
			$this->number->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_number"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "number"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "number");
			$this->number->SelectionList = "";
			$_SESSION["sel_StandOwners_number"] = "";
		}

		// Field price
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_price", $filter)) {
			$sWrk = $filter["sv_price"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_price"], "price");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_price", $filter)) {
			$sWrk = $filter["sel_price"];
			$sWrk = explode("||", $sWrk);
			$this->price->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_price"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "price"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "price");
			$this->price->SelectionList = "";
			$_SESSION["sel_StandOwners_price"] = "";
		}

		// Field deposit
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_deposit", $filter)) {
			$sWrk = $filter["sv_deposit"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_deposit"], "deposit");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_deposit", $filter)) {
			$sWrk = $filter["sel_deposit"];
			$sWrk = explode("||", $sWrk);
			$this->deposit->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_deposit"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "deposit"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "deposit");
			$this->deposit->SelectionList = "";
			$_SESSION["sel_StandOwners_deposit"] = "";
		}

		// Field instalments
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_instalments", $filter) || array_key_exists("so_instalments", $filter) ||
			array_key_exists("sc_instalments", $filter) ||
			array_key_exists("sv2_instalments", $filter) || array_key_exists("so2_instalments", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_instalments"], @$filter["so_instalments"], @$filter["sc_instalments"], @$filter["sv2_instalments"], @$filter["so2_instalments"], "instalments");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_instalments", $filter)) {
			$sWrk = $filter["sel_instalments"];
			$sWrk = explode("||", $sWrk);
			$this->instalments->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_instalments"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "instalments"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "instalments");
			$this->instalments->SelectionList = "";
			$_SESSION["sel_StandOwners_instalments"] = "";
		}

		// Field datestatus
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_datestatus", $filter) || array_key_exists("so_datestatus", $filter) ||
			array_key_exists("sc_datestatus", $filter) ||
			array_key_exists("sv2_datestatus", $filter) || array_key_exists("so2_datestatus", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_datestatus"], @$filter["so_datestatus"], @$filter["sc_datestatus"], @$filter["sv2_datestatus"], @$filter["so2_datestatus"], "datestatus");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_datestatus", $filter)) {
			$sWrk = $filter["sel_datestatus"];
			$sWrk = explode("||", $sWrk);
			$this->datestatus->SelectionList = $sWrk;
			$_SESSION["sel_StandOwners_datestatus"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "datestatus"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "datestatus");
			$this->datestatus->SelectionList = "";
			$_SESSION["sel_StandOwners_datestatus"] = "";
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		if (!$this->ExtendedFilterExist($this->surname)) {
			if (is_array($this->surname->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->surname, "`surname`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->surname, $sFilter, "popup");
				$this->surname->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->file_number)) {
			if (is_array($this->file_number->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->file_number, "`file_number`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->file_number, $sFilter, "popup");
				$this->file_number->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->office)) {
			if (is_array($this->office->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->office, "`office`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->office, $sFilter, "popup");
				$this->office->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->idnum)) {
			if (is_array($this->idnum->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->idnum, "`idnum`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->idnum, $sFilter, "popup");
				$this->idnum->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->contact)) {
			if (is_array($this->contact->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->contact, "`contact`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->contact, $sFilter, "popup");
				$this->contact->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->location)) {
			if (is_array($this->location->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->location, "`location`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->location, $sFilter, "popup");
				$this->location->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->DropDownFilterExist($this->area, $this->area->SearchOperator)) {
			if (is_array($this->area->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->area, "`area`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->area, $sFilter, "popup");
				$this->area->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->number)) {
			if (is_array($this->number->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->number, "`number`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->number, $sFilter, "popup");
				$this->number->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->DropDownFilterExist($this->price, $this->price->SearchOperator)) {
			if (is_array($this->price->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->price, "`price`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->price, $sFilter, "popup");
				$this->price->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->DropDownFilterExist($this->deposit, $this->deposit->SearchOperator)) {
			if (is_array($this->deposit->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->deposit, "`deposit`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->deposit, $sFilter, "popup");
				$this->deposit->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->instalments)) {
			if (is_array($this->instalments->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->instalments, "`instalments`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->instalments, $sFilter, "popup");
				$this->instalments->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->datestatus)) {
			if (is_array($this->datestatus->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->datestatus, "`datestatus`", EWR_DATATYPE_DATE, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->datestatus, $sFilter, "popup");
				$this->datestatus->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : ewr_StripSlashes(@$_GET["order"]);
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : ewr_StripSlashes(@$_GET["ordertype"]);

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->name->setSort("");
			$this->surname->setSort("");
			$this->file_number->setSort("");
			$this->office->setSort("");
			$this->idnum->setSort("");
			$this->contact->setSort("");
			$this->location->setSort("");
			$this->area->setSort("");
			$this->number->setSort("");
			$this->price->setSort("");
			$this->deposit->setSort("");
			$this->instalments->setSort("");
			$this->datestatus->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->name, $bCtrl); // name
			$this->UpdateSort($this->surname, $bCtrl); // surname
			$this->UpdateSort($this->file_number, $bCtrl); // file_number
			$this->UpdateSort($this->office, $bCtrl); // office
			$this->UpdateSort($this->idnum, $bCtrl); // idnum
			$this->UpdateSort($this->contact, $bCtrl); // contact
			$this->UpdateSort($this->location, $bCtrl); // location
			$this->UpdateSort($this->area, $bCtrl); // area
			$this->UpdateSort($this->number, $bCtrl); // number
			$this->UpdateSort($this->price, $bCtrl); // price
			$this->UpdateSort($this->deposit, $bCtrl); // deposit
			$this->UpdateSort($this->instalments, $bCtrl); // instalments
			$this->UpdateSort($this->datestatus, $bCtrl); // datestatus
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Export email
	function ExportEmail($EmailContent, $options = array()) {
		global $gTmpImages, $ReportLanguage;
		$bGenRequest = @$options["reporttype"] == "email";
		$sFailRespPfx = $bGenRequest ? "" : "<p class=\"text-error\">";
		$sSuccessRespPfx = $bGenRequest ? "" : "<p class=\"text-success\">";
		$sRespPfx = $bGenRequest ? "" : "</p>";
		$sContentType = (@$options["contenttype"] <> "") ? $options["contenttype"] : @$_POST["contenttype"];
		$sSender = (@$options["sender"] <> "") ? $options["sender"] : @$_POST["sender"];
		$sRecipient = (@$options["recipient"] <> "") ? $options["recipient"] : @$_POST["recipient"];
		$sCc = (@$options["cc"] <> "") ? $options["cc"] : @$_POST["cc"];
		$sBcc = (@$options["bcc"] <> "") ? $options["bcc"] : @$_POST["bcc"];

		// Subject
		$sEmailSubject = (@$options["subject"] <> "") ? $options["subject"] : ewr_StripSlashes(@$_POST["subject"]);

		// Message
		$sEmailMessage = (@$options["message"] <> "") ? $options["message"] : ewr_StripSlashes(@$_POST["message"]);

		// Check sender
		if ($sSender == "")
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterSenderEmail") . $sRespPfx;
		if (!ewr_CheckEmail($sSender))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperSenderEmail") . $sRespPfx;

		// Check recipient
		if (!ewr_CheckEmailList($sRecipient, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperRecipientEmail") . $sRespPfx;

		// Check cc
		if (!ewr_CheckEmailList($sCc, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperCcEmail") . $sRespPfx;

		// Check bcc
		if (!ewr_CheckEmailList($sBcc, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperBccEmail") . $sRespPfx;

		// Check email sent count
		$emailcount = $bGenRequest ? 0 : ewr_LoadEmailCount();
		if (intval($emailcount) >= EWR_MAX_EMAIL_SENT_COUNT)
			return $sFailRespPfx . $ReportLanguage->Phrase("ExceedMaxEmailExport") . $sRespPfx;
		if ($sEmailMessage <> "") {
			if (EWR_REMOVE_XSS) $sEmailMessage = ewr_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		$sAttachmentContent = ewr_AdjustEmailContent($EmailContent);
		$sAppPath = ewr_FullUrl();
		$sAppPath = substr($sAppPath, 0, strrpos($sAppPath, "/")+1);
		if (strpos($sAttachmentContent, "<head>") !== FALSE)
			$sAttachmentContent = str_replace("<head>", "<head><base href=\"" . $sAppPath . "\">", $sAttachmentContent); // Add <base href> statement inside the header
		else
			$sAttachmentContent = "<base href=\"" . $sAppPath . "\">" . $sAttachmentContent; // Add <base href> statement as the first statement

		//$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . ".html";
		$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . "_" . ewr_Random() . ".html";
		if ($sContentType == "url") {
			ewr_SaveFile(EWR_UPLOAD_DEST_PATH, $sAttachmentFile, $sAttachmentContent);
			$sAttachmentFile = EWR_UPLOAD_DEST_PATH . $sAttachmentFile;
			$sUrl = $sAppPath . $sAttachmentFile;
			$sEmailMessage .= $sUrl; // Send URL only
			$sAttachmentFile = "";
			$sAttachmentContent = "";
		} else {
			$sEmailMessage .= $sAttachmentContent;
			$sAttachmentFile = "";
			$sAttachmentContent = "";
		}

		// Send email
		$Email = new crEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Content = $sEmailMessage; // Content
		if ($sAttachmentFile <> "")
			$Email->AddAttachment($sAttachmentFile, $sAttachmentContent);
		if ($sContentType <> "url") {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
		}
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EWR_EMAIL_CHARSET;
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();
		ewr_DeleteTmpImages($EmailContent);

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count and write log
			ewr_AddEmailLog($sSender, $sRecipient, $sEmailSubject, $sEmailMessage);

			// Sent email success
			return $sSuccessRespPfx . $ReportLanguage->Phrase("SendEmailSuccess") . $sRespPfx; // Set up success message
		} else {

			// Sent email failure
			return $sFailRespPfx . $Email->SendErrDescription . $sRespPfx;
		}
	}

	// Export to HTML
	function ExportHtml($html, $options = array()) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');

		$folder = @$this->GenOptions["folder"];
		$fileName = @$this->GenOptions["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";

		// Save generate file for print
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			$baseTag = "<base href=\"" . ewr_BaseUrl() . "\">";
			$html = preg_replace('/<head>/', '<head>' . $baseTag, $html);
			ewr_SaveFile($folder, $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file")
			echo $html;
		return $saveToFile;
	}

	// Export to WORD
	function ExportWord($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-word' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
			echo $html;
		}
		return $saveToFile;
	}

	// Export to EXCEL
	function ExportExcel($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-excel' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
			echo $html;
		}
		return $saveToFile;
	}

	// Export PDF
	function ExportPdf($html, $options = array()) {
		global $gsExportFile;
		@ini_set("memory_limit", EWR_PDF_MEMORY_LIMIT);
		set_time_limit(EWR_PDF_TIME_LIMIT);
		if (EWR_DEBUG_ENABLED) // Add debug message
			$html = str_replace("</body>", ewr_DebugMsg() . "</body>", $html);
		$dompdf = new \Dompdf\Dompdf(array("pdf_backend" => "Cpdf"));
		$doc = new DOMDocument();
		@$doc->loadHTML('<?xml encoding="uft-8">' . ewr_ConvertToUtf8($html)); // Convert to utf-8
		$spans = $doc->getElementsByTagName("span");
		foreach ($spans as $span) {
			if ($span->getAttribute("class") == "ewFilterCaption")
				$span->parentNode->insertBefore($doc->createElement("span", ":&nbsp;"), $span->nextSibling);
		}
		$html = $doc->saveHTML();
		$html = ewr_ConvertFromUtf8($html);
		$dompdf->load_html($html);
		$dompdf->set_paper("a4", "portrait");
		$dompdf->render();
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $dompdf->output());
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			$sExportFile = strtolower(substr($gsExportFile, -4)) == ".pdf" ? $gsExportFile : $gsExportFile . ".pdf";
			$dompdf->stream($sExportFile, array("Attachment" => 1)); // 0 to open in browser, 1 to download
		}
		ewr_DeleteTmpImages($html);
		return $saveToFile;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($StandOwners_summary)) $StandOwners_summary = new crStandOwners_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$StandOwners_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "phprptinc/header.php" ?>
<?php if ($Page->Export == "" || $Page->Export == "print" || $Page->Export == "email" && @$gsEmailContentType == "url") { ?>
<script type="text/javascript">

// Create page object
var StandOwners_summary = new ewr_Page("StandOwners_summary");

// Page properties
StandOwners_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = StandOwners_summary.PageID;

// Extend page with Chart_Rendering function
StandOwners_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
StandOwners_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fStandOwnerssummary = new ewr_Form("fStandOwnerssummary");

// Validate method
fStandOwnerssummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	var elm = fobj.sv_datestatus;
	if (elm && !ewr_CheckDateDef(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->datestatus->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fStandOwnerssummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fStandOwnerssummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fStandOwnerssummary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fStandOwnerssummary.Lists["sv_area"] = {"LinkField":"sv_area","Ajax":true,"DisplayFields":["sv_area","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fStandOwnerssummary.Lists["sv_price"] = {"LinkField":"sv_price","Ajax":true,"DisplayFields":["sv_price","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fStandOwnerssummary.Lists["sv_deposit"] = {"LinkField":"sv_deposit","Ajax":true,"DisplayFields":["sv_deposit","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Page->Export == "") { ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if ($Page->Export == "" && (!$Page->DrillDown || !$Page->DrillDownInPanel)) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "") { ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
<?php } ?>
	<!-- Left slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
<?php } ?>
	<!-- center slot -->
<!-- summary report starts -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<!-- Search form (begin) -->
<form name="fStandOwnerssummary" id="fStandOwnerssummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fStandOwnerssummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_surname" class="ewCell form-group">
	<label for="sv_surname" class="ewSearchCaption ewLabel"><?php echo $Page->surname->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_surname" id="so_surname" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->surname->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->surname->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->surname->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->surname->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->surname->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->surname->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->surname->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->surname->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->surname->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->surname->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->surname->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->surname->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->surname->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->surname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_surname" id="sv_surname" name="sv_surname" size="30" maxlength="255" placeholder="<?php echo $Page->surname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->surname->SearchValue) ?>"<?php echo $Page->surname->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_surname" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_surname" style="display: none">
<?php ewr_PrependClass($Page->surname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_surname" id="sv2_surname" name="sv2_surname" size="30" maxlength="255" placeholder="<?php echo $Page->surname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->surname->SearchValue2) ?>"<?php echo $Page->surname->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_file_number" class="ewCell form-group">
	<label for="sv_file_number" class="ewSearchCaption ewLabel"><?php echo $Page->file_number->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_file_number" id="so_file_number" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->file_number->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->file_number->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->file_number->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->file_number->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->file_number->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->file_number->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->file_number->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->file_number->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->file_number->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->file_number->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->file_number->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->file_number->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->file_number->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->file_number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_file_number" id="sv_file_number" name="sv_file_number" size="30" maxlength="255" placeholder="<?php echo $Page->file_number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->file_number->SearchValue) ?>"<?php echo $Page->file_number->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_file_number" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_file_number" style="display: none">
<?php ewr_PrependClass($Page->file_number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_file_number" id="sv2_file_number" name="sv2_file_number" size="30" maxlength="255" placeholder="<?php echo $Page->file_number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->file_number->SearchValue2) ?>"<?php echo $Page->file_number->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_3" class="ewRow">
<div id="c_office" class="ewCell form-group">
	<label for="sv_office" class="ewSearchCaption ewLabel"><?php echo $Page->office->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_office" id="so_office" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->office->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->office->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->office->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->office->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->office->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->office->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->office->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->office->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->office->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->office->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->office->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->office->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->office->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->office->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_office" id="sv_office" name="sv_office" size="30" maxlength="255" placeholder="<?php echo $Page->office->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->office->SearchValue) ?>"<?php echo $Page->office->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_office" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_office" style="display: none">
<?php ewr_PrependClass($Page->office->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_office" id="sv2_office" name="sv2_office" size="30" maxlength="255" placeholder="<?php echo $Page->office->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->office->SearchValue2) ?>"<?php echo $Page->office->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_4" class="ewRow">
<div id="c_idnum" class="ewCell form-group">
	<label for="sv_idnum" class="ewSearchCaption ewLabel"><?php echo $Page->idnum->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_idnum" id="so_idnum" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->idnum->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->idnum->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->idnum->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->idnum->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->idnum->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->idnum->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->idnum->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->idnum->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->idnum->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->idnum->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->idnum->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->idnum->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->idnum->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->idnum->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_idnum" id="sv_idnum" name="sv_idnum" size="30" maxlength="255" placeholder="<?php echo $Page->idnum->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->idnum->SearchValue) ?>"<?php echo $Page->idnum->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_idnum" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_idnum" style="display: none">
<?php ewr_PrependClass($Page->idnum->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_idnum" id="sv2_idnum" name="sv2_idnum" size="30" maxlength="255" placeholder="<?php echo $Page->idnum->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->idnum->SearchValue2) ?>"<?php echo $Page->idnum->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_5" class="ewRow">
<div id="c_contact" class="ewCell form-group">
	<label for="sv_contact" class="ewSearchCaption ewLabel"><?php echo $Page->contact->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_contact" id="so_contact" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->contact->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->contact->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->contact->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->contact->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->contact->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->contact->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->contact->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->contact->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->contact->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->contact->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->contact->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->contact->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->contact->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->contact->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_contact" id="sv_contact" name="sv_contact" size="30" maxlength="255" placeholder="<?php echo $Page->contact->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->contact->SearchValue) ?>"<?php echo $Page->contact->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_contact" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_contact" style="display: none">
<?php ewr_PrependClass($Page->contact->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_contact" id="sv2_contact" name="sv2_contact" size="30" maxlength="255" placeholder="<?php echo $Page->contact->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->contact->SearchValue2) ?>"<?php echo $Page->contact->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_6" class="ewRow">
<div id="c_location" class="ewCell form-group">
	<label for="sv_location" class="ewSearchCaption ewLabel"><?php echo $Page->location->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_location" id="so_location" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->location->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->location->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->location->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->location->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->location->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->location->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->location->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->location->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->location->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->location->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->location->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->location->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->location->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->location->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_location" id="sv_location" name="sv_location" size="30" maxlength="111" placeholder="<?php echo $Page->location->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->location->SearchValue) ?>"<?php echo $Page->location->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_location" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_location" style="display: none">
<?php ewr_PrependClass($Page->location->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_location" id="sv2_location" name="sv2_location" size="30" maxlength="111" placeholder="<?php echo $Page->location->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->location->SearchValue2) ?>"<?php echo $Page->location->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_7" class="ewRow">
<div id="c_area" class="ewCell form-group">
	<label for="sv_area" class="ewSearchCaption ewLabel"><?php echo $Page->area->FldCaption() ?></label>
	<span class="ewSearchField">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_sv_area"><?php echo (strval(ewr_FilterDropDownValue($Page->area)) == "" ? $ReportLanguage->Phrase("PleaseSelect") : ewr_FilterDropDownValue($Page->area)); ?></span>
</span>
<button type="button" title="<?php echo ewr_HtmlEncode(str_replace("%s", ewr_RemoveHtml($Page->area->FldCaption()), $ReportLanguage->Phrase("LookupLink", TRUE))) ?>" onclick="ewr_ModalLookupShow({lnk:this,el:'sv_area',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="StandOwners" data-field="x_area" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $Page->area->DisplayValueSeparatorAttribute() ?>" name="sv_area" id="sv_area" value="<?php echo ewr_FilterDropDownValue($Page->area) ?>"<?php echo $Page->area->EditAttributes() ?>>
<input type="hidden" name="s_sv_area" id="s_sv_area" value="<?php echo $Page->area->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_8" class="ewRow">
<div id="c_number" class="ewCell form-group">
	<label for="sv_number" class="ewSearchCaption ewLabel"><?php echo $Page->number->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_number" id="so_number" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->number->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->number->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->number->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->number->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->number->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->number->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->number->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->number->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->number->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->number->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->number->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->number->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->number->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_number" id="sv_number" name="sv_number" size="30" maxlength="111" placeholder="<?php echo $Page->number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->number->SearchValue) ?>"<?php echo $Page->number->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_number" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_number" style="display: none">
<?php ewr_PrependClass($Page->number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_number" id="sv2_number" name="sv2_number" size="30" maxlength="111" placeholder="<?php echo $Page->number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->number->SearchValue2) ?>"<?php echo $Page->number->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_9" class="ewRow">
<div id="c_price" class="ewCell form-group">
	<label for="sv_price" class="ewSearchCaption ewLabel"><?php echo $Page->price->FldCaption() ?></label>
	<span class="ewSearchField">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_sv_price"><?php echo (strval(ewr_FilterDropDownValue($Page->price)) == "" ? $ReportLanguage->Phrase("PleaseSelect") : ewr_FilterDropDownValue($Page->price)); ?></span>
</span>
<button type="button" title="<?php echo ewr_HtmlEncode(str_replace("%s", ewr_RemoveHtml($Page->price->FldCaption()), $ReportLanguage->Phrase("LookupLink", TRUE))) ?>" onclick="ewr_ModalLookupShow({lnk:this,el:'sv_price',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="StandOwners" data-field="x_price" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $Page->price->DisplayValueSeparatorAttribute() ?>" name="sv_price" id="sv_price" value="<?php echo ewr_FilterDropDownValue($Page->price) ?>"<?php echo $Page->price->EditAttributes() ?>>
<input type="hidden" name="s_sv_price" id="s_sv_price" value="<?php echo $Page->price->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_10" class="ewRow">
<div id="c_deposit" class="ewCell form-group">
	<label for="sv_deposit" class="ewSearchCaption ewLabel"><?php echo $Page->deposit->FldCaption() ?></label>
	<span class="ewSearchField">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_sv_deposit"><?php echo (strval(ewr_FilterDropDownValue($Page->deposit)) == "" ? $ReportLanguage->Phrase("PleaseSelect") : ewr_FilterDropDownValue($Page->deposit)); ?></span>
</span>
<button type="button" title="<?php echo ewr_HtmlEncode(str_replace("%s", ewr_RemoveHtml($Page->deposit->FldCaption()), $ReportLanguage->Phrase("LookupLink", TRUE))) ?>" onclick="ewr_ModalLookupShow({lnk:this,el:'sv_deposit',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="StandOwners" data-field="x_deposit" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $Page->deposit->DisplayValueSeparatorAttribute() ?>" name="sv_deposit" id="sv_deposit" value="<?php echo ewr_FilterDropDownValue($Page->deposit) ?>"<?php echo $Page->deposit->EditAttributes() ?>>
<input type="hidden" name="s_sv_deposit" id="s_sv_deposit" value="<?php echo $Page->deposit->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_11" class="ewRow">
<div id="c_instalments" class="ewCell form-group">
	<label for="sv_instalments" class="ewSearchCaption ewLabel"><?php echo $Page->instalments->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_instalments" id="so_instalments" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->instalments->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->instalments->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->instalments->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->instalments->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->instalments->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->instalments->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->instalments->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->instalments->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->instalments->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->instalments->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->instalments->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->instalments->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->instalments->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->instalments->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_instalments" id="sv_instalments" name="sv_instalments" size="30" maxlength="111" placeholder="<?php echo $Page->instalments->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->instalments->SearchValue) ?>"<?php echo $Page->instalments->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_instalments" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_instalments" style="display: none">
<?php ewr_PrependClass($Page->instalments->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_instalments" id="sv2_instalments" name="sv2_instalments" size="30" maxlength="111" placeholder="<?php echo $Page->instalments->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->instalments->SearchValue2) ?>"<?php echo $Page->instalments->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_12" class="ewRow">
<div id="c_datestatus" class="ewCell form-group">
	<label for="sv_datestatus" class="ewSearchCaption ewLabel"><?php echo $Page->datestatus->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_datestatus" id="so_datestatus" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->datestatus->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->datestatus->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->datestatus->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->datestatus->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->datestatus->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->datestatus->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="IS NULL"<?php if ($Page->datestatus->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->datestatus->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->datestatus->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->datestatus->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_datestatus" id="sv_datestatus" name="sv_datestatus" placeholder="<?php echo $Page->datestatus->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->datestatus->SearchValue) ?>"<?php echo $Page->datestatus->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_datestatus" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_datestatus" style="display: none">
<?php ewr_PrependClass($Page->datestatus->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="StandOwners" data-field="x_datestatus" id="sv2_datestatus" name="sv2_datestatus" placeholder="<?php echo $Page->datestatus->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->datestatus->SearchValue2) ?>"<?php echo $Page->datestatus->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fStandOwnerssummary.Init();
fStandOwnerssummary.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php include "StandOwnerssmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="name"><div class="StandOwners_name"><span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="name">
<?php if ($Page->SortUrl($Page->name) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_name">
			<span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_name" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->name) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="surname"><div class="StandOwners_surname"><span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="surname">
<?php if ($Page->SortUrl($Page->surname) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_surname">
			<span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_surname', false, '<?php echo $Page->surname->RangeFrom; ?>', '<?php echo $Page->surname->RangeTo; ?>');" id="x_surname<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_surname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->surname) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->surname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->surname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_surname', false, '<?php echo $Page->surname->RangeFrom; ?>', '<?php echo $Page->surname->RangeTo; ?>');" id="x_surname<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="file_number"><div class="StandOwners_file_number"><span class="ewTableHeaderCaption"><?php echo $Page->file_number->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="file_number">
<?php if ($Page->SortUrl($Page->file_number) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_file_number">
			<span class="ewTableHeaderCaption"><?php echo $Page->file_number->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_file_number', false, '<?php echo $Page->file_number->RangeFrom; ?>', '<?php echo $Page->file_number->RangeTo; ?>');" id="x_file_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_file_number" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->file_number) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->file_number->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->file_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->file_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_file_number', false, '<?php echo $Page->file_number->RangeFrom; ?>', '<?php echo $Page->file_number->RangeTo; ?>');" id="x_file_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="office"><div class="StandOwners_office"><span class="ewTableHeaderCaption"><?php echo $Page->office->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="office">
<?php if ($Page->SortUrl($Page->office) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_office">
			<span class="ewTableHeaderCaption"><?php echo $Page->office->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_office', false, '<?php echo $Page->office->RangeFrom; ?>', '<?php echo $Page->office->RangeTo; ?>');" id="x_office<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_office" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->office) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->office->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->office->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->office->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_office', false, '<?php echo $Page->office->RangeFrom; ?>', '<?php echo $Page->office->RangeTo; ?>');" id="x_office<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="idnum"><div class="StandOwners_idnum"><span class="ewTableHeaderCaption"><?php echo $Page->idnum->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="idnum">
<?php if ($Page->SortUrl($Page->idnum) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_idnum">
			<span class="ewTableHeaderCaption"><?php echo $Page->idnum->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_idnum', false, '<?php echo $Page->idnum->RangeFrom; ?>', '<?php echo $Page->idnum->RangeTo; ?>');" id="x_idnum<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_idnum" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->idnum) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->idnum->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->idnum->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->idnum->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_idnum', false, '<?php echo $Page->idnum->RangeFrom; ?>', '<?php echo $Page->idnum->RangeTo; ?>');" id="x_idnum<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="contact"><div class="StandOwners_contact"><span class="ewTableHeaderCaption"><?php echo $Page->contact->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="contact">
<?php if ($Page->SortUrl($Page->contact) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_contact">
			<span class="ewTableHeaderCaption"><?php echo $Page->contact->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_contact', false, '<?php echo $Page->contact->RangeFrom; ?>', '<?php echo $Page->contact->RangeTo; ?>');" id="x_contact<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_contact" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->contact) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->contact->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->contact->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->contact->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_contact', false, '<?php echo $Page->contact->RangeFrom; ?>', '<?php echo $Page->contact->RangeTo; ?>');" id="x_contact<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="location"><div class="StandOwners_location"><span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="location">
<?php if ($Page->SortUrl($Page->location) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_location">
			<span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_location', false, '<?php echo $Page->location->RangeFrom; ?>', '<?php echo $Page->location->RangeTo; ?>');" id="x_location<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_location" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->location) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_location', false, '<?php echo $Page->location->RangeFrom; ?>', '<?php echo $Page->location->RangeTo; ?>');" id="x_location<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="area"><div class="StandOwners_area"><span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="area">
<?php if ($Page->SortUrl($Page->area) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_area">
			<span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_area', true, '<?php echo $Page->area->RangeFrom; ?>', '<?php echo $Page->area->RangeTo; ?>');" id="x_area<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_area" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->area) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->area->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->area->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_area', true, '<?php echo $Page->area->RangeFrom; ?>', '<?php echo $Page->area->RangeTo; ?>');" id="x_area<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="number"><div class="StandOwners_number"><span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="number">
<?php if ($Page->SortUrl($Page->number) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_number">
			<span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_number', false, '<?php echo $Page->number->RangeFrom; ?>', '<?php echo $Page->number->RangeTo; ?>');" id="x_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_number" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->number) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_number', false, '<?php echo $Page->number->RangeFrom; ?>', '<?php echo $Page->number->RangeTo; ?>');" id="x_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="price"><div class="StandOwners_price"><span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="price">
<?php if ($Page->SortUrl($Page->price) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_price">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_price', true, '<?php echo $Page->price->RangeFrom; ?>', '<?php echo $Page->price->RangeTo; ?>');" id="x_price<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_price" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->price) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_price', true, '<?php echo $Page->price->RangeFrom; ?>', '<?php echo $Page->price->RangeTo; ?>');" id="x_price<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="deposit"><div class="StandOwners_deposit"><span class="ewTableHeaderCaption"><?php echo $Page->deposit->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="deposit">
<?php if ($Page->SortUrl($Page->deposit) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_deposit">
			<span class="ewTableHeaderCaption"><?php echo $Page->deposit->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_deposit', true, '<?php echo $Page->deposit->RangeFrom; ?>', '<?php echo $Page->deposit->RangeTo; ?>');" id="x_deposit<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_deposit" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->deposit) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->deposit->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->deposit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->deposit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_deposit', true, '<?php echo $Page->deposit->RangeFrom; ?>', '<?php echo $Page->deposit->RangeTo; ?>');" id="x_deposit<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="instalments"><div class="StandOwners_instalments"><span class="ewTableHeaderCaption"><?php echo $Page->instalments->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="instalments">
<?php if ($Page->SortUrl($Page->instalments) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_instalments">
			<span class="ewTableHeaderCaption"><?php echo $Page->instalments->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_instalments', false, '<?php echo $Page->instalments->RangeFrom; ?>', '<?php echo $Page->instalments->RangeTo; ?>');" id="x_instalments<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_instalments" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->instalments) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->instalments->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->instalments->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->instalments->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_instalments', false, '<?php echo $Page->instalments->RangeFrom; ?>', '<?php echo $Page->instalments->RangeTo; ?>');" id="x_instalments<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="datestatus"><div class="StandOwners_datestatus"><span class="ewTableHeaderCaption"><?php echo $Page->datestatus->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="datestatus">
<?php if ($Page->SortUrl($Page->datestatus) == "") { ?>
		<div class="ewTableHeaderBtn StandOwners_datestatus">
			<span class="ewTableHeaderCaption"><?php echo $Page->datestatus->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_datestatus', false, '<?php echo $Page->datestatus->RangeFrom; ?>', '<?php echo $Page->datestatus->RangeTo; ?>');" id="x_datestatus<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer StandOwners_datestatus" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->datestatus) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->datestatus->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->datestatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->datestatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'StandOwners_datestatus', false, '<?php echo $Page->datestatus->RangeFrom; ?>', '<?php echo $Page->datestatus->RangeTo; ?>');" id="x_datestatus<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_name"<?php echo $Page->name->ViewAttributes() ?>><?php echo $Page->name->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_surname"<?php echo $Page->surname->ViewAttributes() ?>><?php echo $Page->surname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_file_number"<?php echo $Page->file_number->ViewAttributes() ?>><?php echo $Page->file_number->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_office"<?php echo $Page->office->ViewAttributes() ?>><?php echo $Page->office->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_idnum"<?php echo $Page->idnum->ViewAttributes() ?>><?php echo $Page->idnum->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_contact"<?php echo $Page->contact->ViewAttributes() ?>><?php echo $Page->contact->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_location"<?php echo $Page->location->ViewAttributes() ?>><?php echo $Page->location->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_number"<?php echo $Page->number->ViewAttributes() ?>><?php echo $Page->number->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_instalments"<?php echo $Page->instalments->ViewAttributes() ?>><?php echo $Page->instalments->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_StandOwners_datestatus"<?php echo $Page->datestatus->ViewAttributes() ?>><?php echo $Page->datestatus->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->area->Count = $Page->GrandCnt[8];
	$Page->area->SumValue = $Page->GrandSmry[8]; // Load SUM
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->SumValue = $Page->GrandSmry[10]; // Load SUM
	$Page->deposit->Count = $Page->GrandCnt[11];
	$Page->deposit->SumValue = $Page->GrandSmry[11]; // Load SUM
	$Page->area->Count = $Page->GrandCnt[8];
	$Page->area->AvgValue = ($Page->area->Count > 0) ? $Page->GrandSmry[8]/$Page->area->Count : 0; // Load AVG
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->AvgValue = ($Page->price->Count > 0) ? $Page->GrandSmry[10]/$Page->price->Count : 0; // Load AVG
	$Page->deposit->Count = $Page->GrandCnt[11];
	$Page->deposit->AvgValue = ($Page->deposit->Count > 0) ? $Page->GrandSmry[11]/$Page->deposit->Count : 0; // Load AVG
	$Page->area->Count = $Page->GrandCnt[8];
	$Page->area->MinValue = $Page->GrandMn[8]; // Load MIN
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->MinValue = $Page->GrandMn[10]; // Load MIN
	$Page->deposit->Count = $Page->GrandCnt[11];
	$Page->deposit->MinValue = $Page->GrandMn[11]; // Load MIN
	$Page->area->Count = $Page->GrandCnt[8];
	$Page->area->MaxValue = $Page->GrandMx[8]; // Load MAX
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->MaxValue = $Page->GrandMx[10]; // Load MAX
	$Page->deposit->Count = $Page->GrandCnt[11];
	$Page->deposit->MaxValue = $Page->GrandMx[11]; // Load MAX
	$Page->area->Count = $Page->GrandCnt[8];
	$Page->area->CntValue = $Page->GrandCnt[8]; // Load CNT
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->CntValue = $Page->GrandCnt[10]; // Load CNT
	$Page->deposit->Count = $Page->GrandCnt[11];
	$Page->deposit->CntValue = $Page->GrandCnt[11]; // Load CNT
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->file_number->Visible) { ?>
		<td data-field="file_number"<?php echo $Page->file_number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->office->Visible) { ?>
		<td data-field="office"<?php echo $Page->office->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->idnum->Visible) { ?>
		<td data-field="idnum"<?php echo $Page->idnum->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->contact->Visible) { ?>
		<td data-field="contact"<?php echo $Page->contact->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_StandOwners_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_StandOwners_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->deposit->Visible) { ?>
		<td data-field="deposit"<?php echo $Page->deposit->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_StandOwners_deposit"<?php echo $Page->deposit->ViewAttributes() ?>><?php echo $Page->deposit->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->instalments->Visible) { ?>
		<td data-field="instalments"<?php echo $Page->instalments->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->datestatus->Visible) { ?>
		<td data-field="datestatus"<?php echo $Page->datestatus->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && TRUE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php include "StandOwnerssmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || TRUE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->TotalGrps > 0) { ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "StandOwnerssmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
<?php } ?>
	<!-- Right slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
<?php } ?>
	<!-- Bottom slot -->
<?php if ($Page->Export == "") { ?>
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php } ?>
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
