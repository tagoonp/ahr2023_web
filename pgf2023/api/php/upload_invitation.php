<?php 
require('../../../config/php/config.conf.php');
require('../../../config/php/database.php'); 
// require('../../../config/php/function.php'); 

$page_name = basename(__FILE__) ;


$return = array();
$buffer = array(); 

$uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
$token = mysqli_real_escape_string($conn, $_REQUEST['token']);
$reviewer_uid = mysqli_real_escape_string($conn, $_REQUEST['reviewer_uid']);

$strSQL = "SELECT uid FROM sx4_account WHERE active_status = 'Y' AND delete_status = 'N' AND allow_status = 'Y' AND uid = '$uid'";
$res = $db->fetch($strSQL, false, false);

if($res){
    
    $strSQL = "SELECT uid FROM sx4_account WHERE active_status = 'Y' AND delete_status = 'N' AND allow_status = 'Y' AND uid = '$reviewer_uid'";
    $resAbs = $db->fetch($strSQL, false, false);
    if(!$resAbs){
        echo "Fail x1001";
        $db->close(); 
        die();
    }

    if(isset($_FILES)){
    
        $originalName = $_FILES['file']['name'];
        $path = "../../upload/invitation/";
    
        $generatedName = $dateu.'-'.$_FILES['file']['name'];
        $filePath = $path.$generatedName;
    
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $fileUrl = ROOT_DOMAIN.'pgf2023/upload/invitation/'.$generatedName;
    
            $strSQL = "UPDATE sx4_account SET invitation_letter_url = '$fileUrl' WHERE uid = '$reviewer_uid'";
            $db->execute($strSQL);
    
            echo "Success";

            $db->close(); 
            die();
        }else{
            echo "Fail x1003";
            $db->close(); 
            die();
        }
    }else{
        echo "Fail x1002 (No file upload)";
        $db->close(); 
        die();
    }
}else{
    echo "Fail x1001 (User not found)";
    $db->close(); 
    die();
}



?>