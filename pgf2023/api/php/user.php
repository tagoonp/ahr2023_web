
<?php 
require('../../../config/php/config.conf.php');
require('../../../config/php/database.php'); 
require('../../../config/php/function.php'); 
require('./email.php'); 

$page_name = basename(__FILE__) ;

$return = array();
$buffer = array(); 

$return['status'] = 'Fail';


if(!isset($_REQUEST['stage'])){ $return['error_message'] = 'Invalid stage code'; echo json_encode($return); mysqli_close($conn); die(); }

$stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);
// remove_participant

switch ($stage) {
    case 'remove_participant':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) ||
            (!isset($_REQUEST['target_uid']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $target_uid = mysqli_real_escape_string($conn, $_REQUEST['target_uid']);

        $strSQL = "UPDATE sx4_account SET role_participant = 'N' WHERE uid = '$target_uid'";
        $dbUpdate = $db->execute($strSQL);

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break;
    case 'set_reviewer':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) ||
            (!isset($_REQUEST['target_code']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $target_code = mysqli_real_escape_string($conn, $_REQUEST['target_code']);

        $strSQL = "SELECT uid FROM sx4_account WHERE ucode = '$target_code'";
        $res = $db->fetch($strSQL, false, false);
        if($res){
            $target_uid = $res['uid'];
            $strSQL = "UPDATE sx4_account SET role_reviewer = 'Y' WHERE uid = '$target_uid'";
            $dbUpdate = $db->execute($strSQL);

            $return['status'] = 'Success';
        }else{
            $return['err_message'] = 'User not found';
        }

        
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break;
    case 'send_invitation':

        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) ||
            (!isset($_REQUEST['target_uid'])) ||
            (!isset($_REQUEST['email'])) ||
            (!isset($_REQUEST['fullname'])) ||
            (!isset($_REQUEST['title'])) ||
            (!isset($_REQUEST['content']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $target_uid = mysqli_real_escape_string($conn, $_REQUEST['target_uid']);
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $fullname = mysqli_real_escape_string($conn, $_REQUEST['fullname']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $content = mysqli_real_escape_string($conn, $_REQUEST['content']);

        $strSQL = "SELECT * FROM sx4_account WHERE uid = '$target_uid'";
        $res = $db->fetch($strSQL, false, false);
        if($res){

            // $target_uid = $res['uid'];
            // $strSQL = "UPDATE sx4_account SET role_reviewer = 'Y' WHERE uid = '$target_uid'";
            // $dbUpdate = $db->execute($strSQL);

            $strSQL = "UPDATE sx4_account SET invitation_send = 'N' WHERE uid = '$target_uid'";
            $db->execute($strSQL);


            $file = null;
            if(($res['invitation_letter_url'] != null) && ($res['invitation_letter_url'] != '')){
                $file = $res['invitation_letter_url'];
                $content .=  ' (Click <a href="'.$file.'">- here -</a> to view invitation letter in PDF)';
            }
           
            $content .= '<p>If you have any questions, please contact Ms.Saina Seeyong via saina.seeyong@gmail.com.</p>';
            $content .=  '<div style="padding-top: 20px;"><a class="btn" href="https://medipe2.psu.ac.th/har/pgf2023/api/php/reviewer?stage=conside&accept=accept&uid='.$target_uid.'" type="button" style="text-decoration: none; background-color: green; cursor: pointer; color: #fff; padding: 10px 30px; font-size: 20px; border: none; border-radius: 10px; ">Accept</a>&nbsp;&nbsp;<a  href="https://medipe2.psu.ac.th/har/pgf2023/api/php/reviewer?stage=conside&accept=reject&uid='.$target_uid.'" class="btn" style="text-decoration: none; background-color: red; color: #fff;  cursor: pointer; padding: 10px 30px; font-size: 20px; border: none; border-radius: 10px;">Reject</a></div>';
            $content .= '<p style="padding-top: 50px;"><strong>Dr. Tippawan Liabsuetrakul, M.D.</strong><br>Professor and Head of the Department of Epidemiology,<br>Director of WHO-CC for Research and Training on Epidemiology</p>';

            sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system ', $fullname, $email, $title . " (Invitation Ref. $dateu')", $content);
            
            $strSQL = "UPDATE sx4_account SET invitation_send = 'Y' WHERE uid = '$target_uid'";
            $db->execute($strSQL);

            $return['status'] = 'Success';
        }else{
            $return['err_message'] = 'User not found';
        }


        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    default:
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break;
}