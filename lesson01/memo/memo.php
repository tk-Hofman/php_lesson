<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        require ("db.php");
        $stmt =$db->prepare('select * from memos where id=?');
        if(!$stmt) {
            die($db->error);
        }
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if(!$id) {
            echo "表示する投稿を指定してください";
            exit();
        }
        $stmt->bind_param('i',$id);
        $stmt->execute();

        $stmt->bind_result($id,$memo,$created);
        $result = $stmt->fetch();

        if(!$result) {
            echo '指定された投稿は見つかりません';
            exit();
        }
    ?>

    <div><pre><?php echo htmlspecialchars($memo); ?></pre></div>

    <p>
        <a href="update.php?id=<?php echo $id; ?>">編集する</a> |
        <a href="delete.php?id=<?php echo $id; ?>">削除する</a> |
        <a href="/lesson01/memo">一覧へ</a>
    </p>
</body>
</html>
