<script>
// setTimeout("location.href='ceb_buysit1.php'",1000);
</script>

<?php
if (isset($_POST["message-text"])) {
    $_SESSION["text"] = $_POST["message-text"];
} else {
    $_SESSION["text"] = 0;
}

if (isset($_POST["check"])) {
    $c = $_POST["check"];
    $_SESSION["no"] = [];
    array_push($_SESSION["no"], $c);

    foreach ($_SESSION["no"] as $i => $v) {
        echo $v;
    }
} else {
    $_SESSION["no"] = 0;
}

// echo $_SESSION["text"].$_SESSION["no"];

?>