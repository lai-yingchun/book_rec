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
        // 登出
        function logout() {
            answer = confirm("你確定要登出嗎？");
            if (answer)
                location.href = "../logout.php";
        }

        // 推薦確認
        function sub() {
            var mas = "是否確定推薦此圖書？";
            var agree_yn = document.getElementById('denyYN');
            if (agree_yn.checked) {
                if (confirm(mas) == true) {
                    if ($book == "" && $isbn == "") {
                        event.preventDefault();
                    }
                    else {
                        document.getElementById('subform').submit();
                    }
                }
                else {
                    event.preventDefault();
                }
            }
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
                        echo "<td >" . $hrec_ceb['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_ceb['nbReason'] . "</span></td>";
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
                        echo "<td >" . $hrec_avm['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_avm['nbReason'] . "</span></td>";
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
                        echo "<td >" . $hrec_cj['situation'] . "&nbsp&nbsp&nbsp<span style='color: red;'>" . $hrec_cj['nbReason'] . "</span></td>";
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
        <p style="text-align:center;">
            <input type="button" class="history-btn" name="send" value="推薦紀錄"
                onclick="location.href='ceb_record.php'" />
        </p>

        <!-- 回首頁 btn -->
        <p style="text-align:center;">
            <input type="button" class="bindex-btn" name="send" value="回首頁"
                onclick="location.href='reader_index.php'" />
        </p>
    </div>

    <div class="right-section">

        </br></br>

        <h2 id="tit" style="margin-left:20%">推 薦 圖 書&emsp;&nbsp;&nbsp;&nbsp;
            <b style="color:red; font-family:Times New Roman,'DFKai-sb'; font-size:18.5px;"
                class="required-label">為必填</b>
        </h2>

        <br>

        <div style="color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:24px; float:left; margin-left:28%">
            <form method="post" action="cebr_judge.php" id="subform">
                <!-- 中西文選項欄位 -->
                <label for="language" class="required-label">中西文：</label>
                <input type="radio" id="chinese" name="language" value="中文" required checked>
                <label for="chinese">中文</label>
                <input type="radio" id="english" name="language" value="西文" required>
                <label for="english">西文</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <!-- 預約選項欄位 -->
                <label for="pred" class="required-label">預約：</label>
                <input type="radio" id="是" name="pred" value="是" required checked>
                <label for="yes">是</label>
                <input type="radio" id="否" name="pred" value="否" required>
                <label for="no">否</label><br><br>
                <!-- 書名欄位 -->
                <label for="book" class="required-label">書名：</label>
                <input type="text" style="width:389px;" id="book" name="book" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- ISBN欄位 -->
                <label for="isbn" class="required-label">ISBN：</label>
                <input type="text" style="width:382px;" id="isbn" name="isbn" required autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"><br><br>
                <!-- 網址欄位 -->
                <label for="IntroUrl">請提供您查得此書資料的網址：</label><br>
                <input type="url" style="width:483px;" id="IntroUrl" name="IntroUrl" autocomplete="off"><br><br>
                <!-- 理由欄位 -->
                <label for="reason">推薦理由：</label><br>
                <textarea id="reason" style="width:483px; height:200px; resize:none;" name="reason" autocomplete="off"
                    onchange="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5]/g,'')"></textarea><br>
                <!-- 必勾欄位 -->
                <input type="checkbox" id="denyYN" name="denyYN" value="accepted" required>
                <label for="denyYN"><b style="color:red; font-size:18.5px;">同意蒐集以上輸入資料僅供日後聯絡推薦書刊到館等事宜</b></label>
                <br><br>
                <input type="hidden" id="isbnText" name="isbnTest" value="0">
                <!-- 送出 btn -->
                <p style="text-align:center;">
                    <button class="send-btn" name="send" onclick="sub();">送出</button>
                </p>
            </form>

            <br>

        </div>
    </div>
</body>

</html>