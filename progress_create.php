<?php
//var_dump($_POST);
require 'dbConection.php';

//POST送信を取得
$taskname=$_POST['taskname'];
$deadline=$_POST['deadline'];
$man_hour=$_POST['man_hour'];
$charge=$_POST['charge'];
$numForCreateStartDate=$man_hour-1;

//納期から工数を差し引いて開始日を算出
echo $deadline;
$date=new DateTime($deadline);
$date->format('Y年m月d日 H時');
$start_date=$date->modify('-'.$numForCreateStartDate.' days');
$start_date=$start_date->format('Y-m-d');


//DB接続
$pdo = dbconect();

//SQL文を作成
$sql="INSERT INTO progress_table(id,taskname,startdate,deadline,manhour,charge,nowstatus)VALUES(NULL,:taskname,:startdate,:deadline,:manhour,:charge,0)";


//SQL文をセット&実行
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':taskname',$taskname,PDO::PARAM_STR);
$stmt->bindValue(':startdate',$start_date,PDO::PARAM_STR);
$stmt->bindValue(':deadline',$deadline,PDO::PARAM_STR);
$stmt->bindValue(':manhour',$man_hour,PDO::PARAM_INT);
$stmt->bindValue(':charge',$charge,PDO::PARAM_STR);
$status=$stmt->execute();



if($status==false){
  //SQL実行に失敗した場合はここでエラーを出力し、以降の処理を中止する
  $error=$stmt->errorInfo();
  exit('sqlError'.$error[2]);
}else{
  header('Location:./');
}









