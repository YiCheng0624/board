<?php
    $oLink = mysqli_connect('localhost', 'root', '','board');
    // var_dump($_POST);

    $sName=$_POST['nametext'];
    $sMessage=$_POST['messagetext'];
    // $message=$_POST['StoreMoney'];
    // echo $name;
    if (!$oLink) {
        die(' 連線失敗，輸出錯誤訊息 : ' . mysql_error());
    }
    mysqli_query($oLink,"INSERT INTO Data (Name,Message) VALUES ('$sName','$sMessage')");
    // echo json_encode(array(' 連線成功 '=>$name));
    mysqli_close($oLink);
?>