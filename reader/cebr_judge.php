<!DOCTYPE html>
<?php session_start();
header("Content-Type: text/html; charset=utf-8");
require_once("../globefunction.php");
include_once('../mysql_connect.php');

// 讀取表單
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$language = isset($formData['language']) ? $formData['language'] : '';
$pred = isset($formData['pred']) ? $formData['pred'] : '';
$book = isset($formData['book']) ? $formData['book'] : '';
$isbn = isset($formData['isbn']) ? $formData['isbn'] : '';
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

if (isset($_GET['isbnRe'])) {
    // 確認繼續推薦中西文書籍
    $sql = "INSERT INTO `hrec_ceb` (`name`,`id`,`style`,`unit`,`email`,`language`, `pred`, `book`, `isbn`, `IntroUrl`, `reason`, `duplicate`) 
            VALUES ('$name','$uid','$style','$unit','$mail','$language', '$pred', '$book', '$isbn', '$IntroUrl', '$reason', '是')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('書刊推薦成功！');</script>";
        header("refresh:0;url=./ceb_rec.php");
    }
} else {
    // 搜尋全部中西文 isbn 資料
    $sql1 = "SELECT `isbn` FROM `hrec_ceb`;";
    $result1 = mysqli_query($con, $sql1);
    $num = mysqli_num_rows($result1);
    $t = 0;

    if ($num > 0 && isset($_POST["isbn"])) {
        while ($list = mysqli_fetch_array($result1)) {
            if ($list['isbn'] == $_POST["isbn"]) {
                $t += 1;
                break;
            }
        }

        if ($t > 0) {
            // 使用者推薦的書刊已被推薦
            echo "<script>
                var msg = '您推薦的書刊已被推薦！點擊確定繼續推薦；取消則取消推薦。';
                if (confirm(msg) == true) {
                    location.href = './cebr_judge.php?isbnRe=1';
                }
                else {
                    location.href = './ceb_rec.php';
                }
            </script>";
        } else {
            // 推薦一本新的書刊
            $sql2 = "INSERT INTO `hrec_ceb` (`name`,`id`,`style`,`unit`,`email`,`language`, `pred`, `book`, `isbn`, `IntroUrl`, `reason`, `duplicate`) 
                     VALUES ('$name','$uid','$style','$unit','$mail','$language', '$pred', '$book', '$isbn', '$IntroUrl', '$reason', '否')";

            if (mysqli_query($con, $sql2)) {
                echo "<script>alert('書刊推薦成功！');</script>";
                header("refresh:0;url=./ceb_rec.php");
            }
        }
    }
}

mysqli_close($con);
?>