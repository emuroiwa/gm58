<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "Payments_Reportsmryinfo.php" ?>
<?php

//
// Page class
//

$Payments_Report_summary = NULL; // Initialize page object first

class crPayments_Report_summary extends crPayments_Report {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{3080AF49-5443-4264-8421-3510B6183D7C}";

	// Page object name
	var $PageObjName = 'Payments_Report_summary';

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

		// Table object (Payments_Report)
		if (!isset($GLOBALS["Payments_Report"])) {
			$GLOBALS["Payments_Report"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Payments_Report"];
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
			define("EWR_TABLE_NAME", 'Payments Report', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fPayments_Reportsummary";

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
		$this->name->PlaceHolder = $this->name->FldCaption();
		$this->surname->PlaceHolder = $this->surname->FldCaption();
		$this->date->PlaceHolder = $this->date->FldCaption();
		$this->capturer->PlaceHolder = $this->capturer->FldCaption();
		$this->d->PlaceHolder = $this->d->FldCaption();
		$this->location->PlaceHolder = $this->location->FldCaption();
		$this->number->PlaceHolder = $this->number->FldCaption();
		$this->area->PlaceHolder = $this->area->FldCaption();
		$this->monthz->PlaceHolder = $this->monthz->FldCaption();

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
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_Payments_Report\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_Payments_Report',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fPayments_Reportsummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fPayments_Reportsummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fPayments_Reportsummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
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
		$this->cash->SetVisibility();
		$this->date->SetVisibility();
		$this->capturer->SetVisibility();
		$this->d->SetVisibility();
		$this->location->SetVisibility();
		$this->number->SetVisibility();
		$this->area->SetVisibility();
		$this->price->SetVisibility();
		$this->monthz->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 12;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,TRUE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE), array(TRUE,TRUE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		$this->name->SelectionList = "";
		$this->name->DefaultSelectionList = "";
		$this->name->ValueList = "";
		$this->surname->SelectionList = "";
		$this->surname->DefaultSelectionList = "";
		$this->surname->ValueList = "";
		$this->cash->SelectionList = "";
		$this->cash->DefaultSelectionList = "";
		$this->cash->ValueList = "";
		$this->date->SelectionList = "";
		$this->date->DefaultSelectionList = "";
		$this->date->ValueList = "";
		$this->capturer->SelectionList = "";
		$this->capturer->DefaultSelectionList = "";
		$this->capturer->ValueList = "";
		$this->d->SelectionList = "";
		$this->d->DefaultSelectionList = "";
		$this->d->ValueList = "";
		$this->location->SelectionList = "";
		$this->location->DefaultSelectionList = "";
		$this->location->ValueList = "";
		$this->number->SelectionList = "";
		$this->number->DefaultSelectionList = "";
		$this->number->ValueList = "";
		$this->area->SelectionList = "";
		$this->area->DefaultSelectionList = "";
		$this->area->ValueList = "";
		$this->price->SelectionList = "";
		$this->price->DefaultSelectionList = "";
		$this->price->ValueList = "";
		$this->monthz->SelectionList = "";
		$this->monthz->DefaultSelectionList = "";
		$this->monthz->ValueList = "";

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
				$this->FirstRowData['id'] = ewr_Conv($rs->fields('id'), 3);
				$this->FirstRowData['name'] = ewr_Conv($rs->fields('name'), 200);
				$this->FirstRowData['surname'] = ewr_Conv($rs->fields('surname'), 200);
				$this->FirstRowData['cash'] = ewr_Conv($rs->fields('cash'), 131);
				$this->FirstRowData['date'] = ewr_Conv($rs->fields('date'), 135);
				$this->FirstRowData['capturer'] = ewr_Conv($rs->fields('capturer'), 200);
				$this->FirstRowData['d'] = ewr_Conv($rs->fields('d'), 200);
				$this->FirstRowData['location'] = ewr_Conv($rs->fields('location'), 200);
				$this->FirstRowData['number'] = ewr_Conv($rs->fields('number'), 200);
				$this->FirstRowData['area'] = ewr_Conv($rs->fields('area'), 131);
				$this->FirstRowData['price'] = ewr_Conv($rs->fields('price'), 131);
				$this->FirstRowData['paidmonths'] = ewr_Conv($rs->fields('paidmonths'), 5);
				$this->FirstRowData['monthz'] = ewr_Conv($rs->fields('monthz'), 200);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->id->setDbValue($rs->fields('id'));
			$this->name->setDbValue($rs->fields('name'));
			$this->surname->setDbValue($rs->fields('surname'));
			$this->cash->setDbValue($rs->fields('cash'));
			$this->date->setDbValue($rs->fields('date'));
			$this->capturer->setDbValue($rs->fields('capturer'));
			$this->d->setDbValue($rs->fields('d'));
			$this->location->setDbValue($rs->fields('location'));
			$this->number->setDbValue($rs->fields('number'));
			$this->area->setDbValue($rs->fields('area'));
			$this->price->setDbValue($rs->fields('price'));
			$this->paidmonths->setDbValue($rs->fields('paidmonths'));
			$this->monthz->setDbValue($rs->fields('monthz'));
			$this->Val[1] = $this->name->CurrentValue;
			$this->Val[2] = $this->surname->CurrentValue;
			$this->Val[3] = $this->cash->CurrentValue;
			$this->Val[4] = $this->date->CurrentValue;
			$this->Val[5] = $this->capturer->CurrentValue;
			$this->Val[6] = $this->d->CurrentValue;
			$this->Val[7] = $this->location->CurrentValue;
			$this->Val[8] = $this->number->CurrentValue;
			$this->Val[9] = $this->area->CurrentValue;
			$this->Val[10] = $this->price->CurrentValue;
			$this->Val[11] = $this->monthz->CurrentValue;
		} else {
			$this->id->setDbValue("");
			$this->name->setDbValue("");
			$this->surname->setDbValue("");
			$this->cash->setDbValue("");
			$this->date->setDbValue("");
			$this->capturer->setDbValue("");
			$this->d->setDbValue("");
			$this->location->setDbValue("");
			$this->number->setDbValue("");
			$this->area->setDbValue("");
			$this->price->setDbValue("");
			$this->paidmonths->setDbValue("");
			$this->monthz->setDbValue("");
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
			// Build distinct values for name

			if ($popupname == 'Payments_Report_name') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->name, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->name->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->name->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->name->setDbValue($rswrk->fields[0]);
					$this->name->ViewValue = @$rswrk->fields[1];
					if (is_null($this->name->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->name->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->name->ValueList, $this->name->CurrentValue, $this->name->ViewValue, FALSE, $this->name->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->name->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->name->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->name;
			}

			// Build distinct values for surname
			if ($popupname == 'Payments_Report_surname') {
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

			// Build distinct values for cash
			if ($popupname == 'Payments_Report_cash') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->cash, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->cash->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->cash->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->cash->setDbValue($rswrk->fields[0]);
					$this->cash->ViewValue = @$rswrk->fields[1];
					if (is_null($this->cash->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->cash->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->cash->ValueList, $this->cash->CurrentValue, $this->cash->ViewValue, FALSE, $this->cash->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->cash->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->cash->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->cash;
			}

			// Build distinct values for date
			if ($popupname == 'Payments_Report_date') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->date, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->date->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->date->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->date->setDbValue($rswrk->fields[0]);
					$this->date->ViewValue = @$rswrk->fields[1];
					if (is_null($this->date->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->date->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->date->ValueList, $this->date->CurrentValue, $this->date->ViewValue, FALSE, $this->date->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->date->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->date->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->date;
			}

			// Build distinct values for capturer
			if ($popupname == 'Payments_Report_capturer') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->capturer, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->capturer->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->capturer->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->capturer->setDbValue($rswrk->fields[0]);
					$this->capturer->ViewValue = @$rswrk->fields[1];
					if (is_null($this->capturer->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->capturer->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->capturer->ValueList, $this->capturer->CurrentValue, $this->capturer->ViewValue, FALSE, $this->capturer->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->capturer->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->capturer->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->capturer;
			}

			// Build distinct values for d
			if ($popupname == 'Payments_Report_d') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->d, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->d->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->d->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->d->setDbValue($rswrk->fields[0]);
					$this->d->ViewValue = @$rswrk->fields[1];
					if (is_null($this->d->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->d->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->d->ValueList, $this->d->CurrentValue, $this->d->ViewValue, FALSE, $this->d->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->d->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->d->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->d;
			}

			// Build distinct values for location
			if ($popupname == 'Payments_Report_location') {
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

			// Build distinct values for number
			if ($popupname == 'Payments_Report_number') {
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

			// Build distinct values for area
			if ($popupname == 'Payments_Report_area') {
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

			// Build distinct values for price
			if ($popupname == 'Payments_Report_price') {
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

			// Build distinct values for monthz
			if ($popupname == 'Payments_Report_monthz') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;

				// Call Page Filtering event
				$this->Page_Filtering($this->monthz, $sFilter, "popup");
				$sSql = ewr_BuildReportSql($this->monthz->SqlSelect, $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->monthz->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->monthz->setDbValue($rswrk->fields[0]);
					$this->monthz->ViewValue = @$rswrk->fields[1];
					if (is_null($this->monthz->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->monthz->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						ewr_SetupDistinctValues($this->monthz->ValueList, $this->monthz->CurrentValue, $this->monthz->ViewValue, FALSE, $this->monthz->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->monthz->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->monthz->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->monthz;
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
				$this->ClearSessionSelection('name');
				$this->ClearSessionSelection('surname');
				$this->ClearSessionSelection('cash');
				$this->ClearSessionSelection('date');
				$this->ClearSessionSelection('capturer');
				$this->ClearSessionSelection('d');
				$this->ClearSessionSelection('location');
				$this->ClearSessionSelection('number');
				$this->ClearSessionSelection('area');
				$this->ClearSessionSelection('price');
				$this->ClearSessionSelection('monthz');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get name selected values

		if (is_array(@$_SESSION["sel_Payments_Report_name"])) {
			$this->LoadSelectionFromSession('name');
		} elseif (@$_SESSION["sel_Payments_Report_name"] == EWR_INIT_VALUE) { // Select all
			$this->name->SelectionList = "";
		}

		// Get surname selected values
		if (is_array(@$_SESSION["sel_Payments_Report_surname"])) {
			$this->LoadSelectionFromSession('surname');
		} elseif (@$_SESSION["sel_Payments_Report_surname"] == EWR_INIT_VALUE) { // Select all
			$this->surname->SelectionList = "";
		}

		// Get cash selected values
		if (is_array(@$_SESSION["sel_Payments_Report_cash"])) {
			$this->LoadSelectionFromSession('cash');
		} elseif (@$_SESSION["sel_Payments_Report_cash"] == EWR_INIT_VALUE) { // Select all
			$this->cash->SelectionList = "";
		}

		// Get date selected values
		if (is_array(@$_SESSION["sel_Payments_Report_date"])) {
			$this->LoadSelectionFromSession('date');
		} elseif (@$_SESSION["sel_Payments_Report_date"] == EWR_INIT_VALUE) { // Select all
			$this->date->SelectionList = "";
		}

		// Get capturer selected values
		if (is_array(@$_SESSION["sel_Payments_Report_capturer"])) {
			$this->LoadSelectionFromSession('capturer');
		} elseif (@$_SESSION["sel_Payments_Report_capturer"] == EWR_INIT_VALUE) { // Select all
			$this->capturer->SelectionList = "";
		}

		// Get d selected values
		if (is_array(@$_SESSION["sel_Payments_Report_d"])) {
			$this->LoadSelectionFromSession('d');
		} elseif (@$_SESSION["sel_Payments_Report_d"] == EWR_INIT_VALUE) { // Select all
			$this->d->SelectionList = "";
		}

		// Get location selected values
		if (is_array(@$_SESSION["sel_Payments_Report_location"])) {
			$this->LoadSelectionFromSession('location');
		} elseif (@$_SESSION["sel_Payments_Report_location"] == EWR_INIT_VALUE) { // Select all
			$this->location->SelectionList = "";
		}

		// Get number selected values
		if (is_array(@$_SESSION["sel_Payments_Report_number"])) {
			$this->LoadSelectionFromSession('number');
		} elseif (@$_SESSION["sel_Payments_Report_number"] == EWR_INIT_VALUE) { // Select all
			$this->number->SelectionList = "";
		}

		// Get area selected values
		if (is_array(@$_SESSION["sel_Payments_Report_area"])) {
			$this->LoadSelectionFromSession('area');
		} elseif (@$_SESSION["sel_Payments_Report_area"] == EWR_INIT_VALUE) { // Select all
			$this->area->SelectionList = "";
		}

		// Get price selected values
		if (is_array(@$_SESSION["sel_Payments_Report_price"])) {
			$this->LoadSelectionFromSession('price');
		} elseif (@$_SESSION["sel_Payments_Report_price"] == EWR_INIT_VALUE) { // Select all
			$this->price->SelectionList = "";
		}

		// Get monthz selected values
		if (is_array(@$_SESSION["sel_Payments_Report_monthz"])) {
			$this->LoadSelectionFromSession('monthz');
		} elseif (@$_SESSION["sel_Payments_Report_monthz"] == EWR_INIT_VALUE) { // Select all
			$this->monthz->SelectionList = "";
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
				$this->GrandSmry[3] = $rsagg->fields("sum_cash");
				$this->GrandSmry[3] = $rsagg->fields("sum_cash");
				$this->GrandMn[3] = $rsagg->fields("min_cash");
				$this->GrandMx[3] = $rsagg->fields("max_cash");
				$this->GrandCnt[3] = $rsagg->fields("cnt_cash");
				$this->GrandCnt[4] = $this->TotCount;
				$this->GrandCnt[5] = $this->TotCount;
				$this->GrandCnt[6] = $this->TotCount;
				$this->GrandCnt[7] = $this->TotCount;
				$this->GrandCnt[8] = $this->TotCount;
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandSmry[9] = $rsagg->fields("sum_area");
				$this->GrandSmry[9] = $rsagg->fields("sum_area");
				$this->GrandMn[9] = $rsagg->fields("min_area");
				$this->GrandMx[9] = $rsagg->fields("max_area");
				$this->GrandCnt[9] = $rsagg->fields("cnt_area");
				$this->GrandCnt[10] = $this->TotCount;
				$this->GrandSmry[10] = $rsagg->fields("sum_price");
				$this->GrandSmry[10] = $rsagg->fields("sum_price");
				$this->GrandMn[10] = $rsagg->fields("min_price");
				$this->GrandMx[10] = $rsagg->fields("max_price");
				$this->GrandCnt[10] = $rsagg->fields("cnt_price");
				$this->GrandCnt[11] = $this->TotCount;
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

			// cash
			$this->cash->SumViewValue = $this->cash->SumValue;
			$this->cash->SumViewValue = ewr_FormatNumber($this->cash->SumViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// cash
			$this->cash->AvgViewValue = $this->cash->AvgValue;
			$this->cash->AvgViewValue = ewr_FormatNumber($this->cash->AvgViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// cash
			$this->cash->MinViewValue = $this->cash->MinValue;
			$this->cash->MinViewValue = ewr_FormatNumber($this->cash->MinViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// cash
			$this->cash->MaxViewValue = $this->cash->MaxValue;
			$this->cash->MaxViewValue = ewr_FormatNumber($this->cash->MaxViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// cash
			$this->cash->CntViewValue = $this->cash->CntValue;
			$this->cash->CntViewValue = ewr_FormatNumber($this->cash->CntViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

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

			// name
			$this->name->HrefValue = "";

			// surname
			$this->surname->HrefValue = "";

			// cash
			$this->cash->HrefValue = "";

			// date
			$this->date->HrefValue = "";

			// capturer
			$this->capturer->HrefValue = "";

			// d
			$this->d->HrefValue = "";

			// location
			$this->location->HrefValue = "";

			// number
			$this->number->HrefValue = "";

			// area
			$this->area->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// monthz
			$this->monthz->HrefValue = "";
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

			// cash
			$this->cash->ViewValue = $this->cash->CurrentValue;
			$this->cash->ViewValue = ewr_FormatNumber($this->cash->ViewValue, 0, -2, -2, -2);
			$this->cash->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// date
			$this->date->ViewValue = $this->date->CurrentValue;
			$this->date->ViewValue = ewr_FormatDateTime($this->date->ViewValue, 0);
			$this->date->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// capturer
			$this->capturer->ViewValue = $this->capturer->CurrentValue;
			$this->capturer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// d
			$this->d->ViewValue = $this->d->CurrentValue;
			$this->d->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// location
			$this->location->ViewValue = $this->location->CurrentValue;
			$this->location->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// number
			$this->number->ViewValue = $this->number->CurrentValue;
			$this->number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// area
			$this->area->ViewValue = $this->area->CurrentValue;
			$this->area->ViewValue = ewr_FormatNumber($this->area->ViewValue, 0, -2, -2, -2);
			$this->area->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->ViewValue = ewr_FormatNumber($this->price->ViewValue, 0, -2, -2, -2);
			$this->price->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// monthz
			$this->monthz->ViewValue = $this->monthz->CurrentValue;
			$this->monthz->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// name
			$this->name->HrefValue = "";

			// surname
			$this->surname->HrefValue = "";

			// cash
			$this->cash->HrefValue = "";

			// date
			$this->date->HrefValue = "";

			// capturer
			$this->capturer->HrefValue = "";

			// d
			$this->d->HrefValue = "";

			// location
			$this->location->HrefValue = "";

			// number
			$this->number->HrefValue = "";

			// area
			$this->area->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// monthz
			$this->monthz->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// cash
			$CurrentValue = $this->cash->SumValue;
			$ViewValue = &$this->cash->SumViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// cash
			$CurrentValue = $this->cash->AvgValue;
			$ViewValue = &$this->cash->AvgViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// cash
			$CurrentValue = $this->cash->MinValue;
			$ViewValue = &$this->cash->MinViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// cash
			$CurrentValue = $this->cash->MaxValue;
			$ViewValue = &$this->cash->MaxViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// cash
			$CurrentValue = $this->cash->CntValue;
			$ViewValue = &$this->cash->CntViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

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

			// cash
			$CurrentValue = $this->cash->CurrentValue;
			$ViewValue = &$this->cash->ViewValue;
			$ViewAttrs = &$this->cash->ViewAttrs;
			$CellAttrs = &$this->cash->CellAttrs;
			$HrefValue = &$this->cash->HrefValue;
			$LinkAttrs = &$this->cash->LinkAttrs;
			$this->Cell_Rendered($this->cash, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// date
			$CurrentValue = $this->date->CurrentValue;
			$ViewValue = &$this->date->ViewValue;
			$ViewAttrs = &$this->date->ViewAttrs;
			$CellAttrs = &$this->date->CellAttrs;
			$HrefValue = &$this->date->HrefValue;
			$LinkAttrs = &$this->date->LinkAttrs;
			$this->Cell_Rendered($this->date, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// capturer
			$CurrentValue = $this->capturer->CurrentValue;
			$ViewValue = &$this->capturer->ViewValue;
			$ViewAttrs = &$this->capturer->ViewAttrs;
			$CellAttrs = &$this->capturer->CellAttrs;
			$HrefValue = &$this->capturer->HrefValue;
			$LinkAttrs = &$this->capturer->LinkAttrs;
			$this->Cell_Rendered($this->capturer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// d
			$CurrentValue = $this->d->CurrentValue;
			$ViewValue = &$this->d->ViewValue;
			$ViewAttrs = &$this->d->ViewAttrs;
			$CellAttrs = &$this->d->CellAttrs;
			$HrefValue = &$this->d->HrefValue;
			$LinkAttrs = &$this->d->LinkAttrs;
			$this->Cell_Rendered($this->d, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// location
			$CurrentValue = $this->location->CurrentValue;
			$ViewValue = &$this->location->ViewValue;
			$ViewAttrs = &$this->location->ViewAttrs;
			$CellAttrs = &$this->location->CellAttrs;
			$HrefValue = &$this->location->HrefValue;
			$LinkAttrs = &$this->location->LinkAttrs;
			$this->Cell_Rendered($this->location, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// number
			$CurrentValue = $this->number->CurrentValue;
			$ViewValue = &$this->number->ViewValue;
			$ViewAttrs = &$this->number->ViewAttrs;
			$CellAttrs = &$this->number->CellAttrs;
			$HrefValue = &$this->number->HrefValue;
			$LinkAttrs = &$this->number->LinkAttrs;
			$this->Cell_Rendered($this->number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// area
			$CurrentValue = $this->area->CurrentValue;
			$ViewValue = &$this->area->ViewValue;
			$ViewAttrs = &$this->area->ViewAttrs;
			$CellAttrs = &$this->area->CellAttrs;
			$HrefValue = &$this->area->HrefValue;
			$LinkAttrs = &$this->area->LinkAttrs;
			$this->Cell_Rendered($this->area, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// price
			$CurrentValue = $this->price->CurrentValue;
			$ViewValue = &$this->price->ViewValue;
			$ViewAttrs = &$this->price->ViewAttrs;
			$CellAttrs = &$this->price->CellAttrs;
			$HrefValue = &$this->price->HrefValue;
			$LinkAttrs = &$this->price->LinkAttrs;
			$this->Cell_Rendered($this->price, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// monthz
			$CurrentValue = $this->monthz->CurrentValue;
			$ViewValue = &$this->monthz->ViewValue;
			$ViewAttrs = &$this->monthz->ViewAttrs;
			$CellAttrs = &$this->monthz->CellAttrs;
			$HrefValue = &$this->monthz->HrefValue;
			$LinkAttrs = &$this->monthz->LinkAttrs;
			$this->Cell_Rendered($this->monthz, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->cash->Visible) $this->DtlColumnCount += 1;
		if ($this->date->Visible) $this->DtlColumnCount += 1;
		if ($this->capturer->Visible) $this->DtlColumnCount += 1;
		if ($this->d->Visible) $this->DtlColumnCount += 1;
		if ($this->location->Visible) $this->DtlColumnCount += 1;
		if ($this->number->Visible) $this->DtlColumnCount += 1;
		if ($this->area->Visible) $this->DtlColumnCount += 1;
		if ($this->price->Visible) $this->DtlColumnCount += 1;
		if ($this->monthz->Visible) $this->DtlColumnCount += 1;
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

			// Clear extended filter for field name
			if ($this->ClearExtFilter == 'Payments_Report_name')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'name');

			// Clear extended filter for field surname
			if ($this->ClearExtFilter == 'Payments_Report_surname')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'surname');

			// Set/clear dropdown for field cash
			if ($this->PopupName == 'Payments_Report_cash' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->cash->DropDownValue = EWR_ALL_VALUE;
				else
					$this->cash->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'Payments_Report_cash') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'cash');
			}

			// Clear extended filter for field date
			if ($this->ClearExtFilter == 'Payments_Report_date')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'date');

			// Clear extended filter for field capturer
			if ($this->ClearExtFilter == 'Payments_Report_capturer')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'capturer');

			// Clear extended filter for field d
			if ($this->ClearExtFilter == 'Payments_Report_d')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'd');

			// Clear extended filter for field location
			if ($this->ClearExtFilter == 'Payments_Report_location')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'location');

			// Clear extended filter for field number
			if ($this->ClearExtFilter == 'Payments_Report_number')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'number');

			// Clear extended filter for field area
			if ($this->ClearExtFilter == 'Payments_Report_area')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'area');

			// Set/clear dropdown for field price
			if ($this->PopupName == 'Payments_Report_price' && $this->PopupValue <> "") {
				if ($this->PopupValue == EWR_INIT_VALUE)
					$this->price->DropDownValue = EWR_ALL_VALUE;
				else
					$this->price->DropDownValue = $this->PopupValue;
				$bRestoreSession = FALSE; // Do not restore
			} elseif ($this->ClearExtFilter == 'Payments_Report_price') {
				$this->SetSessionDropDownValue(EWR_INIT_VALUE, '', 'price');
			}

			// Clear extended filter for field monthz
			if ($this->ClearExtFilter == 'Payments_Report_monthz')
				$this->SetSessionFilterValues('', '=', 'AND', '', '=', 'monthz');

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->name->SearchValue, $this->name->SearchOperator, $this->name->SearchCondition, $this->name->SearchValue2, $this->name->SearchOperator2, 'name'); // Field name
			$this->SetSessionFilterValues($this->surname->SearchValue, $this->surname->SearchOperator, $this->surname->SearchCondition, $this->surname->SearchValue2, $this->surname->SearchOperator2, 'surname'); // Field surname
			$this->SetSessionDropDownValue($this->cash->DropDownValue, $this->cash->SearchOperator, 'cash'); // Field cash
			$this->SetSessionFilterValues($this->date->SearchValue, $this->date->SearchOperator, $this->date->SearchCondition, $this->date->SearchValue2, $this->date->SearchOperator2, 'date'); // Field date
			$this->SetSessionFilterValues($this->capturer->SearchValue, $this->capturer->SearchOperator, $this->capturer->SearchCondition, $this->capturer->SearchValue2, $this->capturer->SearchOperator2, 'capturer'); // Field capturer
			$this->SetSessionFilterValues($this->d->SearchValue, $this->d->SearchOperator, $this->d->SearchCondition, $this->d->SearchValue2, $this->d->SearchOperator2, 'd'); // Field d
			$this->SetSessionFilterValues($this->location->SearchValue, $this->location->SearchOperator, $this->location->SearchCondition, $this->location->SearchValue2, $this->location->SearchOperator2, 'location'); // Field location
			$this->SetSessionFilterValues($this->number->SearchValue, $this->number->SearchOperator, $this->number->SearchCondition, $this->number->SearchValue2, $this->number->SearchOperator2, 'number'); // Field number
			$this->SetSessionFilterValues($this->area->SearchValue, $this->area->SearchOperator, $this->area->SearchCondition, $this->area->SearchValue2, $this->area->SearchOperator2, 'area'); // Field area
			$this->SetSessionDropDownValue($this->price->DropDownValue, $this->price->SearchOperator, 'price'); // Field price
			$this->SetSessionFilterValues($this->monthz->SearchValue, $this->monthz->SearchOperator, $this->monthz->SearchCondition, $this->monthz->SearchValue2, $this->monthz->SearchOperator2, 'monthz'); // Field monthz

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field name
			if ($this->GetFilterValues($this->name)) {
				$bSetupFilter = TRUE;
			}

			// Field surname
			if ($this->GetFilterValues($this->surname)) {
				$bSetupFilter = TRUE;
			}

			// Field cash
			if ($this->GetDropDownValue($this->cash)) {
				$bSetupFilter = TRUE;
			} elseif ($this->cash->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_Payments_Report_cash'])) {
				$bSetupFilter = TRUE;
			}

			// Field date
			if ($this->GetFilterValues($this->date)) {
				$bSetupFilter = TRUE;
			}

			// Field capturer
			if ($this->GetFilterValues($this->capturer)) {
				$bSetupFilter = TRUE;
			}

			// Field d
			if ($this->GetFilterValues($this->d)) {
				$bSetupFilter = TRUE;
			}

			// Field location
			if ($this->GetFilterValues($this->location)) {
				$bSetupFilter = TRUE;
			}

			// Field number
			if ($this->GetFilterValues($this->number)) {
				$bSetupFilter = TRUE;
			}

			// Field area
			if ($this->GetFilterValues($this->area)) {
				$bSetupFilter = TRUE;
			}

			// Field price
			if ($this->GetDropDownValue($this->price)) {
				$bSetupFilter = TRUE;
			} elseif ($this->price->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_Payments_Report_price'])) {
				$bSetupFilter = TRUE;
			}

			// Field monthz
			if ($this->GetFilterValues($this->monthz)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->name); // Field name
			$this->GetSessionFilterValues($this->surname); // Field surname
			$this->GetSessionDropDownValue($this->cash); // Field cash
			$this->GetSessionFilterValues($this->date); // Field date
			$this->GetSessionFilterValues($this->capturer); // Field capturer
			$this->GetSessionFilterValues($this->d); // Field d
			$this->GetSessionFilterValues($this->location); // Field location
			$this->GetSessionFilterValues($this->number); // Field number
			$this->GetSessionFilterValues($this->area); // Field area
			$this->GetSessionDropDownValue($this->price); // Field price
			$this->GetSessionFilterValues($this->monthz); // Field monthz
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->name, $sFilter, FALSE, TRUE); // Field name
		$this->BuildExtendedFilter($this->surname, $sFilter, FALSE, TRUE); // Field surname
		$this->BuildDropDownFilter($this->cash, $sFilter, $this->cash->SearchOperator, FALSE, TRUE); // Field cash
		$this->BuildExtendedFilter($this->date, $sFilter, FALSE, TRUE); // Field date
		$this->BuildExtendedFilter($this->capturer, $sFilter, FALSE, TRUE); // Field capturer
		$this->BuildExtendedFilter($this->d, $sFilter, FALSE, TRUE); // Field d
		$this->BuildExtendedFilter($this->location, $sFilter, FALSE, TRUE); // Field location
		$this->BuildExtendedFilter($this->number, $sFilter, FALSE, TRUE); // Field number
		$this->BuildExtendedFilter($this->area, $sFilter, FALSE, TRUE); // Field area
		$this->BuildDropDownFilter($this->price, $sFilter, $this->price->SearchOperator, FALSE, TRUE); // Field price
		$this->BuildExtendedFilter($this->monthz, $sFilter, FALSE, TRUE); // Field monthz

		// Save parms to session
		$this->SetSessionFilterValues($this->name->SearchValue, $this->name->SearchOperator, $this->name->SearchCondition, $this->name->SearchValue2, $this->name->SearchOperator2, 'name'); // Field name
		$this->SetSessionFilterValues($this->surname->SearchValue, $this->surname->SearchOperator, $this->surname->SearchCondition, $this->surname->SearchValue2, $this->surname->SearchOperator2, 'surname'); // Field surname
		$this->SetSessionDropDownValue($this->cash->DropDownValue, $this->cash->SearchOperator, 'cash'); // Field cash
		$this->SetSessionFilterValues($this->date->SearchValue, $this->date->SearchOperator, $this->date->SearchCondition, $this->date->SearchValue2, $this->date->SearchOperator2, 'date'); // Field date
		$this->SetSessionFilterValues($this->capturer->SearchValue, $this->capturer->SearchOperator, $this->capturer->SearchCondition, $this->capturer->SearchValue2, $this->capturer->SearchOperator2, 'capturer'); // Field capturer
		$this->SetSessionFilterValues($this->d->SearchValue, $this->d->SearchOperator, $this->d->SearchCondition, $this->d->SearchValue2, $this->d->SearchOperator2, 'd'); // Field d
		$this->SetSessionFilterValues($this->location->SearchValue, $this->location->SearchOperator, $this->location->SearchCondition, $this->location->SearchValue2, $this->location->SearchOperator2, 'location'); // Field location
		$this->SetSessionFilterValues($this->number->SearchValue, $this->number->SearchOperator, $this->number->SearchCondition, $this->number->SearchValue2, $this->number->SearchOperator2, 'number'); // Field number
		$this->SetSessionFilterValues($this->area->SearchValue, $this->area->SearchOperator, $this->area->SearchCondition, $this->area->SearchValue2, $this->area->SearchOperator2, 'area'); // Field area
		$this->SetSessionDropDownValue($this->price->DropDownValue, $this->price->SearchOperator, 'price'); // Field price
		$this->SetSessionFilterValues($this->monthz->SearchValue, $this->monthz->SearchOperator, $this->monthz->SearchCondition, $this->monthz->SearchValue2, $this->monthz->SearchOperator2, 'monthz'); // Field monthz

		// Setup filter
		if ($bSetupFilter) {

			// Field name
			$sWrk = "";
			$this->BuildExtendedFilter($this->name, $sWrk);
			ewr_LoadSelectionFromFilter($this->name, $sWrk, $this->name->SelectionList);
			$_SESSION['sel_Payments_Report_name'] = ($this->name->SelectionList == "") ? EWR_INIT_VALUE : $this->name->SelectionList;

			// Field surname
			$sWrk = "";
			$this->BuildExtendedFilter($this->surname, $sWrk);
			ewr_LoadSelectionFromFilter($this->surname, $sWrk, $this->surname->SelectionList);
			$_SESSION['sel_Payments_Report_surname'] = ($this->surname->SelectionList == "") ? EWR_INIT_VALUE : $this->surname->SelectionList;

			// Field cash
			ewr_LoadSelectionList($this->cash->SelectionList, $this->cash->DropDownValue);
			$_SESSION['sel_Payments_Report_cash'] = ($this->cash->SelectionList == "") ? EWR_INIT_VALUE : $this->cash->SelectionList;

			// Field date
			$sWrk = "";
			$this->BuildExtendedFilter($this->date, $sWrk);
			ewr_LoadSelectionFromFilter($this->date, $sWrk, $this->date->SelectionList);
			$_SESSION['sel_Payments_Report_date'] = ($this->date->SelectionList == "") ? EWR_INIT_VALUE : $this->date->SelectionList;

			// Field capturer
			$sWrk = "";
			$this->BuildExtendedFilter($this->capturer, $sWrk);
			ewr_LoadSelectionFromFilter($this->capturer, $sWrk, $this->capturer->SelectionList);
			$_SESSION['sel_Payments_Report_capturer'] = ($this->capturer->SelectionList == "") ? EWR_INIT_VALUE : $this->capturer->SelectionList;

			// Field d
			$sWrk = "";
			$this->BuildExtendedFilter($this->d, $sWrk);
			ewr_LoadSelectionFromFilter($this->d, $sWrk, $this->d->SelectionList);
			$_SESSION['sel_Payments_Report_d'] = ($this->d->SelectionList == "") ? EWR_INIT_VALUE : $this->d->SelectionList;

			// Field location
			$sWrk = "";
			$this->BuildExtendedFilter($this->location, $sWrk);
			ewr_LoadSelectionFromFilter($this->location, $sWrk, $this->location->SelectionList);
			$_SESSION['sel_Payments_Report_location'] = ($this->location->SelectionList == "") ? EWR_INIT_VALUE : $this->location->SelectionList;

			// Field number
			$sWrk = "";
			$this->BuildExtendedFilter($this->number, $sWrk);
			ewr_LoadSelectionFromFilter($this->number, $sWrk, $this->number->SelectionList);
			$_SESSION['sel_Payments_Report_number'] = ($this->number->SelectionList == "") ? EWR_INIT_VALUE : $this->number->SelectionList;

			// Field area
			$sWrk = "";
			$this->BuildExtendedFilter($this->area, $sWrk);
			ewr_LoadSelectionFromFilter($this->area, $sWrk, $this->area->SelectionList);
			$_SESSION['sel_Payments_Report_area'] = ($this->area->SelectionList == "") ? EWR_INIT_VALUE : $this->area->SelectionList;

			// Field price
			$sWrk = "";
			$this->BuildDropDownFilter($this->price, $sWrk, $this->price->SearchOperator);
			ewr_LoadSelectionFromFilter($this->price, $sWrk, $this->price->SelectionList, $this->price->DropDownValue);
			$_SESSION['sel_Payments_Report_price'] = ($this->price->SelectionList == "") ? EWR_INIT_VALUE : $this->price->SelectionList;

			// Field monthz
			$sWrk = "";
			$this->BuildExtendedFilter($this->monthz, $sWrk);
			ewr_LoadSelectionFromFilter($this->monthz, $sWrk, $this->monthz->SelectionList);
			$_SESSION['sel_Payments_Report_monthz'] = ($this->monthz->SelectionList == "") ? EWR_INIT_VALUE : $this->monthz->SelectionList;
		}

		// Field cash
		ewr_LoadDropDownList($this->cash->DropDownList, $this->cash->DropDownValue);

		// Field price
		ewr_LoadDropDownList($this->price->DropDownList, $this->price->DropDownValue);
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
		$this->GetSessionValue($fld->DropDownValue, 'sv_Payments_Report_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_Payments_Report_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_Payments_Report_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_Payments_Report_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_Payments_Report_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_Payments_Report_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_Payments_Report_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_Payments_Report_' . $parm] = $sv;
		$_SESSION['so_Payments_Report_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_Payments_Report_' . $parm] = $sv1;
		$_SESSION['so_Payments_Report_' . $parm] = $so1;
		$_SESSION['sc_Payments_Report_' . $parm] = $sc;
		$_SESSION['sv2_Payments_Report_' . $parm] = $sv2;
		$_SESSION['so2_Payments_Report_' . $parm] = $so2;
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
		if (!ewr_CheckDateDef($this->date->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->date->FldErrMsg();
		}
		if (!ewr_CheckNumber($this->area->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $this->area->FldErrMsg();
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
		$_SESSION["sel_Payments_Report_$parm"] = "";
		$_SESSION["rf_Payments_Report_$parm"] = "";
		$_SESSION["rt_Payments_Report_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Payments_Report_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Payments_Report_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Payments_Report_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/

		// Field cash
		$this->cash->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->cash->DropDownValue = $this->cash->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->cash, $sWrk, $this->cash->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->cash, $sWrk, $this->cash->DefaultSelectionList);
		if (!$this->SearchCommand) $this->cash->SelectionList = $this->cash->DefaultSelectionList;

		// Field price
		$this->price->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->price->DropDownValue = $this->price->DefaultDropDownValue;
		$sWrk = "";
		$this->BuildDropDownFilter($this->price, $sWrk, $this->price->SearchOperator, TRUE);
		ewr_LoadSelectionFromFilter($this->price, $sWrk, $this->price->DefaultSelectionList);
		if (!$this->SearchCommand) $this->price->SelectionList = $this->price->DefaultSelectionList;
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

		// Field name
		$this->SetDefaultExtFilter($this->name, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->name);
		$sWrk = "";
		$this->BuildExtendedFilter($this->name, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->name, $sWrk, $this->name->DefaultSelectionList);
		if (!$this->SearchCommand) $this->name->SelectionList = $this->name->DefaultSelectionList;

		// Field surname
		$this->SetDefaultExtFilter($this->surname, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->surname);
		$sWrk = "";
		$this->BuildExtendedFilter($this->surname, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->surname, $sWrk, $this->surname->DefaultSelectionList);
		if (!$this->SearchCommand) $this->surname->SelectionList = $this->surname->DefaultSelectionList;

		// Field date
		$this->SetDefaultExtFilter($this->date, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->date);
		$sWrk = "";
		$this->BuildExtendedFilter($this->date, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->date, $sWrk, $this->date->DefaultSelectionList);
		if (!$this->SearchCommand) $this->date->SelectionList = $this->date->DefaultSelectionList;

		// Field capturer
		$this->SetDefaultExtFilter($this->capturer, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->capturer);
		$sWrk = "";
		$this->BuildExtendedFilter($this->capturer, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->capturer, $sWrk, $this->capturer->DefaultSelectionList);
		if (!$this->SearchCommand) $this->capturer->SelectionList = $this->capturer->DefaultSelectionList;

		// Field d
		$this->SetDefaultExtFilter($this->d, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->d);
		$sWrk = "";
		$this->BuildExtendedFilter($this->d, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->d, $sWrk, $this->d->DefaultSelectionList);
		if (!$this->SearchCommand) $this->d->SelectionList = $this->d->DefaultSelectionList;

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

		// Field area
		$this->SetDefaultExtFilter($this->area, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->area);
		$sWrk = "";
		$this->BuildExtendedFilter($this->area, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->area, $sWrk, $this->area->DefaultSelectionList);
		if (!$this->SearchCommand) $this->area->SelectionList = $this->area->DefaultSelectionList;

		// Field monthz
		$this->SetDefaultExtFilter($this->monthz, "USER SELECT", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->monthz);
		$sWrk = "";
		$this->BuildExtendedFilter($this->monthz, $sWrk, TRUE);
		ewr_LoadSelectionFromFilter($this->monthz, $sWrk, $this->monthz->DefaultSelectionList);
		if (!$this->SearchCommand) $this->monthz->SelectionList = $this->monthz->DefaultSelectionList;
		/**
		* Set up default values for popup filters
		*/

		// Field name
		// $this->name->DefaultSelectionList = array("val1", "val2");
		// Field surname
		// $this->surname->DefaultSelectionList = array("val1", "val2");
		// Field cash
		// $this->cash->DefaultSelectionList = array("val1", "val2");
		// Field date
		// $this->date->DefaultSelectionList = array("val1", "val2");
		// Field capturer
		// $this->capturer->DefaultSelectionList = array("val1", "val2");
		// Field d
		// $this->d->DefaultSelectionList = array("val1", "val2");
		// Field location
		// $this->location->DefaultSelectionList = array("val1", "val2");
		// Field number
		// $this->number->DefaultSelectionList = array("val1", "val2");
		// Field area
		// $this->area->DefaultSelectionList = array("val1", "val2");
		// Field price
		// $this->price->DefaultSelectionList = array("val1", "val2");
		// Field monthz
		// $this->monthz->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check name text filter
		if ($this->TextFilterApplied($this->name))
			return TRUE;

		// Check name popup filter
		if (!ewr_MatchedArray($this->name->DefaultSelectionList, $this->name->SelectionList))
			return TRUE;

		// Check surname text filter
		if ($this->TextFilterApplied($this->surname))
			return TRUE;

		// Check surname popup filter
		if (!ewr_MatchedArray($this->surname->DefaultSelectionList, $this->surname->SelectionList))
			return TRUE;

		// Check cash extended filter
		if ($this->NonTextFilterApplied($this->cash))
			return TRUE;

		// Check cash popup filter
		if (!ewr_MatchedArray($this->cash->DefaultSelectionList, $this->cash->SelectionList))
			return TRUE;

		// Check date text filter
		if ($this->TextFilterApplied($this->date))
			return TRUE;

		// Check date popup filter
		if (!ewr_MatchedArray($this->date->DefaultSelectionList, $this->date->SelectionList))
			return TRUE;

		// Check capturer text filter
		if ($this->TextFilterApplied($this->capturer))
			return TRUE;

		// Check capturer popup filter
		if (!ewr_MatchedArray($this->capturer->DefaultSelectionList, $this->capturer->SelectionList))
			return TRUE;

		// Check d text filter
		if ($this->TextFilterApplied($this->d))
			return TRUE;

		// Check d popup filter
		if (!ewr_MatchedArray($this->d->DefaultSelectionList, $this->d->SelectionList))
			return TRUE;

		// Check location text filter
		if ($this->TextFilterApplied($this->location))
			return TRUE;

		// Check location popup filter
		if (!ewr_MatchedArray($this->location->DefaultSelectionList, $this->location->SelectionList))
			return TRUE;

		// Check number text filter
		if ($this->TextFilterApplied($this->number))
			return TRUE;

		// Check number popup filter
		if (!ewr_MatchedArray($this->number->DefaultSelectionList, $this->number->SelectionList))
			return TRUE;

		// Check area text filter
		if ($this->TextFilterApplied($this->area))
			return TRUE;

		// Check area popup filter
		if (!ewr_MatchedArray($this->area->DefaultSelectionList, $this->area->SelectionList))
			return TRUE;

		// Check price extended filter
		if ($this->NonTextFilterApplied($this->price))
			return TRUE;

		// Check price popup filter
		if (!ewr_MatchedArray($this->price->DefaultSelectionList, $this->price->SelectionList))
			return TRUE;

		// Check monthz text filter
		if ($this->TextFilterApplied($this->monthz))
			return TRUE;

		// Check monthz popup filter
		if (!ewr_MatchedArray($this->monthz->DefaultSelectionList, $this->monthz->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field name
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->name, $sExtWrk);
		if (is_array($this->name->SelectionList))
			$sWrk = ewr_JoinArray($this->name->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->name->FldCaption() . "</span>" . $sFilter . "</div>";

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

		// Field cash
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->cash, $sExtWrk, $this->cash->SearchOperator);
		if (is_array($this->cash->SelectionList))
			$sWrk = ewr_JoinArray($this->cash->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->cash->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field date
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->date, $sExtWrk);
		if (is_array($this->date->SelectionList))
			$sWrk = ewr_JoinArray($this->date->SelectionList, ", ", EWR_DATATYPE_DATE, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->date->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field capturer
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->capturer, $sExtWrk);
		if (is_array($this->capturer->SelectionList))
			$sWrk = ewr_JoinArray($this->capturer->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->capturer->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field d
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->d, $sExtWrk);
		if (is_array($this->d->SelectionList))
			$sWrk = ewr_JoinArray($this->d->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->d->FldCaption() . "</span>" . $sFilter . "</div>";

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

		// Field area
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->area, $sExtWrk);
		if (is_array($this->area->SelectionList))
			$sWrk = ewr_JoinArray($this->area->SelectionList, ", ", EWR_DATATYPE_NUMBER, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->area->FldCaption() . "</span>" . $sFilter . "</div>";

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

		// Field monthz
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->monthz, $sExtWrk);
		if (is_array($this->monthz->SelectionList))
			$sWrk = ewr_JoinArray($this->monthz->SelectionList, ", ", EWR_DATATYPE_STRING, 0, $this->DBID);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->monthz->FldCaption() . "</span>" . $sFilter . "</div>";
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

		// Field name
		$sWrk = "";
		if ($this->name->SearchValue <> "" || $this->name->SearchValue2 <> "") {
			$sWrk = "\"sv_name\":\"" . ewr_JsEncode2($this->name->SearchValue) . "\"," .
				"\"so_name\":\"" . ewr_JsEncode2($this->name->SearchOperator) . "\"," .
				"\"sc_name\":\"" . ewr_JsEncode2($this->name->SearchCondition) . "\"," .
				"\"sv2_name\":\"" . ewr_JsEncode2($this->name->SearchValue2) . "\"," .
				"\"so2_name\":\"" . ewr_JsEncode2($this->name->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->name->SelectionList <> EWR_INIT_VALUE) ? $this->name->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_name\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

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

		// Field cash
		$sWrk = "";
		$sWrk = ($this->cash->DropDownValue <> EWR_INIT_VALUE) ? $this->cash->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_cash\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk == "") {
			$sWrk = ($this->cash->SelectionList <> EWR_INIT_VALUE) ? $this->cash->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_cash\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field date
		$sWrk = "";
		if ($this->date->SearchValue <> "" || $this->date->SearchValue2 <> "") {
			$sWrk = "\"sv_date\":\"" . ewr_JsEncode2($this->date->SearchValue) . "\"," .
				"\"so_date\":\"" . ewr_JsEncode2($this->date->SearchOperator) . "\"," .
				"\"sc_date\":\"" . ewr_JsEncode2($this->date->SearchCondition) . "\"," .
				"\"sv2_date\":\"" . ewr_JsEncode2($this->date->SearchValue2) . "\"," .
				"\"so2_date\":\"" . ewr_JsEncode2($this->date->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->date->SelectionList <> EWR_INIT_VALUE) ? $this->date->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_date\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field capturer
		$sWrk = "";
		if ($this->capturer->SearchValue <> "" || $this->capturer->SearchValue2 <> "") {
			$sWrk = "\"sv_capturer\":\"" . ewr_JsEncode2($this->capturer->SearchValue) . "\"," .
				"\"so_capturer\":\"" . ewr_JsEncode2($this->capturer->SearchOperator) . "\"," .
				"\"sc_capturer\":\"" . ewr_JsEncode2($this->capturer->SearchCondition) . "\"," .
				"\"sv2_capturer\":\"" . ewr_JsEncode2($this->capturer->SearchValue2) . "\"," .
				"\"so2_capturer\":\"" . ewr_JsEncode2($this->capturer->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->capturer->SelectionList <> EWR_INIT_VALUE) ? $this->capturer->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_capturer\":\"" . ewr_JsEncode2($sWrk) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field d
		$sWrk = "";
		if ($this->d->SearchValue <> "" || $this->d->SearchValue2 <> "") {
			$sWrk = "\"sv_d\":\"" . ewr_JsEncode2($this->d->SearchValue) . "\"," .
				"\"so_d\":\"" . ewr_JsEncode2($this->d->SearchOperator) . "\"," .
				"\"sc_d\":\"" . ewr_JsEncode2($this->d->SearchCondition) . "\"," .
				"\"sv2_d\":\"" . ewr_JsEncode2($this->d->SearchValue2) . "\"," .
				"\"so2_d\":\"" . ewr_JsEncode2($this->d->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->d->SelectionList <> EWR_INIT_VALUE) ? $this->d->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_d\":\"" . ewr_JsEncode2($sWrk) . "\"";
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

		// Field area
		$sWrk = "";
		if ($this->area->SearchValue <> "" || $this->area->SearchValue2 <> "") {
			$sWrk = "\"sv_area\":\"" . ewr_JsEncode2($this->area->SearchValue) . "\"," .
				"\"so_area\":\"" . ewr_JsEncode2($this->area->SearchOperator) . "\"," .
				"\"sc_area\":\"" . ewr_JsEncode2($this->area->SearchCondition) . "\"," .
				"\"sv2_area\":\"" . ewr_JsEncode2($this->area->SearchValue2) . "\"," .
				"\"so2_area\":\"" . ewr_JsEncode2($this->area->SearchOperator2) . "\"";
		}
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

		// Field monthz
		$sWrk = "";
		if ($this->monthz->SearchValue <> "" || $this->monthz->SearchValue2 <> "") {
			$sWrk = "\"sv_monthz\":\"" . ewr_JsEncode2($this->monthz->SearchValue) . "\"," .
				"\"so_monthz\":\"" . ewr_JsEncode2($this->monthz->SearchOperator) . "\"," .
				"\"sc_monthz\":\"" . ewr_JsEncode2($this->monthz->SearchCondition) . "\"," .
				"\"sv2_monthz\":\"" . ewr_JsEncode2($this->monthz->SearchValue2) . "\"," .
				"\"so2_monthz\":\"" . ewr_JsEncode2($this->monthz->SearchOperator2) . "\"";
		}
		if ($sWrk == "") {
			$sWrk = ($this->monthz->SelectionList <> EWR_INIT_VALUE) ? $this->monthz->SelectionList : "";
			if (is_array($sWrk))
				$sWrk = implode("||", $sWrk);
			if ($sWrk <> "")
				$sWrk = "\"sel_monthz\":\"" . ewr_JsEncode2($sWrk) . "\"";
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

		// Field name
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_name", $filter) || array_key_exists("so_name", $filter) ||
			array_key_exists("sc_name", $filter) ||
			array_key_exists("sv2_name", $filter) || array_key_exists("so2_name", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_name"], @$filter["so_name"], @$filter["sc_name"], @$filter["sv2_name"], @$filter["so2_name"], "name");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_name", $filter)) {
			$sWrk = $filter["sel_name"];
			$sWrk = explode("||", $sWrk);
			$this->name->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_name"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "name"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "name");
			$this->name->SelectionList = "";
			$_SESSION["sel_Payments_Report_name"] = "";
		}

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
			$_SESSION["sel_Payments_Report_surname"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "surname"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "surname");
			$this->surname->SelectionList = "";
			$_SESSION["sel_Payments_Report_surname"] = "";
		}

		// Field cash
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_cash", $filter)) {
			$sWrk = $filter["sv_cash"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_cash"], "cash");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_cash", $filter)) {
			$sWrk = $filter["sel_cash"];
			$sWrk = explode("||", $sWrk);
			$this->cash->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_cash"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "cash"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "cash");
			$this->cash->SelectionList = "";
			$_SESSION["sel_Payments_Report_cash"] = "";
		}

		// Field date
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_date", $filter) || array_key_exists("so_date", $filter) ||
			array_key_exists("sc_date", $filter) ||
			array_key_exists("sv2_date", $filter) || array_key_exists("so2_date", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_date"], @$filter["so_date"], @$filter["sc_date"], @$filter["sv2_date"], @$filter["so2_date"], "date");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_date", $filter)) {
			$sWrk = $filter["sel_date"];
			$sWrk = explode("||", $sWrk);
			$this->date->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_date"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "date"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "date");
			$this->date->SelectionList = "";
			$_SESSION["sel_Payments_Report_date"] = "";
		}

		// Field capturer
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_capturer", $filter) || array_key_exists("so_capturer", $filter) ||
			array_key_exists("sc_capturer", $filter) ||
			array_key_exists("sv2_capturer", $filter) || array_key_exists("so2_capturer", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_capturer"], @$filter["so_capturer"], @$filter["sc_capturer"], @$filter["sv2_capturer"], @$filter["so2_capturer"], "capturer");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_capturer", $filter)) {
			$sWrk = $filter["sel_capturer"];
			$sWrk = explode("||", $sWrk);
			$this->capturer->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_capturer"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "capturer"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "capturer");
			$this->capturer->SelectionList = "";
			$_SESSION["sel_Payments_Report_capturer"] = "";
		}

		// Field d
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_d", $filter) || array_key_exists("so_d", $filter) ||
			array_key_exists("sc_d", $filter) ||
			array_key_exists("sv2_d", $filter) || array_key_exists("so2_d", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_d"], @$filter["so_d"], @$filter["sc_d"], @$filter["sv2_d"], @$filter["so2_d"], "d");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_d", $filter)) {
			$sWrk = $filter["sel_d"];
			$sWrk = explode("||", $sWrk);
			$this->d->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_d"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "d"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "d");
			$this->d->SelectionList = "";
			$_SESSION["sel_Payments_Report_d"] = "";
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
			$_SESSION["sel_Payments_Report_location"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "location"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "location");
			$this->location->SelectionList = "";
			$_SESSION["sel_Payments_Report_location"] = "";
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
			$_SESSION["sel_Payments_Report_number"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "number"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "number");
			$this->number->SelectionList = "";
			$_SESSION["sel_Payments_Report_number"] = "";
		}

		// Field area
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_area", $filter) || array_key_exists("so_area", $filter) ||
			array_key_exists("sc_area", $filter) ||
			array_key_exists("sv2_area", $filter) || array_key_exists("so2_area", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_area"], @$filter["so_area"], @$filter["sc_area"], @$filter["sv2_area"], @$filter["so2_area"], "area");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_area", $filter)) {
			$sWrk = $filter["sel_area"];
			$sWrk = explode("||", $sWrk);
			$this->area->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_area"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "area"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "area");
			$this->area->SelectionList = "";
			$_SESSION["sel_Payments_Report_area"] = "";
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
			$_SESSION["sel_Payments_Report_price"] = $sWrk;
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "price"); // Clear drop down
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "price");
			$this->price->SelectionList = "";
			$_SESSION["sel_Payments_Report_price"] = "";
		}

		// Field monthz
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_monthz", $filter) || array_key_exists("so_monthz", $filter) ||
			array_key_exists("sc_monthz", $filter) ||
			array_key_exists("sv2_monthz", $filter) || array_key_exists("so2_monthz", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_monthz"], @$filter["so_monthz"], @$filter["sc_monthz"], @$filter["sv2_monthz"], @$filter["so2_monthz"], "monthz");
			$bRestoreFilter = TRUE;
		}
		if (array_key_exists("sel_monthz", $filter)) {
			$sWrk = $filter["sel_monthz"];
			$sWrk = explode("||", $sWrk);
			$this->monthz->SelectionList = $sWrk;
			$_SESSION["sel_Payments_Report_monthz"] = $sWrk;
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "monthz"); // Clear extended filter
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "monthz");
			$this->monthz->SelectionList = "";
			$_SESSION["sel_Payments_Report_monthz"] = "";
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		if (!$this->ExtendedFilterExist($this->name)) {
			if (is_array($this->name->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->name, "`name`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->name, $sFilter, "popup");
				$this->name->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->surname)) {
			if (is_array($this->surname->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->surname, "`surname`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->surname, $sFilter, "popup");
				$this->surname->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->DropDownFilterExist($this->cash, $this->cash->SearchOperator)) {
			if (is_array($this->cash->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->cash, "`cash`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->cash, $sFilter, "popup");
				$this->cash->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->date)) {
			if (is_array($this->date->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->date, "`date`", EWR_DATATYPE_DATE, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->date, $sFilter, "popup");
				$this->date->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->capturer)) {
			if (is_array($this->capturer->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->capturer, "`capturer`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->capturer, $sFilter, "popup");
				$this->capturer->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->d)) {
			if (is_array($this->d->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->d, "`d`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->d, $sFilter, "popup");
				$this->d->CurrentFilter = $sFilter;
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
		if (!$this->ExtendedFilterExist($this->number)) {
			if (is_array($this->number->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->number, "`number`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->number, $sFilter, "popup");
				$this->number->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		}
		if (!$this->ExtendedFilterExist($this->area)) {
			if (is_array($this->area->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->area, "`area`", EWR_DATATYPE_NUMBER, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->area, $sFilter, "popup");
				$this->area->CurrentFilter = $sFilter;
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
		if (!$this->ExtendedFilterExist($this->monthz)) {
			if (is_array($this->monthz->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->monthz, "`monthz`", EWR_DATATYPE_STRING, $this->DBID);

				// Call Page Filtering event
				$this->Page_Filtering($this->monthz, $sFilter, "popup");
				$this->monthz->CurrentFilter = $sFilter;
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
			$this->cash->setSort("");
			$this->date->setSort("");
			$this->capturer->setSort("");
			$this->d->setSort("");
			$this->location->setSort("");
			$this->number->setSort("");
			$this->area->setSort("");
			$this->price->setSort("");
			$this->monthz->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->name, $bCtrl); // name
			$this->UpdateSort($this->surname, $bCtrl); // surname
			$this->UpdateSort($this->cash, $bCtrl); // cash
			$this->UpdateSort($this->date, $bCtrl); // date
			$this->UpdateSort($this->capturer, $bCtrl); // capturer
			$this->UpdateSort($this->d, $bCtrl); // d
			$this->UpdateSort($this->location, $bCtrl); // location
			$this->UpdateSort($this->number, $bCtrl); // number
			$this->UpdateSort($this->area, $bCtrl); // area
			$this->UpdateSort($this->price, $bCtrl); // price
			$this->UpdateSort($this->monthz, $bCtrl); // monthz
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
if (!isset($Payments_Report_summary)) $Payments_Report_summary = new crPayments_Report_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$Payments_Report_summary;

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
var Payments_Report_summary = new ewr_Page("Payments_Report_summary");

// Page properties
Payments_Report_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = Payments_Report_summary.PageID;

// Extend page with Chart_Rendering function
Payments_Report_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
Payments_Report_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fPayments_Reportsummary = new ewr_Form("fPayments_Reportsummary");

// Validate method
fPayments_Reportsummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	var elm = fobj.sv_date;
	if (elm && !ewr_CheckDateDef(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->date->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_area;
	if (elm && !ewr_CheckNumber(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->area->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fPayments_Reportsummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fPayments_Reportsummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fPayments_Reportsummary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fPayments_Reportsummary.Lists["sv_cash"] = {"LinkField":"sv_cash","Ajax":true,"DisplayFields":["sv_cash","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fPayments_Reportsummary.Lists["sv_price"] = {"LinkField":"sv_price","Ajax":true,"DisplayFields":["sv_price","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
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
<form name="fPayments_Reportsummary" id="fPayments_Reportsummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fPayments_Reportsummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_name" class="ewCell form-group">
	<label for="sv_name" class="ewSearchCaption ewLabel"><?php echo $Page->name->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_name" id="so_name" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->name->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->name->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->name->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->name->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->name->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->name->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->name->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->name->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->name->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->name->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->name->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->name->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->name->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->name->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_name" id="sv_name" name="sv_name" size="30" maxlength="255" placeholder="<?php echo $Page->name->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->name->SearchValue) ?>"<?php echo $Page->name->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_name" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_name" style="display: none">
<?php ewr_PrependClass($Page->name->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_name" id="sv2_name" name="sv2_name" size="30" maxlength="255" placeholder="<?php echo $Page->name->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->name->SearchValue2) ?>"<?php echo $Page->name->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_surname" class="ewCell form-group">
	<label for="sv_surname" class="ewSearchCaption ewLabel"><?php echo $Page->surname->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_surname" id="so_surname" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->surname->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->surname->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->surname->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->surname->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->surname->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->surname->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->surname->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->surname->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->surname->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->surname->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->surname->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->surname->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->surname->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->surname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_surname" id="sv_surname" name="sv_surname" size="30" maxlength="255" placeholder="<?php echo $Page->surname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->surname->SearchValue) ?>"<?php echo $Page->surname->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_surname" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_surname" style="display: none">
<?php ewr_PrependClass($Page->surname->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_surname" id="sv2_surname" name="sv2_surname" size="30" maxlength="255" placeholder="<?php echo $Page->surname->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->surname->SearchValue2) ?>"<?php echo $Page->surname->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_3" class="ewRow">
<div id="c_cash" class="ewCell form-group">
	<label for="sv_cash" class="ewSearchCaption ewLabel"><?php echo $Page->cash->FldCaption() ?></label>
	<span class="ewSearchField">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_sv_cash"><?php echo (strval(ewr_FilterDropDownValue($Page->cash)) == "" ? $ReportLanguage->Phrase("PleaseSelect") : ewr_FilterDropDownValue($Page->cash)); ?></span>
</span>
<button type="button" title="<?php echo ewr_HtmlEncode(str_replace("%s", ewr_RemoveHtml($Page->cash->FldCaption()), $ReportLanguage->Phrase("LookupLink", TRUE))) ?>" onclick="ewr_ModalLookupShow({lnk:this,el:'sv_cash',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="Payments_Report" data-field="x_cash" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $Page->cash->DisplayValueSeparatorAttribute() ?>" name="sv_cash" id="sv_cash" value="<?php echo ewr_FilterDropDownValue($Page->cash) ?>"<?php echo $Page->cash->EditAttributes() ?>>
<input type="hidden" name="s_sv_cash" id="s_sv_cash" value="<?php echo $Page->cash->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_4" class="ewRow">
<div id="c_date" class="ewCell form-group">
	<label for="sv_date" class="ewSearchCaption ewLabel"><?php echo $Page->date->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_date" id="so_date" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->date->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->date->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->date->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->date->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->date->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->date->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="IS NULL"<?php if ($Page->date->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->date->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->date->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->date->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_date" id="sv_date" name="sv_date" placeholder="<?php echo $Page->date->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->date->SearchValue) ?>"<?php echo $Page->date->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_date" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_date" style="display: none">
<?php ewr_PrependClass($Page->date->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_date" id="sv2_date" name="sv2_date" placeholder="<?php echo $Page->date->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->date->SearchValue2) ?>"<?php echo $Page->date->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_5" class="ewRow">
<div id="c_capturer" class="ewCell form-group">
	<label for="sv_capturer" class="ewSearchCaption ewLabel"><?php echo $Page->capturer->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_capturer" id="so_capturer" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->capturer->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->capturer->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->capturer->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->capturer->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->capturer->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->capturer->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->capturer->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->capturer->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->capturer->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->capturer->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->capturer->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->capturer->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->capturer->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->capturer->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_capturer" id="sv_capturer" name="sv_capturer" size="30" maxlength="255" placeholder="<?php echo $Page->capturer->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->capturer->SearchValue) ?>"<?php echo $Page->capturer->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_capturer" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_capturer" style="display: none">
<?php ewr_PrependClass($Page->capturer->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_capturer" id="sv2_capturer" name="sv2_capturer" size="30" maxlength="255" placeholder="<?php echo $Page->capturer->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->capturer->SearchValue2) ?>"<?php echo $Page->capturer->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_6" class="ewRow">
<div id="c_d" class="ewCell form-group">
	<label for="sv_d" class="ewSearchCaption ewLabel"><?php echo $Page->d->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_d" id="so_d" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->d->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->d->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->d->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->d->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->d->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->d->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->d->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->d->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->d->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->d->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->d->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->d->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->d->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->d->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_d" id="sv_d" name="sv_d" size="30" maxlength="111" placeholder="<?php echo $Page->d->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->d->SearchValue) ?>"<?php echo $Page->d->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_d" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_d" style="display: none">
<?php ewr_PrependClass($Page->d->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_d" id="sv2_d" name="sv2_d" size="30" maxlength="111" placeholder="<?php echo $Page->d->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->d->SearchValue2) ?>"<?php echo $Page->d->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_7" class="ewRow">
<div id="c_location" class="ewCell form-group">
	<label for="sv_location" class="ewSearchCaption ewLabel"><?php echo $Page->location->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_location" id="so_location" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->location->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->location->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->location->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->location->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->location->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->location->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->location->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->location->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->location->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->location->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->location->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->location->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->location->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->location->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_location" id="sv_location" name="sv_location" size="30" maxlength="111" placeholder="<?php echo $Page->location->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->location->SearchValue) ?>"<?php echo $Page->location->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_location" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_location" style="display: none">
<?php ewr_PrependClass($Page->location->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_location" id="sv2_location" name="sv2_location" size="30" maxlength="111" placeholder="<?php echo $Page->location->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->location->SearchValue2) ?>"<?php echo $Page->location->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_8" class="ewRow">
<div id="c_number" class="ewCell form-group">
	<label for="sv_number" class="ewSearchCaption ewLabel"><?php echo $Page->number->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_number" id="so_number" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->number->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->number->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->number->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->number->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->number->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->number->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->number->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->number->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->number->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->number->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->number->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->number->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->number->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_number" id="sv_number" name="sv_number" size="30" maxlength="111" placeholder="<?php echo $Page->number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->number->SearchValue) ?>"<?php echo $Page->number->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_number" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_number" style="display: none">
<?php ewr_PrependClass($Page->number->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_number" id="sv2_number" name="sv2_number" size="30" maxlength="111" placeholder="<?php echo $Page->number->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->number->SearchValue2) ?>"<?php echo $Page->number->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_9" class="ewRow">
<div id="c_area" class="ewCell form-group">
	<label for="sv_area" class="ewSearchCaption ewLabel"><?php echo $Page->area->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_area" id="so_area" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->area->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->area->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->area->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->area->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->area->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->area->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="IS NULL"<?php if ($Page->area->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->area->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->area->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->area->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_area" id="sv_area" name="sv_area" size="30" placeholder="<?php echo $Page->area->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->area->SearchValue) ?>"<?php echo $Page->area->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_area" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_area" style="display: none">
<?php ewr_PrependClass($Page->area->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_area" id="sv2_area" name="sv2_area" size="30" placeholder="<?php echo $Page->area->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->area->SearchValue2) ?>"<?php echo $Page->area->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_10" class="ewRow">
<div id="c_price" class="ewCell form-group">
	<label for="sv_price" class="ewSearchCaption ewLabel"><?php echo $Page->price->FldCaption() ?></label>
	<span class="ewSearchField">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_sv_price"><?php echo (strval(ewr_FilterDropDownValue($Page->price)) == "" ? $ReportLanguage->Phrase("PleaseSelect") : ewr_FilterDropDownValue($Page->price)); ?></span>
</span>
<button type="button" title="<?php echo ewr_HtmlEncode(str_replace("%s", ewr_RemoveHtml($Page->price->FldCaption()), $ReportLanguage->Phrase("LookupLink", TRUE))) ?>" onclick="ewr_ModalLookupShow({lnk:this,el:'sv_price',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="Payments_Report" data-field="x_price" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $Page->price->DisplayValueSeparatorAttribute() ?>" name="sv_price" id="sv_price" value="<?php echo ewr_FilterDropDownValue($Page->price) ?>"<?php echo $Page->price->EditAttributes() ?>>
<input type="hidden" name="s_sv_price" id="s_sv_price" value="<?php echo $Page->price->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_11" class="ewRow">
<div id="c_monthz" class="ewCell form-group">
	<label for="sv_monthz" class="ewSearchCaption ewLabel"><?php echo $Page->monthz->FldCaption() ?></label>
	<span class="ewSearchOperator"><select name="so_monthz" id="so_monthz" class="form-control" onchange="ewrForms(this).SrchOprChanged(this);"><option value="="<?php if ($Page->monthz->SearchOperator == "=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("EQUAL"); ?></option><option value="<>"<?php if ($Page->monthz->SearchOperator == "<>") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<>"); ?></option><option value="<"<?php if ($Page->monthz->SearchOperator == "<") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<"); ?></option><option value="<="<?php if ($Page->monthz->SearchOperator == "<=") echo " selected" ?>><?php echo $ReportLanguage->Phrase("<="); ?></option><option value=">"<?php if ($Page->monthz->SearchOperator == ">") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">"); ?></option><option value=">="<?php if ($Page->monthz->SearchOperator == ">=") echo " selected" ?>><?php echo $ReportLanguage->Phrase(">="); ?></option><option value="LIKE"<?php if ($Page->monthz->SearchOperator == "LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("LIKE"); ?></option><option value="NOT LIKE"<?php if ($Page->monthz->SearchOperator == "NOT LIKE") echo " selected" ?>><?php echo $ReportLanguage->Phrase("NOT LIKE"); ?></option><option value="STARTS WITH"<?php if ($Page->monthz->SearchOperator == "STARTS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("STARTS WITH"); ?></option><option value="ENDS WITH"<?php if ($Page->monthz->SearchOperator == "ENDS WITH") echo " selected" ?>><?php echo $ReportLanguage->Phrase("ENDS WITH"); ?></option><option value="IS NULL"<?php if ($Page->monthz->SearchOperator == "IS NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NULL"); ?></option><option value="IS NOT NULL"<?php if ($Page->monthz->SearchOperator == "IS NOT NULL") echo " selected" ?>><?php echo $ReportLanguage->Phrase("IS NOT NULL"); ?></option><option value="BETWEEN"<?php if ($Page->monthz->SearchOperator == "BETWEEN") echo " selected" ?>><?php echo $ReportLanguage->Phrase("BETWEEN"); ?></option></select></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->monthz->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_monthz" id="sv_monthz" name="sv_monthz" size="30" maxlength="14" placeholder="<?php echo $Page->monthz->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->monthz->SearchValue) ?>"<?php echo $Page->monthz->EditAttributes() ?>>
</span>
	<span class="ewSearchCond btw1_monthz" style="display: none"><?php echo $ReportLanguage->Phrase("AND") ?></span>
	<span class="ewSearchField btw1_monthz" style="display: none">
<?php ewr_PrependClass($Page->monthz->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="Payments_Report" data-field="x_monthz" id="sv2_monthz" name="sv2_monthz" size="30" maxlength="14" placeholder="<?php echo $Page->monthz->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->monthz->SearchValue2) ?>"<?php echo $Page->monthz->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fPayments_Reportsummary.Init();
fPayments_Reportsummary.FilterList = <?php echo $Page->GetFilterList() ?>;
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
<?php include "Payments_Reportsmrypager.php" ?>
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
	<td data-field="name"><div class="Payments_Report_name"><span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="name">
<?php if ($Page->SortUrl($Page->name) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_name">
			<span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_name', false, '<?php echo $Page->name->RangeFrom; ?>', '<?php echo $Page->name->RangeTo; ?>');" id="x_name<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_name" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->name) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->name->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_name', false, '<?php echo $Page->name->RangeFrom; ?>', '<?php echo $Page->name->RangeTo; ?>');" id="x_name<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="surname"><div class="Payments_Report_surname"><span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="surname">
<?php if ($Page->SortUrl($Page->surname) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_surname">
			<span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_surname', false, '<?php echo $Page->surname->RangeFrom; ?>', '<?php echo $Page->surname->RangeTo; ?>');" id="x_surname<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_surname" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->surname) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->surname->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->surname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->surname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_surname', false, '<?php echo $Page->surname->RangeFrom; ?>', '<?php echo $Page->surname->RangeTo; ?>');" id="x_surname<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="cash"><div class="Payments_Report_cash"><span class="ewTableHeaderCaption"><?php echo $Page->cash->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="cash">
<?php if ($Page->SortUrl($Page->cash) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_cash">
			<span class="ewTableHeaderCaption"><?php echo $Page->cash->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_cash', true, '<?php echo $Page->cash->RangeFrom; ?>', '<?php echo $Page->cash->RangeTo; ?>');" id="x_cash<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_cash" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->cash) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->cash->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->cash->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->cash->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_cash', true, '<?php echo $Page->cash->RangeFrom; ?>', '<?php echo $Page->cash->RangeTo; ?>');" id="x_cash<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="date"><div class="Payments_Report_date"><span class="ewTableHeaderCaption"><?php echo $Page->date->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="date">
<?php if ($Page->SortUrl($Page->date) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_date">
			<span class="ewTableHeaderCaption"><?php echo $Page->date->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_date', false, '<?php echo $Page->date->RangeFrom; ?>', '<?php echo $Page->date->RangeTo; ?>');" id="x_date<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_date" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->date) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->date->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_date', false, '<?php echo $Page->date->RangeFrom; ?>', '<?php echo $Page->date->RangeTo; ?>');" id="x_date<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="capturer"><div class="Payments_Report_capturer"><span class="ewTableHeaderCaption"><?php echo $Page->capturer->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="capturer">
<?php if ($Page->SortUrl($Page->capturer) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_capturer">
			<span class="ewTableHeaderCaption"><?php echo $Page->capturer->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_capturer', false, '<?php echo $Page->capturer->RangeFrom; ?>', '<?php echo $Page->capturer->RangeTo; ?>');" id="x_capturer<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_capturer" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->capturer) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->capturer->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->capturer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->capturer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_capturer', false, '<?php echo $Page->capturer->RangeFrom; ?>', '<?php echo $Page->capturer->RangeTo; ?>');" id="x_capturer<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="d"><div class="Payments_Report_d"><span class="ewTableHeaderCaption"><?php echo $Page->d->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="d">
<?php if ($Page->SortUrl($Page->d) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_d">
			<span class="ewTableHeaderCaption"><?php echo $Page->d->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_d', false, '<?php echo $Page->d->RangeFrom; ?>', '<?php echo $Page->d->RangeTo; ?>');" id="x_d<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_d" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->d) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->d->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->d->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->d->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_d', false, '<?php echo $Page->d->RangeFrom; ?>', '<?php echo $Page->d->RangeTo; ?>');" id="x_d<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="location"><div class="Payments_Report_location"><span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="location">
<?php if ($Page->SortUrl($Page->location) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_location">
			<span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_location', false, '<?php echo $Page->location->RangeFrom; ?>', '<?php echo $Page->location->RangeTo; ?>');" id="x_location<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_location" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->location) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->location->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_location', false, '<?php echo $Page->location->RangeFrom; ?>', '<?php echo $Page->location->RangeTo; ?>');" id="x_location<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="number"><div class="Payments_Report_number"><span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="number">
<?php if ($Page->SortUrl($Page->number) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_number">
			<span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_number', false, '<?php echo $Page->number->RangeFrom; ?>', '<?php echo $Page->number->RangeTo; ?>');" id="x_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_number" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->number) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->number->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_number', false, '<?php echo $Page->number->RangeFrom; ?>', '<?php echo $Page->number->RangeTo; ?>');" id="x_number<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="area"><div class="Payments_Report_area"><span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="area">
<?php if ($Page->SortUrl($Page->area) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_area">
			<span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_area', false, '<?php echo $Page->area->RangeFrom; ?>', '<?php echo $Page->area->RangeTo; ?>');" id="x_area<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_area" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->area) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->area->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->area->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->area->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_area', false, '<?php echo $Page->area->RangeFrom; ?>', '<?php echo $Page->area->RangeTo; ?>');" id="x_area<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="price"><div class="Payments_Report_price"><span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="price">
<?php if ($Page->SortUrl($Page->price) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_price">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_price', true, '<?php echo $Page->price->RangeFrom; ?>', '<?php echo $Page->price->RangeTo; ?>');" id="x_price<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_price" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->price) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->price->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_price', true, '<?php echo $Page->price->RangeFrom; ?>', '<?php echo $Page->price->RangeTo; ?>');" id="x_price<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="monthz"><div class="Payments_Report_monthz"><span class="ewTableHeaderCaption"><?php echo $Page->monthz->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="monthz">
<?php if ($Page->SortUrl($Page->monthz) == "") { ?>
		<div class="ewTableHeaderBtn Payments_Report_monthz">
			<span class="ewTableHeaderCaption"><?php echo $Page->monthz->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_monthz', false, '<?php echo $Page->monthz->RangeFrom; ?>', '<?php echo $Page->monthz->RangeTo; ?>');" id="x_monthz<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Payments_Report_monthz" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->monthz) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->monthz->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->monthz->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->monthz->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" title="<?php echo $ReportLanguage->Phrase("Filter"); ?>" onclick="ewr_ShowPopup.call(this, event, 'Payments_Report_monthz', false, '<?php echo $Page->monthz->RangeFrom; ?>', '<?php echo $Page->monthz->RangeTo; ?>');" id="x_monthz<?php echo $Page->Cnt[0][0]; ?>"><span class="icon-filter"></span></a>
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
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_name"<?php echo $Page->name->ViewAttributes() ?>><?php echo $Page->name->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_surname"<?php echo $Page->surname->ViewAttributes() ?>><?php echo $Page->surname->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_date"<?php echo $Page->date->ViewAttributes() ?>><?php echo $Page->date->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_capturer"<?php echo $Page->capturer->ViewAttributes() ?>><?php echo $Page->capturer->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_d"<?php echo $Page->d->ViewAttributes() ?>><?php echo $Page->d->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_location"<?php echo $Page->location->ViewAttributes() ?>><?php echo $Page->location->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_number"<?php echo $Page->number->ViewAttributes() ?>><?php echo $Page->number->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->RecCount ?>_Payments_Report_monthz"<?php echo $Page->monthz->ViewAttributes() ?>><?php echo $Page->monthz->ListViewValue() ?></span></td>
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
	$Page->cash->Count = $Page->GrandCnt[3];
	$Page->cash->SumValue = $Page->GrandSmry[3]; // Load SUM
	$Page->area->Count = $Page->GrandCnt[9];
	$Page->area->SumValue = $Page->GrandSmry[9]; // Load SUM
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->SumValue = $Page->GrandSmry[10]; // Load SUM
	$Page->cash->Count = $Page->GrandCnt[3];
	$Page->cash->AvgValue = ($Page->cash->Count > 0) ? $Page->GrandSmry[3]/$Page->cash->Count : 0; // Load AVG
	$Page->area->Count = $Page->GrandCnt[9];
	$Page->area->AvgValue = ($Page->area->Count > 0) ? $Page->GrandSmry[9]/$Page->area->Count : 0; // Load AVG
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->AvgValue = ($Page->price->Count > 0) ? $Page->GrandSmry[10]/$Page->price->Count : 0; // Load AVG
	$Page->cash->Count = $Page->GrandCnt[3];
	$Page->cash->MinValue = $Page->GrandMn[3]; // Load MIN
	$Page->area->Count = $Page->GrandCnt[9];
	$Page->area->MinValue = $Page->GrandMn[9]; // Load MIN
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->MinValue = $Page->GrandMn[10]; // Load MIN
	$Page->cash->Count = $Page->GrandCnt[3];
	$Page->cash->MaxValue = $Page->GrandMx[3]; // Load MAX
	$Page->area->Count = $Page->GrandCnt[9];
	$Page->area->MaxValue = $Page->GrandMx[9]; // Load MAX
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->MaxValue = $Page->GrandMx[10]; // Load MAX
	$Page->cash->Count = $Page->GrandCnt[3];
	$Page->cash->CntValue = $Page->GrandCnt[3]; // Load CNT
	$Page->area->Count = $Page->GrandCnt[9];
	$Page->area->CntValue = $Page->GrandCnt[9]; // Load CNT
	$Page->price->Count = $Page->GrandCnt[10];
	$Page->price->CntValue = $Page->GrandCnt[10]; // Load CNT
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
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpts_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptAvg") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tpta_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->AvgViewValue ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMin") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptn_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->MinViewValue ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptMax") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptx_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->MaxViewValue ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->name->Visible) { ?>
		<td data-field="name"<?php echo $Page->name->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->surname->Visible) { ?>
		<td data-field="surname"<?php echo $Page->surname->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->cash->Visible) { ?>
		<td data-field="cash"<?php echo $Page->cash->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_Payments_Report_cash"<?php echo $Page->cash->ViewAttributes() ?>><?php echo $Page->cash->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
		<td data-field="date"<?php echo $Page->date->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->capturer->Visible) { ?>
		<td data-field="capturer"<?php echo $Page->capturer->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->d->Visible) { ?>
		<td data-field="d"<?php echo $Page->d->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->location->Visible) { ?>
		<td data-field="location"<?php echo $Page->location->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->number->Visible) { ?>
		<td data-field="number"<?php echo $Page->number->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->area->Visible) { ?>
		<td data-field="area"<?php echo $Page->area->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_Payments_Report_area"<?php echo $Page->area->ViewAttributes() ?>><?php echo $Page->area->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->price->Visible) { ?>
		<td data-field="price"<?php echo $Page->price->CellAttributes() ?>><span class="ewAggregate"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateColon") ?>
<span data-class="tptc_Payments_Report_price"<?php echo $Page->price->ViewAttributes() ?>><?php echo $Page->price->CntViewValue ?></span></td>
<?php } ?>
<?php if ($Page->monthz->Visible) { ?>
		<td data-field="monthz"<?php echo $Page->monthz->CellAttributes() ?>>&nbsp;</td>
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
<?php include "Payments_Reportsmrypager.php" ?>
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
<?php include "Payments_Reportsmrypager.php" ?>
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
<a id="cht_Payments_Report_PaymentsBar"></a>
<div class="">
<div id="div_ctl_Payments_Report_PaymentsBar" class="ewChart">
<div id="div_Payments_Report_PaymentsBar" class="ewChartDiv"></div>
<!-- grid component -->
<div id="div_Payments_Report_PaymentsBar_grid" class="ewChartGrid"></div>
</div>
</div>
<?php

// Set up chart object
$Chart = &$Table->PaymentsBar;

// Set up chart SQL
$SqlSelect = $Table->getSqlSelect();
$SqlChartSelect = $Chart->SqlSelect;
$sSqlChartBase = $Table->getSqlFrom();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sChartFilter = $Chart->SqlWhere;
ewr_AddFilter($sChartFilter, $Table->getSqlWhere());
$sSql = ewr_BuildReportSql($sSql, $sChartFilter, $Chart->SqlGroupBy, "", $Chart->SqlOrderBy, $Page->Filter, "");
$Chart->ChartSql = $sSql;
$Chart->DrillDownInPanel = $Page->DrillDownInPanel;

// Set up page break
if (($Page->Export == "print" || $Page->Export == "pdf" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD")) && $Page->ExportChartPageBreak) {

	// Page_Breaking server event
	$Page->Page_Breaking($Page->ExportChartPageBreak, $Page->PageBreakContent);
	$Chart->PageBreakType = "before";
	$Chart->PageBreak = $Table->ExportChartPageBreak;
	$Chart->PageBreakContent = $Table->PageBreakContent;
}

// Set up show temp image
$Chart->ShowChart = ($Page->Export == "" || ($Page->Export == "print" && $Page->CustomExport == "") || ($Page->Export == "email" && @$_POST["contenttype"] == "url"));
$Chart->ShowTempImage = ($Page->Export == "pdf" || $Page->CustomExport <> "" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD"));
?>
<?php include_once "Payments_Report_PaymentsBarchart.php" ?>
<?php if ($Page->Export <> "email" && !$Page->DrillDown) { ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<a href="javascript:void(0);" class="ewTopLink" onclick="$(document).scrollTop($('#top').offset().top);"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<?php } ?>
<?php } ?>
<a id="cht_Payments_Report_PaymentsPie"></a>
<div class="">
<div id="div_ctl_Payments_Report_PaymentsPie" class="ewChart">
<div id="div_Payments_Report_PaymentsPie" class="ewChartDiv"></div>
<!-- grid component -->
<div id="div_Payments_Report_PaymentsPie_grid" class="ewChartGrid"></div>
</div>
</div>
<?php

// Set up chart object
$Chart = &$Table->PaymentsPie;

// Set up chart SQL
$SqlSelect = $Table->getSqlSelect();
$SqlChartSelect = $Chart->SqlSelect;
$sSqlChartBase = $Table->getSqlFrom();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sChartFilter = $Chart->SqlWhere;
ewr_AddFilter($sChartFilter, $Table->getSqlWhere());
$sSql = ewr_BuildReportSql($sSql, $sChartFilter, $Chart->SqlGroupBy, "", $Chart->SqlOrderBy, $Page->Filter, "");
$Chart->ChartSql = $sSql;
$Chart->DrillDownInPanel = $Page->DrillDownInPanel;

// Set up page break
if (($Page->Export == "print" || $Page->Export == "pdf" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD")) && $Page->ExportChartPageBreak) {

	// Page_Breaking server event
	$Page->Page_Breaking($Page->ExportChartPageBreak, $Page->PageBreakContent);
	$Chart->PageBreakType = "before";
	$Chart->PageBreak = $Table->ExportChartPageBreak;
	$Chart->PageBreakContent = $Table->PageBreakContent;
}

// Set up show temp image
$Chart->ShowChart = ($Page->Export == "" || ($Page->Export == "print" && $Page->CustomExport == "") || ($Page->Export == "email" && @$_POST["contenttype"] == "url"));
$Chart->ShowTempImage = ($Page->Export == "pdf" || $Page->CustomExport <> "" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD"));
?>
<?php include_once "Payments_Report_PaymentsPiechart.php" ?>
<?php if ($Page->Export <> "email" && !$Page->DrillDown) { ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<a href="javascript:void(0);" class="ewTopLink" onclick="$(document).scrollTop($('#top').offset().top);"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<?php } ?>
<?php } ?>
<a id="cht_Payments_Report_Line_Chart"></a>
<div class="">
<div id="div_ctl_Payments_Report_Line_Chart" class="ewChart">
<div id="div_Payments_Report_Line_Chart" class="ewChartDiv"></div>
<!-- grid component -->
<div id="div_Payments_Report_Line_Chart_grid" class="ewChartGrid"></div>
</div>
</div>
<?php

// Set up chart object
$Chart = &$Table->Line_Chart;

// Set up chart SQL
$SqlSelect = $Table->getSqlSelect();
$SqlChartSelect = $Chart->SqlSelect;
$sSqlChartBase = $Table->getSqlFrom();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sChartFilter = $Chart->SqlWhere;
ewr_AddFilter($sChartFilter, $Table->getSqlWhere());
$sSql = ewr_BuildReportSql($sSql, $sChartFilter, $Chart->SqlGroupBy, "", $Chart->SqlOrderBy, $Page->Filter, "");
$Chart->ChartSql = $sSql;
$Chart->DrillDownInPanel = $Page->DrillDownInPanel;

// Set up page break
if (($Page->Export == "print" || $Page->Export == "pdf" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD")) && $Page->ExportChartPageBreak) {

	// Page_Breaking server event
	$Page->Page_Breaking($Page->ExportChartPageBreak, $Page->PageBreakContent);
	$Chart->PageBreakType = "before";
	$Chart->PageBreak = $Table->ExportChartPageBreak;
	$Chart->PageBreakContent = $Table->PageBreakContent;
}

// Set up show temp image
$Chart->ShowChart = ($Page->Export == "" || ($Page->Export == "print" && $Page->CustomExport == "") || ($Page->Export == "email" && @$_POST["contenttype"] == "url"));
$Chart->ShowTempImage = ($Page->Export == "pdf" || $Page->CustomExport <> "" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD"));
?>
<?php include_once "Payments_Report_Line_Chartchart.php" ?>
<?php if ($Page->Export <> "email" && !$Page->DrillDown) { ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<a href="javascript:void(0);" class="ewTopLink" onclick="$(document).scrollTop($('#top').offset().top);"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<?php } ?>
<?php } ?>
<a id="cht_Payments_Report_Area_Chart"></a>
<div class="">
<div id="div_ctl_Payments_Report_Area_Chart" class="ewChart">
<div id="div_Payments_Report_Area_Chart" class="ewChartDiv"></div>
<!-- grid component -->
<div id="div_Payments_Report_Area_Chart_grid" class="ewChartGrid"></div>
</div>
</div>
<?php

// Set up chart object
$Chart = &$Table->Area_Chart;

// Set up chart SQL
$SqlSelect = $Table->getSqlSelect();
$SqlChartSelect = $Chart->SqlSelect;
$sSqlChartBase = $Table->getSqlFrom();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sChartFilter = $Chart->SqlWhere;
ewr_AddFilter($sChartFilter, $Table->getSqlWhere());
$sSql = ewr_BuildReportSql($sSql, $sChartFilter, $Chart->SqlGroupBy, "", $Chart->SqlOrderBy, $Page->Filter, "");
$Chart->ChartSql = $sSql;
$Chart->DrillDownInPanel = $Page->DrillDownInPanel;

// Set up page break
if (($Page->Export == "print" || $Page->Export == "pdf" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD")) && $Page->ExportChartPageBreak) {

	// Page_Breaking server event
	$Page->Page_Breaking($Page->ExportChartPageBreak, $Page->PageBreakContent);
	$Chart->PageBreakType = "before";
	$Chart->PageBreak = $Table->ExportChartPageBreak;
	$Chart->PageBreakContent = $Table->PageBreakContent;
}

// Set up show temp image
$Chart->ShowChart = ($Page->Export == "" || ($Page->Export == "print" && $Page->CustomExport == "") || ($Page->Export == "email" && @$_POST["contenttype"] == "url"));
$Chart->ShowTempImage = ($Page->Export == "pdf" || $Page->CustomExport <> "" || $Page->Export == "email" || $Page->Export == "excel" && defined("EWR_USE_PHPEXCEL") || $Page->Export == "word" && defined("EWR_USE_PHPWORD"));
?>
<?php include_once "Payments_Report_Area_Chartchart.php" ?>
<?php if ($Page->Export <> "email" && !$Page->DrillDown) { ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<a href="javascript:void(0);" class="ewTopLink" onclick="$(document).scrollTop($('#top').offset().top);"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<?php } ?>
<?php } ?>
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
