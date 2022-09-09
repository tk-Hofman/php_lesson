<?php
    require ("db.php");
    $stmt = $db->prepare('select * from memos where id=?');
    if (!$stmt) {
        die($db->error);
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt->bind_result($id, $memo, $created);
    $result = $stmt->fetch();
?>

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
<form action="update_do.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <textarea name="memo" cols="50" rows="10" placeholder="投稿を編集"><?php echo $memo; ?></textarea><br>
    <button type="submit">編集する</button>
</form>
</body>
</html>
