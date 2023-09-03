<!DOCTYPE html>
<?php session_start();
require_once("../globefunction.php");
include_once('../mysql_connect.php');

// 中西文圖書_依職位統計之SQL
$query1 = "SELECT user_style.style as style, COUNT(id) as count_ceb FROM hrec_ceb RIGHT OUTER JOIN user_style ON hrec_ceb.style = user_style.style";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1 = $query1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    } else {
        $query1 = $query1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    }
} else {
    $query1 = $query1 . " GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
}

$result1 = $con->query($query1);
$count_ceb = array();
$styleName1 = array();

while ($row1 = mysqli_fetch_assoc($result1)) {
    $count_ceb[] = $row1['count_ceb'];
    $styleName1[] = $row1['style'];
}
if (!$result1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位(系所名稱擷取)統計之SQL(大學生)
$query1_1 = "SELECT user_depart.dep as department, COUNT(H.id) as count_ceb_1 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生') as H RIGHT OUTER JOIN user_depart ON SUBSTRING(H.unit, 1, 3) = user_depart.dep";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1 = $query1_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query1_1 = $query1_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query1_1 = $query1_1 . " GROUP BY department ORDER BY department";
}

$result1_1 = $con->query($query1_1);
$count_ceb_1 = array();
$styleName1_1 = array();

while ($row1_1 = mysqli_fetch_assoc($result1_1)) {
    $count_ceb_1[] = $row1_1['count_ceb_1'];
    $styleName1_1[] = $row1_1['department'];
}
if (!$result1_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(健產系)統計之SQL(大學生)
$query1_1_1 = "SELECT grade, COUNT(H.id) as count_ceb_1_1 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '健產系%') as H RIGHT OUTER JOIN depart_healthIndustryTechnologyManagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_1 = $query1_1_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    } else {
        $query1_1_1 = $query1_1_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    }
} else {
    $query1_1_1 = $query1_1_1 . " GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
}

$result1_1_1 = $con->query($query1_1_1);
$count_ceb_1_1 = array();
$styleName1_1_1 = array();

while ($row1_1_1 = mysqli_fetch_assoc($result1_1_1)) {
    $count_ceb_1_1[] = $row1_1_1['count_ceb_1_1'];
    $styleName1_1_1[] = $row1_1_1['grade'];
}
if (!$result1_1_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(公衛系)統計之SQL(大學生)
$query1_1_2 = "SELECT grade, COUNT(H.id) as count_ceb_1_2 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '公衛系%') as H RIGHT OUTER JOIN depart_publichealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_2 = $query1_1_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    } else {
        $query1_1_2 = $query1_1_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    }
} else {
    $query1_1_2 = $query1_1_2 . " GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
}

$result1_1_2 = $con->query($query1_1_2);
$count_ceb_1_2 = array();
$styleName1_1_2 = array();

while ($row1_1_2 = mysqli_fetch_assoc($result1_1_2)) {
    $count_ceb_1_2[] = $row1_1_2['count_ceb_1_2'];
    $styleName1_1_2[] = $row1_1_2['grade'];
}
if (!$result1_1_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(心理系)統計之SQL(大學生)
$query1_1_3 = "SELECT grade, COUNT(H.id) as count_ceb_1_3 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '心理系%') as H RIGHT OUTER JOIN depart_psychology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_3 = $query1_1_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    } else {
        $query1_1_3 = $query1_1_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    }
} else {
    $query1_1_3 = $query1_1_3 . " GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
}

$result1_1_3 = $con->query($query1_1_3);
$count_ceb_1_3 = array();
$styleName1_1_3 = array();

while ($row1_1_3 = mysqli_fetch_assoc($result1_1_3)) {
    $count_ceb_1_3[] = $row1_1_3['count_ceb_1_3'];
    $styleName1_1_3[] = $row1_1_3['grade'];
}
if (!$result1_1_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(應外系)統計之SQL(大學生)
$query1_1_4 = "SELECT grade, COUNT(H.id) as count_ceb_1_4 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '應外系%') as H RIGHT OUTER JOIN depart_appliedforeignlinguistics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_4 = $query1_1_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    } else {
        $query1_1_4 = $query1_1_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    }
} else {
    $query1_1_4 = $query1_1_4 . " GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
}

$result1_1_4 = $con->query($query1_1_4);
$count_ceb_1_4 = array();
$styleName1_1_4 = array();

while ($row1_1_4 = mysqli_fetch_assoc($result1_1_4)) {
    $count_ceb_1_4[] = $row1_1_4['count_ceb_1_4'];
    $styleName1_1_4[] = $row1_1_4['grade'];
}
if (!$result1_1_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(營養系)統計之SQL(大學生)
$query1_1_5 = "SELECT grade, COUNT(H.id) as count_ceb_1_5 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '營養系%') as H RIGHT OUTER JOIN depart_nutrition ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_5 = $query1_1_5 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    } else {
        $query1_1_5 = $query1_1_5 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    }
} else {
    $query1_1_5 = $query1_1_5 . " GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
}

$result1_1_5 = $con->query($query1_1_5);
$count_ceb_1_5 = array();
$styleName1_1_5 = array();

while ($row1_1_5 = mysqli_fetch_assoc($result1_1_5)) {
    $count_ceb_1_5[] = $row1_1_5['count_ceb_1_5'];
    $styleName1_1_5[] = $row1_1_5['grade'];
}
if (!$result1_1_5) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(牙醫系)統計之SQL(大學生)
$query1_1_6 = "SELECT grade, COUNT(H.id) as count_ceb_1_6 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '牙醫系%') as H RIGHT OUTER JOIN depart_dentistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_6 = $query1_1_6 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    } else {
        $query1_1_6 = $query1_1_6 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    }
} else {
    $query1_1_6 = $query1_1_6 . " GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
}

$result1_1_6 = $con->query($query1_1_6);
$count_ceb_1_6 = array();
$styleName1_1_6 = array();

while ($row1_1_6 = mysqli_fetch_assoc($result1_1_6)) {
    $count_ceb_1_6[] = $row1_1_6['count_ceb_1_6'];
    $styleName1_1_6[] = $row1_1_6['grade'];
}
if (!$result1_1_6) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(物治系)統計之SQL(大學生)
$query1_1_7 = "SELECT grade, COUNT(H.id) as count_ceb_1_7 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '物治系%') as H RIGHT OUTER JOIN depart_physicaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_7 = $query1_1_7 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    } else {
        $query1_1_7 = $query1_1_7 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    }
} else {
    $query1_1_7 = $query1_1_7 . " GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
}

$result1_1_7 = $con->query($query1_1_7);
$count_ceb_1_7 = array();
$styleName1_1_7 = array();

while ($row1_1_7 = mysqli_fetch_assoc($result1_1_7)) {
    $count_ceb_1_7[] = $row1_1_7['count_ceb_1_7'];
    $styleName1_1_7[] = $row1_1_7['grade'];
}
if (!$result1_1_7) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(生醫系)統計之SQL(大學生)
$query1_1_8 = "SELECT grade, COUNT(H.id) as count_ceb_1_8 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '生醫系%') as H RIGHT OUTER JOIN depart_biomedicalscience ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_8 = $query1_1_8 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    } else {
        $query1_1_8 = $query1_1_8 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    }
} else {
    $query1_1_8 = $query1_1_8 . " GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
}

$result1_1_8 = $con->query($query1_1_8);
$count_ceb_1_8 = array();
$styleName1_1_8 = array();

while ($row1_1_8 = mysqli_fetch_assoc($result1_1_8)) {
    $count_ceb_1_8[] = $row1_1_8['count_ceb_1_8'];
    $styleName1_1_8[] = $row1_1_8['grade'];
}
if (!$result1_1_8) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(職安系)統計之SQL(大學生)
$query1_1_9 = "SELECT grade, COUNT(H.id) as count_ceb_1_9 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '職安系%') as H RIGHT OUTER JOIN depart_occupationalsafetyhealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_9 = $query1_1_9 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    } else {
        $query1_1_9 = $query1_1_9 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    }
} else {
    $query1_1_9 = $query1_1_9 . " GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
}

$result1_1_9 = $con->query($query1_1_9);
$count_ceb_1_9 = array();
$styleName1_1_9 = array();

while ($row1_1_9 = mysqli_fetch_assoc($result1_1_9)) {
    $count_ceb_1_9[] = $row1_1_9['count_ceb_1_9'];
    $styleName1_1_9[] = $row1_1_9['grade'];
}
if (!$result1_1_9) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(職治系)統計之SQL(大學生)
$query1_1_10 = "SELECT grade, COUNT(H.id) as count_ceb_1_10 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '職治系%') as H RIGHT OUTER JOIN depart_occupationaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_10 = $query1_1_10 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    } else {
        $query1_1_10 = $query1_1_10 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    }
} else {
    $query1_1_10 = $query1_1_10 . " GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
}

$result1_1_10 = $con->query($query1_1_10);
$count_ceb_1_10 = array();
$styleName1_1_10 = array();

while ($row1_1_10 = mysqli_fetch_assoc($result1_1_10)) {
    $count_ceb_1_10[] = $row1_1_10['count_ceb_1_10'];
    $styleName1_1_10[] = $row1_1_10['grade'];
}
if (!$result1_1_10) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(視光系)統計之SQL(大學生)
$query1_1_11 = "SELECT grade, COUNT(H.id) as count_ceb_1_11 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '視光系%') as H RIGHT OUTER JOIN depart_optometry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_11 = $query1_1_11 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    } else {
        $query1_1_11 = $query1_1_11 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    }
} else {
    $query1_1_11 = $query1_1_11 . " GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
}

$result1_1_11 = $con->query($query1_1_11);
$count_ceb_1_11 = array();
$styleName1_1_11 = array();

while ($row1_1_11 = mysqli_fetch_assoc($result1_1_11)) {
    $count_ceb_1_11[] = $row1_1_11['count_ceb_1_11'];
    $styleName1_1_11[] = $row1_1_11['grade'];
}
if (!$result1_1_11) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(語聽系)統計之SQL(大學生)
$query1_1_12 = "SELECT grade, COUNT(H.id) as count_ceb_1_12 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '語聽系%') as H RIGHT OUTER JOIN depart_speechtherapyaudiology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_12 = $query1_1_12 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    } else {
        $query1_1_12 = $query1_1_12 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    }
} else {
    $query1_1_12 = $query1_1_12 . " GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
}

$result1_1_12 = $con->query($query1_1_12);
$count_ceb_1_12 = array();
$styleName1_1_12 = array();

while ($row1_1_12 = mysqli_fetch_assoc($result1_1_12)) {
    $count_ceb_1_12[] = $row1_1_12['count_ceb_1_12'];
    $styleName1_1_12[] = $row1_1_12['grade'];
}
if (!$result1_1_12) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(護理系)統計之SQL(大學生)
$query1_1_13 = "SELECT grade, COUNT(H.id) as count_ceb_1_13 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '護理系%') as H RIGHT OUTER JOIN depart_nursing ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_13 = $query1_1_13 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    } else {
        $query1_1_13 = $query1_1_13 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    }
} else {
    $query1_1_13 = $query1_1_13 . " GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
}

$result1_1_13 = $con->query($query1_1_13);
$count_ceb_1_13 = array();
$styleName1_1_13 = array();

while ($row1_1_13 = mysqli_fetch_assoc($result1_1_13)) {
    $count_ceb_1_13[] = $row1_1_13['count_ceb_1_13'];
    $styleName1_1_13[] = $row1_1_13['grade'];
}
if (!$result1_1_13) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫化系)統計之SQL(大學生)
$query1_1_14 = "SELECT grade, COUNT(H.id) as count_ceb_1_14 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫化系%') as H RIGHT OUTER JOIN depart_medicalappliedchemistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_14 = $query1_1_14 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    } else {
        $query1_1_14 = $query1_1_14 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    }
} else {
    $query1_1_14 = $query1_1_14 . " GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
}

$result1_1_14 = $con->query($query1_1_14);
$count_ceb_1_14 = array();
$styleName1_1_14 = array();

