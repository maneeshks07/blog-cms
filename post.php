<?php
include 'includes/connection.php';
include 'includes/blog.class.php';

$obj  = new Blog($conn);
$post = $obj->getById((int) ($_GET["id"] ?? 0));

if (!$post || $post["status"] != "Published") 
    {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo htmlspecialchars($post["title"]); ?></title>
    <?php include 'head-script.php'; ?>
    <link rel="stylesheet" href="css/blog.css">
</head>

<body>
    <div class="blog_header">
        <h1>Dalal Street Daily</h1>
    </div>

    <div class="blog_wrap">
        <div class="blog_card">
            <span class="badge badge-confirmed"><?php echo htmlspecialchars($post["category"]); ?></span>
            <h2><?php echo htmlspecialchars($post["title"]); ?></h2>
            <div class="meta">By <?php echo htmlspecialchars($post["author"]); ?> | <?php echo date("d M Y", strtotime($post["created_at"])); ?></div>
            <p><?php echo nl2br(htmlspecialchars($post["content"])); ?></p>
            <a href="index.php" class="read_more">&larr; Back to all posts</a>
        </div>
    </div>
</body>

</html>
