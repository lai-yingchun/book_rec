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
                    updateNO.push(checkboxs[i].value);  // 儲存打勾的no
                }
            }
            u.innerHTML = updateNO;
            if (count >= 1) {
                document.getElementById("edit").disabled = false;
                //document.getElementById("download").disabled=false;
            }
            else {
                document.getElementById("edit").disabled = true;
                //document.getElementById("download").disabled=true;
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

        // 全選修改
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
            document.getElementById("edit").disabled = true;
            //document.getElementById("download").disabled=true;  
        }

        // 搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;
            if (temp_search != '') {
                location.href = "cj_pending.php?search=" + temp_search;
            }
            else {
                location.href = "cj_pending.php";
            };
        }

        // 下載
        function downloadExcel(section) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'download_query.php?section=' + section, true);
            xhr.responseType = 'text'; // 請求的響應內容為文本

            xhr.onload = function () {
                if (xhr.status === 200) {
                    var csvContent = xhr.responseText;
                    var csvContentWithBOM = '\uFEFF' + csvContent;
                    var blob = new Blob([csvContentWithBOM], { type: 'text/csv;charset=utf-8;' });
                    var link = document.createElement('a');

                    // 生成帶有日期時間的文件名（台灣時間）
                    var currentDate = new Date();
                    var formattedDate =
                        ('0' + (currentDate.getMonth() + 1)).slice(-2) +
                        ('0' + currentDate.getDate()).slice(-2) +
                        ('0' + currentDate.getHours()).slice(-2) +
                        ('0' + currentDate.getMinutes()).slice(-2);

                    var filename = formattedDate + '_中文期刊待處理推薦清單' + '.csv';

                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    link.click();
                }
            };

            xhr.send();
        }

        // 刪除
        function empty() {
            var no = document.getElementById("update");
            if (no != '') {
                location.href = "cj_pending.php?no=" + no.innerHTML;
            }
            else {
                location.href = "cj_pending.php";
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
            <li class="breadcrumb-item active" aria-current="page"><a href="cj_pending.php">中文期刊待處理推薦清單</a></li>
        </ol>
    </nav>

    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <h2 id="la-tit">中文期刊待處理推薦清單</h2>

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

            <!-- 推薦紀錄表格 -->
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
                        // 改變刪除狀態 (empty)
                        if (isset($_GET['no'])) {
                            $no_update = $_GET['no'];
                            $no_array = explode(",", $no_update);
                            foreach ($no_array as $i => $value) {
                                $con->query("UPDATE `hrec_cj` 
                                            SET `situation`='未採購'
                                            WHERE `no` =" . $value . ";");
                            }
                        }

                        // 算筆數
                        $sql_view = "SELECT * FROM hrec_cj WHERE `situation` LIKE '待處理' AND `empty` LIKE '否'";
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
                            $number = intval($total / 20); // 資料頁數
                            $spare = $total % 20; // 不滿一頁加一頁 
                            if ($spare != 0) {
                                $number += 1;
                            }
                            if ($number < 1) {
                                $number += 1;
                            }
                        }

                        // 資料表輸出內容 and empty like '否'
                        $sql = "SELECT `no`,`date`,`name`,`title`,`pred`,`situation`,`duplicate` 
                                FROM hrec_cj
                                WHERE `situation` LIKE '待處理' AND `empty` lIKE '否'";
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

            <!-- btn group -->
            <p style="text-align:center; margin-left:506px">
                <input class="btn" type="button" id="download" value="下載" onclick="downloadExcel('cj_pending')">
                &emsp;
                <input disabled="true" class="btn" type="button" id="edit" value="刪除"
                    data-bs-target="#exampleModalToggle1" data-bs-toggle="modal" onclick="#">
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
                        echo '<a class="page-link" href="cj_pending.php?page=1&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="cj_pending.php?page=1" aria-label="Previous">';
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
                            echo '<a class="page-link" href="cj_pending.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="cj_pending.php?page=1&search=' . $search . '" aria-label="Previous">';
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
                            echo '<a class="page-link" href="cj_pending.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="cj_pending.php?page=1" aria-label="Previous">';
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
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                } else {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=1" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=2" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="cj_pending.php?page=3" style="color:#203057;">3</a></li>';
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
                            echo '<a class="page-link" href="cj_pending.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="cj_pending.php?page=1&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="cj_pending.php?page=2&search=' . $search . '" aria-label="Previous">';
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
                            echo '<a class="page-link" href="cj_pending.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="cj_pending.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="cj_pending.php?page=2" aria-label="Previous">';
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
                        echo '<a class="page-link" href="cj_pending.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="cj_pending.php?page=' . $number . '" aria-label="Previous">';
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
                    <h5 class="modal-title" id="edit" style="color:#203057;"><b>刪除</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    是否確定刪除紀錄？
                </div>
                <div class="modal-footer">
                    <button id="sure" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                        data-bs-dismiss="modal">確定</button>
                    <button id="cancel" aria-label="Close" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content" style="font-size:18px; font-family:DFKai-sb;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2" style="color:#203057;"><b>刪除</b>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    紀錄已刪除！
                </div>
                <div class="modal-footer">
                    <button id="sure" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                        data-bs-dismiss="modal"
                        onclick="empty(); cancelChecked(this,'check'); cancelChecked(this,'all');">確定</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>