while ($row1_1_14 = mysqli_fetch_assoc($result1_1_14)) {
    $count_ceb_1_14[] = $row1_1_14['count_ceb_1_14'];
    $styleName1_1_14[] = $row1_1_14['grade'];
}
if (!$result1_1_14) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫學系)統計之SQL(大學生)
$query1_1_15 = "SELECT grade, COUNT(H.id) as count_ceb_1_15 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫學系%') as H RIGHT OUTER JOIN depart_medicine ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_15 = $query1_1_15 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    } else {
        $query1_1_15 = $query1_1_15 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    }
} else {
    $query1_1_15 = $query1_1_15 . " GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
}

$result1_1_15 = $con->query($query1_1_15);
$count_ceb_1_15 = array();
$styleName1_1_15 = array();

while ($row1_1_15 = mysqli_fetch_assoc($result1_1_15)) {
    $count_ceb_1_15[] = $row1_1_15['count_ceb_1_15'];
    $styleName1_1_15[] = $row1_1_15['grade'];
}
if (!$result1_1_15) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫影系)統計之SQL(大學生)
$query1_1_16 = "SELECT grade, COUNT(H.id) as count_ceb_1_16 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫影系%') as H RIGHT OUTER JOIN depart_medicalimagingradiologicalsciences ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_16 = $query1_1_16 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    } else {
        $query1_1_16 = $query1_1_16 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    }
} else {
    $query1_1_16 = $query1_1_16 . " GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
}

$result1_1_16 = $con->query($query1_1_16);
$count_ceb_1_16 = array();
$styleName1_1_16 = array();

while ($row1_1_16 = mysqli_fetch_assoc($result1_1_16)) {
    $count_ceb_1_16[] = $row1_1_16['count_ceb_1_16'];
    $styleName1_1_16[] = $row1_1_16['grade'];
}
if (!$result1_1_16) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫技系)統計之SQL(大學生)
$query1_1_17 = "SELECT grade, COUNT(H.id) as count_ceb_1_17 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫技系%') as H RIGHT OUTER JOIN depart_medicallaboratorybiotechnology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_17 = $query1_1_17 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    } else {
        $query1_1_17 = $query1_1_17 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    }
} else {
    $query1_1_17 = $query1_1_17 . " GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
}

$result1_1_17 = $con->query($query1_1_17);
$count_ceb_1_17 = array();
$styleName1_1_17 = array();

while ($row1_1_17 = mysqli_fetch_assoc($result1_1_17)) {
    $count_ceb_1_17[] = $row1_1_17['count_ceb_1_17'];
    $styleName1_1_17[] = $row1_1_17['grade'];
}
if (!$result1_1_17) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫社系)統計之SQL(大學生)
$query1_1_18 = "SELECT grade, COUNT(H.id) as count_ceb_1_18 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫社系%') as H RIGHT OUTER JOIN depart_medicalsocietysocialwork ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_18 = $query1_1_18 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    } else {
        $query1_1_18 = $query1_1_18 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    }
} else {
    $query1_1_18 = $query1_1_18 . " GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
}

$result1_1_18 = $con->query($query1_1_18);
$count_ceb_1_18 = array();
$styleName1_1_18 = array();

while ($row1_1_18 = mysqli_fetch_assoc($result1_1_18)) {
    $count_ceb_1_18[] = $row1_1_18['count_ceb_1_18'];
    $styleName1_1_18[] = $row1_1_18['grade'];
}
if (!$result1_1_18) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫管系)統計之SQL(大學生)
$query1_1_19 = "SELECT grade, COUNT(H.id) as count_ceb_1_19 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫管系%') as H RIGHT OUTER JOIN depart_medicalindustrytechnologymanagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_19 = $query1_1_19 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
    } else {
        $query1_1_19 = $query1_1_19 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
    }
} else {
    $query1_1_19 = $query1_1_19 . " GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
}

$result1_1_19 = $con->query($query1_1_19);
$count_ceb_1_19 = array();
$styleName1_1_19 = array();

while ($row1_1_19 = mysqli_fetch_assoc($result1_1_19)) {
    $count_ceb_1_19[] = $row1_1_19['count_ceb_1_19'];
    $styleName1_1_19[] = $row1_1_19['grade'];
}
if (!$result1_1_19) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依特定系所(醫資系)統計之SQL(大學生)
$query1_1_20 = "SELECT grade, COUNT(H.id) as count_ceb_1_20 FROM ( SELECT unit, id, date FROM hrec_ceb WHERE style = '大學生' and  unit like '醫資系%') as H RIGHT OUTER JOIN depart_medicalinformatics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_1_20 = $query1_1_20 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    } else {
        $query1_1_20 = $query1_1_20 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    }
} else {
    $query1_1_20 = $query1_1_20 . " GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
}

$result1_1_20 = $con->query($query1_1_20);
$count_ceb_1_20 = array();
$styleName1_1_20 = array();

while ($row1_1_20 = mysqli_fetch_assoc($result1_1_20)) {
    $count_ceb_1_20[] = $row1_1_20['count_ceb_1_20'];
    $styleName1_1_20[] = $row1_1_20['grade'];
}
if (!$result1_1_20) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位(系所名稱擷取)統計之SQL(研究生)
$query1_2 = "SELECT SUBSTRING_INDEX(unit, '碩', 1) as department, COUNT(id) as count_ceb_2 FROM hrec_ceb WHERE style = '研究生'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_2 = $query1_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query1_2 = $query1_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query1_2 = $query1_2 . " GROUP BY department ORDER BY department";
}

$result1_2 = $con->query($query1_2);
$count_ceb_2 = array();
$styleName1_2 = array();

while ($row1_2 = mysqli_fetch_assoc($result1_2)) {
    $count_ceb_2[] = $row1_2['count_ceb_2'];
    $styleName1_2[] = $row1_2['department'];
}
if (!$result1_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(教職員)
$query1_3 = "SELECT unit, COUNT(id) as count_ceb_3 FROM hrec_ceb WHERE style = '教職員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_3 = $query1_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_3 = $query1_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_3 = $query1_3 . " GROUP BY unit ORDER BY unit";
}

$result1_3 = $con->query($query1_3);
$count_ceb_3 = array();
$styleName1_3 = array();

while ($row1_3 = mysqli_fetch_assoc($result1_3)) {
    $count_ceb_3[] = $row1_3['count_ceb_3'];
    $styleName1_3[] = $row1_3['unit'];
}
if (!$result1_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中西文圖書_依單位統計之SQL(醫護人員)
$query1_4 = "SELECT unit, COUNT(id) as count_ceb_4 FROM hrec_ceb WHERE style = '醫護人員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query1_4 = $query1_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query1_4 = $query1_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query1_4 = $query1_4 . " GROUP BY unit ORDER BY unit";
}

$result1_4 = $con->query($query1_4);
$count_ceb_4 = array();
$styleName1_4 = array();

while ($row1_4 = mysqli_fetch_assoc($result1_4)) {
    $count_ceb_4[] = $row1_4['count_ceb_4'];
    $styleName1_4[] = $row1_4['unit'];
}
if (!$result1_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依職位統計之SQL
$query2 = "SELECT user_style.style as style, COUNT(id) as count_avm FROM hrec_avm RIGHT OUTER JOIN user_style ON hrec_avm.style = user_style.style";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2 = $query2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    } else {
        $query2 = $query2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    }
} else {
    $query2 = $query2 . " GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
}

$result2 = $con->query($query2);
$count_avm = array();
$styleName2 = array();

while ($row2 = mysqli_fetch_assoc($result2)) {
    $count_avm[] = $row2['count_avm'];
    $styleName2[] = $row2['style'];
}
if (!$result2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位(系所名稱擷取)統計之SQL(大學生)
$query2_1 = "SELECT user_depart.dep as department, COUNT(H.id) as count_avm_1 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生') as H RIGHT OUTER JOIN user_depart ON SUBSTRING(H.unit, 1, 3) = user_depart.dep";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1 = $query2_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query2_1 = $query2_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query2_1 = $query2_1 . " GROUP BY department ORDER BY department";
}

$result2_1 = $con->query($query2_1);
$count_avm_1 = array();
$styleName2_1 = array();

while ($row2_1 = mysqli_fetch_assoc($result2_1)) {
    $count_avm_1[] = $row2_1['count_avm_1'];
    $styleName2_1[] = $row2_1['department'];
}
if (!$result2_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(健產系)統計之SQL(大學生)
$query2_1_1 = "SELECT grade, COUNT(H.id) as count_avm_1_1 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '健產系%') as H RIGHT OUTER JOIN depart_healthIndustryTechnologyManagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_1 = $query2_1_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    } else {
        $query2_1_1 = $query2_1_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    }
} else {
    $query2_1_1 = $query2_1_1 . " GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
}

$result2_1_1 = $con->query($query2_1_1);
$count_avm_1_1 = array();
$styleName2_1_1 = array();

while ($row2_1_1 = mysqli_fetch_assoc($result2_1_1)) {
    $count_avm_1_1[] = $row2_1_1['count_avm_1_1'];
    $styleName2_1_1[] = $row2_1_1['grade'];
}
if (!$result2_1_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(公衛系)統計之SQL(大學生)
$query2_1_2 = "SELECT grade, COUNT(H.id) as count_avm_1_2 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '公衛系%') as H RIGHT OUTER JOIN depart_publichealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_2 = $query2_1_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    } else {
        $query2_1_2 = $query2_1_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    }
} else {
    $query2_1_2 = $query2_1_2 . " GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
}

$result2_1_2 = $con->query($query2_1_2);
$count_avm_1_2 = array();
$styleName2_1_2 = array();

while ($row2_1_2 = mysqli_fetch_assoc($result2_1_2)) {
    $count_avm_1_2[] = $row2_1_2['count_avm_1_2'];
    $styleName2_1_2[] = $row2_1_2['grade'];
}
if (!$result2_1_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(心理系)統計之SQL(大學生)
$query2_1_3 = "SELECT grade, COUNT(H.id) as count_avm_1_3 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '心理系%') as H RIGHT OUTER JOIN depart_psychology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_3 = $query2_1_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    } else {
        $query2_1_3 = $query2_1_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    }
} else {
    $query2_1_3 = $query2_1_3 . " GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
}

$result2_1_3 = $con->query($query2_1_3);
$count_avm_1_3 = array();
$styleName2_1_3 = array();

while ($row2_1_3 = mysqli_fetch_assoc($result2_1_3)) {
    $count_avm_1_3[] = $row2_1_3['count_avm_1_3'];
    $styleName2_1_3[] = $row2_1_3['grade'];
}
if (!$result2_1_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(應外系)統計之SQL(大學生)
$query2_1_4 = "SELECT grade, COUNT(H.id) as count_avm_1_4 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '應外系%') as H RIGHT OUTER JOIN depart_appliedforeignlinguistics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_4 = $query2_1_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    } else {
        $query2_1_4 = $query2_1_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    }
} else {
    $query2_1_4 = $query2_1_4 . " GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
}

$result2_1_4 = $con->query($query2_1_4);
$count_avm_1_4 = array();
$styleName2_1_4 = array();

while ($row2_1_4 = mysqli_fetch_assoc($result2_1_4)) {
    $count_avm_1_4[] = $row2_1_4['count_avm_1_4'];
    $styleName2_1_4[] = $row2_1_4['grade'];
}
if (!$result2_1_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(營養系)統計之SQL(大學生)
$query2_1_5 = "SELECT grade, COUNT(H.id) as count_avm_1_5 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '營養系%') as H RIGHT OUTER JOIN depart_nutrition ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_5 = $query2_1_5 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    } else {
        $query2_1_5 = $query2_1_5 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    }
} else {
    $query2_1_5 = $query2_1_5 . " GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
}

$result2_1_5 = $con->query($query2_1_5);
$count_avm_1_5 = array();
$styleName2_1_5 = array();

while ($row2_1_5 = mysqli_fetch_assoc($result2_1_5)) {
    $count_avm_1_5[] = $row2_1_5['count_avm_1_5'];
    $styleName2_1_5[] = $row2_1_5['grade'];
}
if (!$result2_1_5) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(牙醫系)統計之SQL(大學生)
$query2_1_6 = "SELECT grade, COUNT(H.id) as count_avm_1_6 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '牙醫系%') as H RIGHT OUTER JOIN depart_dentistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_6 = $query2_1_6 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    } else {
        $query2_1_6 = $query2_1_6 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    }
} else {
    $query2_1_6 = $query2_1_6 . " GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
}

