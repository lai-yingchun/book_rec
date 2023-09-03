<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("../globefunction.php");
include_once('../mysql_connect.php');

// 讀取表單
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$title = isset($formData['title']) ? $formData['title'] : '';
$publish = isset($formData['publish']) ? $formData['publish'] : '';
$publishTel = isset($formData['publishTel']) ? $formData['publishTel'] : '';
$issn = isset($formData['issn']) ? $formData['issn'] : '';
$price = isset($formData['price']) ? $formData['price'] : '';
$reason = isset($formData['reason']) ? $formData['reason'] : '';

$userInfo = $_SESSION['user_info'];
$uid = $userInfo['uid'];
// $maskedUid = str_repeat('*', strlen($uid));
$name = $userInfo['name'];
$style = $userInfo['stlye'];
$unit = $userInfo['unit'];
$mail = $userInfo['mail'];
// $maskedEmail = str_repeat('*', strlen($mail));

if (isset($_GET['issnRe'])) {
    // 確認繼續推薦中文期刊
    $sql = "INSERT INTO hrec_cj (`name`,`id`,`style`,`unit`,`email`,`title`, `publish`, `publishTel`, `issn`, `price`, `reason`, `duplicate`) 
            VALUES ('$name','$uid','$style','$unit','$mail','$title', '$publish', '$publishTel', '$issn', '$price', '$reason', '是')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('書刊推薦成功！');</script>";
        header("refresh:0;url=./cj_rec.php");
    }
} else {
    // 搜尋全部中文期刊 issn 資料
    $sql1 = "SELECT `issn` FROM `hrec_cj`;";
    $result1 = mysqli_query($con, $sql1);
    $num = mysqli_num_rows($result1);
    $t = 0;

    if ($num > 0 && isset($_POST["issn"])) {
        while ($list = mysqli_fetch_array($result1)) {
            if ($list['issn'] == $_POST["issn"]) {
                $t += 1;
                break;
            }
        }

        if ($t > 0) {
            // 使用者推薦的書刊已被推薦
            echo "<script>
                var msg = '您推薦的書刊已被推薦！點擊確定繼續推薦；取消則取消推薦。';
                if (confirm(msg) == true) {
                    location.href = './cjr_judge.php?issnRe=1';
                }
                else {
                    location.href = './cj_rec.php';
                }
            </script>";
        } else {
            // 推薦一本新的書刊
            $sql2 = "INSERT INTO hrec_cj (`name`,`id`,`style`,`unit`,`email`,`title`, `publish`, `publishTel`, `issn`, `price`, `reason`, `duplicate`) 
                     VALUES ('$name','$uid','$style','$unit','$mail','$title','$publish', '$publishTel', '$issn', '$price', '$reason', '否')";

            if (mysqli_query($con, $sql2)) {
                echo "<script>alert('書刊推薦成功！');</script>";
                header("refresh:0;url=./cj_rec.php");
            }
        }
    }
}

mysqli_close($con);
?>