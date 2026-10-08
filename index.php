<?php
include 'includes/connection.php';
include 'includes/blog.class.php';

$obj      = new Blog($conn);
$category = trim($_GET["category"] ?? "");
$keyword  = trim($_GET["keyword"] ?? "");
$posts    = $obj->searchPublished($keyword, $category);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dalal Street Daily</title>
    <?php include 'head-script.php'; ?>
    <link rel="stylesheet" href="css/blog.css">
</head>

<body>
    <div class="ticker"><div class="ticker_in">NIFTY 50 24,850 ▲0.42% &nbsp;•&nbsp; SENSEX 81,300 ▲0.38% &nbsp;•&nbsp; BANK NIFTY 53,200 ▼0.11% &nbsp;•&nbsp; RELIANCE 2,980 ▲0.9% &nbsp;•&nbsp; TCS 4,120 ▲0.3% &nbsp;•&nbsp; HDFC BANK 1,720 ▼0.2% &nbsp;•&nbsp; (sample values)</div></div>
    <div class="blog_header">
        <h1>Dalal Street Daily</h1>
        <p>Nifty, Sensex and Indian market explainers</p>
        <a href="login.php" class="admin_link">Admin</a>
    </div>

    <div class="blog_wrap">
        <form method="get" class="blog_search">
            <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Search posts">
            <select name="category">
                <option value="">All categories</option>
                <?php foreach (array("Tech", "Business", "Lifestyle", "Travel") as $option): ?>
                    <option value="<?php echo $option; ?>" <?php echo $category == $option ? "selected" : ""; ?>><?php echo $option; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
        </form>

        <?php if ($posts && mysqli_num_rows($posts) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                <div class="blog_card">
                    <span class="badge badge-confirmed"><?php echo htmlspecialchars($post["category"]); ?></span>
                    <h2><a href="post.php?id=<?php echo $post["id"]; ?>"><?php echo htmlspecialchars($post["title"]); ?></a></h2>
                    <div class="meta">By <?php echo htmlspecialchars($post["author"]); ?> | <?php echo date("d M Y", strtotime($post["created_at"])); ?></div>
                    <p><?php echo htmlspecialchars(mb_substr($post["content"], 0, 140)); ?>...</p>
                    <a href="post.php?id=<?php echo $post["id"]; ?>" class="read_more">Read more</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="empty">No posts found.</p>
        <?php endif; ?>
    </div>
</body>

</html>
