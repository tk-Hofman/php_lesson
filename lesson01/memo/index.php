<?php
    require('db.php');

    $counts = $db->query('select count(*) as cnt from memos');
    $count = $counts->fetch_assoc();
    $max_page = floor(($count['cnt']+1)/5+1);

    $stmt = $db->prepare('select * from memos order by id desc limit ?, 5');
    if (!$stmt) {
        die($db->error);
    }
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
    $page = ($page ?: 1);
    if (!$page) {
        $page = 1;
    }
    $start = ($page-1) * 5;
    $stmt->bind_param("i",$page);
    $result = $stmt->execute();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>投稿</h1>
    <p>→ <a href="input.html">新しい投稿</a></p>
    <?php if(!$result):  ?>
        <p>表示する投稿はありません</p>
    <?php endif; ?>
    <?php $stmt->bind_result($id, $memo, $created); ?>
    <?php while ($stmt->fetch()): ?>
        <div>
            <h2><a href="memo.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars(mb_substr($memo,0,50)); ?></a></h2>
            <time><?php echo htmlspecialchars($created); ?></time>
        </div>
        <hr>
    <?php endwhile; ?>
    <p>
        <?php if($page>1): ?>
            <a href="?page=<?php echo $page-1; ?>"><?php echo $page-1; ?>ページ目へ</a> |
        <?php endif; ?>
        <?php if ($page<$max_page): ?>
            <a href="?page=<?php echo $page+1; ?>"><?php echo $page+1; ?>ページ目へ</a>
        <?php endif; ?>
    </p>
</body>
</html>