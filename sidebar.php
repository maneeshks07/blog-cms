<?php
$li_dashboard = "";
$li_records   = "";
$li_add       = "";
$li_logout    = "";

if ($activePage == "dashboard") 
    {
        $li_dashboard = " active_mnu";
    }

if ($activePage == "records") 
    {
        $li_records = " active_mnu";
    }

if ($activePage == "add") 
    {
        $li_add = " active_mnu";
    }

if ($activePage == "logout") 
    {
        $li_logout = " active_mnu";
    }
?>
<!--mobile header-->
<div class="mobile-header d-flex align-items-center justify-content-between">
    <div class="mob_logo text-white fw-500"><i class="fa-solid fa-newspaper"></i> Blog CMS</div>

    <div class="mob_menu">
        <input type="checkbox" id="menu-toggle-checkbox" class="menu-toggle-checkbox">
        <label for="menu-toggle-checkbox" id="menu-toggle" class="menu-toggle-label">
            <i class="bi bi-list text-white" style="font-size: 28px;"></i>
        </label>
        <!-- Side menu -->
        <div id="side-menu" class="side-menu">
            <label for="menu-toggle-checkbox" id="close-menu" class="close-btn">&times;</label>

            <div class="navigation_sec mt-4">
                <ul>
                    <li class="<?php echo $li_dashboard; ?>">
                        <a href="dashboard.php">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span class="hd_tb">Dashboard</span>
                        </a>
                    </li>
                    <li class="<?php echo $li_records; ?>">
                        <a href="manage.php">
                            <i class="fa-solid fa-newspaper"></i>
                            <span class="hd_tb">Posts</span>
                        </a>
                    </li>
                    <li class="<?php echo $li_add; ?>">
                        <a href="form.php">
                            <i class="fa-solid fa-plus"></i>
                            <span class="hd_tb">Add Post</span>
                        </a>
                    </li>
                    <li class="<?php echo $li_logout; ?>">
                        <a href="logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span class="hd_tb">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Overlay -->
        <label for="menu-toggle-checkbox" id="overlay" class="overlay"></label>
    </div>
</div>
<!--mobile header-->

<div class="left_bar">
    <div class="logo_dash">
        <a href="dashboard.php" class="intro-x d-flex gap-2 align-items-center ps-3">
            <i class="fa-solid fa-newspaper text-white"></i>
            <span class="d-none d-lg-block text-white text-lg ml-3">Blog CMS</span>
        </a>
    </div>
    <div class="navigation_sec mt-4">
        <ul>
            <li class="<?php echo $li_dashboard; ?>">
                <a href="dashboard.php">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span class="hd_tb">Dashboard</span>
                </a>
            </li>
            <li class="<?php echo $li_records; ?>">
                <a href="manage.php">
                    <i class="fa-solid fa-newspaper"></i>
                    <span class="hd_tb">Posts</span>
                </a>
            </li>
            <li class="<?php echo $li_add; ?>">
                <a href="form.php">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hd_tb">Add Post</span>
                </a>
            </li>
            <li class="<?php echo $li_logout; ?>">
                <a href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span class="hd_tb">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
