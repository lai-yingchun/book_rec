<!DOCTYPE html>
<?php session_start();
require_once("../globefunction.php");
include_once('../mysql_connect.php');
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

    <script>
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../logout.php";
        }
    </script>

    <style>
        body {
            background-image: linear-gradient(to left, white 65%, #FBE5D6 35%);
            background-attachment: fixed;
            background-position: center;
            background-size: 100%;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php showheader1() ?>
        <div id="user">
            管理者&nbsp;-
            <?php
            // if (isset($_SESSION['user_id']) && isset($_SESSION['user_style']) && $_SESSION['user_style'] === "管理員") {
            //     $userName = $_SESSION['user_name'];
            //     echo htmlspecialchars($userName);
            // }
            // else {
            //     echo '<script>alert("您尚未登入！");</script>';
            //     echo '<script>window.location.href = "../login.php";</script>';
            //     exit();
            // }
            ?>&nbsp;
        </div>
    </div>

    <hr style="height:3px; margin-top:0px;">

    <div class="left-section">

        <br>

        <!-- 通知欄 -->
        <div style="text-align:center;">
            <p id="notice">通 知 欄</p>
            <div align="center"
                style=" width:505px; height:255px; overflow-y:scroll; /*縱向滾動條始終顯示*/ overflow-x:none; margin-left:15px;">
                <table id="notice-table">
                    <?php
                    // 推薦圖書
                    $sql = "SELECT `name`,`book` FROM `hrec_ceb` WHERE `situation`='待處理' AND `empty`='否' ORDER BY date desc;";
                    $result = mysqli_query($con, $sql);
                    $num = $con->query($sql);

                    if ($num) {
                        $total = mysqli_num_rows($num);
                    }
                    if ($total >= 1) {
                        echo "<tr> <th style='color:#FF5151'>中西文圖書</th> </tr>";
                    }
                    while ($hrec_ceb = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<th style='width:20%;'>推薦人：</th>";
                        echo "<td>" . $hrec_ceb['name'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>推薦圖書：</th>";
                        echo "<td>" . $hrec_ceb['book'] . "</td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 推薦視聽
                    $sql_1 = "SELECT `name`,`video` FROM `hrec_avm` WHERE `situation`='待處理' AND `empty`='否' ORDER BY date desc;";
                    $result = mysqli_query($con, $sql_1);
                    $num1 = $con->query($sql_1);

                    if ($num1) {
                        $total1 = mysqli_num_rows($num1);
                    }
                    if ($total1 >= 1) {
                        echo "<tr> <th style='color:#FF5151'>視聽資料</th> </tr>";
                    }
                    while ($hrec_avm = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<th style='width:20%;'>推薦人：</th>";
                        echo "<td>" . $hrec_avm['name'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th >推薦視聽：</th>";
                        echo "<td>" . $hrec_avm['video'] . "</td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 推薦期刊
                    $sql_2 = "SELECT `name`,`title` FROM `hrec_cj` WHERE `situation`='待處理' AND `empty`='否' ORDER BY date desc;";
                    $result = mysqli_query($con, $sql_2);
                    $num2 = $con->query($sql_2);

                    if ($num2) {
                        $total2 = mysqli_num_rows($num2);
                    }
                    if ($total2 >= 1) {
                        echo "<tr> <th style='color:#FF5151'>中文期刊</th> </tr>";
                    }
                    while ($hrec_cj = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<th style='width:20%;'>推薦人：</th>";
                        echo "<td>" . $hrec_cj['name'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th >推薦期刊：</th>";
                        echo "<td>" . $hrec_cj['title'] . "</td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 無推薦書刊
                    $all_total = $total + $total1 + $total2;
                    if ($all_total == 0) {
                        echo "<tr> <td style='height:255px;text-align: center;'>目前已無待處理書刊</td> </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <br>

        <!-- 統計推薦紀錄 btn -->
        <div style="text-align:center;">
            <input class="cbtn" type="button" value="統計推薦紀錄" onclick="location.href='count_rr.php'">
        </div>
    </div>

    <div class="right-section">

        <br>

        <h2 id="tit">推 薦 書 刊 管 理</h2>

        <br>

        <div class="row row-cols-3 row-cols-md-3 g-4"
            style="width:80%; margin-left:10%; font-family:Times New Roman,'DFKai-sb'; font-size:20px; text-align:center;">
            <!-- 中西文圖書 -->
            <div style="text-align:center;">
                <h3 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; text-align:center;">中西文圖書</h3>
                <img src="../imgs/ceb.jpg" data-bs-toggle="dropdown" aria-expanded="false" style="width:85%;">

                <br><br>

                <ul style="text-align:center; width:100%; margin-left:-16px;" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="ceb_pending.php">待處理推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="ceb_history.php">歷史推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="ceb_buysit1.php">採購狀況</a></li>
                </ul>
            </div>

            <!-- 視聽資料 -->
            <div style="text-align:center;">
                <h3 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; text-align:center;">視聽資料</h3>
                <img src="../imgs/avm.jpg" data-bs-toggle="dropdown" aria-expanded="false" style="width:85%;">

                <br><br>

                <ul style="text-align:center; width:100%; margin-left:-16px;" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="avm_pending.php">待處理推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="avm_history.php">歷史推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="avm_buysit1.php">採購狀況</a></li>
                </ul>
            </div>

            <!-- 中文期刊 -->
            <div style="text-align:center;">
                <h3 style="color:#203057; font-family:Times New Roman,'DFKai-sb'; text-align:center;">中文期刊</h3>
                <img src="../imgs/cj.jpg" data-bs-toggle="dropdown" aria-expanded="false" style="width:85%;">

                <br><br>

                <ul style="text-align:center; width:100%; margin-left:-16px;" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="cj_pending.php">待處理推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="cj_history.php">歷史推薦清單</a></li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="cj_buysit1.php">採購狀況</a></li>
                </ul>
            </div>
        </div>
    </div>

    <br><br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>

</html>