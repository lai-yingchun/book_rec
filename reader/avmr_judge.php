<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("../globefunction.php");
include_once('../mysql_connect.php');

// 讀取表單
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$pred = isset($formData['pred']) ? $formData['pred'] : '';
$video = isset($formData['video']) ? $formData['video'] : '';
$auth = isset($formData['auth']) ? $formData['auth'] : '';
$publish = isset($formData['publish']) ? $formData['publish'] : '';
$IntroUrl = isset($formData['IntroUrl']) ? $formData['IntroUrl'] : '';
$reason = isset($formData['reason']) ? $formData['reason'] : '';

$userInfo = $_SESSION['user_info'];
$uid = $userInfo['uid'];
// $maskedUid = str_repeat('*', strlen($uid));
$name = $userInfo['name'];
$style = $userInfo['stlye'];
$unit = $userInfo['unit'];
$mail = $userInfo['mail'];
// $maskedEmail = str_repeat('*', strlen($mail));

// 未阻擋重複推薦
$sql = "INSERT INTO hrec_avm (`name`,`id`,`style`,`unit`,`email`,`pred`, `video`, `auth`, `publish`, `IntroUrl`, `reason`) 
        VALUES ('$name','$uid','$style','$unit','$mail','$pred', '$video', '$auth', '$publish', '$IntroUrl', '$reason')";

if (mysqli_query($con, $sql)) {
    echo "<script>alert('書刊推薦成功！');</script>";
    header("refresh:0;url=./avm_rec.php");
}

mysqli_close($con);
?>