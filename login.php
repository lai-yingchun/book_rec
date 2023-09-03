<!DOCTYPE html>
<?php session_start();
require_once("./globefunction.php");
require_once('./mysql_connect.php');
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
        // enter-login
        function handleEnterKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                check();
            }
        }

        // validate-login
        function check() {
            var acc = document.getElementById("account").value;
            var pwd = document.getElementById("password").value;

            if (acc !== "" && pwd !== "") {
                document.getElementById("logintable").submit();
            } else if (acc === "") {
                alert("尚未填寫帳號！");
            } else if (pwd === "") {
                alert("尚未填寫密碼！");
            }
        }
    </script>
</head>

<body>
    <div class="left-section">

        </br></br>

        <img src="./imgs/logo.jpg" style="float:left; width:80%; margin-left:9%; margin-top:6%;">

        </br></br>

        <img src="./imgs/books.jpg" style="float:left; width:90%; margin-left:3%;">
    </div>

    <div class="right-section">

        </br></br></br></br></br>

        <h2 id="tit">登 入</h2>

        <br><br><br>

        <div id="layout">
            <!-- 登入 table -->
            <form id="logintable" name="logintable" method="post" enctype="multipart/form-data"
                action="validate_login.php">
                <p
                    style="text-align:right; margin-right:35%; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px;">
                    帳號：
                    <input type="text" placeholder="學號/悠遊卡證號/身分證字號" name="account" id="account"
                        onKeyUp="value=value.replace(/[\W]/g,'') " onkeydown="handleEnterKeyPress(event)" />
                </p>

                <p
                    style="text-align:right; margin-right:35%; color:#203057; font-family:Times New Roman,'DFKai-sb'; font-size:20px;">
                    密碼：
                    <input type="password" placeholder="Password" name="password" id="password"
                        onKeyUp="value=value.replace(/[\W]/g,'') " onkeydown="handleEnterKeyPress(event)" />
                    <img src="./imgs/eyeclose.jpg" style="width:4%; margin-right:-30px;" id="eyes">
                </p>

                <!-- 密碼顯示判斷 -->
                <script>
                    var input = document.querySelector('input[name="password"]');
                    var eyes = document.getElementById('eyes');
                    var flag = 0;
                    eyes.onclick = function () {
                        if (flag == 0) {
                            input.type = 'text';
                            eyes.src = './imgs/eyeopen.jpg';
                            flag = 1;
                        } else {
                            input.type = 'password';
                            eyes.src = './imgs/eyeclose.jpg';
                            flag = 0;
                        }
                    };
                </script>

                <!-- 帳號密碼說明 btn -->
                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="margin-left:54%; color:red; font-family:Times New Roman,'DFKai-sb'; font-size:18px;"><u>帳號密碼說明</u></a>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <img src="./imgs/notice.jpg" style="width:95%;">
                        </div>
                    </div>
                </div>

                <br><br><br><br><br>

                <!-- 登入 btn -->
                <div style="text-align:center;">
                    <input type="button" class="btn" name="send" value="登入" onclick="check();" />
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>

</html>