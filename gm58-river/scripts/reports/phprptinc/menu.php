<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(22, "mi_Payments_Report", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("22", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "Payments_Reportsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(24, "mi_StandOwners", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("24", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "StandOwnerssmry.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
