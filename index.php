<?php
  require 'dbConection.php';

  //DB接続
  $pdo=dbconect();

  //SQL作成
  $sql="SELECT * from user";
  $stmt=$pdo->prepare($sql);
  $status=$stmt->execute();

  $output='';
  if($status==false){
    //SQL実行に失敗した場合はここでエラーを出力し、以降の処理を中止する
    $error=$stmt->errorInfo();
    exit('sqlError'.$error[2]);
  }else{
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $output.="<select class='charge' id='charge' name='charge'>";
    foreach($result as $record){
      $output.="<option value='".$record['user_name']."'>".$record['user_name']."</option>";
    }
    $output.="</select>";
  }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
   <link rel="stylesheet" type="text/css" href="css/index.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <title>案件進捗管理システム</title>
</head>

<html>
  <body>
    <h1 class="page-title">登録ページ</h1>
    <form action="progress_create.php" method="POST">
      <table>
        <tr><th><label for="taskname">案件名</label></th><td><input type="text" id="taskname" name="taskname"></td></tr>
        <tr><th><label for="deadline">納期</label></th><td><input type="date" id="deadline" name="deadline"></td></tr>
        <tr><th><label for="man-hour">工数</th><td><input id="man-hour" name="man_hour">日</td></tr>
        <tr><th><label for="charge">担当</th><td><?=$output?></td></tr>
        <tr><th colspan="2"><input type="submit" value="登録" class='submit-btn'></th></tr>
      </table>
    </form>
    <hr>
    <div>担当者追加</div>
    <form action='user_add.php' method="POST">
      <input type="text" name="user">
      <input type="submit" value="登録">
    </form>

    <hr>
    <a href="./progress_read.php">案件進捗一覧へ</a>

  </body>
</html>