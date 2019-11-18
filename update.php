<?php
$oLink = mysqli_connect('localhost', 'root', '', 'board');
if (!$oLink) {
    die(' 連線失敗，輸出錯誤訊息 : ' . mysql_error());
}
$iId = $_POST['updateID'];

if(isset($_POST["show"])) {
    // $needName=123;
    $oSelectName = mysqli_query($oLink, "SELECT Name from data where id=$iId");
    $aNeedname = mysqli_fetch_array($oSelectName);
    $oSelectMessage = mysqli_query($oLink, "SELECT Message from data where id=$iId");
    $aNeedmessage = mysqli_fetch_array($oSelectMessage);
    // $test=gettype($needname);
    echo json_encode(array('dataname' => $aNeedname['Name'], 'datamessage' => $aNeedmessage['Message']));
}
if (isset($_POST['NewName'])) {
    $sName = $_POST['NewName'];
    $sMessage = $_POST['NewMessage'];

    mysqli_query($oLink, "update data set Name='$sName',Message='$sMessage' where id=$iId");
}
mysqli_close($oLink);
