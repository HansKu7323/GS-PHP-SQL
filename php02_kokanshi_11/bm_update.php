<?php
//1.POSTでid,name,email,naiyouを取得
$id = $_POST["id"];
$book_name = $_POST["book_name"];
$book_URL = $_POST["book_URL"];
$note = $_POST["note"];

//2.DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//3.UPDATE gs_an_table SET ....; で更新(bindValue)
$sql = 'UPDATE gs_bm_table SET book_name=:book_name,book_URL=:book_URL,note=:note WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);
$stmt->bindValue(':book_URL',  $book_URL,  PDO::PARAM_STR);
$stmt->bindValue(':note',      $note,      PDO::PARAM_STR);
$stmt->bindValue(':id',        $id,        PDO::PARAM_INT);    //更新したいidを渡す
$status = $stmt->execute();

//４．データ:id
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //select.phpへリダイレクト
  header("Location: bm_list_view.php");
  exit;

}

?>
