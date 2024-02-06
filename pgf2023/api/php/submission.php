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

switch($stage){
    case 'delete_submission_by_staff':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['role'])) ||
            (!isset($_REQUEST['abs_id'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
        $abs_id = mysqli_real_escape_string($conn, $_REQUEST['abs_id']);

        $strSQL = "SELECT * FROM sx4_abstract WHERE abstract_id = '$abs_id'";
        $res = $db->fetch($strSQL, false, false);
        if($res){
            $strSQL = "UPDATE sx4_abstract SET abstract_delete = 'Y' WHERE abstract_id = '$abs_id'";
            $db->execute($strSQL);
            
            $sid = $res['abstract_sid'];

            $strSQL = "INSERT INTO sx4_abstract_activity  (`aa_abstract_id`, `aa_by_uid`, `aa_datetime`, `aa_ip`, `aa_activity`, `aa_info`)
                           VALUES  ( '$abs_id', '$uid', '$datetime', '$ip', 'Delete abstract', 'Abstract ID $abs_id (Ref : $sid)' ) ";
            $resInsert = $db->insert($strSQL, false);

            $return['status'] = 'Success'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }else{
            $return['error_message'] = 'Abstract not found'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        


        break ;
    case 'confirm_send':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);

        $strSQL = "SELECT * FROM sx4_abstract WHERE abstract_sid = '$sid' AND abstract_uid = '$uid' AND abstract_delete = 'N'";
        $resCheck = $db->fetch($strSQL, false, false);
        if($resCheck){
            $abstract_id = $resCheck['abstract_id'];
            // $abstract_ref_id = $resCheck['abstract_ref_id'];
            $abstract_title = $resCheck['abstract_title'];

            $strSQL = "UPDATE sx4_abstract SET abstract_draft = 'N', abstract_send = 'Y', abstract_send_datetime = '$datetime', abstract_status = 'wait for staff review' 
                       WHERE abstract_sid = '$sid' AND abstract_uid = '$uid' AND abstract_delete = 'N' AND abstract_id = '$abstract_id'";
            $resUpdate = $db->execute($strSQL);

            $ord = 1;
            $strSQL = "SELECT MAX(abstract_ref_id) mx FROM sx4_abstract WHERE abstract_ref_id IS NOT NULL";
            $resOrder = $db->fetch($strSQL, false, false);
            if($resOrder){
                $ord = $resOrder['mx'] + 1;
            }

            $strSQL = "UPDATE sx4_abstract SET abstract_ref_id = '$ord'
                       WHERE abstract_sid = '$sid' AND abstract_uid = '$uid' AND abstract_delete = 'N' AND abstract_id = '$abstract_id'";
            $resUpdate = $db->execute($strSQL);

            $strSQL = "SELECT abstract_ref_id FROM sx4_abstract WHERE abstract_sid = '$sid' AND abstract_uid = '$uid' AND abstract_delete = 'N'";
            $resCheckRef = $db->fetch($strSQL, false, false);

            $abstract_ref_id = '00000'.$ord;
            if($resCheckRef){
                $abstract_ref_id = $resCheckRef['abstract_ref_id'];
            }

            $strSQL = "INSERT INTO sx4_abstract_activity 
                       (`aa_abstract_id`, `aa_by_uid`, `aa_datetime`, `aa_ip`, `aa_activity`, `aa_info`)
                       VALUES 
                       (
                        '$abstract_id', '$uid', '$datetime', '$ip', 'Submit abstract', 'Abstract ID $abstract_id (Ref : $sid)' 
                       )
                      ";
            $resInsert = $db->insert($strSQL, false);

            // Send email 
            $strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid' AND delete_status = 'N'";
            $resUser = $db->fetch($strSQL, false, false);
            if($resUser){
                $user_fullname = $resUser['fname'] . " " . $resUser['lname'];
                $content = '<p>Dear ' . $user_fullname . '</p>';
                $content .= '<p>You have submitted the abstract in to Postgraduateforum 2023 entitled <strong>"'.$abstract_title.'"</strong> and the next process is review process. You can check the submission progress by visit our system at  <a href="' . ROOT_DOMAIN . 'pgf2023/submission/">' . ROOT_DOMAIN . 'pgf2023/submission/</a> </p>';
                $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
                sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system', $user_fullname, $resUser['email'], 'PGF2023 Abstract (Ref : ' . $abstract_ref_id . ')  submitted notification.', $content);
            }

            // Send email to staff
            $strSQL = "SELECT * FROM sx4_account WHERE role_staff = 'Y' AND delete_status = 'N' AND active_status = 'Y' AND allow_status = 'Y'";
            $resStaff = $db->fetch($strSQL, true, true);
            if(($resStaff) && ($resStaff['status'])){
                foreach($resStaff['data'] as $row){
                    $user_fullname = $row['fname'] . " " . $row['lname'];
                    $content = '<p>Dear ' . $user_fullname . '</p>';
                    $content .= '<p>Someone submit the abstract to Postgraduateforum 2023 entitled <strong>"'.$abstract_title.'"</strong>. Please check at  <a href="' . ROOT_DOMAIN . 'pgf2023/submission/">' . ROOT_DOMAIN . 'pgf2023/submission/</a> </p>';
                    $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
                    sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system (Ref.'. $dateu .')', $user_fullname, $row['email'], 'PGF2023 Abstract (Ref : ' . $abstract_ref_id . ') submitted.', $content);
                }
            }

            $return['status'] = 'Success';
        }else{
            $return['error_message'] = 'Abstract not found.'; 
        }
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'delete_abstract':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['abstract_id']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $abstract_id = mysqli_real_escape_string($conn, $_REQUEST['abstract_id']);

        $strSQL = "UPDATE sx4_abstract SET abstract_delete = 'Y' WHERE abstract_id = '$abstract_id'";
        $res = $db->execute($strSQL);

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'delete_uploaded_file': 
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);

        $strSQL = "UPDATE sx4_abstract SET abstract_recent_file = NULL WHERE abstract_sid = '$sid' AND abstract_uid = '$uid'";
        $db->execute($strSQL);

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'save_draft':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid'])) || 
            (!isset($_REQUEST['title'])) || 
            (!isset($_REQUEST['category'])) || 
            (!isset($_REQUEST['typeofpresent'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $category = mysqli_real_escape_string($conn, $_REQUEST['category']);
        $typeofpresent = mysqli_real_escape_string($conn, $_REQUEST['typeofpresent']);

        if($category == ''){
            $category = 'NA';
        }

        if($typeofpresent == ''){
            $typeofpresent = 'NA';
        }

        $strSQL = "SELECT * FROM sx4_abstract WHERE abstract_sid = '$sid'";
        
        $resAbstract = $db->fetch($strSQL, false, false);
        if($resAbstract){
            $strSQL = "UPDATE sx4_abstract 
                       SET 
                       abstract_title = '$title',
                       abstract_category = '$category',
                       abstract_present_type = '$typeofpresent'
                       WHERE 
                       abstract_sid = '$sid' AND abstract_uid = '$uid'
                      ";
            $db->execute($strSQL);
            $return['status'] = 'Success';
        }else{

            // Check recent order
            $order = 1;
            $strSQL = "INSERT INTO sx4_abstract 
                       (
                        `abstract_uid`, `abstract_title`, `abstract_category`, `abstract_present_type`, `abstract_sid`, `abstract_create_datetime`
                       )
                       VALUES 
                       (
                        '$uid', '$title', '$category', '$typeofpresent', '$sid', '$datetime'
                       )
                      ";
            $resInsert = $db->insert($strSQL, false);
            // $return['error_cmd']  = $strSQL;
            if($resInsert){
                $return['status'] = 'Success';
            }else{
                $return['error_message'] = 'Can not save draft'; 
            }
        }

        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'delete_co':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid'])) || 
            (!isset($_REQUEST['co_id']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
        $co_id = mysqli_real_escape_string($conn, $_REQUEST['co_id']);

        $strSQL = "UPDATE sx4_coauthor SET co_delete = 'Y' WHERE co_id = '$co_id' ";
        $ex = $db->execute($strSQL);
        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'update_co': 
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid'])) || 
            (!isset($_REQUEST['co_id'])) || 
            (!isset($_REQUEST['title'])) || 
            (!isset($_REQUEST['fullname'])) || 
            (!isset($_REQUEST['email'])) || 
            (!isset($_REQUEST['inst'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
        $co_id = mysqli_real_escape_string($conn, $_REQUEST['co_id']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $fullname = mysqli_real_escape_string($conn, $_REQUEST['fullname']);
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $inst = mysqli_real_escape_string($conn, $_REQUEST['inst']);
        $cores = mysqli_real_escape_string($conn, $_REQUEST['cores']);

        $strSQL = "UPDATE sx4_coauthor 
                   SET 
                   co_title = '$title', 
                   co_fullname = '$fullname',
                   co_email = '$email',
                   co_institution = '$inst',
                   co_resonding = '$cores'
                   WHERE 
                   co_sid = '$sid' AND co_id = '$co_id'
                  ";
        $db->execute($strSQL);

        if($cores == 'Y'){
            $strSQL = "UPDATE sx4_coauthor SET co_resonding = 'N' WHERE co_sid = '$sid' AND co_id != '$co_id'";
            $db->execute($strSQL);
        }

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'update_co_response': 
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid'])) || 
            (!isset($_REQUEST['co_id'])) || 
            (!isset($_REQUEST['co_to']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
        $co_id = mysqli_real_escape_string($conn, $_REQUEST['co_id']);
        $co_to = mysqli_real_escape_string($conn, $_REQUEST['co_to']);

        $strSQL = "UPDATE sx4_coauthor SET co_resonding = '$co_to' WHERE co_id = '$co_id'";
        $db->execute($strSQL);

        if($co_to == 'Y'){
            $strSQL = "UPDATE sx4_coauthor SET co_resonding = 'N' WHERE co_sid = '$sid' AND co_id != '$co_id'";
            $db->execute($strSQL);
        }

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();

        break ; 
    case 'save_co';
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) || 
            (!isset($_REQUEST['sid'])) || 
            (!isset($_REQUEST['title'])) || 
            (!isset($_REQUEST['fullname'])) || 
            (!isset($_REQUEST['email'])) || 
            (!isset($_REQUEST['inst'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $fullname = mysqli_real_escape_string($conn, $_REQUEST['fullname']);
        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $inst = mysqli_real_escape_string($conn, $_REQUEST['inst']);
        $cores = mysqli_real_escape_string($conn, $_REQUEST['cores']);

        $strSQL = "INSERT INTO sx4_coauthor 
                   (
                    `co_sid`, `co_uid`, `co_title`, `co_fullname`, `co_email`, 
                    `co_institution`, `co_resonding`, `co_regdatetime`
                    )
                    VALUES
                    (
                        '$sid', '$uid', '$title', '$fullname', '$email', '$inst', '$cores', '$datetime' 
                    )
                   ";
        $resInsert = $db->insert($strSQL, false);
        if($resInsert){
            $return['status'] = 'Success';

            if($cores == 'Y'){
                $strSQL = "UPDATE sx4_coauthor SET co_resonding = 'N' WHERE co_sid = '$sid' AND co_id != '$co_id'";
                $db->execute($strSQL);
            }
        }
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    default:
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
    break ;
}