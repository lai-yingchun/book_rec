<?php
session_start();
require_once("../mysql_connect.php");

// 檢查參數以確定查詢哪個部分
$section = isset($_GET['section']) ? $_GET['section'] : '';
$language = isset($_GET['language']) ? $_GET['language'] : '';
$statue = isset($_GET['statue']) ? $_GET['statue'] : '';

switch ($section . '_' . $language . '_' . $statue) {
    case 'ceb_pending__':
    case 'ceb_pending_中文_':
    case 'ceb_pending_西文_':
        $table = 'hrec_ceb';
        $title = '中西文圖書待處理推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '中西文', '書名', 'ISBN', '作者', '出版社', '版本', '年份', '價格', '網址', '預約', '重複');
        break;
    case 'ceb_history__':
    case 'ceb_history_中文_':
    case 'ceb_history_西文_':
    case 'ceb_history__待處理':
    case 'ceb_history__未採購':
    case 'ceb_history__採購中':
    case 'ceb_history__編目中':
    case 'ceb_history__已上架':
        $table = 'hrec_ceb';
        $title = '中西文圖書歷史推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '中西文', '書名', 'ISBN', '作者', '出版社', '版本', '年份', '價格', '網址', '預約', '採購狀況', '重複');
        break;
    case 'avm_pending__':
        $table = 'hrec_avm';
        $title = '視聽資料待處理推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '視聽名稱', '作者', '出版社', '版本', '年份', '價格', '網址', '預約', '重複');
        break;
    case 'avm_history__':
    case 'avm_history__待處理':
    case 'avm_history__未採購':
    case 'avm_history__採購中':
    case 'avm_history__編目中':
    case 'avm_history__已上架':
        $table = 'hrec_avm';
        $title = '視聽資料歷史推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '視聽名稱', '作者', '出版社', '版本', '年份', '價格', '網址', '預約', '採購狀況', '重複');
        break;
    case 'cj_pending__':
        $table = 'hrec_cj';
        $title = '中文期刊待處理推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '期刊名稱', 'ISSN', '出版社電話', '出版社', '價格', '網址', '預約', '重複');
        break;
    case 'cj_history__':
    case 'cj_history__待處理':
    case 'cj_history__未採購':
    case 'cj_history__採購中':
    case 'cj_history__編目中':
    case 'cj_history__已上架':
        $table = 'hrec_cj';
        $title = '中文期刊歷史推薦清單';
        $columns = array('編號', '推薦日期', '推薦人', '期刊名稱', 'ISSN', '出版社電話', '出版社', '價格', '網址', '預約', '採購狀況', '重複');
        break;
    default:
        echo '下載失敗！';
        exit();
}

$pending_query = "SELECT date, name, ";
if ($section === 'ceb_pending' && $language === '' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, duplicate FROM $table WHERE situation like '待處理' and empty like '否' ORDER BY date DESC";
} else if ($section === 'ceb_pending' && $language === '中文' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, duplicate FROM $table WHERE language like '中文' and situation like '待處理' and empty like '否' ORDER BY date DESC";
} else if ($section === 'ceb_pending' && $language === '西文' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, duplicate FROM $table WHERE language like '西文' and situation like '待處理' and empty like '否' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '中文' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE language like '中文' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '西文' && $statue === '') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE language like '西文' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '待處理') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '待處理' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '未採購') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '未採購' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '採購中') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '採購中' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '編目中') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '編目中' ORDER BY date DESC";
} else if ($section === 'ceb_history' && $language === '' && $statue === '已上架') {
    $pending_query .= "language, book, isbn, auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '已上架' ORDER BY date DESC";
} else if ($section === 'avm_pending' && $language === '' && $statue === '') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, duplicate FROM $table WHERE situation like '待處理' and empty like '否' ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '待處理') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '待處理' ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '未採購') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '未採購' ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '採購中') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '採購中' ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '編目中') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '編目中' ORDER BY date DESC";
} else if ($section === 'avm_history' && $language === '' && $statue === '已上架') {
    $pending_query .= "video,  auth, publish, version, year, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '已上架' ORDER BY date DESC";
} else if ($section === 'cj_pending' && $language === '' && $statue === '') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, duplicate FROM $table WHERE situation like '待處理' and empty like '否' ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '待處理') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '待處理' ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '未採購') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '未採購' ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '採購中') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '採購中' ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '編目中') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '編目中' ORDER BY date DESC";
} else if ($section === 'cj_history' && $language === '' && $statue === '已上架') {
    $pending_query .= "title, issn, publishTel, publish, price, IntroUrl, pred, situation, duplicate FROM $table WHERE situation like '已上架' ORDER BY date DESC";
}
$pending = $con->query($pending_query);

if (!$pending) {
    printf("錯誤：%s\n", mysqli_error($con));
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="download.csv"');

$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // 添加BOM以確保UTF-8編碼
fputcsv($output, $columns);

$counter = 1; // 自動編號

while ($row = $pending->fetch_assoc()) {
    // 防止excel格式化
    $row['date'] = "'" . $row['date'];
    $row['price'] = "$" . $row['price'];
    if ($section === 'ceb_pending') {
        $row['isbn'] = "'" . $row['isbn'];
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['language'],
            $row['book'],
            $row['isbn'],
            $row['auth'],
            $row['publish'],
            $row['version'],
            $row['year'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['duplicate']
        );
    } else if ($section === 'avm_pending') {
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['video'],
            $row['auth'],
            $row['publish'],
            $row['version'],
            $row['year'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['duplicate']
        );
    } else if ($section === 'cj_pending') {
        $row['issn'] = "'" . $row['issn'];
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['title'],
            $row['issn'],
            $row['publishTel'],
            $row['publish'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['duplicate']
        );
    } else if ($section === 'ceb_history') {
        $row['isbn'] = "'" . $row['isbn'];
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['language'],
            $row['book'],
            $row['isbn'],
            $row['auth'],
            $row['publish'],
            $row['version'],
            $row['year'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['situation'],
            $row['duplicate']
        );
    } else if ($section === 'avm_history') {
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['video'],
            $row['auth'],
            $row['publish'],
            $row['version'],
            $row['year'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['situation'],
            $row['duplicate']
        );
    } else if ($section === 'cj_history') {
        $row['issn'] = "'" . $row['issn'];
        $escaped_row = array(
            $counter,
            $row['date'],
            $row['name'],
            $row['title'],
            $row['issn'],
            $row['publishTel'],
            $row['publish'],
            $row['price'],
            $row['IntroUrl'],
            $row['pred'],
            $row['situation'],
            $row['duplicate']
        );
    }

    fputcsv($output, $escaped_row);

    $counter++;
}

fclose($output);
?>