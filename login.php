<?php
include 'includes/connection.php';
include 'includes/blog.class.php';

$obj      = new Blog($conn);
$username = "";
$errorMsg = "";

if (isset($_POST["login"])) 
    {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        if ($username === "" || $password === "") 
            {
                $errorMsg = "Please enter username and password.";
            } 
        else 
            {
                if ($obj->login($username, $password)) 
                    {
                        header("Location: dashboard.php");
                        exit();
                    } 
                else 
                    {
                        $errorMsg = $obj->errorMessage;
                    }
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog CMS - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/theme.css">
</head>
<body class="lg4">
<div class="lg4_paper">
  <div class="lg4_rule">EST. 2026 &bull; MUMBAI &bull; DALAL STREET</div>
  <h1>Dalal Street Daily</h1><div class="lg4_rule">EDITOR'S DESK &mdash; SIGN IN</div><?php if ($errorMsg !== ""): ?><div class="alert_msg"><?php echo htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
  <form method="post" action="login.php"><label>Username</label><input type="text" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"><label>Password</label><input type="password" name="password"><button type="submit" name="login">Enter the newsroom</button></form>
</div>
</body>
</html>
