<?php
include_once 'includes/blog.class.php';

if (empty($pageTitle)) 
    {
        $pageTitle = "Blog CMS";
    }
if (empty($breadcrumbLabel)) 
    {
        $breadcrumbLabel = $pageTitle;
    }

$headerUsername = $_SESSION["username"] ?? "";
$headerPhoto    = "https://ui-avatars.com/api/?background=1e40af&color=fff&name=" . urlencode($headerUsername);
?>
<div class="top_bar d-flex justify-content-between align-items-center">

    <ol class="breadcrumb mt-2 mb-3">
        <li class="breadcrumb-item">
            <a href="dashboard.php">Blog CMS</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($breadcrumbLabel); ?></li>
    </ol>

    <div class="user onhover-dropdown">
        <span><img src="<?php echo htmlspecialchars($headerPhoto); ?>" alt="" /></span>

        <div class="onhover-div onhover-div-login">
            <ul class="user-box-name">

                <li class="fst_drp_li">
                    <div class="font-medium"><?php echo htmlspecialchars($headerUsername); ?></div>
                    <div class="text-small">Blog CMS</div>
                </li>

                <li class="product-box-contain">
                    <a href="logout.php">Log out</a>
                </li>
            </ul>
        </div>

    </div>
</div>
