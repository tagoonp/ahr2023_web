<?php 
require('../../../config/php/config.conf.php');
require('../../../config/php/database.php'); 
// require('../../../config/php/function.php'); 

$page_name = basename(__FILE__) ;


$return = array();
$buffer = array(); 

$uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
$token = mysqli_real_escape_string($conn, $_REQUEST['token']);
$sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);

$strSQL = "SELECT uid FROM sx4_account WHERE active_status = 'Y' AND delete_status = 'N' AND allow_status = 'Y'";
$res = $db->fetch($strSQL, false, false);

if($res){

    $strSQL = "SELECT * FROM sx4_abstract WHERE abstract_sid = '$sid' ";
    $resAbs = $db->fetch($strSQL, false, false);
    if(!$resAbs){
        echo "Fail x1001";
        $db->close(); 
        die();
    }

    if(isset($_FILES)){
    
        $originalName = $_FILES['file']['name'];
        // $path = '../img/upload/concent/';
        $path = "../../upload/abstract/";
    
        $generatedName = $dateu.'-'.$_FILES['file']['name'];
        $filePath = $path.$generatedName;
    
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $fileUrl = ROOT_DOMAIN.'pgf2023/upload/abstract/'.$generatedName;
    
            $strSQL = "INSERT INTO sx4_upload_file (`upload_uid`, `upload_file_name`, `upload_url`,  `upload_token`, `upload_ref`, `upload_udatetime`) VALUES ('$uid', '".$_FILES['file']['name']."', '$fileUrl', '$token', '$sid', '$datetime')";
            $res = $db->insert($strSQL, false);

            if($res){
                $strSQL = "UPDATE sx4_abstract SET abstract_recent_file = '$fileUrl' WHERE abstract_sid = '$sid'";
                $db->execute($strSQL);
            }
    
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