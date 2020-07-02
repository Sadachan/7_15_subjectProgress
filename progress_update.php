<?php
require 'dbConection.php';

var_dump($_POST['status']);
var_dump($_POST['id']);
var_dump($_POST['deadline']);
var_dump($_POST['startdate']);
var_dump($_POST['charge']);


//フォームの値を取得
$id=$_POST['id'];
$status=$_POST['status'];
$deadline=$_POST['deadline'];
$startdate=$_POST['startdate'];
$charge=$_POST['charge'];

//ステータスリストを作成
$statusArray=array("未対応"=>0,"対応中"=>1,"データ待ち"=>2,"確認待ち"=>3,"完了"=>4);

//DB接続
$pdo=dbconect();

$sql="update progress_table set startdate=:startdate, deadline=:deadline, charge=:charge, nowstatus=:nowstatus where id=:id";
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$stmt->bindValue(':startdate',$startdate,PDO::PARAM_STR);
$stmt->bindValue(':deadline',$deadline,PDO::PARAM_STR);
$stmt->bindValue(':charge',$charge,PDO::PARAM_STR);
$stmt->bindValue(':nowstatus',$statusArray[$status],PDO::PARAM_INT);
$status=$stmt->execute();

if($status==false){
  $error=$stmt->errorInfo();
  exit("sqlError".$error[2]);
}else{
  header('Location:./progress_read.php?status=updated');
}

