<?php
include 'includes/connection.php';
include 'includes/chk_login.php';
include 'includes/blog.class.php';

$obj     = new Blog($conn);

$message = "";
$error   = "";

if (($_GET["msg"] ?? "") == "saved") 
    {
        $message = "Record saved successfully.";
    }

if (($_GET["delete"] ?? "") !== "") 
    {
        $id = (int) $_GET["delete"];

        if ($obj->deleteRecord($id)) 
            {
                $message = "Record deleted successfully.";
            } 
        else 
            {
                $error = "Could not delete the record.";
            }
    }

$keyword = trim($_GET["keyword"] ?? "");
$filter  = trim($_GET["filter"] ?? "");

$records = $obj->search($keyword, $filter);

$pageTitle       = "Manage Posts";
$activePage      = "records";
$breadcrumbLabel = "Posts List";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'head-script.php'; ?>
</head>

<body class="page-manage">
    <div class="bg_dashboard h-screen">
        <div class="row">

            <!--left menu-->
            <?php include 'sidebar.php'; ?>
            <!--left menu-->

            <div class="right_bar">

                <!--header-->
                <?php include 'header.php'; ?>
                <!--header-->

                <div class="row mt-4 max_565 content_row_flex">
                    <div class="col-12 content_col_full">
                        <div class="manage-card">

                            <h2>Manage Posts</h2>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <form method="get" class="search-form">
                                    <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>"
                                        placeholder="Search by title or author">

                                    <select name="filter">
                                        <option value="">All Statuses</option>
                                        <?php foreach (array("Draft", "Published") as $option): ?>
                                            <option value="<?php echo $option; ?>" <?php echo $filter == $option ? "selected" : ""; ?>><?php echo $option; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="submit" class="button">Search</button>
                                    <a href="form.php" class="button">+ Add Post</a>
                                </form>
                            </div>

                            <?php if ($message != ""): ?>
                                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
                            <?php endif; ?>

                            <?php if ($error != ""): ?>
                                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <?php
                            $showActions = true;
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
