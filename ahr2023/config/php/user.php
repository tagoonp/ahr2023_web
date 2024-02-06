<?php 
$uid = $_SESSION['ahr2023_uid'];
$role = $_SESSION['ahr2023_role'];
$token = $_SESSION['ahr2023_token'];
$strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid' AND active_status = 'Y' AND allow_status = 'Y' AND delete_status = 'N'";
$currentUser = $db->fetch($strSQL, false, false);
if(!$currentUser){
    $db->close();
    header('Location: ' . ROOT_DOMAIN . 'ahr2023/submission/');
    die();
}
?>