$result2_1_6 = $con->query($query2_1_6);
$count_avm_1_6 = array();
$styleName2_1_6 = array();

while ($row2_1_6 = mysqli_fetch_assoc($result2_1_6)) {
    $count_avm_1_6[] = $row2_1_6['count_avm_1_6'];
    $styleName2_1_6[] = $row2_1_6['grade'];
}
if (!$result2_1_6) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(物治系)統計之SQL(大學生)
$query2_1_7 = "SELECT grade, COUNT(H.id) as count_avm_1_7 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '物治系%') as H RIGHT OUTER JOIN depart_physicaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_7 = $query2_1_7 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    } else {
        $query2_1_7 = $query2_1_7 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    }
} else {
    $query2_1_7 = $query2_1_7 . " GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
}

$result2_1_7 = $con->query($query2_1_7);
$count_avm_1_7 = array();
$styleName2_1_7 = array();

while ($row2_1_7 = mysqli_fetch_assoc($result2_1_7)) {
    $count_avm_1_7[] = $row2_1_7['count_avm_1_7'];
    $styleName2_1_7[] = $row2_1_7['grade'];
}
if (!$result2_1_7) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(生醫系)統計之SQL(大學生)
$query2_1_8 = "SELECT grade, COUNT(H.id) as count_avm_1_8 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '生醫系%') as H RIGHT OUTER JOIN depart_biomedicalscience ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_8 = $query2_1_8 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    } else {
        $query2_1_8 = $query2_1_8 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    }
} else {
    $query2_1_8 = $query2_1_8 . " GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
}

$result2_1_8 = $con->query($query2_1_8);
$count_avm_1_8 = array();
$styleName2_1_8 = array();

while ($row2_1_8 = mysqli_fetch_assoc($result2_1_8)) {
    $count_avm_1_8[] = $row2_1_8['count_avm_1_8'];
    $styleName2_1_8[] = $row2_1_8['grade'];
}
if (!$result2_1_8) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(職安系)統計之SQL(大學生)
$query2_1_9 = "SELECT grade, COUNT(H.id) as count_avm_1_9 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '職安系%') as H RIGHT OUTER JOIN depart_occupationalsafetyhealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_9 = $query2_1_9 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    } else {
        $query2_1_9 = $query2_1_9 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    }
} else {
    $query2_1_9 = $query2_1_9 . " GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
}

$result2_1_9 = $con->query($query2_1_9);
$count_avm_1_9 = array();
$styleName2_1_9 = array();

while ($row2_1_9 = mysqli_fetch_assoc($result2_1_9)) {
    $count_avm_1_9[] = $row2_1_9['count_avm_1_9'];
    $styleName2_1_9[] = $row2_1_9['grade'];
}
if (!$result2_1_9) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(職治系)統計之SQL(大學生)
$query2_1_10 = "SELECT grade, COUNT(H.id) as count_avm_1_10 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '職治系%') as H RIGHT OUTER JOIN depart_occupationaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_10 = $query2_1_10 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    } else {
        $query2_1_10 = $query2_1_10 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    }
} else {
    $query2_1_10 = $query2_1_10 . " GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
}

$result2_1_10 = $con->query($query2_1_10);
$count_avm_1_10 = array();
$styleName2_1_10 = array();

while ($row2_1_10 = mysqli_fetch_assoc($result2_1_10)) {
    $count_avm_1_10[] = $row2_1_10['count_avm_1_10'];
    $styleName2_1_10[] = $row2_1_10['grade'];
}
if (!$result2_1_10) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(視光系)統計之SQL(大學生)
$query2_1_11 = "SELECT grade, COUNT(H.id) as count_avm_1_11 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '視光系%') as H RIGHT OUTER JOIN depart_optometry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_11 = $query2_1_11 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    } else {
        $query2_1_11 = $query2_1_11 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    }
} else {
    $query2_1_11 = $query2_1_11 . " GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
}

$result2_1_11 = $con->query($query2_1_11);
$count_avm_1_11 = array();
$styleName2_1_11 = array();

while ($row2_1_11 = mysqli_fetch_assoc($result2_1_11)) {
    $count_avm_1_11[] = $row2_1_11['count_avm_1_11'];
    $styleName2_1_11[] = $row2_1_11['grade'];
}
if (!$result2_1_11) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(語聽系)統計之SQL(大學生)
$query2_1_12 = "SELECT grade, COUNT(H.id) as count_avm_1_12 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '語聽系%') as H RIGHT OUTER JOIN depart_speechtherapyaudiology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_12 = $query2_1_12 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    } else {
        $query2_1_12 = $query2_1_12 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    }
} else {
    $query2_1_12 = $query2_1_12 . " GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
}

$result2_1_12 = $con->query($query2_1_12);
$count_avm_1_12 = array();
$styleName2_1_12 = array();

while ($row2_1_12 = mysqli_fetch_assoc($result2_1_12)) {
    $count_avm_1_12[] = $row2_1_12['count_avm_1_12'];
    $styleName2_1_12[] = $row2_1_12['grade'];
}
if (!$result2_1_12) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(護理系)統計之SQL(大學生)
$query2_1_13 = "SELECT grade, COUNT(H.id) as count_avm_1_13 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '護理系%') as H RIGHT OUTER JOIN depart_nursing ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_13 = $query2_1_13 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    } else {
        $query2_1_13 = $query2_1_13 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    }
} else {
    $query2_1_13 = $query2_1_13 . " GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
}

$result2_1_13 = $con->query($query2_1_13);
$count_avm_1_13 = array();
$styleName2_1_13 = array();

while ($row2_1_13 = mysqli_fetch_assoc($result2_1_13)) {
    $count_avm_1_13[] = $row2_1_13['count_avm_1_13'];
    $styleName2_1_13[] = $row2_1_13['grade'];
}
if (!$result2_1_13) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫化系)統計之SQL(大學生)
$query2_1_14 = "SELECT grade, COUNT(H.id) as count_avm_1_14 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫化系%') as H RIGHT OUTER JOIN depart_medicalappliedchemistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_14 = $query2_1_14 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    } else {
        $query2_1_14 = $query2_1_14 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    }
} else {
    $query2_1_14 = $query2_1_14 . " GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
}

$result2_1_14 = $con->query($query2_1_14);
$count_avm_1_14 = array();
$styleName2_1_14 = array();

while ($row2_1_14 = mysqli_fetch_assoc($result2_1_14)) {
    $count_avm_1_14[] = $row2_1_14['count_avm_1_14'];
    $styleName2_1_14[] = $row2_1_14['grade'];
}
if (!$result2_1_14) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫學系)統計之SQL(大學生)
$query2_1_15 = "SELECT grade, COUNT(H.id) as count_avm_1_15 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫學系%') as H RIGHT OUTER JOIN depart_medicine ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_15 = $query2_1_15 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    } else {
        $query2_1_15 = $query2_1_15 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    }
} else {
    $query2_1_15 = $query2_1_15 . " GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
}

$result2_1_15 = $con->query($query2_1_15);
$count_avm_1_15 = array();
$styleName2_1_15 = array();

while ($row2_1_15 = mysqli_fetch_assoc($result2_1_15)) {
    $count_avm_1_15[] = $row2_1_15['count_avm_1_15'];
    $styleName2_1_15[] = $row2_1_15['grade'];
}
if (!$result2_1_15) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫影系)統計之SQL(大學生)
$query2_1_16 = "SELECT grade, COUNT(H.id) as count_avm_1_16 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫影系%') as H RIGHT OUTER JOIN depart_medicalimagingradiologicalsciences ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_16 = $query2_1_16 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    } else {
        $query2_1_16 = $query2_1_16 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    }
} else {
    $query2_1_16 = $query2_1_16 . " GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
}

$result2_1_16 = $con->query($query2_1_16);
$count_avm_1_16 = array();
$styleName2_1_16 = array();

while ($row2_1_16 = mysqli_fetch_assoc($result2_1_16)) {
    $count_avm_1_16[] = $row2_1_16['count_avm_1_16'];
    $styleName2_1_16[] = $row2_1_16['grade'];
}
if (!$result2_1_16) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫技系)統計之SQL(大學生)
$query2_1_17 = "SELECT grade, COUNT(H.id) as count_avm_1_17 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫技系%') as H RIGHT OUTER JOIN depart_medicallaboratorybiotechnology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_17 = $query2_1_17 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    } else {
        $query2_1_17 = $query2_1_17 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    }
} else {
    $query2_1_17 = $query2_1_17 . " GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
}

$result2_1_17 = $con->query($query2_1_17);
$count_avm_1_17 = array();
$styleName2_1_17 = array();

while ($row2_1_17 = mysqli_fetch_assoc($result2_1_17)) {
    $count_avm_1_17[] = $row2_1_17['count_avm_1_17'];
    $styleName2_1_17[] = $row2_1_17['grade'];
}
if (!$result2_1_17) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫社系)統計之SQL(大學生)
$query2_1_18 = "SELECT grade, COUNT(H.id) as count_avm_1_18 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫社系%') as H RIGHT OUTER JOIN depart_medicalsocietysocialwork ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_18 = $query2_1_18 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    } else {
        $query2_1_18 = $query2_1_18 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    }
} else {
    $query2_1_18 = $query2_1_18 . " GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
}

$result2_1_18 = $con->query($query2_1_18);
$count_avm_1_18 = array();
$styleName2_1_18 = array();

while ($row2_1_18 = mysqli_fetch_assoc($result2_1_18)) {
    $count_avm_1_18[] = $row2_1_18['count_avm_1_18'];
    $styleName2_1_18[] = $row2_1_18['grade'];
}
if (!$result2_1_18) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫管系)統計之SQL(大學生)
$query2_1_19 = "SELECT grade, COUNT(H.id) as count_avm_1_19 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫管系%') as H RIGHT OUTER JOIN depart_medicalindustrytechnologymanagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_19 = $query2_1_19 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
    } else {
        $query2_1_19 = $query2_1_19 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
    }
} else {
    $query2_1_19 = $query2_1_19 . " GROUP BY grade ORDER BY FIELD(grade, '醫管系一', '醫管系二', '醫管系三', '醫管系四')";
}

$result2_1_19 = $con->query($query2_1_19);
$count_avm_1_19 = array();
$styleName2_1_19 = array();

while ($row2_1_19 = mysqli_fetch_assoc($result2_1_19)) {
    $count_avm_1_19[] = $row2_1_19['count_avm_1_19'];
    $styleName2_1_19[] = $row2_1_19['grade'];
}
if (!$result2_1_19) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依特定系所(醫資系)統計之SQL(大學生)
$query2_1_20 = "SELECT grade, COUNT(H.id) as count_avm_1_20 FROM ( SELECT unit, id, date FROM hrec_avm WHERE style = '大學生' and  unit like '醫資系%') as H RIGHT OUTER JOIN depart_medicalinformatics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_1_20 = $query2_1_20 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    } else {
        $query2_1_20 = $query2_1_20 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    }
} else {
    $query2_1_20 = $query2_1_20 . " GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
}

$result2_1_20 = $con->query($query2_1_20);
$count_avm_1_20 = array();
$styleName2_1_20 = array();

while ($row2_1_20 = mysqli_fetch_assoc($result2_1_20)) {
    $count_avm_1_20[] = $row2_1_20['count_avm_1_20'];
    $styleName2_1_20[] = $row2_1_20['grade'];
}
if (!$result2_1_20) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位(系所名稱擷取)統計之SQL(研究生)
$query2_2 = "SELECT SUBSTRING_INDEX(unit, '碩', 1) as department, COUNT(id) as count_avm_2 FROM hrec_avm WHERE style = '研究生'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_2 = $query2_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query2_2 = $query2_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query2_2 = $query2_2 . " GROUP BY department ORDER BY department";
}

$result2_2 = $con->query($query2_2);
$count_avm_2 = array();
$styleName2_2 = array();

while ($row2_2 = mysqli_fetch_assoc($result2_2)) {
    $count_avm_2[] = $row2_2['count_avm_2'];
    $styleName2_2[] = $row2_2['department'];
}
if (!$result2_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(教職員)
$query2_3 = "SELECT unit, COUNT(id) as count_avm_3 FROM hrec_avm WHERE style = '教職員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_3 = $query2_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_3 = $query2_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_3 = $query2_3 . " GROUP BY unit ORDER BY unit";
}

