<!DOCTYPE html>
<?php session_start();
require_once("../globefunction.php");
require_once("../mysql_connect.php");
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./style.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>
        <?php showtitle() ?>
    </title>

    <script language="javascript">
        // 登出
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../logout.php";
        }

        // 按鈕隱藏
        function disableElement(cName) {
            var checkboxs = document.getElementsByName(cName);
            var count = 0;
            var updateNO = [];
            var u = document.getElementById("update");
            for (var i = 0; i < checkboxs.length; i++) {
                if (checkboxs[i].checked) {
                    count += 1;
                    updateNO.push(checkboxs[i].value);  //儲存打勾的no
                }
            }
            u.innerHTML = updateNO;
            if (count >= 1) {
                document.getElementById("edit").disabled = false;
                document.getElementById("send").disabled = false;
                document.getElementById("delete").disabled = false;
            }
            else {
                document.getElementById("edit").disabled = true;
                document.getElementById("send").disabled = true;
                document.getElementById("delete").disabled = true;
            }

            // 檢查全選框
            if (count != checkboxs.length) {
                document.getElementsByName("all")[0].checked = false;
            }
            else {
                document.getElementsByName("all")[0].checked = true;
            }
        }

        // 全選
        function check_all(obj, cName) {
            var checkboxs = document.getElementsByName(cName);
            for (var i = 0; i < checkboxs.length; i++) {
                checkboxs[i].checked = obj.checked;
            }
        }

        // 全選改值
        function allPush() {
            var updateNO = [];
            var u = document.getElementById("update");
            var ck = document.getElementsByName("all");
            var checkboxs = document.getElementsByName("check");
            if (ck.checked = true) {
                for (var i = 0; i < checkboxs.length; i++) {
                    updateNO.push(checkboxs[i].value);
                }
                u.innerHTML = updateNO;
            }
        }

        // 取消勾選
        function cancelChecked(obj, cName) {
            var checkboxs = document.getElementsByName(cName);
            for (var i = 0; i < checkboxs.length; i++) { checkboxs[i].checked = false; }
            document.getElementById("send").disabled = true;
            document.getElementById("delete").disabled = true;
            document.getElementById("edit").disabled = true;
        }

        // 搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;
            if (temp_search != '') {

                location.href = "cj_buysit4.php?search=" + temp_search;
            }
            else {
                location.href = "cj_buysit4.php";
            };
        }

        // 編輯採購狀況 - 取得 radio 值
        function changeState() {
            var state_list = document.getElementsByName("state");
            var Sno = document.getElementById("update");
            var selected = [];
            for (var i = 0; i < state_list.length; i++) {
                if (state_list[i].checked) {
                    selected.push(state_list[i].value);
                }
            }
            if (Sno != '' && selected != '') {
                location.href = "cj_buysit4.php?Sno=" + Sno.innerHTML + "&newState=" + selected;
            }
            else {
                location.href = "cj_buysit4.php";
            }
        }

        // 寄信
        function sendEmail() {
            var checkboxes = document.getElementsByName('check');
            var selectedValues = [];

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    selectedValues.push(checkbox.value);
                }
            });

            if (selectedValues.length > 0) {
                $.ajax({
                    url: 'email.php?nos=7,8,9&source=cj',
                    method: 'GET',
                    data: { nos: selectedValues.join(',') }, // 將選中的值分隔拼接成字符串
                    success: function (response) {
                        console.log(response);

                        // response 是從伺服器返回的郵件地址列表，格式為一行一個地址
                        var emailList = response.trim().split('\n');

                        if (emailList.length > 0) {
                            var subject = "您推薦書刊的採購狀況已更新";
                            var body = "您推薦的書刊已上架，可登入書刊推薦系統查看。";

                            var mailtoLink = "mailto:" + emailList.join(',') + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                            window.location.href = mailtoLink; // 在當前窗口打開郵件連結
                        } else {
                            console.log("郵件地址為空");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }

        // 刪除
        function empty() {
            var no = document.getElementById("update");
            if (no != '') {
                location.href = "cj_buysit4.php?no=" + no.innerHTML;
            }
            else {
                location.href = "cj_buysit4.php";
            }
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
            <li class="breadcrumb-item active" aria-current="page"><a href="cj_buysit1.php">中文期刊採購狀況</a></li>
        </ol>
    </nav>

    <h2 id="mid-title">中文期刊採購狀況</h2>

    <!-- 頁籤 -->
    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" aria-current="#" href="cj_buysit1.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">未採購</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cj_buysit2.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">採購中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cj_buysit3.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">編目中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="cj_buysit4.php"
                        style="font-size:20px; font-family:DFKai-sb; color:#203057; border:none;">已上架</a>
                </li>
            </ul>

            <form class="d-flex">
                <!-- 搜尋 -->
                <input class="light-table-filter" type="text" placeholder="Search" id="txt-search"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')" <?php
                    if (isset($_GET['search'])) {
                        echo 'value="' . $_GET['search'] . '"';
                    }
                    ?>>

                <input type="button" title="Search" id="search" value="搜尋" onClick="Search()">
            </form>

        </div>
    </nav>

    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <!-- 已上架 -->
            <div id="cj_table" style="width:100%;">
                <table class="table table-striped table-hover" id="record-table" align="center">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" name="all"
                                    onclick="check_all(this,'check'); disableElement('all'); allPush();">
                                編號
                            </th>
                            <th scope="col">推薦日期</th>
                            <th scope="col">推薦人</th>
                            <th scope="col">期刊名稱</th>
                            <th scope="col">預約</th>
                            <th scope="col">重複</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // 改變採購狀況
                        if (isset($_GET['Sno']) && isset($_GET['newState'])) {
                            $Sno_update = $_GET['Sno'];
                            $newState = $_GET['newState'];
                            $Sno_array = explode(",", $Sno_update);
                            $count_num = 0;
                            foreach ($Sno_array as $i => $value) {
                                $con->query("UPDATE `hrec_cj` 
                                            SET `situation` = '" . $newState . "', `empty` = '否'
                                            WHERE `no` =" . $value . ";");
                                $count_num += 1;
                            }
                        }

                        // 改變刪除狀態 (empty)
                        if (isset($_GET['no'])) {
                            $no_update = $_GET['no'];
                            $no_array = explode(",", $no_update);
                            foreach ($no_array as $i => $value) {
                                $con->query("UPDATE `hrec_cj` 
                                            SET `empty` = '是'
                                            WHERE `no` =" . $value . ";");
                            }
                        }

                        //算筆數
                        $sql_view = "SELECT * FROM hrec_cj WHERE `situation` LIKE '已上架' AND `empty` LIKE '否'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql_view = $sql_view . " and (
                                        date like '%" . $search . "%' or 
                                        name like '%" . $search . "%' or 
                                        title like '%" . $search . "%' or 
                                        pred like '%" . $search . "%'or 
                                        duplicate like '%" . $search . "%')";
                        }

                        $result = $con->query($sql_view);
                        if ($result) {
                            $total = mysqli_num_rows($result); // 總筆數
                            $number = intval($total / 20); //資料頁數
                            $spare = $total % 20; // 不滿一頁加一頁 
                            if ($spare != 0) {
                                $number += 1;
                            }
                            if ($number < 1) {
                                $number += 1;
                            }
                        }

                        // 資料表輸出內容 and empty like '否'
                        $sql = "SELECT `no`,`date`,`name`,`title`,`pred`,`duplicate`   
                                FROM hrec_cj
                                WHERE `situation` LIKE '已上架' AND `empty` LIKE '否'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = $sql . "and (
                                    date like '%" . $search . "%' or 
                                    name like '%" . $search . "%' or 
                                    title like '%" . $search . "%' or  
                                    pred like '%" . $search . "%'or 
                                    duplicate like '%" . $search . "%')";
                        }

                        // 資料表輸出格式
                        $sql = $sql . " ORDER BY date desc ";
                        if (isset($_GET['page'])) {
                            $temp = 0;
                            while ($temp < $number) {
                                $temp = $temp + 1;
                                if (intval($_GET['page']) == $temp) {
                                    $temp1 = ($temp - 1) * 20;
                                    $sql = $sql . ' LIMIT ' . $temp1 . ',20;';
                                    break;
                                }
                            }
                        } else {
                            $sql = $sql . " LIMIT 0,20;";
                        }

                        // 資料表輸出
                        $result = $con->query($sql);
                        $num = 1;
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            $num = $num + 20 * ($p - 1);
                        } else {
                            $p = 1;
                            $num = $num + 20 * ($p - 1);
                        }

                        while ($hrec_cj = $result->fetch_array()) {
                            echo '<tr style="vertical-align: middle;">';

                            echo '<th><input type="checkbox" name="check" onclick="disableElement(' . "'check'" . ')" value="' . $hrec_cj["no"] . '">&nbsp;' . $num . '</th>';
                            echo '<td>' . $hrec_cj["date"] . '</td>';
                            echo '<td>' . $hrec_cj["name"] . '</td>';
                            echo '<td style="width:30%;">' . $hrec_cj["title"] . '</td>';
                            echo '<td>' . $hrec_cj["pred"] . '</td>';
                            echo '<td>' . $hrec_cj["duplicate"] . '</td>';

                            echo '</tr>';
                            $num += 1;
                        }
                        if ($spare < 20 && $spare > 0) {
                            $need = 20 - $spare;
                            if (isset($_GET['page'])) {
                                $_SESSION['page'] = $_GET['page'];
                                if ($_SESSION['page'] == $number && $_SESSION['page'] != 1) {
                                    for ($i = 1; $i <= $need; $i++) {
                                        echo '<tr>
                                            <th>-</th>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            </tr>';
                                    }
                                }
                            }
                            if ($number == 1) {
                                for ($i = 1; $i <= $need; $i++) {
                                    echo '<tr>
                                        <th>-</th>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        </tr>';
                                }
                            }
                        }
                        if ($spare == 0 && $total == 0) {
                            for ($i = 1; $i <= 20; $i++) {
                                echo '<tr>
                                    <th>-</th>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- 暫存 -->
            <div id="update" style="display:none"></div>
            <?php
            if (isset($_GET['search'])) {
                $_SESSION['search'] = $_GET['search'];
                echo '<div id="searchNow" style="display:none">' . $_SESSION['search'] . '</div>';
            } else {
                echo '<div id="searchNow" style="display:none"></div>';
            }
            ?>

            <!-- btn group -->
            <p style="text-align:center; margin-left:423px">
                <input disabled="true" class="btn" type="button" id="edit" value="編輯採購狀況"
                    data-bs-target="#exampleModalToggle1" data-bs-toggle="modal" onclick="#">&emsp;
                <input disabled="true" type="button" class="btn" id="send" value="寄信"
                    onclick="sendEmail(); cancelChecked(this,'check'); cancelChecked(this,'all');" />&emsp;
                <input disabled="true" type="button" data-bs-toggle="modal" href="#exampleModalToggle5" class="btn"
                    id="delete" value="刪除" onclick="#" />
            </p>
        </div>
    </nav>

    <!-- 分頁 -->
    <div style="text-align:center;">
        <nav aria-label="Page navigation example" style="font-family:'Times New Roman';">
            <ul class="pagination justify-content-center">
                <!-- 回第一頁 -->
                <li class="page-item">
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="cj_buysit4.php?page=1&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="cj_buysit4.php?page=1" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    }
                    ?>
                </li>

                <!-- 往前一頁 -->
                <li class="page-item">
                    <?php
                    if (isset($_GET['search'])) {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1) {
                                $p = $p - 1;
                            } else {
                                $p = 1;
                            }
                            echo '<a class="page-link" href="cj_buysit4.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="cj_buysit4.php?page=1&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1) {
                                $p = $p - 1;
                            } else {
                                $p = 1;
                            }
                            echo '<a class="page-link" href="cj_buysit4.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="cj_buysit4.php?page=1" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        }
                    }
                    ?>
                </li>

                <!-- 頁數 -->
                <?php
                if (isset($_GET['search'])) {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                } else {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=1" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=2" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_buysit4.php?page=3" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                }
                ?>

                <!-- 往後一頁 -->
                <li class="page-item">
                    <?php
                    if (isset($_GET['search'])) {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p >= 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="cj_buysit4.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="cj_buysit4.php?page=1&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="cj_buysit4.php?page=2&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p >= 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="cj_buysit4.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="cj_buysit4.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="cj_buysit4.php?page=2" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </li>

                <!-- 到最後一頁 -->
                <li class="page-item">
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="cj_buysit4.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="cj_buysit4.php?page=' . $number . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>

    <br><br>

    <!-- 返回 btn -->
    <p style="text-align:center;">
        <input type="button" id="bbtn" name="send" value="返回" onclick="location.href = 'admin_index.php'" />
    </p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

    <!-- 編輯採購狀況的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle1" aria-hidden="true" tabindex="-1"
        aria-labelledby="exampleModalToggle1" data-bs-toggle="modal">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit" style="color:#203057;"><b>編輯採購狀況</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="radio" name="state" value="待處理">待處理
                    <input type="radio" name="state" value="未採購">未採購
                    <input type="radio" name="state" value="採購中">採購中
                    <input type="radio" name="state" value="編目中">編目中
                    <input type="radio" name="state" value="已上架" CHECKED>已上架
                </div>
                <div class="modal-footer">
                    <button id="sure" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');changeState();">確定</button>
                    <button id="cancel" aria-label="Close" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2" style="color:#203057;"><b>編輯採購狀況</b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    採購狀況已變更！
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                        height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');changeState();">確定</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- 刪除的彈跳視窗 -->
    <div class="modal fade" id="exampleModalToggle5" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    是否確定刪除紀錄？
                </div>
                <div class="modal-footer">
                    <button id="sure" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');empty()">確定</button>
                    <button id="cancel" aria-label="Close" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="exampleModalToggle6" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel6" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    紀錄已刪除！
                </div>
                <div class="modal-footer">
                    <button style="background-color:#203057; font-size:18px; font-family:DFKai-sb; color:white;
                                                height:37px; width:98px; border-radius:3px;"
                        data-bs-target="#exampleModalToggle6" data-bs-toggle="modal" data-bs-dismiss="modal"
                        onclick="cancelChecked(this,'check');cancelChecked(this,'all');empty()">確定</button>
                </div>
            </div>
        </div>
    </div> -->
</body>

</html>