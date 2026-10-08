<?php
include 'includes/connection.php';
include 'includes/chk_login.php';
include 'includes/blog.class.php';

$obj = new Blog($conn);

$stat1   = $obj->getCount("SELECT COUNT(*) AS total FROM posts");
$stat2   = $obj->getCount("SELECT COUNT(*) AS total FROM posts WHERE status = 'Published'");
$stat3   = $obj->getCount("SELECT COUNT(*) AS total FROM posts WHERE status = 'Draft'");
$stat4   = $obj->getCount("SELECT COUNT(*) AS total FROM posts WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");

$recent = $obj->search("", "", 5);

$pageTitle       = "Blog CMS - Dashboard";
$activePage      = "dashboard";
$breadcrumbLabel = "Dashboard";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'head-script.php'; ?>
</head>

<body class="page-dashboard">
    <div class="bg_dashboard h-screen">
        <div class="row">

            <!--left menu-->
            <?php include 'sidebar.php'; ?>
            <!--left menu-->

            <div class="right_bar">

                <!--header-->
                <?php include 'header.php'; ?>
                <!--header-->

                <div class="row mt-4 max_565">
                    <div class="col-6 col-md-6 col-lg-3">
                        <a href="manage.php" class="col-span-12  text-white sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-3 box-stat1">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>
                                    <div class="fs-2 font-medium leading-8 mt-3"><?php echo $stat1; ?></div>
                                    <div class="fs-6  mt-1">Total Posts</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <a href="manage.php" class="col-span-12  text-white sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-3 box-stat2">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-globe"></i>
                                    </div>
                                    <div class="fs-2 font-medium leading-8 mt-3"><?php echo $stat2; ?></div>
                                    <div class="fs-6  mt-1">Published</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <a href="manage.php" class="col-span-12  text-white sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-3 box-stat3">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-pen-ruler"></i>
                                    </div>
                                    <div class="fs-2 font-medium leading-8 mt-3"><?php echo $stat3; ?></div>
                                    <div class="fs-6  mt-1">Drafts</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-6 col-lg-3">
                        <a href="manage.php" class="col-span-12  text-white sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-3 box-stat4">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-calendar"></i>
                                    </div>
                                    <div class="fs-2 font-medium leading-8 mt-3"><?php echo $stat4; ?></div>
                                    <div class="fs-6  mt-1">This Month</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row mt-4 max_565 content_row_flex">
                    <div class="col-12 content_col_full">
                        <div class="manage-card">
                            <h2>Posts by Category</h2>
                            <?php
                            $chartRows = array();
                            $chartRes  = mysqli_query($conn, "SELECT category AS label, COUNT(*) AS total FROM posts GROUP BY category");
                            while ($chartRow = mysqli_fetch_assoc($chartRes)) 
                                {
                                    $chartRows[] = $chartRow;
                                }
                            $palette  = array("#7c3aed", "#0ea5e9", "#f59e0b", "#16a34a", "#ef4444", "#14b8a6");
                            $chartSum = 0;
                            foreach ($chartRows as $chartRow) 
                                {
                                    $chartSum = $chartSum + $chartRow["total"];
                                }
                            if ($chartSum == 0) 
                                {
                                    $chartSum = 1;
                                }
                            $stops  = "";
                            $legend = "";
                            $start  = 0;
                            $n      = 0;
                            foreach ($chartRows as $chartRow) 
                                {
                                    $end    = $start + ($chartRow["total"] / $chartSum) * 100;
                                    $color  = $palette[$n % 6];
                                    $stops  = $stops . $color . " " . $start . "% " . $end . "%,";
                                    $legend = $legend . '<li><i style="background:' . $color . '"></i>' . htmlspecialchars($chartRow["label"]) . ' (' . $chartRow["total"] . ')</li>';
                                    $start  = $end;
                                    $n++;
                                }
                            $stops = rtrim($stops, ",");
                            if ($stops == "") 
                                {
                                    $stops = "#e5e7eb 0% 100%";
                                }
                            ?>
                            <div class="chart_wrap">
                                <div class="donut" style="background:conic-gradient(<?php echo $stops; ?>)"></div>
                                <ul class="legend"><?php echo $legend; ?></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 max_565 content_row_flex">
                    <div class="col-12 content_col_full">
                        <div class="manage-card">
                            <h2>Recent Posts</h2>

                            <?php
                            $records     = $recent;
                            $showActions = false;
                            include 'includes/table.php';
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
