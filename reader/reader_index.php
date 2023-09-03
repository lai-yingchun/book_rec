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
                    $userInfo = $_SESSION['user_info'];
                    $uid = $userInfo['uid'];
                    // $maskedUid = str_repeat('*', strlen($uid));
                    
                    $sql = "SELECT `book`,`situation`,`nbReason` FROM `hrec_ceb` WHERE `id`='" . $uid . "' ORDER BY date desc; ";
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
                        echo "<th style='width:20%;'>推薦圖書：</th>";
                        echo "<td>" . $hrec_ceb['book'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th style='width:20%;'>採購狀況：</th>";
                        echo "<td>" . $hrec_ceb['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_ceb['nbReason'] . "</span></td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 推薦視聽
                    $userInfo = $_SESSION['user_info'];
                    $uid = $userInfo['uid'];
                    // $maskedUid = str_repeat('*', strlen($uid));
                    
                    $sql_1 = "SELECT `video`,`situation`,`nbReason` FROM `hrec_avm` WHERE `id`='" . $uid . "' ORDER BY date desc; ";
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
                        echo "<th style='width:20%;'>推薦視聽：</th>";
                        echo "<td>" . $hrec_avm['video'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th style='width:20%;'>採購狀況：</th>";
                        echo "<td>" . $hrec_avm['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_avm['nbReason'] . "</span></td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 推薦期刊
                    $userInfo = $_SESSION['user_info'];
                    $uid = $userInfo['uid'];
                    // $maskedUid = str_repeat('*', strlen($uid));
                    
                    $sql_2 = "SELECT `title`,`situation`,`nbReason` FROM `hrec_cj` WHERE `id`='" . $uid . "' ORDER BY date desc; ";
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
                        echo "<th style='width:20%;'>推薦期刊：</th>";
                        echo "<td>" . $hrec_cj['title'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th style='width:20%;'>採購狀況：</th>";
                        echo "<td>" . $hrec_cj['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_cj['nbReason'] . "</span></td>";
                        echo "</tr>";

                        echo "<tr> <td>-</td> </tr>";
                    }

                    // 尚未推薦書刊
                    $all_total = $total + $total1 + $total2;
                    if ($all_total == 0) {
                        echo "<tr> <td style='height:255px;text-align: center;'>尚未推薦書刊</td> </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

        <br>

        <!-- 歷史推薦紀錄 btn -->
        <div class="dropdown" style="text-align:center;">
            <button class="history-btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                推薦紀錄
            </button>

            <!-- 歷史推薦紀錄 btn 類別 -->
            <ul class="dropdown-menu" style="text-align:center; width:46.5%;" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="ceb_record.php">中西文圖書</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="avm_record.php">視聽資料</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="cj_record.php">中文期刊</a></li>
            </ul>
        </div>
    </div>

    <div id="right-section">

        <br><br>

        <h2 id="tit">個 人 書 刊 推 薦</h2>

        <br><br><br>

        <!-- 書刊推薦類別 -->
        <div>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="ceb" value="中西文圖書" onclick="location.href='ceb_rec.php'" />
            </p>
            <br><br>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="avm" value="視聽資料" onclick="location.href='avm_rec.php'" />
            </p>
            <br><br>
            <p style="text-align:center;">
                <input type="button" class="bbtn" name="cj" value="中文期刊" onclick="location.href='cj_rec.php'" />
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>

</html>