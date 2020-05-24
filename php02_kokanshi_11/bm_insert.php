<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["book_name"]) || $_POST["book_name"]=="" ||
  !isset($_POST["book_URL"]) || $_POST["book_URL"]=="" ||
  !isset($_POST["note"]) || $_POST["note"]==""
){
  exit('ParamError');
}


//1. POSTデータ取得
$book_name = $_POST['book_name'];
$book_URL = $_POST['book_URL'];
$note = $_POST['note'];



//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, book_name, book_URL, note,
indate )VALUES(NULL, :book_name, :book_URL, :note, sysdate())");
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':book_URL', $book_URL, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':note', $note, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;

}
?>
