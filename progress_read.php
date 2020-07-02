<?php
  require 'dbConection.php';

  //DB接続
  $pdo=dbconect();

  //SQL文作成
  $sql="SELECT * from progress_table where NOT (nowstatus=4);";

  //SQL準備&実行
  $stmt=$pdo->prepare($sql);
  $status=$stmt->execute();

  //実行後
  if($status==false){
    $error=$stmt->errorInfo();
    exit("sqlError".$error[2]);
  }else{
    //担当者一覧を取得
    $sql="SELECT * from user";
    $stmt2=$pdo->prepare($sql);
    $status=$stmt2->execute();
    $result2=$stmt2->fetchAll(PDO::FETCH_ASSOC);


    $output="";
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $output .= "<table border='1' width='95%' class='progress-table'>";
    $output .= "<tr><th width='100'>更新</td><th width='100'>案件名</th><th width='100'>担当</th><th width='100'>ステータス</th>";
    //本日の日付を取得
    $nowDate=date("m/d");
    for($i=0;$i<=15;$i++){
      $output .="<th width='40'>$nowDate</th>";
      $nowDate=new DateTime($nowDate);
      $nowDate->modify('+1 days');
      $nowDate=$nowDate->format('m/d');
    }
    $output .="</tr>";
    $statusArray=array(0=>"未対応",1=>"対応中",2=>"データ待ち",3=>"確認待ち",4=>"完了");
    //テーブルの行を作成
    foreach($result as $record){
      $statusNum =0;
      $output .= "<tr>";
      $output .= "<form action='progress_update.php' method='POST'>";
      $output .= "<input type='hidden' name='id' value='{$record['id']}'>";
      $output .= "<td><input type='submit' value='更新' class='update-btn'></td>";
      $output .= "<td class='taskname-cell'>{$record['taskname']}</td>";
      $output2='';
      $output2.="<td><select class='charge' name='charge'>";
      foreach($result2 as $record2){
        if($record2['user_name']==$record['charge']){
          $output2.="<option value='".$record2['user_name']."' selected>".$record2['user_name']."</option>";
        }else{
          $output2.="<option value='".$record2['user_name']."'>".$record2['user_name']."</option>";
        }
      }
      $output2.="</select></td>";
      $output .=$output2;
      //$output .= "<td>{$record['charge']}</td>";
      $output .= "<td><select class='status-box' name='status'>";
      for($j=0; $j<=4; $j++){
        if($j==$record['nowstatus']){
          $output .= "<option selected>{$statusArray[$record['nowstatus']]}</option>";
        }else{
          $output .= "<option>{$statusArray[$j]}</option>";
        }
      }
      $statusNum +=1;
      $nowDate=date("Y-m-d");
      //一日のセルを作成
      for($i=0;$i<=15;$i++){
        $nowDateForComparion=new DateTime($nowDate);
        $satrtDateForComparison=new DateTime($record['startdate']);
        $deadlineForComparison=new DateTime($record['deadline']);
        if($nowDateForComparion>$satrtDateForComparison AND $nowDateForComparion<$deadlineForComparison){
          $output .= "<td style='background-color:#00E676;' class='color-mass {$nowDate}' width='40'></td>";
        }else if($nowDate==$record['startdate']){
          $output .= "<td style='background-color:#00E676;' class='color-mass {$nowDate} startdate' width='40'></td>";
        }else if($nowDate==$record['deadline']){
          $output .= "<td style='background-color:#FF3D00;' class='color-mass {$nowDate} deadline' 'width='40'></td>";
        }else{
          $output .= "<td width='40' class='color-mass {$nowDate}'></td>";
        }
        //日付を一日繰り上げ
        $nowDate=new DateTime($nowDate);
        $nowDate->modify('+1 days');
        $nowDate=$nowDate->format('Y-m-d');
      }
      $output .= "</select></td>";
      $output .="<input type='hidden' class='deadlineforupdate' name='deadline' value='{$record['deadline']}'>";
      $output .="<input type='hidden' class='startdateforupdate' name='startdate' value='{$record['startdate']}'>";
      $output .= "</form>";
      $output .= "</tr>";
    }
    $output .= "</table>";
  }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
  <link rel="stylesheet" type="text/css" href="css/progress.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <title>案件進捗管理システム</title>
