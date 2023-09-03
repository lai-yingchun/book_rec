<?php
$db_server = "localhost";
$db_name = "book_rec";
$db_user = "root";
$db_passwd = "";

// $con = mysqli_connect("$db_server", $db_user, $db_passwd, $db_name);

$con = new mysqli($db_server, $db_user, $db_passwd, $db_name); //對資料庫連線
if ($con->connect_error) {
    die("Connected Failed: " . $con->connect_error);
}

mysqli_set_charset($con, "utf8");

// $userkind = $_POST['userkind'];

//對資料庫連線
// if (!@mysqli_connect($db_server, $db_user, $db_passwd))
// die("無法對資料庫連線");

//資料庫連線採UTF8
// mysqli_query("SET NAMES 'utf8'");

// mysqli_set_charset($con, "utf8");

// //選擇資料庫
// if (!@mysqli_select_db($db_name))
//     die("無法使用資料庫");

// 檢查連線
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }


// 中西文圖書
// $language = $_POST["language"];
// $pred = $_POST["pred"];
// $book = $_POST["book"];
// $isbn = $_POST["isbn"];
// $IntroUrl = $_POST["IntroUrl"];
// $reason = $_POST["reason"];

if (isset($_POST['language'])) {
    $_SESSION['form_data'] = [
        'language' => $_POST['language'],
        'pred' => $_POST['pred'],
        'book' => $_POST['book'],
        'isbn' => $_POST['isbn'],
        'IntroUrl' => $_POST['IntroUrl'],
        'reason' => $_POST['reason'],
    ];

    $userInfo = $_SESSION['user_info'];
    $uid = $userInfo['uid'];
    $maskedUid = str_repeat('*', strlen($uid));
    $name = $userInfo['name'];
    $style = $userInfo['stlye'];
    $unit = $userInfo['unit'];
    $mail = $userInfo['mail'];
    // $maskedEmail = str_repeat('*', strlen($mail));
}

// 視聽資料
// $pred = $_POST["pred"];
// $video = $_POST["video"];
// $auth = $_POST["auth"];
// $publish = $_POST["publish"];
// $IntroUrl = $_POST["IntroUrl"];
// $reason = $_POST["reason"];

if (isset($_POST['video'])) {
    $_SESSION['form_data'] = [
        'pred' => $_POST['pred'],
        'video' => $_POST['video'],
        'auth' => $_POST['auth'],
        'publish' => $_POST['publish'],
        'IntroUrl' => $_POST['IntroUrl'],
        'reason' => $_POST['reason'],
    ];

    $userInfo = $_SESSION['user_info'];
    $uid = $userInfo['uid'];
    $maskedUid = str_repeat('*', strlen($uid));
    $name = $userInfo['name'];
    $style = $userInfo['stlye'];
    $unit = $userInfo['unit'];
    $mail = $userInfo['mail'];
    // $maskedEmail = str_repeat('*', strlen($mail));
}

// 中文期刊
// $title = $_POST["title"];
// $publish = $_POST["publish"];
// $publishTel = $_POST["publishTel"];
// $issn = $_POST["issn"];
// $price = $_POST["price"];
// $reason = $_POST["reason"];

if (isset($_POST['title'])) {
    $_SESSION['form_data'] = [
        'title' => $_POST['title'],
        'publish' => $_POST['publish'],
        'publishTel' => $_POST['publishTel'],
        'issn' => $_POST['issn'],
        'price' => $_POST['price'],
        'reason' => $_POST['reason'],
    ];

    $userInfo = $_SESSION['user_info'];
    $uid = $userInfo['uid'];
    $maskedUid = str_repeat('*', strlen($uid));
    $name = $userInfo['name'];
    $style = $userInfo['stlye'];
    $unit = $userInfo['unit'];
    $mail = $userInfo['mail'];
    // $maskedEmail = str_repeat('*', strlen($mail));
}
?>