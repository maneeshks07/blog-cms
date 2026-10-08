<?php
include 'includes/connection.php';
include 'includes/chk_login.php';
include 'includes/blog.class.php';

$obj    = new Blog($conn);

$id     = (int) ($_GET["id"] ?? 0);
$error  = "";
$record = array();

if ($id > 0) 
    {
        $record = $obj->getById($id);

        if (!$record) 
            {
                header("Location: manage.php");
                exit();
            }
    }

if (isset($_POST["save"])) 
    {
        $record = $_POST;

        if ($obj->saveRecord($id, $_POST)) 
            {
                header("Location: manage.php?msg=saved");
                exit();
            } 
        else 
            {
                $error = $obj->errorMessage;
            }
    }

$pageTitle       = ($id > 0 ? "Edit " : "Add ") . "Post";
$activePage      = ($id > 0 ? "records" : "add");
$breadcrumbLabel = $pageTitle;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php include 'head-script.php'; ?>
</head>

<body class="page-form">
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

                            <h2><?php echo htmlspecialchars($pageTitle); ?></h2>

                            <?php if ($error != ""): ?>
                                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <form method="post" action="" style="margin-top: 20px;">
                                <div class="form_row">

                                    <?php foreach ($obj->fields as $field): ?>
                                        <?php
                                        $name  = $field["name"];
                                        $value = $record[$name] ?? ($field["default"] ?? "");
                                        $full  = ($field["type"] == "textarea") ? " form_grp_full" : "";
                                        ?>
                                        <div class="form_grp<?php echo $full; ?>">
                                            <label><?php echo htmlspecialchars($field["label"]); ?><?php echo $field["required"] ? " *" : ""; ?></label>

                                            <?php if ($field["type"] == "select"): ?>
                                                <select name="<?php echo $name; ?>">
                                                    <?php foreach ($field["options"] as $option): ?>
                                                        <option value="<?php echo $option; ?>" <?php echo $value == $option ? "selected" : ""; ?>><?php echo $option; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            <?php elseif ($field["type"] == "textarea"): ?>
                                                <textarea name="<?php echo $name; ?>" rows="6"><?php echo htmlspecialchars($value); ?></textarea>

                                            <?php elseif ($field["type"] == "number"): ?>
                                                <input type="text" name="<?php echo $name; ?>" inputmode="decimal" value="<?php echo htmlspecialchars($value); ?>">

                                            <?php else: ?>
                                                <input type="<?php echo $field["type"]; ?>" name="<?php echo $name; ?>" value="<?php echo htmlspecialchars($value); ?>">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>

                                </div>

                                <button type="submit" name="save" class="btn_update">Save</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
