<?php
$acc = $_POST['account'];
$pwd = $_POST['password'];

$url = "https://elib.csmu.edu.tw/cgi-bin/CheckID_SchStd.cgi?id=" . urlencode($acc) . "&passwd=" . urlencode($pwd);

$response = file_get_contents($url);
$jsonResponse = json_decode($response, true); // Decode JSON as an associative array

if (isset($jsonResponse['status']) && $jsonResponse['status'] === 'success') {
    session_start();
    $_SESSION['user_account'] = $acc;
    $_SESSION['user_info'] = $jsonResponse; // 儲存整個 JSON 回應

    $userStyle = $jsonResponse['stlye'];
    $_SESSION['user_style'] = $userStyle;
    $_SESSION['user_id'] = $jsonResponse['uid'];
    $_SESSION['user_name'] = $jsonResponse['name'];

    $redirect = in_array($userStyle, ['大學生', '研究生', '教職員', '醫護人員', '其他']) ? "./reader/reader_index.php" : "./admin/admin_index.php";
    header("Location: $redirect");
    exit();
} else {
    echo '<script>alert("帳號或密碼輸入錯誤！");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}
?>