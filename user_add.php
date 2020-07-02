<?php
  require 'dbConection.php';

  var_dump($_POST['user']);
  $user=$_POST['user'];

  //DB接続
  $pdo=dbconect();

  //SQL作成
  $sql="INSERT INTO user(user_id,user_name) VALUES(NULL,:user)";
  $stmt=$pdo->prepare($sql);
  $stmt->bindValue(':user',$user,PDO::PARAM_STR);
  $status=$stmt->execute();

  if($status==false){
    //SQL実行に失敗した場合はここでエラーを出力し、以降の処理を中止する
    $error=$stmt->errorInfo();
    exit('sqlError'.$error[2]);
  }else{
    header('Location:./');
  }

  