$result2_3 = $con->query($query2_3);
$count_avm_3 = array();
$styleName2_3 = array();

while ($row2_3 = mysqli_fetch_assoc($result2_3)) {
    $count_avm_3[] = $row2_3['count_avm_3'];
    $styleName2_3[] = $row2_3['unit'];
}
if (!$result2_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 視聽資料_依單位統計之SQL(醫護人員)
$query2_4 = "SELECT unit, COUNT(id) as count_avm_4 FROM hrec_avm WHERE style = '醫護人員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query2_4 = $query2_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query2_4 = $query2_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query2_4 = $query2_4 . " GROUP BY unit ORDER BY unit";
}

$result2_4 = $con->query($query2_4);
$count_avm_4 = array();
$styleName2_4 = array();

while ($row2_4 = mysqli_fetch_assoc($result2_4)) {
    $count_avm_4[] = $row2_4['count_avm_4'];
    $styleName2_4[] = $row2_4['unit'];
}
if (!$result2_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依職位統計之SQL
$query3 = "SELECT user_style.style as style, COUNT(id) as count_cj FROM hrec_cj RIGHT OUTER JOIN user_style ON hrec_cj.style = user_style.style";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3 = $query3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    } else {
        $query3 = $query3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
    }
} else {
    $query3 = $query3 . " GROUP BY user_style.style ORDER BY FIELD(user_style.style, '大學生', '研究生', '教職員', '醫護人員', '其他')";
}

$result3 = $con->query($query3);
$count_cj = array();
$styleName3 = array();

while ($row3 = mysqli_fetch_assoc($result3)) {
    $count_cj[] = $row3['count_cj'];
    $styleName3[] = $row3['style'];
}
if (!$result3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位(系所名稱擷取)統計之SQL(大學生)
$query3_1 = "SELECT user_depart.dep as department, COUNT(H.id) as count_cj_1 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生') as H RIGHT OUTER JOIN user_depart ON SUBSTRING(H.unit, 1, 3) = user_depart.dep";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1 = $query3_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query3_1 = $query3_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query3_1 = $query3_1 . " GROUP BY department ORDER BY department";
}

$result3_1 = $con->query($query3_1);
$count_cj_1 = array();
$styleName3_1 = array();

while ($row3_1 = mysqli_fetch_assoc($result3_1)) {
    $count_cj_1[] = $row3_1['count_cj_1'];
    $styleName3_1[] = $row3_1['department'];
}
if (!$result3_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(健產系)統計之SQL(大學生)
$query3_1_1 = "SELECT grade, COUNT(H.id) as count_cj_1_1 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '健產系%') as H RIGHT OUTER JOIN depart_healthIndustryTechnologyManagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_1 = $query3_1_1 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    } else {
        $query3_1_1 = $query3_1_1 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
    }
} else {
    $query3_1_1 = $query3_1_1 . " GROUP BY grade ORDER BY FIELD(grade, '健產系一', '健產系二', '健產系三', '健產系四')";
}

$result3_1_1 = $con->query($query3_1_1);
$count_cj_1_1 = array();
$styleName3_1_1 = array();

while ($row3_1_1 = mysqli_fetch_assoc($result3_1_1)) {
    $count_cj_1_1[] = $row3_1_1['count_cj_1_1'];
    $styleName3_1_1[] = $row3_1_1['grade'];
}
if (!$result3_1_1) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(公衛系)統計之SQL(大學生)
$query3_1_2 = "SELECT grade, COUNT(H.id) as count_cj_1_2 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '公衛系%') as H RIGHT OUTER JOIN depart_publichealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_2 = $query3_1_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    } else {
        $query3_1_2 = $query3_1_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
    }
} else {
    $query3_1_2 = $query3_1_2 . " GROUP BY grade ORDER BY FIELD(grade, '公衛系一', '公衛系二', '公衛系三', '公衛系四')";
}

$result3_1_2 = $con->query($query3_1_2);
$count_cj_1_2 = array();
$styleName3_1_2 = array();

while ($row3_1_2 = mysqli_fetch_assoc($result3_1_2)) {
    $count_cj_1_2[] = $row3_1_2['count_cj_1_2'];
    $styleName3_1_2[] = $row3_1_2['grade'];
}
if (!$result3_1_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(心理系)統計之SQL(大學生)
$query3_1_3 = "SELECT grade, COUNT(H.id) as count_cj_1_3 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '心理系%') as H RIGHT OUTER JOIN depart_psychology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_3 = $query3_1_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    } else {
        $query3_1_3 = $query3_1_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
    }
} else {
    $query3_1_3 = $query3_1_3 . " GROUP BY grade ORDER BY FIELD(grade, '心理系一', '心理系二', '心理系三', '心理系四')";
}

$result3_1_3 = $con->query($query3_1_3);
$count_cj_1_3 = array();
$styleName3_1_3 = array();

while ($row3_1_3 = mysqli_fetch_assoc($result3_1_3)) {
    $count_cj_1_3[] = $row3_1_3['count_cj_1_3'];
    $styleName3_1_3[] = $row3_1_3['grade'];
}
if (!$result3_1_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(應外系)統計之SQL(大學生)
$query3_1_4 = "SELECT grade, COUNT(H.id) as count_cj_1_4 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '應外系%') as H RIGHT OUTER JOIN depart_appliedforeignlinguistics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_4 = $query3_1_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    } else {
        $query3_1_4 = $query3_1_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
    }
} else {
    $query3_1_4 = $query3_1_4 . " GROUP BY grade ORDER BY FIELD(grade, '應外系一', '應外系二', '應外系三', '應外系四')";
}

$result3_1_4 = $con->query($query3_1_4);
$count_cj_1_4 = array();
$styleName3_1_4 = array();

while ($row3_1_4 = mysqli_fetch_assoc($result3_1_4)) {
    $count_cj_1_4[] = $row3_1_4['count_cj_1_4'];
    $styleName3_1_4[] = $row3_1_4['grade'];
}
if (!$result3_1_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(營養系)統計之SQL(大學生)
$query3_1_5 = "SELECT grade, COUNT(H.id) as count_cj_1_5 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '營養系%') as H RIGHT OUTER JOIN depart_nutrition ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_5 = $query3_1_5 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    } else {
        $query3_1_5 = $query3_1_5 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
    }
} else {
    $query3_1_5 = $query3_1_5 . " GROUP BY grade ORDER BY FIELD(grade, '營養系一', '營養系二', '營養系三', '營養系四')";
}

$result3_1_5 = $con->query($query3_1_5);
$count_cj_1_5 = array();
$styleName3_1_5 = array();

while ($row3_1_5 = mysqli_fetch_assoc($result3_1_5)) {
    $count_cj_1_5[] = $row3_1_5['count_cj_1_5'];
    $styleName3_1_5[] = $row3_1_5['grade'];
}
if (!$result3_1_5) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(牙醫系)統計之SQL(大學生)
$query3_1_6 = "SELECT grade, COUNT(H.id) as count_cj_1_6 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '牙醫系%') as H RIGHT OUTER JOIN depart_dentistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_6 = $query3_1_6 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    } else {
        $query3_1_6 = $query3_1_6 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
    }
} else {
    $query3_1_6 = $query3_1_6 . " GROUP BY grade ORDER BY FIELD(grade, '牙醫系一', '牙醫系二', '牙醫系三', '牙醫系四', '牙醫系五', '牙醫系六')";
}

$result3_1_6 = $con->query($query3_1_6);
$count_cj_1_6 = array();
$styleName3_1_6 = array();

while ($row3_1_6 = mysqli_fetch_assoc($result3_1_6)) {
    $count_cj_1_6[] = $row3_1_6['count_cj_1_6'];
    $styleName3_1_6[] = $row3_1_6['grade'];
}
if (!$result3_1_6) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(物治系)統計之SQL(大學生)
$query3_1_7 = "SELECT grade, COUNT(H.id) as count_cj_1_7 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '物治系%') as H RIGHT OUTER JOIN depart_physicaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_7 = $query3_1_7 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    } else {
        $query3_1_7 = $query3_1_7 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
    }
} else {
    $query3_1_7 = $query3_1_7 . " GROUP BY grade ORDER BY FIELD(grade, '物治系一', '物治系二', '物治系三', '物治系四')";
}

$result3_1_7 = $con->query($query3_1_7);
$count_cj_1_7 = array();
$styleName3_1_7 = array();

while ($row3_1_7 = mysqli_fetch_assoc($result3_1_7)) {
    $count_cj_1_7[] = $row3_1_7['count_cj_1_7'];
    $styleName3_1_7[] = $row3_1_7['grade'];
}
if (!$result3_1_7) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(生醫系)統計之SQL(大學生)
$query3_1_8 = "SELECT grade, COUNT(H.id) as count_cj_1_8 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '生醫系%') as H RIGHT OUTER JOIN depart_biomedicalscience ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_8 = $query3_1_8 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    } else {
        $query3_1_8 = $query3_1_8 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
    }
} else {
    $query3_1_8 = $query3_1_8 . " GROUP BY grade ORDER BY FIELD(grade, '生醫系一', '生醫系二', '生醫系三', '生醫系四')";
}

$result3_1_8 = $con->query($query3_1_8);
$count_cj_1_8 = array();
$styleName3_1_8 = array();

while ($row3_1_8 = mysqli_fetch_assoc($result3_1_8)) {
    $count_cj_1_8[] = $row3_1_8['count_cj_1_8'];
    $styleName3_1_8[] = $row3_1_8['grade'];
}
if (!$result3_1_8) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(職安系)統計之SQL(大學生)
$query3_1_9 = "SELECT grade, COUNT(H.id) as count_cj_1_9 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '職安系%') as H RIGHT OUTER JOIN depart_occupationalsafetyhealth ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_9 = $query3_1_9 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    } else {
        $query3_1_9 = $query3_1_9 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
    }
} else {
    $query3_1_9 = $query3_1_9 . " GROUP BY grade ORDER BY FIELD(grade, '職安系一', '職安系二', '職安系三', '職安系四')";
}

$result3_1_9 = $con->query($query3_1_9);
$count_cj_1_9 = array();
$styleName3_1_9 = array();

while ($row3_1_9 = mysqli_fetch_assoc($result3_1_9)) {
    $count_cj_1_9[] = $row3_1_9['count_cj_1_9'];
    $styleName3_1_9[] = $row3_1_9['grade'];
}
if (!$result3_1_9) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(職治系)統計之SQL(大學生)
$query3_1_10 = "SELECT grade, COUNT(H.id) as count_cj_1_10 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '職治系%') as H RIGHT OUTER JOIN depart_occupationaltherapy ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_10 = $query3_1_10 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    } else {
        $query3_1_10 = $query3_1_10 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
    }
} else {
    $query3_1_10 = $query3_1_10 . " GROUP BY grade ORDER BY FIELD(grade, '職治系一', '職治系二', '職治系三', '職治系四')";
}

$result3_1_10 = $con->query($query3_1_10);
$count_cj_1_10 = array();
$styleName3_1_10 = array();

while ($row3_1_10 = mysqli_fetch_assoc($result3_1_10)) {
    $count_cj_1_10[] = $row3_1_10['count_cj_1_10'];
    $styleName3_1_10[] = $row3_1_10['grade'];
}
if (!$result3_1_10) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(視光系)統計之SQL(大學生)
$query3_1_11 = "SELECT grade, COUNT(H.id) as count_cj_1_11 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '視光系%') as H RIGHT OUTER JOIN depart_optometry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_11 = $query3_1_11 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    } else {
        $query3_1_11 = $query3_1_11 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
    }
} else {
    $query3_1_11 = $query3_1_11 . " GROUP BY grade ORDER BY FIELD(grade, '視光系一', '視光系二', '視光系三', '視光系四')";
}

$result3_1_11 = $con->query($query3_1_11);
$count_cj_1_11 = array();
$styleName3_1_11 = array();

