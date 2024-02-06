<?php 
$uid = $_SESSION['pgf2023_uid'];
$role = $_SESSION['pgf2023_role'];
$token = $_SESSION['pgf2023_token'];
$strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid' AND active_status = 'Y' AND allow_status = 'Y' AND delete_status = 'N'";
$currentUser = $db->fetch($strSQL, false, false);
if(!$currentUser){
    $db->close();
    header('Location: ' . ROOT_DOMAIN . 'pgf2023/submission/');
    die();
}
?>