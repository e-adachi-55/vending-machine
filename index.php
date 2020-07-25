<?php
$host = 'localhost'; // データベースのホスト名又はIPアドレス
$username = 'codecamp30074';  // MySQLのユーザ名
$passwd   = 'KKDNFGXT';    // MySQLのパスワード
$dbname   = 'codecamp30074';    // データベース名
$link = mysqli_connect($host, $username, $passwd, $dbname);
$data = [];
$error = [];


if ($link) {
    mysqli_set_charset($link, 'utf8');
    $query = 'SELECT drink_data_table.id, image, drink_data_table.name, price, stock FROM drink_data_table JOIN stock_table ON drink_data_table.id = stock_table.id WHERE status = 1';
    $result = mysqli_query($link, $query);
   // 1行ずつ結果を配列で取得します
   while ($row = mysqli_fetch_array($result)) {
       $data[] = $row;
   }
   // 結果セットを開放します
   mysqli_free_result($result);
   // 接続を閉じます
   mysqli_close($link);
} else {
   $error[] = 'DB接続失敗';
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>vending-machine</title>
   <link rel ="stylesheet" href ="css/style.css">
</head>
<body>
    <h1>vending-machine</h1>
    <?php foreach ($error as $value) { ?>
        <P><?php print $value; ?></P>
        <?php } ?> 
    
    <form method="post" action="result.php">
        <p><label>金額<input type="text" name="price" value=""></label></p>
        <ul>
            <?php foreach ($data as $value) { ?>
            <li>
                <p><img src ="<?php print $value['image']; ?>"></p>
                <p><?php print htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><?php print $value['price']; ?></p>
                <?php  if ($value['stock'] > 0) { ?>
                <p><input type ="radio" name ="id" value ="<?php print $value['id']; ?>"></p>
                <?php } else { ?>
                    <p class ="sold_out">売り切れ</p>
                <?php } ?>
                
            </li>
            
            <?php } ?> 
        </ul>
        <p class ="buy"><input type="submit" value="購入"></p>
    </form>       
    
    

</body>
</html>