while ($row3_1_11 = mysqli_fetch_assoc($result3_1_11)) {
    $count_cj_1_11[] = $row3_1_11['count_cj_1_11'];
    $styleName3_1_11[] = $row3_1_11['grade'];
}
if (!$result3_1_11) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(語聽系)統計之SQL(大學生)
$query3_1_12 = "SELECT grade, COUNT(H.id) as count_cj_1_12 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '語聽系%') as H RIGHT OUTER JOIN depart_speechtherapyaudiology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_12 = $query3_1_12 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    } else {
        $query3_1_12 = $query3_1_12 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
    }
} else {
    $query3_1_12 = $query3_1_12 . " GROUP BY grade ORDER BY FIELD(grade, '語聽系一', '語聽系二', '語聽系三', '語聽系四')";
}

$result3_1_12 = $con->query($query3_1_12);
$count_cj_1_12 = array();
$styleName3_1_12 = array();

while ($row3_1_12 = mysqli_fetch_assoc($result3_1_12)) {
    $count_cj_1_12[] = $row3_1_12['count_cj_1_12'];
    $styleName3_1_12[] = $row3_1_12['grade'];
}
if (!$result3_1_12) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(護理系)統計之SQL(大學生)
$query3_1_13 = "SELECT grade, COUNT(H.id) as count_cj_1_13 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '護理系%') as H RIGHT OUTER JOIN depart_nursing ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_13 = $query3_1_13 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    } else {
        $query3_1_13 = $query3_1_13 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
    }
} else {
    $query3_1_13 = $query3_1_13 . " GROUP BY grade ORDER BY FIELD(grade, '護理系一', '護理系二', '護理系三', '護理系四')";
}

$result3_1_13 = $con->query($query3_1_13);
$count_cj_1_13 = array();
$styleName3_1_13 = array();

while ($row3_1_13 = mysqli_fetch_assoc($result3_1_13)) {
    $count_cj_1_13[] = $row3_1_13['count_cj_1_13'];
    $styleName3_1_13[] = $row3_1_13['grade'];
}
if (!$result3_1_13) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫化系)統計之SQL(大學生)
$query3_1_14 = "SELECT grade, COUNT(H.id) as count_cj_1_14 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫化系%') as H RIGHT OUTER JOIN depart_medicalappliedchemistry ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_14 = $query3_1_14 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    } else {
        $query3_1_14 = $query3_1_14 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
    }
} else {
    $query3_1_14 = $query3_1_14 . " GROUP BY grade ORDER BY FIELD(grade, '醫化系一', '醫化系二', '醫化系三', '醫化系四')";
}

$result3_1_14 = $con->query($query3_1_14);
$count_cj_1_14 = array();
$styleName3_1_14 = array();

while ($row3_1_14 = mysqli_fetch_assoc($result3_1_14)) {
    $count_cj_1_14[] = $row3_1_14['count_cj_1_14'];
    $styleName3_1_14[] = $row3_1_14['grade'];
}
if (!$result3_1_14) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫學系)統計之SQL(大學生)
$query3_1_15 = "SELECT grade, COUNT(H.id) as count_cj_1_15 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫學系%') as H RIGHT OUTER JOIN depart_medicine ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_15 = $query3_1_15 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    } else {
        $query3_1_15 = $query3_1_15 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
    }
} else {
    $query3_1_15 = $query3_1_15 . " GROUP BY grade ORDER BY FIELD(grade, '醫學系一', '醫學系二', '醫學系三', '醫學系四', '醫學系五', '醫學系六')";
}

$result3_1_15 = $con->query($query3_1_15);
$count_cj_1_15 = array();
$styleName3_1_15 = array();

while ($row3_1_15 = mysqli_fetch_assoc($result3_1_15)) {
    $count_cj_1_15[] = $row3_1_15['count_cj_1_15'];
    $styleName3_1_15[] = $row3_1_15['grade'];
}
if (!$result3_1_15) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫影系)統計之SQL(大學生)
$query3_1_16 = "SELECT grade, COUNT(H.id) as count_cj_1_16 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫影系%') as H RIGHT OUTER JOIN depart_medicalimagingradiologicalsciences ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_16 = $query3_1_16 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    } else {
        $query3_1_16 = $query3_1_16 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
    }
} else {
    $query3_1_16 = $query3_1_16 . " GROUP BY grade ORDER BY FIELD(grade, '醫影系一', '醫影系二', '醫影系三', '醫影系四')";
}

$result3_1_16 = $con->query($query3_1_16);
$count_cj_1_16 = array();
$styleName3_1_16 = array();

while ($row3_1_16 = mysqli_fetch_assoc($result3_1_16)) {
    $count_cj_1_16[] = $row3_1_16['count_cj_1_16'];
    $styleName3_1_16[] = $row3_1_16['grade'];
}
if (!$result3_1_16) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫技系)統計之SQL(大學生)
$query3_1_17 = "SELECT grade, COUNT(H.id) as count_cj_1_17 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫技系%') as H RIGHT OUTER JOIN depart_medicallaboratorybiotechnology ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_17 = $query3_1_17 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    } else {
        $query3_1_17 = $query3_1_17 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
    }
} else {
    $query3_1_17 = $query3_1_17 . " GROUP BY grade ORDER BY FIELD(grade, '醫技系一', '醫技系二', '醫技系三', '醫技系四')";
}

$result3_1_17 = $con->query($query3_1_17);
$count_cj_1_17 = array();
$styleName3_1_17 = array();

while ($row3_1_17 = mysqli_fetch_assoc($result3_1_17)) {
    $count_cj_1_17[] = $row3_1_17['count_cj_1_17'];
    $styleName3_1_17[] = $row3_1_17['grade'];
}
if (!$result3_1_17) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫社系)統計之SQL(大學生)
$query3_1_18 = "SELECT grade, COUNT(H.id) as count_cj_1_18 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫社系%') as H RIGHT OUTER JOIN depart_medicalsocietysocialwork ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_18 = $query3_1_18 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    } else {
        $query3_1_18 = $query3_1_18 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    }
} else {
    $query3_1_18 = $query3_1_18 . " GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
}

$result3_1_18 = $con->query($query3_1_18);
$count_cj_1_18 = array();
$styleName3_1_18 = array();

while ($row3_1_18 = mysqli_fetch_assoc($result3_1_18)) {
    $count_cj_1_18[] = $row3_1_18['count_cj_1_18'];
    $styleName3_1_18[] = $row3_1_18['grade'];
}
if (!$result3_1_18) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫管系)統計之SQL(大學生)
$query3_1_19 = "SELECT grade, COUNT(H.id) as count_cj_1_19 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫社系%') as H RIGHT OUTER JOIN depart_medicalindustrytechnologymanagement ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_19 = $query3_1_19 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    } else {
        $query3_1_19 = $query3_1_19 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
    }
} else {
    $query3_1_19 = $query3_1_19 . " GROUP BY grade ORDER BY FIELD(grade, '醫社系一', '醫社系二', '醫社系三', '醫社系四')";
}

$result3_1_19 = $con->query($query3_1_19);
$count_cj_1_19 = array();
$styleName3_1_19 = array();

while ($row3_1_19 = mysqli_fetch_assoc($result3_1_19)) {
    $count_cj_1_19[] = $row3_1_19['count_cj_1_19'];
    $styleName3_1_19[] = $row3_1_19['grade'];
}
if (!$result3_1_19) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依特定系所(醫資系)統計之SQL(大學生)
$query3_1_20 = "SELECT grade, COUNT(H.id) as count_cj_1_20 FROM ( SELECT unit, id, date FROM hrec_cj WHERE style = '大學生' and  unit like '醫資系%') as H RIGHT OUTER JOIN depart_medicalinformatics ON H.unit = grade";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_1_20 = $query3_1_20 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    } else {
        $query3_1_20 = $query3_1_20 . " and date like '" . $_SESSION['year'] . "%' GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
    }
} else {
    $query3_1_20 = $query3_1_20 . " GROUP BY grade ORDER BY FIELD(grade, '醫資系一', '醫資系二', '醫資系三', '醫資系四')";
}

$result3_1_20 = $con->query($query3_1_20);
$count_cj_1_20 = array();
$styleName3_1_20 = array();

while ($row3_1_20 = mysqli_fetch_assoc($result3_1_20)) {
    $count_cj_1_20[] = $row3_1_20['count_cj_1_20'];
    $styleName3_1_20[] = $row3_1_20['grade'];
}
if (!$result3_1_20) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位(系所名稱擷取)統計之SQL(研究生)
$query3_2 = "SELECT SUBSTRING_INDEX(unit, '碩', 1) as department, COUNT(id) as count_cj_2 FROM hrec_cj WHERE style = '研究生'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_2 = $query3_2 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY department ORDER BY department";
    } else {
        $query3_2 = $query3_2 . " and date like '" . $_SESSION['year'] . "%' GROUP BY department ORDER BY department";
    }
} else {
    $query3_2 = $query3_2 . " GROUP BY department ORDER BY department";
}

$result3_2 = $con->query($query3_2);
$count_cj_2 = array();
$styleName3_2 = array();

while ($row3_2 = mysqli_fetch_assoc($result3_2)) {
    $count_cj_2[] = $row3_2['count_cj_2'];
    $styleName3_2[] = $row3_2['department'];
}
if (!$result3_2) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(教職員)
$query3_3 = "SELECT unit, COUNT(id) as count_cj_3 FROM hrec_cj WHERE style = '教職員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_3 = $query3_3 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_3 = $query3_3 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_3 = $query3_3 . " GROUP BY unit ORDER BY unit";
}

$result3_3 = $con->query($query3_3);
$count_cj_3 = array();
$styleName3_3 = array();

while ($row3_3 = mysqli_fetch_assoc($result3_3)) {
    $count_cj_3[] = $row3_3['count_cj_3'];
    $styleName3_3[] = $row3_3['unit'];
}
if (!$result3_3) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}

// 中文期刊_依單位統計之SQL(醫護人員)
$query3_4 = "SELECT unit, COUNT(id) as count_cj_4 FROM hrec_cj WHERE style = '醫護人員'";

if (isset($_GET['year'])) {
    $_SESSION['year'] = $_GET['year'];
    if (isset($_GET['month'])) {
        $_SESSION['month'] = $_GET['month'];
        $query3_4 = $query3_4 . " and date like '" . $_SESSION['year'] . "-" . $_SESSION['month'] . "%' GROUP BY unit ORDER BY unit";
    } else {
        $query3_4 = $query3_4 . " and date like '" . $_SESSION['year'] . "%' GROUP BY unit ORDER BY unit";
    }
} else {
    $query3_4 = $query3_4 . " GROUP BY unit ORDER BY unit";
}

$result3_4 = $con->query($query3_4);
$count_cj_4 = array();
$styleName3_4 = array();

while ($row3_4 = mysqli_fetch_assoc($result3_4)) {
    $count_cj_4[] = $row3_4['count_cj_4'];
    $styleName3_4[] = $row3_4['unit'];
}
if (!$result3_4) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>
        <?php showtitle() ?>
    </title>

    <script>
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../logout.php";
        }
    </script>
</head>

