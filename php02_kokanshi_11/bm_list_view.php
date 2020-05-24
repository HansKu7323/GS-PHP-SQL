<?php
session_start();
if( !isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN ERROR";
  exit();
}else{
  session_regenerate_id(true);
  $_SESSION["chk/ssid"] = session_id();
}



//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");//FROM table名
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= '<p>'.$result['id']."-".$result['name'].'</p>';
    $view .= '<p>';
    $view .= '<a href = "bm_update_view.php?id='.$result["id"].'">';
    $view .= $result["indate"].'-'.$result["book_name"].'-'.$result["book_URL"];
    $view .= '</a>';
    $view .= '　';
    $view .= '<a href = "bm_delete.php?id='.$result["id"].'">';
    $view .= ' ［削除］';
    $view .= '</a>';
    $view .= '</p>';
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">書庫登録</a>
      <a class="navbar-brand" href="bm_logout.php">LOGOUT</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
