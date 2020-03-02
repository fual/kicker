<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/functions.php";

$result = "";

$city = isset($_GET["city"]) ? filter_var($_GET["city"], FILTER_SANITIZE_STRING) : "";
if ( !empty($city) && file_exists($_SERVER["DOCUMENT_ROOT"] . "/" . $city) ) {
    $subfolder = "/" . $city;
    require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/bootstrap.php";
} else
    $result .= "City is not selected, can't access database<br>";

$action = isset($_GET["action"]) ? filter_var($_GET["action"], FILTER_SANITIZE_STRING) : "";
if ($action == "schedule") {
   include_once $_SERVER["DOCUMENT_ROOT"] . "/api/actions/schedule.php";
} else
    $result .= "Invalid action.<br>";

require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/head.php";
?>
<body>
    <main role="main" class="container">
        <div class="starter-template text-center">
        <?php if (!empty($result)) echo "<div class='alert alert-info'>".$result."</div>"; ?>
        <table class="table table-sm">
            <tr>
                <th>Property</th>
                <th>Value</th>
            </tr>
            <tr>
                <td colspan="2">action=schedule</td>
            </tr>
            <tr>
                <td>city</td>
                <td>One of: msk, kld, spb</td>
            </tr>
            <tr>
                <td>tournament_id</td>
                <td>tournament id</td>
            </tr>
            <tr>
                <td>start{# of round}</td>
                <td>start1={date} like 'start1=23.01.2020'</td>
            </tr>
            <tr>
                <td>end{# of round}</td>
                <td>end1={date} like 'end1=23.01.2020'</td>
            </tr>
            <tr>
                <td colspan="2">Example: /api.php?action=schedule&city=msk&tournament_id=1&season_id=2&start1=01.03.2020&end1=31.05.2020&start2=30.06.2020&end2=25.12.2020</td>
            </tr>
        </table>
    </div>
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/footer.php"; ?>
</body>
</html>