<body>
    <div id="header">
        <?php showheader1() ?>
        <div id="user">
            管理者&nbsp;-
            <?php
            if (isset($_SESSION['user_name'])) {
                $userName = $_SESSION['user_name'];
                echo htmlspecialchars($userName);
            }
            ?>&nbsp;
        </div>
    </div>

    <hr style="height:3px; margin-top:0px;">

    <!-- 路徑 -->
    <nav style="--bs-breadcrumb-divider: '>'; margin-left:10px; margin-top:-10px;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_index.php">首頁</a></li>
            <!-- <li class="breadcrumb-item active" aria-current="page">中西文圖書歷史推薦清單</li> -->
            <li class="breadcrumb-item active" aria-current="page"><a href="count_rr.php">統計推薦紀錄</a></li>
        </ol>
    </nav>

    <h2 id="mid-title">統計推薦紀錄</h2>

    <nav class="navbar navbar-light" style="width:95%;" user-select:none;>
        <div class="container-fluid" style="margin-left:5.5%;">
            <!-- 暫存 -->
            <?php
            if (isset($_GET['year'])) { // 年
                $_SESSION['year'] = $_GET['year'];
                echo '<div id="yearNow" style="display:none">' . $_SESSION['year'] . '</div>';
            } else {
                echo '<div id="yearNow" style="display:none"></div>';
            }
            if (isset($_GET['month'])) { // 月
                $_SESSION['month'] = $_GET['month'];
                echo '<div id="monthNow" style="display:none">' . $_SESSION['month'] . '</div>';
            } else {
                echo '<div id="monthNow" style="display:none"></div>';
            }
            ?>

            <!-- 年度下拉式選單 -->
            <form class="d-flex">
                <div class="dropdown">
                    <select id="slt1" class="dropdown"
                        style="background-color:white; font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#808080;
                                                            height:37px; width:120px; border-radius:3px; text-align:center;" onchange="year();">
                        <option disabled hidden> 年 </option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000">選取年份</option>

                        <!-- 依據現在年份添加年度 -->
                        <?php
                        $currentYear = date("Y");
                        for ($year = $currentYear; $year >= 2020; $year--) {
                            if (isset($_GET['year']) && $_GET['year'] == $year) {
                                echo '<option style="font-size:18px; font-family:Times New Roman; color:#000000" name="year" selected>' . $year . '</option>';
                            } else if (isset($_GET['year'])) {
                                echo '<option style="font-size:18px; font-family:Times New Roman; color:#000000" name="year">' . $year . '</option>';
                            } else {
                                echo '<option disabled hidden selected> 年 </option>';
                                echo '<option style="font-size:18px; font-family:Times New Roman; color:#000000" name="year">' . $year . '</option>';
                            }
                        }
                        ?>
                    </select>

                    <br><br><br>

                </div>

                &emsp;

                <!-- 月份下拉式選單 -->
                <div class="dropdown">
                    <select id="slt2" class="dropdown"
                        style="background-color:white; font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#808080;
                                                            height:37px; width:120px; border-radius:3px; text-align:center;" onchange="month();">
                        <option disabled hidden> 月 </option>
                        <option style="font-size:18px; font-family:DFKai-sb; color:#000000">選取月份</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">01</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">02</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">03</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">04</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">05</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">06</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">07</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">08</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">09</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">10</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">11</option>
                        <option style="font-size:18px; font-family:Times New Roman,'DFKai-sb'; color:#000000" name="month">12</option>

                        <?php
                        if (isset($_GET['month'])) {
                            echo '<option style="font-size:18px; font-family:Times New Roman; color:#000000" selected disabled hidden>' . $_GET['month'] . '</option>';
                        } else {
                            echo '<option disabled hidden selected> 月 </option>';
                        }
                        ?>

                    </select>

                    <br><br><br>

                </div>
            </form>
        </div>

        <script>
            (function () {
                //全部選擇隱藏
                $('div[id^="tab_"]').hide();
                $('#slt1').change(function () {
                    let sltValue = $(this).val();
                    console.log(sltValue);

                    $('div[id^="tab_"]').hide();
                    //指定選擇顯示
                    $(sltValue).show();
                });
            });
        </script>
    </nav>

    <!-- 內容表格 -->
    <nav id="chartNav" class="navbar navbar-light" style="width:95%;">
        <div id="chartDiv" class="container-fluid" style="margin-left:5.5%;">
            <canvas id="Chart" style="width: 95.5%; display: block; box-sizing: border-box; height: 435px;"></canvas>
        </div>
    </nav>

    <script language="javascript">
        // Setup Block_依職位統計
        const lables = <?php echo json_encode($styleName1); ?>;
        const count_ceb = <?php echo json_encode($count_ceb); ?>;
        const count_avm = <?php echo json_encode($count_avm); ?>;
        const count_cj = <?php echo json_encode($count_cj); ?>;
        const data = {
            labels: lables,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb,
                backgroundColor: '#4472C4'
            }, {
                label: '視聽資料',
                data: count_avm,
                backgroundColor: '#ED7D31'
            }, {
                label: '中文期刊',
                data: count_cj,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中西文圖書_依單位(系所名稱擷取)統計(大學生)
        const lables_1_1 = <?php echo json_encode($styleName1_1); ?>;
        const count_ceb_1 = <?php echo json_encode($count_ceb_1); ?>;
        const college_student_ceb = {
            labels: lables_1_1,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(健產系)統計(大學生)
        const lables_1_1_1 = <?php echo json_encode($styleName1_1_1); ?>;
        const count_ceb_1_1 = <?php echo json_encode($count_ceb_1_1); ?>;
        const HealthIndustryTechnologyManagement_student_ceb = {
            labels: lables_1_1_1,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_1,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(公衛系)統計(大學生)
        const lables_1_1_2 = <?php echo json_encode($styleName1_1_2); ?>;
        const count_ceb_1_2 = <?php echo json_encode($count_ceb_1_2); ?>;
        const PublicHealth_student_ceb = {
            labels: lables_1_1_2,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_2,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(心理系)統計(大學生)
        const lables_1_1_3 = <?php echo json_encode($styleName1_1_3); ?>;
        const count_ceb_1_3 = <?php echo json_encode($count_ceb_1_3); ?>;
        const Psychology_student_ceb = {
            labels: lables_1_1_3,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_3,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(應外系)統計(大學生)
        const lables_1_1_4 = <?php echo json_encode($styleName1_1_4); ?>;
        const count_ceb_1_4 = <?php echo json_encode($count_ceb_1_4); ?>;
        const AppliedForeignLinguistics_student_ceb = {
            labels: lables_1_1_4,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_4,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(營養系)統計(大學生)
        const lables_1_1_5 = <?php echo json_encode($styleName1_1_5); ?>;
        const count_ceb_1_5 = <?php echo json_encode($count_ceb_1_5); ?>;
        const Nutrition_student_ceb = {
            labels: lables_1_1_5,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_5,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(牙醫系)統計(大學生)
        const lables_1_1_6 = <?php echo json_encode($styleName1_1_6); ?>;
        const count_ceb_1_6 = <?php echo json_encode($count_ceb_1_6); ?>;
        const Dentistry_student_ceb = {
            labels: lables_1_1_6,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_6,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(物治系)統計(大學生)
        const lables_1_1_7 = <?php echo json_encode($styleName1_1_7); ?>;
        const count_ceb_1_7 = <?php echo json_encode($count_ceb_1_7); ?>;
        const PhysicalTherapy_student_ceb = {
            labels: lables_1_1_7,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_7,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(生醫系)統計(大學生)
        const lables_1_1_8 = <?php echo json_encode($styleName1_1_8); ?>;
        const count_ceb_1_8 = <?php echo json_encode($count_ceb_1_8); ?>;
        const BiomedicalSciences_student_ceb = {
            labels: lables_1_1_8,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_8,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(職安系)統計(大學生)
        const lables_1_1_9 = <?php echo json_encode($styleName1_1_9); ?>;
        const count_ceb_1_9 = <?php echo json_encode($count_ceb_1_9); ?>;
        const OccupationalSafetyHealth_student_ceb = {
            labels: lables_1_1_9,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_9,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(職治系)統計(大學生)
        const lables_1_1_10 = <?php echo json_encode($styleName1_1_10); ?>;
        const count_ceb_1_10 = <?php echo json_encode($count_ceb_1_10); ?>;
        const OccupationalTherapy_student_ceb = {
            labels: lables_1_1_10,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_10,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(視光系)統計(大學生)
        const lables_1_1_11 = <?php echo json_encode($styleName1_1_11); ?>;
        const count_ceb_1_11 = <?php echo json_encode($count_ceb_1_11); ?>;
        const Optometry_student_ceb = {
            labels: lables_1_1_11,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_11,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(語聽系)統計(大學生)
        const lables_1_1_12 = <?php echo json_encode($styleName1_1_12); ?>;
        const count_ceb_1_12 = <?php echo json_encode($count_ceb_1_12); ?>;
        const SpeechTherapyAudiology_student_ceb = {
            labels: lables_1_1_12,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_12,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(護理系)統計(大學生)
        const lables_1_1_13 = <?php echo json_encode($styleName1_1_13); ?>;
        const count_ceb_1_13 = <?php echo json_encode($count_ceb_1_13); ?>;
        const Nursing_student_ceb = {
            labels: lables_1_1_13,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_13,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫化系)統計(大學生)
        const lables_1_1_14 = <?php echo json_encode($styleName1_1_14); ?>;
        const count_ceb_1_14 = <?php echo json_encode($count_ceb_1_14); ?>;
        const MedicalAppliedChemistry_student_ceb = {
            labels: lables_1_1_14,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_14,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫學系)統計(大學生)
        const lables_1_1_15 = <?php echo json_encode($styleName1_1_15); ?>;
        const count_ceb_1_15 = <?php echo json_encode($count_ceb_1_15); ?>;
        const Medicine_student_ceb = {
            labels: lables_1_1_15,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_15,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫影系)統計(大學生)
        const lables_1_1_16 = <?php echo json_encode($styleName1_1_16); ?>;
        const count_ceb_1_16 = <?php echo json_encode($count_ceb_1_16); ?>;
        const MedicalImagingRadiologicalSciences_student_ceb = {
            labels: lables_1_1_16,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_16,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫技系)統計(大學生)
        const lables_1_1_17 = <?php echo json_encode($styleName1_1_17); ?>;
        const count_ceb_1_17 = <?php echo json_encode($count_ceb_1_17); ?>;
        const MedicalLaboratoryBiotechnology_student_ceb = {
            labels: lables_1_1_17,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_17,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫社系)統計(大學生)
        const lables_1_1_18 = <?php echo json_encode($styleName1_1_18); ?>;
        const count_ceb_1_18 = <?php echo json_encode($count_ceb_1_18); ?>;
        const MedicalSocietySocialWork_student_ceb = {
            labels: lables_1_1_18,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_18,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫管系)統計(大學生)
        const lables_1_1_19 = <?php echo json_encode($styleName1_1_19); ?>;
        const count_ceb_1_19 = <?php echo json_encode($count_ceb_1_19); ?>;
        const MedicalIndustryTechnologyManagement_student_ceb = {
            labels: lables_1_1_19,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_19,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依特定系所(醫資系)統計(大學生)
        const lables_1_1_20 = <?php echo json_encode($styleName1_1_20); ?>;
        const count_ceb_1_20 = <?php echo json_encode($count_ceb_1_20); ?>;
        const MedicalInformatics_student_ceb = {
            labels: lables_1_1_20,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_1_20,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位(系所名稱擷取)統計(研究生)
        const lables_1_2 = <?php echo json_encode($styleName1_2); ?>;
        const count_ceb_2 = <?php echo json_encode($count_ceb_2); ?>;
        const postgraduate_ceb = {
            labels: lables_1_2,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_2,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(教職員)
        const lables_1_3 = <?php echo json_encode($styleName1_3); ?>;
        const count_ceb_3 = <?php echo json_encode($count_ceb_3); ?>;
        const staff_ceb = {
            labels: lables_1_3,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_3,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_中西文圖書_依單位統計(醫護人員)
        const lables_1_4 = <?php echo json_encode($styleName1_4); ?>;
        const count_ceb_4 = <?php echo json_encode($count_ceb_4); ?>;
        const medical_staff_ceb = {
            labels: lables_1_4,
            datasets: [{
                label: '中西文圖書',
                data: count_ceb_4,
                backgroundColor: '#4472C4'
            }]
        };

        // Setup Block_視聽資料_依單位(系所名稱擷取)統計(大學生)
        const lables_2_1 = <?php echo json_encode($styleName2_1); ?>;
        const count_avm_1 = <?php echo json_encode($count_avm_1); ?>;
        const college_student_avm = {
            labels: lables_2_1,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(健產系)統計(大學生)
        const lables_2_1_1 = <?php echo json_encode($styleName2_1_1); ?>;
        const count_avm_1_1 = <?php echo json_encode($count_avm_1_1); ?>;
        const HealthIndustryTechnologyManagement_student_avm = {
            labels: lables_2_1_1,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_1,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(公衛系)統計(大學生)
        const lables_2_1_2 = <?php echo json_encode($styleName2_1_2); ?>;
        const count_avm_1_2 = <?php echo json_encode($count_avm_1_2); ?>;
        const PublicHealth_student_avm = {
            labels: lables_2_1_2,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_2,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(心理系)統計(大學生)
        const lables_2_1_3 = <?php echo json_encode($styleName2_1_3); ?>;
        const count_avm_1_3 = <?php echo json_encode($count_avm_1_3); ?>;
        const Psychology_student_avm = {
            labels: lables_2_1_3,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_3,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(應外系)統計(大學生)
        const lables_2_1_4 = <?php echo json_encode($styleName2_1_4); ?>;
        const count_avm_1_4 = <?php echo json_encode($count_avm_1_4); ?>;
        const AppliedForeignLinguistics_student_avm = {
            labels: lables_2_1_4,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_4,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(營養系)統計(大學生)
        const lables_2_1_5 = <?php echo json_encode($styleName2_1_5); ?>;
        const count_avm_1_5 = <?php echo json_encode($count_avm_1_5); ?>;
        const Nutrition_student_avm = {
            labels: lables_2_1_5,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_5,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(牙醫系)統計(大學生)
        const lables_2_1_6 = <?php echo json_encode($styleName2_1_6); ?>;
        const count_avm_1_6 = <?php echo json_encode($count_avm_1_6); ?>;
        const Dentistry_student_avm = {
            labels: lables_2_1_6,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_6,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(物治系)統計(大學生)
        const lables_2_1_7 = <?php echo json_encode($styleName2_1_7); ?>;
        const count_avm_1_7 = <?php echo json_encode($count_avm_1_7); ?>;
        const PhysicalTherapy_student_avm = {
            labels: lables_2_1_7,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_7,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(生醫系)統計(大學生)
        const lables_2_1_8 = <?php echo json_encode($styleName2_1_8); ?>;
        const count_avm_1_8 = <?php echo json_encode($count_avm_1_8); ?>;
        const BiomedicalSciences_student_avm = {
            labels: lables_2_1_8,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_8,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(職安系)統計(大學生)
        const lables_2_1_9 = <?php echo json_encode($styleName2_1_9); ?>;
        const count_avm_1_9 = <?php echo json_encode($count_avm_1_9); ?>;
        const OccupationalSafetyHealth_student_avm = {
            labels: lables_2_1_9,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_9,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(職治系)統計(大學生)
        const lables_2_1_10 = <?php echo json_encode($styleName2_1_10); ?>;
        const count_avm_1_10 = <?php echo json_encode($count_avm_1_10); ?>;
        const OccupationalTherapy_student_avm = {
            labels: lables_2_1_10,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_10,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(視光系)統計(大學生)
        const lables_2_1_11 = <?php echo json_encode($styleName2_1_11); ?>;
        const count_avm_1_11 = <?php echo json_encode($count_avm_1_11); ?>;
        const Optometry_student_avm = {
            labels: lables_2_1_11,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_11,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(語聽系)統計(大學生)
        const lables_2_1_12 = <?php echo json_encode($styleName2_1_12); ?>;
        const count_avm_1_12 = <?php echo json_encode($count_avm_1_12); ?>;
        const SpeechTherapyAudiology_student_avm = {
            labels: lables_2_1_12,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_12,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(護理系)統計(大學生)
        const lables_2_1_13 = <?php echo json_encode($styleName2_1_13); ?>;
        const count_avm_1_13 = <?php echo json_encode($count_avm_1_13); ?>;
        const Nursing_student_avm = {
            labels: lables_2_1_13,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_13,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫化系)統計(大學生)
        const lables_2_1_14 = <?php echo json_encode($styleName2_1_14); ?>;
        const count_avm_1_14 = <?php echo json_encode($count_avm_1_14); ?>;
        const MedicalAppliedChemistry_student_avm = {
            labels: lables_2_1_14,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_14,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫學系)統計(大學生)
        const lables_2_1_15 = <?php echo json_encode($styleName2_1_15); ?>;
        const count_avm_1_15 = <?php echo json_encode($count_avm_1_15); ?>;
        const Medicine_student_avm = {
            labels: lables_2_1_15,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_15,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫影系)統計(大學生)
        const lables_2_1_16 = <?php echo json_encode($styleName2_1_16); ?>;
        const count_avm_1_16 = <?php echo json_encode($count_avm_1_16); ?>;
        const MedicalImagingRadiologicalSciences_student_avm = {
            labels: lables_2_1_16,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_16,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫技系)統計(大學生)
        const lables_2_1_17 = <?php echo json_encode($styleName2_1_17); ?>;
        const count_avm_1_17 = <?php echo json_encode($count_avm_1_17); ?>;
        const MedicalLaboratoryBiotechnology_student_avm = {
            labels: lables_2_1_17,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_17,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫社系)統計(大學生)
        const lables_2_1_18 = <?php echo json_encode($styleName2_1_18); ?>;
        const count_avm_1_18 = <?php echo json_encode($count_avm_1_18); ?>;
        const MedicalSocietySocialWork_student_avm = {
            labels: lables_2_1_18,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_18,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫管系)統計(大學生)
        const lables_2_1_19 = <?php echo json_encode($styleName2_1_19); ?>;
        const count_avm_1_19 = <?php echo json_encode($count_avm_1_19); ?>;
        const MedicalIndustryTechnologyManagement_student_avm = {
            labels: lables_2_1_19,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_19,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依特定系所(醫資系)統計(大學生)
        const lables_2_1_20 = <?php echo json_encode($styleName2_1_20); ?>;
        const count_avm_1_20 = <?php echo json_encode($count_avm_1_20); ?>;
        const MedicalInformatics_student_avm = {
            labels: lables_2_1_20,
            datasets: [{
                label: '視聽資料',
                data: count_avm_1_20,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依單位(系所名稱擷取)統計(研究生)
        const lables_2_2 = <?php echo json_encode($styleName2_2); ?>;
        const count_avm_2 = <?php echo json_encode($count_avm_2); ?>;
        const postgraduate_avm = {
            labels: lables_2_2,
            datasets: [{
                label: '視聽資料',
                data: count_avm_2,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依單位統計(教職員)
        const lables_2_3 = <?php echo json_encode($styleName2_3); ?>;
        const count_avm_3 = <?php echo json_encode($count_avm_3); ?>;
        const staff_avm = {
            labels: lables_2_3,
            datasets: [{
                label: '視聽資料',
                data: count_avm_3,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_視聽資料_依單位統計(醫護人員)
        const lables_2_4 = <?php echo json_encode($styleName2_4); ?>;
        const count_avm_4 = <?php echo json_encode($count_avm_4); ?>;
        const medical_staff_avm = {
            labels: lables_2_4,
            datasets: [{
                label: '視聽資料',
                data: count_avm_4,
                backgroundColor: '#ED7D31'
            }]
        };

        // Setup Block_中文期刊_依單位(系所名稱擷取)統計(大學生)
        const lables_3_1 = <?php echo json_encode($styleName3_1); ?>;
        const count_cj_1 = <?php echo json_encode($count_cj_1); ?>;
        const college_student_cj = {
            labels: lables_3_1,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(健產系)統計(大學生)
        const lables_3_1_1 = <?php echo json_encode($styleName3_1_1); ?>;
        const count_cj_1_1 = <?php echo json_encode($count_cj_1_1); ?>;
        const HealthIndustryTechnologyManagement_student_cj = {
            labels: lables_3_1_1,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_1,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(公衛系)統計(大學生)
        const lables_3_1_2 = <?php echo json_encode($styleName3_1_2); ?>;
        const count_cj_1_2 = <?php echo json_encode($count_cj_1_2); ?>;
        const PublicHealth_student_cj = {
            labels: lables_3_1_2,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_2,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(心理系)統計(大學生)
        const lables_3_1_3 = <?php echo json_encode($styleName3_1_3); ?>;
        const count_cj_1_3 = <?php echo json_encode($count_cj_1_3); ?>;
        const Psychology_student_cj = {
            labels: lables_3_1_3,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_3,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(應外系)統計(大學生)
        const lables_3_1_4 = <?php echo json_encode($styleName3_1_4); ?>;
        const count_cj_1_4 = <?php echo json_encode($count_cj_1_4); ?>;
        const AppliedForeignLinguistics_student_cj = {
            labels: lables_3_1_4,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_4,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(營養系)統計(大學生)
        const lables_3_1_5 = <?php echo json_encode($styleName3_1_5); ?>;
        const count_cj_1_5 = <?php echo json_encode($count_cj_1_5); ?>;
        const Nutrition_student_cj = {
            labels: lables_3_1_5,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_5,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(牙醫系)統計(大學生)
        const lables_3_1_6 = <?php echo json_encode($styleName3_1_6); ?>;
        const count_cj_1_6 = <?php echo json_encode($count_cj_1_6); ?>;
        const Dentistry_student_cj = {
            labels: lables_3_1_6,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_6,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(物治系)統計(大學生)
        const lables_3_1_7 = <?php echo json_encode($styleName3_1_7); ?>;
        const count_cj_1_7 = <?php echo json_encode($count_cj_1_7); ?>;
        const PhysicalTherapy_student_cj = {
            labels: lables_3_1_7,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_7,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(生醫系)統計(大學生)
        const lables_3_1_8 = <?php echo json_encode($styleName3_1_8); ?>;
        const count_cj_1_8 = <?php echo json_encode($count_cj_1_8); ?>;
        const BiomedicalSciences_student_cj = {
            labels: lables_3_1_8,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_8,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(職安系)統計(大學生)
        const lables_3_1_9 = <?php echo json_encode($styleName3_1_9); ?>;
        const count_cj_1_9 = <?php echo json_encode($count_cj_1_9); ?>;
        const OccupationalSafetyHealth_student_cj = {
            labels: lables_3_1_9,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_9,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(職治系)統計(大學生)
        const lables_3_1_10 = <?php echo json_encode($styleName3_1_10); ?>;
        const count_cj_1_10 = <?php echo json_encode($count_cj_1_10); ?>;
        const OccupationalTherapy_student_cj = {
            labels: lables_3_1_10,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_10,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(視光系)統計(大學生)
        const lables_3_1_11 = <?php echo json_encode($styleName3_1_11); ?>;
        const count_cj_1_11 = <?php echo json_encode($count_cj_1_11); ?>;
        const Optometry_student_cj = {
            labels: lables_3_1_11,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_11,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(語聽系)統計(大學生)
        const lables_3_1_12 = <?php echo json_encode($styleName3_1_12); ?>;
        const count_cj_1_12 = <?php echo json_encode($count_cj_1_12); ?>;
        const SpeechTherapyAudiology_student_cj = {
            labels: lables_3_1_12,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_12,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(護理系)統計(大學生)
        const lables_3_1_13 = <?php echo json_encode($styleName3_1_13); ?>;
        const count_cj_1_13 = <?php echo json_encode($count_cj_1_13); ?>;
        const Nursing_student_cj = {
            labels: lables_3_1_13,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_13,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫化系)統計(大學生)
        const lables_3_1_14 = <?php echo json_encode($styleName3_1_14); ?>;
        const count_cj_1_14 = <?php echo json_encode($count_cj_1_14); ?>;
        const MedicalAppliedChemistry_student_cj = {
            labels: lables_3_1_14,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_14,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫學系)統計(大學生)
        const lables_3_1_15 = <?php echo json_encode($styleName3_1_15); ?>;
        const count_cj_1_15 = <?php echo json_encode($count_cj_1_15); ?>;
        const Medicine_student_cj = {
            labels: lables_3_1_15,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_15,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫影系)統計(大學生)
        const lables_3_1_16 = <?php echo json_encode($styleName3_1_16); ?>;
        const count_cj_1_16 = <?php echo json_encode($count_cj_1_16); ?>;
        const MedicalImagingRadiologicalSciences_student_cj = {
            labels: lables_3_1_16,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_16,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫技系)統計(大學生)
        const lables_3_1_17 = <?php echo json_encode($styleName3_1_17); ?>;
        const count_cj_1_17 = <?php echo json_encode($count_cj_1_17); ?>;
        const MedicalLaboratoryBiotechnology_student_cj = {
            labels: lables_3_1_17,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_17,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫社系)統計(大學生)
        const lables_3_1_18 = <?php echo json_encode($styleName3_1_18); ?>;
        const count_cj_1_18 = <?php echo json_encode($count_cj_1_18); ?>;
        const MedicalSocietySocialWork_student_cj = {
            labels: lables_3_1_18,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_18,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫管系)統計(大學生)
        const lables_3_1_19 = <?php echo json_encode($styleName3_1_19); ?>;
        const count_cj_1_19 = <?php echo json_encode($count_cj_1_19); ?>;
        const MedicalIndustryTechnologyManagement_student_cj = {
            labels: lables_3_1_19,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_19,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依特定系所(醫資系)統計(大學生)
        const lables_3_1_20 = <?php echo json_encode($styleName3_1_20); ?>;
        const count_cj_1_20 = <?php echo json_encode($count_cj_1_20); ?>;
        const MedicalInformatics_student_cj = {
            labels: lables_3_1_20,
            datasets: [{
                label: '中文期刊',
                data: count_cj_1_20,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位(系所名稱擷取)統計(研究生)
        const lables_3_2 = <?php echo json_encode($styleName3_2); ?>;
        const count_cj_2 = <?php echo json_encode($count_cj_2); ?>;
        const postgraduate_cj = {
            labels: lables_3_2,
            datasets: [{
                label: '中文期刊',
                data: count_cj_2,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位統計(教職員)
        const lables_3_3 = <?php echo json_encode($styleName3_3); ?>;
        const count_cj_3 = <?php echo json_encode($count_cj_3); ?>;
        const staff_cj = {
            labels: lables_3_3,
            datasets: [{
                label: '中文期刊',
                data: count_cj_3,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Setup Block_中文期刊_依單位統計(醫護人員)
        const lables_3_4 = <?php echo json_encode($styleName3_4); ?>;
        const count_cj_4 = <?php echo json_encode($count_cj_4); ?>;
        const medical_staff_cj = {
            labels: lables_3_4,
            datasets: [{
                label: '中文期刊',
                data: count_cj_4,
                backgroundColor: '#A5A5A5'
            }]
        };

        // Config Block
        const options = {
            responsive: true,
            // plugins:{
            //     title: {
            //         display: true,
            //         text: '各職位',
            //         fontColor: '#595959',
            //         fontsize: 20,
            //         position: 'top' //top,left,bottom,right
            //     }
            // },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) { if (value % 1 === 0) { return value; } }
                    },
                    title: {
                        display: true,
                        text: '次數'
                    },
                }
            },
            legend: {
                position: 'top',
                display: true
            }
            // animation: {
            //     duration: 1000,
            //     easing: 'linear' //easeOutQuart, easeInBounce, ...
            // }
        };

        const config = {
            type: 'bar',
            data: data,
            options: options
        };

        // Render Block
        Chart.defaults.font.size = 18;
        Chart.defaults.font.color = '#595959';
        Chart.defaults.font.family = "'Times New Roman','DFKai-sb'";
        const ctx = document.getElementById('Chart');
        const chart = new Chart(ctx, config);
        const originalChartSize = {
            width: ctx.width,
            height: ctx.height
        };

        // 長條圖下鑽(第一層至第二層)
        function handleFirstLayerClick(click) {
            if (chart.config.data.datasets[0].label === '中西文圖書' && chart.config.data.datasets[1].label === '視聽資料' && chart.config.data.datasets[2].label === '中文期刊') {
                const points = chart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
                if (points.length) {

                    const firstPoint = points[0];
                    console.log(firstPoint);

                    const gobackButton = document.getElementById('gobackButton');
                    gobackButton.style.display = 'block';
                    gobackButton.onclick = function () {
                        resetChart();
                    };

                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 0) {
                        updateSecondLayerChart(college_student_ceb);
                        ctx.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 1) {
                        updateSecondLayerChart(college_student_avm);
                        ctx.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 2) {
                        updateSecondLayerChart(college_student_cj);
                        ctx.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 0) {
                        chart.config.data = postgraduate_ceb;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 1) {
                        chart.config.data = postgraduate_avm;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 2) {
                        chart.config.data = postgraduate_cj;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 0) {
                        chart.config.data = staff_ceb;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 1) {
                        chart.config.data = staff_avm;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 2) {
                        chart.config.data = staff_cj;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 0) {
                        chart.config.data = medical_staff_ceb;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 1) {
                        chart.config.data = medical_staff_avm;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 2) {
                        chart.config.data = medical_staff_cj;
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 0) {
                        gobackButton.style.display = 'none';
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 1) {
                        gobackButton.style.display = 'none';
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 2) {
                        gobackButton.style.display = 'none';
                    }

                    chart.update();
                }
            }
        }
        ctx.onclick = handleFirstLayerClick;

        // 創建第二層的圖表
        let secondLayerChart;
        let ctx2;

        function updateSecondLayerChart(secondLayerData) {
            if (chart) {
                chart.destroy();
            }

            const gobackButton = document.getElementById('gobackButton');
            gobackButton.style.display = 'block';
            gobackButton.onclick = function () {
                location.reload();
            };

            ctx2 = document.getElementById('Chart');
            ctx2.width = originalChartSize.width;
            ctx2.height = originalChartSize.height;
            secondLayerChart = new Chart(ctx2, {
                type: 'bar',
                data: secondLayerData,
                options: options
            });
        }

        // 長條圖下鑽(第二層至第三層)
        function handleSecondLayerClick(click) {
            if (secondLayerChart.data.datasets[0].label === '中西文圖書') {
                const points = secondLayerChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
                if (points.length) {

                    const firstPoint = points[0];
                    console.log(firstPoint)

                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 0) {
                        ctx2.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = HealthIndustryTechnologyManagement_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PublicHealth_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Psychology_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = AppliedForeignLinguistics_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 5 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nutrition_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 6 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Dentistry_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 7 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PhysicalTherapy_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 8 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = BiomedicalSciences_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 9 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalSafetyHealth_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 10 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalTherapy_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 11 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Optometry_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 12 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = SpeechTherapyAudiology_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 13 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nursing_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 14 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalAppliedChemistry_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 15 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Medicine_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 16 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalImagingRadiologicalSciences_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 17 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalLaboratoryBiotechnology_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 18 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalSocietySocialWork_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 19 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalIndustryTechnologyManagement_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 20 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalInformatics_student_ceb;
                        ctx2.onclick = handleThirdLayerClick;
                    }

                    secondLayerChart.update();
                }

                const gobackButton = document.getElementById('gobackButton');
                gobackButton.style.display = 'block';
                gobackButton.onclick = function () {
                    secondLayerChart.data = college_student_ceb;
                    secondLayerChart.update();
                    ctx2.onclick = handleSecondLayerClick;
                    gobackButton.style.display = 'none';
                    gobackButton.style.display = 'block';
                    gobackButton.onclick = function () {
                        location.reload();
                    };
                };
            }
            else if (secondLayerChart.data.datasets[0].label === '視聽資料') {
                const points = secondLayerChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
                if (points.length) {

                    const firstPoint = points[0];
                    console.log(firstPoint)

                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 0) {
                        ctx2.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = HealthIndustryTechnologyManagement_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PublicHealth_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Psychology_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = AppliedForeignLinguistics_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 5 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nutrition_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 6 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Dentistry_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 7 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PhysicalTherapy_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 8 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = BiomedicalSciences_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 9 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalSafetyHealth_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 10 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalTherapy_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 11 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Optometry_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 12 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = SpeechTherapyAudiology_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 13 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nursing_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 14 && firstPoint.datasetIndex === 0) {
                    ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 15 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Medicine_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 16 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalImagingRadiologicalSciences_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 17 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalLaboratoryBiotechnology_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 18 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalSocietySocialWork_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 19 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalIndustryTechnologyManagement_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 20 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalInformatics_student_avm;
                        ctx2.onclick = handleThirdLayerClick;
                    }

                    secondLayerChart.update();
                }

                const gobackButton = document.getElementById('gobackButton');
                gobackButton.style.display = 'block';
                gobackButton.onclick = function () {
                    secondLayerChart.data = college_student_avm;
                    secondLayerChart.update();
                    ctx2.onclick = handleSecondLayerClick;
                    gobackButton.style.display = 'none';
                    gobackButton.style.display = 'block';
                    gobackButton.onclick = function () {
                        location.reload();
                    };
                };
            }
            else if (secondLayerChart.data.datasets[0].label === '中文期刊') {
                const points = secondLayerChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
                if (points.length) {

                    const firstPoint = points[0];
                    console.log(firstPoint)

                    if (firstPoint.index === 0 && firstPoint.datasetIndex === 0) {
                        ctx2.onclick = handleSecondLayerClick;
                    }
                    if (firstPoint.index === 1 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = HealthIndustryTechnologyManagement_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 2 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PublicHealth_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 3 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Psychology_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 4 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = AppliedForeignLinguistics_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 5 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nutrition_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 6 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Dentistry_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 7 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = PhysicalTherapy_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 8 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = BiomedicalSciences_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 9 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalSafetyHealth_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 10 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = OccupationalTherapy_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 11 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Optometry_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 12 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = SpeechTherapyAudiology_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 13 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Nursing_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 14 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalAppliedChemistry_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 15 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = Medicine_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 16 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalImagingRadiologicalSciences_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 17 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalLaboratoryBiotechnology_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 18 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalSocietySocialWork_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 19 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalIndustryTechnologyManagement_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }
                    if (firstPoint.index === 20 && firstPoint.datasetIndex === 0) {
                        secondLayerChart.data = MedicalInformatics_student_cj;
                        ctx2.onclick = handleThirdLayerClick;
                    }

                    secondLayerChart.update();
                }

                const gobackButton = document.getElementById('gobackButton');
                gobackButton.style.display = 'block';
                gobackButton.onclick = function () {
                    secondLayerChart.data = college_student_cj;
                    secondLayerChart.update();
                    ctx2.onclick = handleSecondLayerClick;
                    gobackButton.style.display = 'none';
                    gobackButton.style.display = 'block';
                    gobackButton.onclick = function () {
                        location.reload();
                    };
                };
            }
        }
        

        // 長條圖下鑽(第三層為最後一層 不做任何下鑽動作)
        function handleThirdLayerClick(click) {
            const points = secondLayerChart.getElementsAtEventForMode(click, 'nearest', { intersect: true }, true);
            if (points.length) {
                console.log('do noting');
            }
        }

        //回到第一層
        function resetChart() {
            chart.config.data = data;
            chart.update();
            const gobackButton = document.getElementById('gobackButton');
            gobackButton.style.display = 'none';
        }

        //下拉式選單篩選_year
        function year() {
            var year = [];
            var temp_year = document.getElementsByName("year");
            var yNow = document.getElementById("yearNow");
            var mNow = document.getElementById("monthNow").innerHTML;
            for (var i = 0; i < temp_year.length; i++) {
                if (temp_year[i].selected) {
                    year.push(temp_year[i].innerHTML);
                }
            }
            yNow.innerHTML = year;

            if (year != '') {
                if (mNow != '') {
                    location.href = "count_rr.php?year=" + year + "&month=" + mNow;
                }
                else {
                    location.href = "count_rr.php?year=" + year;
                }
            }
            else {
                location.href = "count_rr.php";
            }
        }

        //下拉式選單篩選_month
        function month() {
            var month = [];
            var temp_month = document.getElementsByName("month");
            var mNow = document.getElementById("monthNow");
            var yNow = document.getElementById("yearNow").innerHTML;
            for (var i = 0; i < temp_month.length; i++) {
                if (temp_month[i].selected) {
                    month.push(temp_month[i].innerHTML);
                }
            }
            mNow.innerHTML = month;

            if (month != '') {
                if (yNow != '') {
                    location.href = "count_rr.php?year=" + yNow + "&month=" + month;
                }
                else {
                    location.href = "count_rr.php";
                }
            }
            else {
                if (yNow != '') {
                    location.href = "count_rr.php?year=" + yNow;
                }
                else {
                    location.href = "count_rr.php";
                }
            }
        }
    </script>

    <br>

    <!--回上層button + 返回button-->
    <p style="text-align:center;">
        <input id="gobackButton" type="button" value="回上層" onclick="resetChart()" />
        <br>
        <input type="button" id="bbtn" value="返回" name="send" onclick="location.href = 'admin_index.php'" />
    </p>

    <script>
        window.onload = function() {
            const gobackButton = document.getElementById('gobackButton');
            gobackButton.style.display = 'none';
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

</body>

</html>