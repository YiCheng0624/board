<?php
$oLink = mysqli_connect('localhost', 'root', '', 'board');
$iId = $_POST['deleteID'];
if (!$oLink) {
    die(' 連線失敗，輸出錯誤訊息 : ' . mysql_error());
}
mysqli_query($oLink, "Delete from Data where id=$iId");
mysqli_close($oLink);
// echo json_encode(array(' 連線成功 '=>"fff"));
