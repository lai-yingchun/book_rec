<!DOCTYPE html>
<?php session_start();
require_once("../globefunction.php");
include_once('../mysql_connect.php');
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF8" />
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

        // 搜尋
        function Search() {
            var temp_search = document.getElementById("txt-search").value;
            if (temp_search != '') {
                location.href = "avm_record.php?search=" + temp_search;
            }
            else {
                location.href = "avm_record.php";
            };
        }  
    </script>

    <style>
        body {
            background-image: linear-gradient(to bottom, #FBE5D6 15%, white 85%);
            background-attachment: fixed;
            background-position: center;
            background-size: 100%;
        }

        input:disabled {
            text-align: center;
            background-color: #D3D3D3;
            color: #203057;
            border-color: #203057;
            font-size: 20px;
            font-family: 'DFKai-sb';
            height: 40px;
            width: 150px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php showheader() ?>
        <div id="user">
            讀者&nbsp;-
            <?php
            if (isset($_SESSION['user_id']) && isset($_SESSION['user_style'])) {
                $allowedStyles = array('大學生', '研究生', '教職員', '醫護人員', '其他');
                $userStyle = $_SESSION['user_style'];

                if (!in_array($userStyle, $allowedStyles)) {
                    echo '<script>alert("您並非本系統的使用者！");</script>';
                    echo '<script>window.location.href = "../login.php";</script>';
                    exit();
                } else {
                    $userName = $_SESSION['user_name'];
                    echo htmlspecialchars($userName);
                }
            } else {
                echo '<script>alert("您尚未登入！");</script>';
                echo '<script>window.location.href = "../login.php";</script>';
                exit();
            }
            ?>&nbsp;
        </div>
    </div>

    <hr style="height:3px; margin-top:0px;">

    <!-- 路徑 -->
    <nav style="--bs-breadcrumb-divider: '>'; margin-left:10px; margin-top:-10px;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="reader_index.php">首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="avm_record.php">視聽資料推薦紀錄</a></li>
        </ol>
    </nav>

    <nav class="navbar navbar-light" style="width:95%;">
        <div class="container-fluid" style="margin-left:5.5%;">
            <h2 id="la-tit">視聽資料推薦紀錄</h2>

            <!-- 搜尋 -->
            <form class="d-flex">
                <input class="light-table-filter" type="text" placeholder="Search" id="txt-search"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')" <?php
                    if (isset($_GET['search'])) {
                        echo 'value="' . $_GET['search'] . '"';
                    }
                    ?>>

                <input type="button" title="Search" id="search" value="搜尋" onClick="Search()">
            </form>

            <!-- 推薦紀錄表格 -->
            <div id="avm_table" style="width:100%;">
                <table class="table table-striped table-hover" id="record-table" align="center">
                    <thead>
                        <tr>
                            <th scope="col">編號</th>
                            <th scope="col">視聽名稱</th>
                            <th scope="col">推薦日期</th>
                            <th scope="col">採購狀況</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $userInfo = $_SESSION['user_info'];
                        $uid = $userInfo['uid'];
                        // $maskedUid = str_repeat('*', strlen($uid));
                        
                        // 算筆數
                        $sql_view = "SELECT * FROM hrec_avm WHERE `id` LIKE'" . $uid . "'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql_view = $sql_view . "and (
                                        date like '%" . $search . "%' or 
                                        video like '%" . $search . "%' or 
                                        situation like '%" . $search . "%')";
                        }

                        $result = $con->query($sql_view);
                        if ($result) {
                            $total = mysqli_num_rows($result); // 總筆數
                            $number = intval($total / 10); // 資料頁數
                            $spare = $total % 10; // 不滿一頁加一頁 
                            if ($spare != 0) {
                                $number += 1;
                            }
                            if ($number < 1) {
                                $number += 1;
                            }
                        }

                        // 資料表輸出內容
                        $sql = "SELECT `no`, `video`, `date`,`situation` 
                                FROM hrec_avm
                                WHERE `id` LIKE '" . $uid . "'";
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $sql = $sql . "and(  
                                    video like '%" . $search . "%' or 
                                    date like '%" . $search . "%'or 
                                    situation like '%" . $search . "%')";
                        }

                        // 資料表輸出格式
                        $sql = $sql . " ORDER BY date desc ";
                        if (isset($_GET['page'])) {
                            $temp = 0;
                            while ($temp < $number) {
                                $temp = $temp + 1;
                                if (intval($_GET['page']) == $temp) {
                                    $temp1 = ($temp - 1) * 10;
                                    $sql = $sql . ' LIMIT ' . $temp1 . ',10;';
                                    break;
                                }
                            }
                        } else {
                            $sql = $sql . " LIMIT 0,10;";
                        }

                        // 資料表輸出
                        $result = $con->query($sql);
                        $num = 1;
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            $num = $num + 10 * ($p - 1);
                        } else {
                            $p = 1;
                            $num = $num + 10 * ($p - 1);
                        }

                        while ($hrec_avm = $result->fetch_array()) {
                            echo '<tr style="vertical-align: middle;">';

                            echo '<th>' . $num . '</th>';
                            echo '<td style="width:50%;">' . $hrec_avm["video"] . '</td>';
                            echo '<td>' . $hrec_avm["date"] . '</td>';
                            echo '<td>' . $hrec_avm["situation"] . '</td>';

                            echo '</tr>';
                            $num += 1;
                        }
                        if ($spare < 10 && $spare > 0) {
                            $need = 10 - $spare;
                            if (isset($_GET['page'])) {
                                $_SESSION['page'] = $_GET['page'];
                                if ($_SESSION['page'] == $number && $_SESSION['page'] != 1) {
                                    for ($i = 1; $i <= $need; $i++) {
                                        echo '<tr>
                                            <th>-</th>
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
                                        </tr>';
                                }
                            }
                        }
                        if ($spare == 0 && $total == 0) {
                            for ($i = 1; $i <= 10; $i++) {
                                echo '<tr>
                                    <th>-</th>
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
            <?php
            if (isset($_GET['search'])) {
                $_SESSION['search'] = $_GET['search'];
                echo '<div id="searchNow" style="display:none">' . $_SESSION['search'] . '</div>';
            } else {
                echo '<div id="searchNow" style="display:none"></div>';
            }
            ?>
        </div>
    </nav>

    <!-- 分頁 -->
    <div>
        <nav aria-label="Page navigation example" style="font-family:'Times New Roman';">
            <ul class="pagination justify-content-center">
                <!-- 回第一頁 -->
                <li class="page-item">
                    <?php
                    if (isset($_GET['search'])) {
                        echo '<a class="page-link" href="avm_record.php?page=1&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&laquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="avm_record.php?page=1" aria-label="Previous">';
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
                            echo '<a class="page-link" href="avm_record.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="avm_record.php?page=1&search=' . $search . '" aria-label="Previous">';
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
                            echo '<a class="page-link" href="avm_record.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&lt;</span>';
                            echo '</a>';
                        } else {
                            echo '<a class="page-link" href="avm_record.php?page=1" aria-label="Previous">';
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
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $i . '&search=' . $search . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 2) . '&search=' . $search . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $number . '&search=' . $search . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 1) . '&search=' . $search . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $p . '&search=' . $search . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p + 1) . '&search=' . $search . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=1&search=' . $search . '" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=2&search=' . $search . '" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=3&search=' . $search . '" style="color:#203057;">3</a></li>';
                            }
                        }
                    }
                } else {
                    if (isset($number)) {
                        if ($number <= 3) {
                            for ($i = 1; $i <= $number; $i++) {
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $i . '" style="color:#203057;">' . $i . '</a></li>';
                            }
                        } else {
                            if (isset($_GET['page'])) {
                                $p = intval($_GET['page']);
                                if ($p >= 3) {
                                    if (($p + 1) > $number) {
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 2) . '" style="color:#203057;">' . ($p - 2) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $number . '" style="color:#203057;">' . $number . '</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p - 1) . '" style="color:#203057;">' . ($p - 1) . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . $p . '" style="color:#203057;">' . $p . '</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=' . ($p + 1) . '" style="color:#203057;">' . ($p + 1) . '</a></li>';
                                    }
                                } else {
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=1" style="color:#203057;">1</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=2" style="color:#203057;">2</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=3" style="color:#203057;">3</a></li>';
                                }
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=1" style="color:#203057;">1</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=2" style="color:#203057;">2</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="avm_record.php?page=3" style="color:#203057;">3</a></li>';
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
                            if ($p > 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="avm_record.php?page=' . $p . '&search=' . $search . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="avm_record.php?page=1&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="avm_record.php?page=2&search=' . $search . '" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            }

                        }
                    } else {
                        if (isset($_GET['page'])) {
                            $p = intval($_GET['page']);
                            if ($p > 1 && $p < $number) {
                                $p += 1;
                            } else {
                                $p = $number;
                            }
                            echo '<a class="page-link" href="avm_record.php?page=' . $p . '" aria-label="Previous">';
                            echo '<span aria-hidden="true">&gt;</span>';
                            echo '</a>';
                        } else {
                            if ($number == 1) {
                                echo '<a class="page-link" href="avm_record.php?page=1" aria-label="Previous">';
                                echo '<span aria-hidden="true">&gt;</span>';
                                echo '</a>';
                            } else {
                                echo '<a class="page-link" href="avm_record.php?page=2" aria-label="Previous">';
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
                        echo '<a class="page-link" href="avm_record.php?page=' . $number . '&search=' . $search . '" aria-label="Previous">';
                        echo '<span aria-hidden="true">&raquo;</span>';
                        echo '</a>';
                    } else {
                        echo '<a class="page-link" href="avm_record.php?page=' . $number . '" aria-label="Previous">';
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
        <input type="button" class="send-btn" name="send" value="繼續推薦" onclick="location.href = 'avm_rec.php'" />
    </p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>

    <br>

</body>

</html>