</head>
<?php 
  $message='';
  if(isset($_GET['status'])){
    $status=$_GET['status'];
    if($status=='updated'){
      $message='案件進捗テーブルを更新しました';
    }
  }
?>
<html>
  <body>
    <h1 class="pg-ttl">案件進捗一覧</h1>
    <?php if($message=='案件進捗テーブルを更新しました'){?>
      <div class="message-box"><?= $message?></div>
    <?php } ?>
    <div class="color-select">
      <form id="color-select">
        <input type="radio" name="color_select" checked>納期<span class="square red-square"></span>
        <input type="radio" name="color_select">開始日<span class="square green-square"></span>
        <input type="radio" name="color_select">取り消し<span class="square white-square"></span>
      </form>
    </div>
    <hr>
    <?= $output?>

    <script>
      newdeadline='off'
      newstartdate='off'
      //セルクリック時ラジオボタンの選択によってセルクリックの赤と緑と白を切り替える
      $('.color-mass').on('click',function(){  

        //もしラジオボタンが納期であればクリックしたセルを赤に
        if($('input[name=color_select]:eq(0)').prop('checked')){
          $(this).parent().find('.new-deadline').text('')
          $(this).parent().find('.new-deadline').removeClass('new-deadline')
          $(this).addClass('new-deadline')
          $(this).text('New')
          newdeadline='on'
        //もしラジオボタンが開始日であればクリックしたセルを緑に
        }else if($('input[name=color_select]:eq(1)').prop('checked')){
          $(this).parent().find('.new-startdate').text('')
          $(this).parent().find('.new-startdate').removeClass('new-startdate')
          $(this).addClass('new-startdate')
          $(this).text('New')
          newstartdate='on'
        //もしラジオボタンが取り消しであればクリックしたセルを取り消し
        }else if($('input[name=color_select]:eq(2)').prop('checked')){
          $(this).removeClass('new-deadline')
          $(this).removeClass('new-startdate')
          $(this).text('')
          if($(this).hasClass('new-deadline')){
            newdeadline='off'
          }
          if($(this).hasClass('new-startdate')){
            newstartdate='off'
          }
        }
        //更新用の納期と開始日を取得
        deadlineForUpdate=''
        //もし新しい納期があれば新しい納期をセット
        if(newdeadline=='on'){
          let classVal=$('.new-deadline').attr('class')
          let classVals=classVal.split(' ')
          for (var i = 0; i < classVals.length; i++) {
            deadlineForUpdate=classVals[1]
          }
          alert(deadlineForUpdate)
          $(this).parent().find('.deadlineforupdate').val(deadlineForUpdate)
        //もし新しい開始日があれば新しい開始日をセット
        }
        if(newstartdate=='on'){
          alert('b')
          let classVal=$('.new-startdate').attr('class')
          let classVals=classVal.split(' ')
          for (var i = 0; i < classVals.length; i++) {
            startdateForUpdate=classVals[1]
          }
          alert(startdateForUpdate)
          $(this).parent().find('.startdateforupdate').val(startdateForUpdate)
        }
        //もし新しい納期がなければ現在の納期をセット
        if(newdeadline=='off'){
          classVal=deadlineForUpdate=$(this).parent().find('.deadline').attr('class')
          let classVals=classVal.split(' ')
          for (var i = 0; i < classVals.length; i++) {
            deadlineForUpdate=classVals[1]
          }
          alert(deadlineForUpdate)
          $(this).parent().find('.deadlineforupdate').val(deadlineForUpdate)
        }
        //もし新しい開始日がなければ現在の開始日をセット
        if(newstartdate=='off'){
          classVal=startdateForUpdate=$(this).parent().find('.startdate').attr('class')
          let classVals=classVal.split(' ')
          for (var i = 0; i < classVals.length; i++) {
            startdateForUpdate=classVals[1]
          }
          alert(startdateForUpdate)
          $(this).parent().find('.startdateforupdate').val(startdateForUpdate)
        }
      })
    </script>
  </body>
</html>