<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_account']);
unset($_SESSION['user_info']);
unset($_SESSION['user_style']);

echo '登出中......';
echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
?>