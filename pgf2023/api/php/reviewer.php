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
    case 'conside':
        
        if(
            (!isset($_REQUEST['accept'])) || 
            (!isset($_REQUEST['uid']))
        ){
            $return['status'] = 'Fail';
            $return['error_message'] = 'Invalid stage code'; 
            echo json_encode($return);
            mysqli_close($conn); die(); 
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $accept = mysqli_real_escape_string($conn, $_REQUEST['accept']);

        $strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid' AND delete_status = 'N'";
        $res = $db->fetch($strSQL, false, false);
        if($res){

            if($res['reviewer_acception'] != 'NA'){
                $return['status'] = 'Fail';
                $return['error_message'] = 'Already give us response'; 
                echo json_encode($return);
                mysqli_close($conn); die(); 
            }

            if($accept == 'accept'){
                $strSQL = "UPDATE sx4_account SET reviewer_acception = 'Y', active_status = 'Y', allow_status = 'Y', invitation_response_datetime = '$datetime' WHERE uid = '$uid'";
                $db->execute($strSQL);
            }else{
                $strSQL = "UPDATE sx4_account SET reviewer_acception = 'N', active_status = 'Y', allow_status = 'Y', invitation_response_datetime = '$datetime' WHERE uid = '$uid'";
                $db->execute($strSQL);
            }

            // Send email to staff
            $strSQL = "SELECT * FROM sx4_account WHERE role_staff = 'Y' AND delete_status = 'N' AND active_status = 'Y' AND allow_status = 'Y'";
            $resStaff = $db->fetch($strSQL, true, true);
            if(($resStaff) && ($resStaff['status'])){
                foreach($resStaff['data'] as $row){
                    $user_fullname = $row['fname'] . " " . $row['lname'];
                    $content = '<p>Dear ' . $user_fullname . '</p>';
                    $content .= '<p>Reviewer response invitation. Please check at  <a href="' . ROOT_DOMAIN . 'pgf2023/submission/">' . ROOT_DOMAIN . 'pgf2023/submission/</a> </p>';
                    $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
                    sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system (Ref.'. $dateu .')', $user_fullname, $row['email'], 'PGF2023 reviewer responsed..', $content);
                }
            }

            $access_token = base64_encode($dateu.generateRandomString(10)); 

            $strSQL = "INSERT INTO sx4_access_token (`token`, `gen_datetime`, `uid`, `gen_ip`) VALUES ('$access_token', '$datetime', '$uid', '$ip')";
            $resInsert = $db->insert($strSQL, false);

            $_SESSION['pgf2023_uid'] = $uid;
            $_SESSION['pgf2023_role'] = 'participant';
            $_SESSION['pgf2023_id'] = session_id();
            $_SESSION['pgf2023_token'] = $access_token;

            header('Location: ../../core/app-invite-success');
            
        }else{
            $return['status'] = 'Fail';
            $return['error_message'] = 'Invalid token'; 
            echo json_encode($return);
            mysqli_close($conn); die(); 
        }
        break;
    
    default:
        # code...
        break;
}