<?php

define('DSN', 'mysql:host=db;dbname=pet_shop;charset=utf8;');
define('USER', 'staff');
define('PASSWORD', '9999');

try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

$sql = 'SELECT * FROM animals';
$stmt = $dbh->prepare($sql);

$stmt->execute();

$keyword = $_GET['keyword'];
if ($keyword != '') {
    $sql2 = 'SELECT * FROM animals WHERE description LIKE :keyword';
    $stmt = $dbh->prepare($sql2);

    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $keyword = '%' . $keyword . '%';

    $stmt->execute();
}

$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ペットショップアプリ課題2</title>
</head>

<body>
    <h2>本日のご紹介のペット！</h2>

    <form action="index.php" method="get">
        キーワード: <input type="text" name="keyword" placeholder="キーワードの入力">
        <input type="submit" value="検索">
    </form>

    <?php foreach ($animals as $animal) {
        echo $animal['type'] . 'の' . $animal['classifcation'] . 'ちゃん' . '<br>' .
            $animal['description'] . '<br>' .
            $animal['birthday'] . '生まれ' . '<br>' .
            '出身地' . $animal['birthplace'] . '<hr>';
    }
    ?>
</body>

</html>