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
    $memo = filter_input(INPUT_POST,'memo',FILTER_SANITIZE_SPECIAL_CHARS);

    require('db.php');
    $stmt = $db->prepare('insert into memos(memo) values(?)');
    if(!$stmt) {
        die($db -> error);
    }
    $stmt->bind_param('s',$memo);
    $ret = $stmt->execute();

    if($ret) {
        echo '登録されました';
        echo '<br>-><a href="index.php">トップにもどる</a>';
    } else {
        $db->error;
    }
    ?>
</body>
</html>


