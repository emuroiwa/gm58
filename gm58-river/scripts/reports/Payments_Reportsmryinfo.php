<?php

// Global variable for table object
$Payments_Report = NULL;

//
// Table class for Payments Report
//
class crPayments_Report extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $PaymentsBar;
	var $PaymentsPie;
	var $Line_Chart;
	var $Area_Chart;
	var $id;
	var $name;
	var $surname;
	var $cash;
	var $date;
	var $capturer;
	var $d;
	var $location;
	var $number;
	var $area;
	var $price;
	var $paidmonths;
	var $monthz;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'Payments_Report';
		$this->TableName = 'Payments Report';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// id
		$this->id = new crField('Payments_Report', 'Payments Report', 'x_id', 'id', '`id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;
		$this->id->DateFilter = "";
		$this->id->SqlSelect = "SELECT DISTINCT `id`, `id` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->id->SqlOrderBy = "`id`";

		// name
		$this->name = new crField('Payments_Report', 'Payments Report', 'x_name', 'name', '`name`', 200, EWR_DATATYPE_STRING, -1);
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;
		$this->name->DateFilter = "";
		$this->name->SqlSelect = "SELECT DISTINCT `name`, `name` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->name->SqlOrderBy = "`name`";

		// surname
		$this->surname = new crField('Payments_Report', 'Payments Report', 'x_surname', 'surname', '`surname`', 200, EWR_DATATYPE_STRING, -1);
		$this->surname->Sortable = TRUE; // Allow sort
		$this->fields['surname'] = &$this->surname;
		$this->surname->DateFilter = "";
		$this->surname->SqlSelect = "SELECT DISTINCT `surname`, `surname` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->surname->SqlOrderBy = "`surname`";

		// cash
		$this->cash = new crField('Payments_Report', 'Payments Report', 'x_cash', 'cash', '`cash`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->cash->Sortable = TRUE; // Allow sort
		$this->cash->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['cash'] = &$this->cash;
		$this->cash->DateFilter = "";
		$this->cash->SqlSelect = "SELECT DISTINCT `cash`, `cash` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->cash->SqlOrderBy = "`cash`";
		$this->cash->FldDelimiter = $GLOBALS["EWR_CSV_DELIMITER"];

		// date
		$this->date = new crField('Payments_Report', 'Payments Report', 'x_date', 'date', '`date`', 135, EWR_DATATYPE_DATE, 0);
		$this->date->Sortable = TRUE; // Allow sort
		$this->date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->fields['date'] = &$this->date;
		$this->date->DateFilter = "";
		$this->date->SqlSelect = "SELECT DISTINCT `date`, `date` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->date->SqlOrderBy = "`date`";

		// capturer
		$this->capturer = new crField('Payments_Report', 'Payments Report', 'x_capturer', 'capturer', '`capturer`', 200, EWR_DATATYPE_STRING, -1);
		$this->capturer->Sortable = TRUE; // Allow sort
		$this->fields['capturer'] = &$this->capturer;
		$this->capturer->DateFilter = "";
		$this->capturer->SqlSelect = "SELECT DISTINCT `capturer`, `capturer` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->capturer->SqlOrderBy = "`capturer`";

		// d
		$this->d = new crField('Payments_Report', 'Payments Report', 'x_d', 'd', '`d`', 200, EWR_DATATYPE_STRING, -1);
		$this->d->Sortable = TRUE; // Allow sort
		$this->fields['d'] = &$this->d;
		$this->d->DateFilter = "";
		$this->d->SqlSelect = "SELECT DISTINCT `d`, `d` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->d->SqlOrderBy = "`d`";

		// location
		$this->location = new crField('Payments_Report', 'Payments Report', 'x_location', 'location', '`location`', 200, EWR_DATATYPE_STRING, -1);
		$this->location->Sortable = TRUE; // Allow sort
		$this->fields['location'] = &$this->location;
		$this->location->DateFilter = "";
		$this->location->SqlSelect = "SELECT DISTINCT `location`, `location` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->location->SqlOrderBy = "`location`";

		// number
		$this->number = new crField('Payments_Report', 'Payments Report', 'x_number', 'number', '`number`', 200, EWR_DATATYPE_STRING, -1);
		$this->number->Sortable = TRUE; // Allow sort
		$this->fields['number'] = &$this->number;
		$this->number->DateFilter = "";
		$this->number->SqlSelect = "SELECT DISTINCT `number`, `number` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->number->SqlOrderBy = "`number`";

		// area
		$this->area = new crField('Payments_Report', 'Payments Report', 'x_area', 'area', '`area`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->area->Sortable = TRUE; // Allow sort
		$this->area->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['area'] = &$this->area;
		$this->area->DateFilter = "";
		$this->area->SqlSelect = "SELECT DISTINCT `area`, `area` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->area->SqlOrderBy = "`area`";
		$this->area->FldDelimiter = $GLOBALS["EWR_CSV_DELIMITER"];

		// price
		$this->price = new crField('Payments_Report', 'Payments Report', 'x_price', 'price', '`price`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->price->Sortable = TRUE; // Allow sort
		$this->price->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['price'] = &$this->price;
		$this->price->DateFilter = "";
		$this->price->SqlSelect = "SELECT DISTINCT `price`, `price` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->price->SqlOrderBy = "`price`";

		// paidmonths
		$this->paidmonths = new crField('Payments_Report', 'Payments Report', 'x_paidmonths', 'paidmonths', '`paidmonths`', 5, EWR_DATATYPE_NUMBER, -1);
		$this->paidmonths->Sortable = TRUE; // Allow sort
		$this->paidmonths->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['paidmonths'] = &$this->paidmonths;
		$this->paidmonths->DateFilter = "";
		$this->paidmonths->SqlSelect = "";
		$this->paidmonths->SqlOrderBy = "";

		// monthz
		$this->monthz = new crField('Payments_Report', 'Payments Report', 'x_monthz', 'monthz', '`monthz`', 200, EWR_DATATYPE_STRING, -1);
		$this->monthz->Sortable = TRUE; // Allow sort
		$this->fields['monthz'] = &$this->monthz;
		$this->monthz->DateFilter = "";
		$this->monthz->SqlSelect = "SELECT DISTINCT `monthz`, `monthz` AS `DispFld` FROM " . $this->getSqlFrom();
		$this->monthz->SqlOrderBy = "`monthz`";

		// PaymentsBar
		$this->PaymentsBar = new crChart($this->DBID, 'Payments_Report', 'Payments Report', 'PaymentsBar', 'PaymentsBar', 'monthz', 'number', '', 104, 'COUNT', 550, 440);
		$this->PaymentsBar->SqlSelect = "SELECT `monthz`, '', COUNT(`number`) FROM ";
		$this->PaymentsBar->SqlGroupBy = "`monthz`";
		$this->PaymentsBar->SqlOrderBy = "";
		$this->PaymentsBar->SeriesDateType = "";

		// PaymentsPie
		$this->PaymentsPie = new crChart($this->DBID, 'Payments_Report', 'Payments Report', 'PaymentsPie', 'PaymentsPie', 'monthz', 'number', '', 6, 'COUNT', 550, 440);
		$this->PaymentsPie->SqlSelect = "SELECT `monthz`, '', COUNT(`number`) FROM ";
		$this->PaymentsPie->SqlGroupBy = "`monthz`";
		$this->PaymentsPie->SqlOrderBy = "";
		$this->PaymentsPie->SeriesDateType = "";

		// Line Chart
		$this->Line_Chart = new crChart($this->DBID, 'Payments_Report', 'Payments Report', 'Line_Chart', 'Line Chart', 'monthz', 'number', '', 4, 'COUNT', 550, 440);
		$this->Line_Chart->SqlSelect = "SELECT `monthz`, '', COUNT(`number`) FROM ";
		$this->Line_Chart->SqlGroupBy = "`monthz`";
		$this->Line_Chart->SqlOrderBy = "";
		$this->Line_Chart->SeriesDateType = "";

		// Area Chart
		$this->Area_Chart = new crChart($this->DBID, 'Payments_Report', 'Payments Report', 'Area_Chart', 'Area Chart', 'monthz', 'number', '', 7, 'COUNT', 550, 440);
		$this->Area_Chart->SqlSelect = "SELECT `monthz`, '', COUNT(`number`) FROM ";
		$this->Area_Chart->SqlGroupBy = "`monthz`";
		$this->Area_Chart->SqlOrderBy = "";
		$this->Area_Chart->SeriesDateType = "";
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ofld->GroupingFieldId == 0) {
				if ($ctrl) {
					$sOrderBy = $this->getDetailOrderBy();
					if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
						$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
					} else {
						if ($sOrderBy <> "") $sOrderBy .= ", ";
						$sOrderBy .= $sSortField . " " . $sThisSort;
					}
					$this->setDetailOrderBy($sOrderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
				}
			}
		} else {
			if ($ofld->GroupingFieldId == 0 && !$ctrl) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`payments`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`cash`) AS `sum_cash`, MIN(NULLIF(`cash`,0)) AS `min_cash`, MAX(NULLIF(`cash`,0)) AS `max_cash`, COUNT(NULLIF(`cash`,0)) AS `cnt_cash`, SUM(`area`) AS `sum_area`, MIN(`area`) AS `min_area`, MAX(`area`) AS `max_area`, COUNT(*) AS `cnt_area`, SUM(`price`) AS `sum_price`, MIN(NULLIF(`price`,0)) AS `min_price`, MAX(NULLIF(`price`,0)) AS `max_price`, COUNT(NULLIF(`price`,0)) AS `cnt_price` FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {

			//$sUrlParm = "order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort();
			$sUrlParm = "order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort();
			return ewr_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		case "x_cash":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `cash`, `cash` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `payments`";
		$sWhereWrk = "{filter}";
		$this->cash->LookupFilters = array("dx1" => '`cash`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`cash` = {filter_value}', "t0" => "131", "fn0" => "");
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->cash, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `cash` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_price":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `price`, `price` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `payments`";
		$sWhereWrk = "{filter}";
		$this->price->LookupFilters = array("dx1" => '`price`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`price` = {filter_value}', "t0" => "131", "fn0" => "", "n" => 10);
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->price, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `price` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
