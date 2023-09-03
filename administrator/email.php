<?php
$db_server = "localhost";
$db_name = "book_rec";
$db_user = "root";
$db_passwd = "";

$con = new mysqli($db_server, $db_user, $db_passwd, $db_name);

if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

if (isset($_GET['nos'])) {
    $nos = explode(',', $_GET['nos']); // 將逗號分割的值拆分成數組

    if (isset($_GET['source']) && $_GET['source'] === 'ceb') {
        $query = "SELECT email FROM hrec_ceb WHERE no IN (" . implode(',', $nos) . ")";
    } else if (isset($_GET['source']) && $_GET['source'] === 'avm') {
        $query = "SELECT email FROM hrec_avm WHERE no IN (" . implode(',', $nos) . ")";
    } else if (isset($_GET['source']) && $_GET['source'] === 'cj') {
        $query = "SELECT email FROM hrec_cj WHERE no IN (" . implode(',', $nos) . ")";
    } else {
        echo "無效的來源";
        exit;
    }

    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $emailList = [];
        while ($row = $result->fetch_assoc()) {
            $emailList[] = $row['email'];
        }
        echo implode("\n", $emailList); // 返回每行一個郵件地址
    } else {
        echo "郵件地址未找到";
    }
} else {
    echo "無效的編號";
}

$con->close();
?>