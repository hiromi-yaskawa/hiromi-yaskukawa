<?php
 
// セッションの開始
session_start();
 
$id = time();
$kind = $_SESSION['kind'];
$star = $_SESSION['star'];
$message = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
$userid = $_SESSION['EMAIL'];
 
//mysql接続
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'root';
$password = 'パスワード';
try{
    $dbh = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>
<!DOCTYPE HTML>
<html lang="ja">
    <head>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8"/>>
    <title>投稿</title>
    <style media="screen">
        p{
            margin: 20px 0;
        }
        textarea{
            margin: auto;
            display: block;
            width:100%;
            border-radius: 5px;
            font-size: 15px;
            margin-bottom: 3em;
        }
        .main_log{
            padding:20px,30px;
        }
        #log_body{
            background-color: #fff6e2;
        }
        .log_button{
            width: 45%;
        }
    </style>
</head>
<body id ="log_body">
    <?php
    $query = $dbh->query("select count(*) from  formdata WHERE userid = '".$userid."' AND kind = '".$kind."'"); 
    $count = $query->fetchColumn();
    if ($count > 0){
    ?>
    <p align ="center">投稿が重複しています</p>
    <p align ="center"><a href="input.php?kind=<?php echo $kind;?>" class="log_button" width="45%">入力画面に戻る</a></p>
<?php
    } else {
       // データの追加
$sql = 'INSERT INTO formdata(id, kind, star, message, userid) VALUES("'.$id.'","'.$kind.'","'.$star.'","'.$message.'","'.$userid.'")';
$stmt = $dbh -> prepare($sql);
$stmt -> execute();
?>
<p align="center">投稿ありがとうございました。</p>
<p align="center"><a href="detail.php?kind=<?php echo $kind;?>" class="log_button" width="45%">店舗画面に戻る</a></p>

<?php 
    }
    ?>
    <p align="center"><a href="top.php" class="log_button" width="45%">ホーム画面に戻る</a></p>
</body>
</html>