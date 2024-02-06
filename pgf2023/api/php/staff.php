<?php 
require('../../../config/php/config.conf.php');
require('../../../config/php/database.php'); 
require('../../../config/php/function.php'); 
require('./email.php'); 

$page_name = basename(__FILE__) ;

$return = array();
$buffer = array(); 

$return['status'] = 'Fail';


if(!isset($_REQUEST['stage'])){ 
    $return['error_message'] = 'Invalid stage code'; 
    echo json_encode($return);
     mysqli_close($conn); die(); 
}

$stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);

switch ($stage) {
    case 'update_reviewer_info':

        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['role'])) ||
            (!isset($_REQUEST['selected_id'])) ||
            (!isset($_REQUEST['title'])) || 
            (!isset($_REQUEST['fname'])) || 
            (!isset($_REQUEST['lname'])) || 
            (!isset($_REQUEST['primary_role'])) || 
            (!isset($_REQUEST['gender'])) || 
            (!isset($_REQUEST['email'])) || 
            (!isset($_REQUEST['institution'])) || 
            (!isset($_REQUEST['address'])) || 
            (!isset($_REQUEST['specialize'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
        $selected_id = mysqli_real_escape_string($conn, $_REQUEST['selected_id']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
        $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
        $primary_role = mysqli_real_escape_string($conn, $_REQUEST['primary_role']);
        $gender = mysqli_real_escape_string($conn, $_REQUEST['gender']);
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $institution = mysqli_real_escape_string($conn, $_REQUEST['institution']);
        $address = mysqli_real_escape_string($conn, $_REQUEST['address']);
        $specialize = mysqli_real_escape_string($conn, $_REQUEST['specialize']);

        $strSQL = "UPDATE sx4_account 
                   SET 
                   email = '$email', 
                   title = '$title', 
                   fname = '$fname', 
                   lname = '$lname', 
                   specialize = '$specialize', 
                   core_role = '$primary_role', 
                   gender = '$gender', 
                   institution = '$institution', 
                   address = '$address'
                   WHERE uid = '$selected_id';
                  ";
        $res = $db->execute($strSQL);

        $return['status'] = 'Success'; 
        echo json_encode($return); 
        $db->close();
        die();
        break ;
    case 'update_reviewer_privilledge':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['role'])) ||
            (!isset($_REQUEST['selected_id'])) ||
            (!isset($_REQUEST['target_param'])) || 
            (!isset($_REQUEST['target_status'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
        $selected_id = mysqli_real_escape_string($conn, $_REQUEST['selected_id']);
        $target_param = mysqli_real_escape_string($conn, $_REQUEST['target_param']);
        $target_status = mysqli_real_escape_string($conn, $_REQUEST['target_status']);

        $strSQL = "UPDATE sx4_account 
                   SET 
                   ".$target_param." = '$target_status'
                   WHERE uid = '$selected_id';
                  ";
        $res = $db->execute($strSQL);

        $return['status'] = 'Success'; 
        echo json_encode($return); 
        $db->close();
        die();
        break ;
    case 'add_reviewer':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['role'])) ||
            (!isset($_REQUEST['title'])) || 
            (!isset($_REQUEST['fname'])) || 
            (!isset($_REQUEST['lname'])) || 
            (!isset($_REQUEST['country'])) || 
            (!isset($_REQUEST['email'])) || 
            (!isset($_REQUEST['institution'])) || 
            (!isset($_REQUEST['address'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
        $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
        $country = mysqli_real_escape_string($conn, $_REQUEST['country']);
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $institution = mysqli_real_escape_string($conn, $_REQUEST['institution']);
        $address = mysqli_real_escape_string($conn, $_REQUEST['address']);

        $strSQL = "SELECT * FROM sx4_account WHERE email = '$email' AND active_status = 'Y' AND delete_status = 'N'";
        $resCheck = $db->fetch($strSQL, false, false);
        if($resCheck){
            $return['status'] = 'Duplicate';
            $return['error_message'] = 'Email adready use'; 
            echo json_encode($return); 
            $db->close();
            die();
        }

        $uid = base64_encode($dateu.generateRandomString(4));
        $sid = base64_encode($dateu.generateRandomString(9));
        $password = base64_encode($dateu);

        $m = 1;
        $strSQL = "SELECT COUNT(uid) x FROM sx4_account WHERE 1";
        $resC = $db->fetch($strSQL, false, false);
        if($resC){
            $m = $resC['x'] + 1;  
        }

        $strSQL = "INSERT INTO sx4_account 
                 (
                    `uid`, `ucode`, `email`, `title`, `gender`, `fname`, `lname`, 
                    `passsword`, `role_author`, `role_reviewer`, `presenter`, `listener`, `institution`, `address`, `country`, 
                    `jointype`, `regdatetime`, `active_status`, `allow_status`
                )
                VALUES 
                (
                    '$uid', '$m', '$email', '$title', 'NA', '$fname', '$lname', 
                    '$password', 'N', 'Y', 'N', 'Y', '$institution', '$address', '$country', 
                    'online', '$datetime', 'Y', 'Y'
                )";

        $resInsert = $db->insert($strSQL, false);
        if($resInsert){

            $return['status'] = 'Success';

            $exp_datetime = date("Y-m-d H:i:s", strtotime('+4 hours'));

            $strSQL = "INSERT INTO sx4_account_activation 
                    (
                        `acc_code`, `acc_isssue`, `acc_expire`, `acc_uid`
                    ) 
                    VALUES (
                        '$sid', '$datetime', '$exp_datetime', '$uid'
                    )";
            $resInsertActivate = $db->insert($strSQL, false);

            
        }else{
            $return['status'] = 'Fail';
            $return['error_message'] = 'Can not add reviewer'; 
            
        }

        echo json_encode($return); 
        $db->close();
        die();
        break;
    
    default:
        # code...
        break;
}