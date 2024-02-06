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
    case 'logout': 
        unset($_SESSION['pgf2023_uid']);
        unset($_SESSION['pgf2023_role']);
        unset($_SESSION['pgf2023_id']);
        unset($_SESSION['pgf2023_token']);
        session_destroy();
        $db->close();
        header('Location: ' . ROOT_DOMAIN . 'pgf2023/submission/');
        break ;
    case 'login': 
        if(
            (!isset($_REQUEST['username'])) ||
            (!isset($_REQUEST['password']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
        $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
        $password = base64_encode($password);

        $strSQL = "SELECT * FROM sx4_account 
                   WHERE email = '$username'
                    AND passsword = '$password' 
                    AND delete_status = 'N' AND active_status = 'Y' AND allow_status = 'Y'";
        $res = $db->fetch($strSQL, false, false);

        if($res){

            $uid = $res['uid'];
            $access_token = base64_encode($dateu.generateRandomString(10)); 

            $strSQL = "INSERT INTO sx4_access_token (`token`, `gen_datetime`, `uid`, `gen_ip`) VALUES ('$access_token', '$datetime', '$uid', '$ip')";
            $resInsert = $db->insert($strSQL, false);

            if($resInsert){

                $user_fullname = $res['fname'] . " " . $res['lname'];
                $content = '<p>Dear ' . $user_fullname . '</p>';
                $content .= '<p>You have loged in to PGF2023 submission system. If this activity does not done by you, please go to <a href="' . ROOT_DOMAIN . 'pgf2023/submission/">' . ROOT_DOMAIN . 'pgf2023/submission/</a> to login, check activity and change your password if nessesory.</p>';
                $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
                sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system', $user_fullname, $res['email'], 'PGF2023 Account login notification.', $content);

                $_SESSION['pgf2023_uid'] = $uid;
                $_SESSION['pgf2023_role'] = $res['core_role'];
                $_SESSION['pgf2023_id'] = session_id();
                $_SESSION['pgf2023_token'] = $access_token;

                $return['status'] = 'Success';
            }else{
                $return['error_message'] = 'Token expire';
            }

            
        }else{
            $return['error_message'] = 'Account not found'; 
        }

        echo json_encode($return); 
        mysqli_close($conn); 
        die();
    case 'update': 
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['token'])) ||
            (!isset($_REQUEST['title'])) ||
            (!isset($_REQUEST['fname'])) ||
            (!isset($_REQUEST['lname'])) ||
            (!isset($_REQUEST['inst'])) ||
            (!isset($_REQUEST['address'])) ||
            (!isset($_REQUEST['country'])) ||
            (!isset($_REQUEST['gender'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $token = mysqli_real_escape_string($conn, $_REQUEST['token']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
        $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
        $inst = mysqli_real_escape_string($conn, $_REQUEST['inst']);
        $address = mysqli_real_escape_string($conn, $_REQUEST['address']);
        $country = mysqli_real_escape_string($conn, $_REQUEST['country']);
        $gender = mysqli_real_escape_string($conn, $_REQUEST['gender']);

        $strSQL = "UPDATE sx4_account 
                   SET 
                   `title` = '$title', 
                   `gender` = '$gender', 
                   `fname` = '$fname', 
                   `lname` = '$lname', 
                   `institution` = '$inst', 
                   `address` = '$address', 
                   `country` = '$country'
                   WHERE 
                   uid = '$uid'
                  ";
        $db->execute($strSQL);

        $return['status'] = 'Success';
        echo json_encode($return); 
        mysqli_close($conn); 
        die();

        break ;
    case 'reset_password':
        if(
            (!isset($_REQUEST['uid'])) || 
            (!isset($_REQUEST['password']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $password = mysqli_real_escape_string($conn, $_REQUEST['password']);

        $password = base64_encode($password);

        $strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid' AND active_status = 'Y' AND allow_status = 'Y' AND delete_status = 'N'";
        $resCheck = $db->fetch($strSQL, false, false);

        if($resCheck){
            $strSQL = "UPDATE sx4_account SET passsword = '$password' 
            WHERE 
            uid = '$uid' AND active_status = 'Y' AND allow_status = 'Y' AND delete_status = 'N'";
            $resUpdate = $db->execute($strSQL);
            $return['status'] = 'Success'; 
        }else{
            $return['error_message'] = 'Account not found.'; 
        }

        
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'send_reset_password':
        if(
            (!isset($_REQUEST['email']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);

        $strSQL = "SELECT * FROM sx4_account WHERE email = '$email' AND active_status = 'Y' AND delete_status = 'N'";
        $resCheck = $db->fetch($strSQL, false, false);

        if(!$resCheck){
            $return['error_message'] = 'Email not found'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $sid = base64_encode($dateu.generateRandomString(9));
        $exp_datetime = date("Y-m-d H:i:s", strtotime('+4 hours'));
        $uid = $resCheck['uid'];

        $strSQL = "INSERT INTO sx4_account_activation ( `acc_code`, `acc_isssue`, `acc_expire`, `acc_uid` ) 
                   VALUES ( '$sid', '$datetime', '$exp_datetime', '$uid' )";
        $resInsertActivate = $db->insert($strSQL, false);

        $user_fullname = $resCheck['fname'] . " " . $resCheck['lname'];
        $content = '<p>Dear ' . $user_fullname . '</p>';
        $content .= '<p>We received a request to reset the password for yout account, please visit this link to reset your password.  >> <a href="' . ROOT_DOMAIN . 'pgf2023/api/php/authen?stage=settoresetpassword&uid=' . $uid . '&sid=' . $sid .'">' . ROOT_DOMAIN . 'pgf2023/api/php/authen?stage=settoresetpassword&uid=' . $uid . '&sid=' . $sid .'</a></p>';
        $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
        sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system', $user_fullname, $email, 'PGF2023 Reset passsword link', $content);

        $return['status'] = 'Success'; 
        echo json_encode($return); 
        mysqli_close($conn); 
        die();

        break ;

    case 'settoresetpassword':
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['sid']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);

        $strSQL = "SELECT * FROM sx4_account_activation WHERE acc_uid = '$uid' AND acc_code = '$sid'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $id = $res['acc_id'];

            $strSQL = "UPDATE sx4_account_activation SET acc_active_status = 'Y', acc_active_datetime = '$datetime'";
            $update = $db->execute($strSQL);

            header('Location: ../../submission/auth-resetpassword?uid=' . $uid);
            die();
        }else{
            $return['status'] = 'Fail';
            $return['error_code'] = 'x1003';
            $return['error_message'] = 'Verification code expired';
        }

        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'activate' : 
        if(
            (!isset($_REQUEST['uid'])) ||
            (!isset($_REQUEST['sid']))
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
        $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);

        $strSQL = "SELECT * FROM sx4_account_activation WHERE acc_uid = '$uid' AND acc_code = '$sid'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $id = $res['acc_id'];

            $strSQL = "UPDATE sx4_account_activation SET acc_active_status = 'Y', acc_active_datetime = '$datetime'";
            $update = $db->execute($strSQL);

            $strSQL = "UPDATE sx4_account SET active_status = 'Y', allow_status = 'Y' WHERE uid = '$uid'";
            $update = $db->execute($strSQL);
            
            $access_token = base64_encode($dateu.generateRandomString(10)); 

            $strSQL = "INSERT INTO sx4_access_token (`token`, `gen_datetime`, `uid`, `gen_ip`) VALUES ('$access_token', '$datetime', '$uid', '$ip')";
            $resInsert = $db->insert($strSQL, false);
            if($resInsert){

                $strSQL = "SELECT * FROM sx4_account WHERE uid = '$uid'";
                $resUser = $db->fetch($strSQL, false, false);
                if($resUser){
                    $user_fullname = $resUser['fname'] . " " . $resUser['lname'];
                    $content = '<p>Dear ' . $user_fullname . '</p>';
                    $content .= '<p>Your account is verified, please go to login at <a href="' . ROOT_DOMAIN . 'pgf2023/">' . ROOT_DOMAIN . 'pgf2023/</a></p>';
                    $content .= '<p>Regards, PFG2023 Auto mailer system</p>';
                    sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system', $user_fullname, $resUser['email'], 'PGF2023 Account Verified.', $content);
                }

                 // By pass to system
                $_SESSION['pgf2023_uid'] = $uid;
                $_SESSION['pgf2023_role'] = 'participant';
                $_SESSION['pgf2023_id'] = session_id();
                $_SESSION['pgf2023_token'] = $access_token;

                $db->close();

                header('Location: ../../core/');
                die();

            }else{
                $return['status'] = 'Fail';
                $return['error_code'] = 'x1002';
                $return['error_message'] = 'Param not found';
            }
        }else{
            $return['status'] = 'Fail';
            $return['error_code'] = 'x1003';
            $return['error_message'] = 'Verification code expired';
        }

        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break ;
    case 'register' : 
        if(
            (!isset($_REQUEST['email'])) ||
            (!isset($_REQUEST['password'])) ||
            (!isset($_REQUEST['fname'])) ||
            (!isset($_REQUEST['lname'])) ||
            (!isset($_REQUEST['university'])) 
        ){
            $return['error_message'] = 'In-complete parameter'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
        $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
        $password = base64_encode($password);
        $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
        $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
        $university = mysqli_real_escape_string($conn, $_REQUEST['university']);
        $address = mysqli_real_escape_string($conn, $_REQUEST['address']);
        $country = mysqli_real_escape_string($conn, $_REQUEST['country']);
        $ptype = mysqli_real_escape_string($conn, $_REQUEST['ptype']);
        $vtype = mysqli_real_escape_string($conn, $_REQUEST['vtype']);
        $gender = mysqli_real_escape_string($conn, $_REQUEST['gender']);
        $title = mysqli_real_escape_string($conn, $_REQUEST['title']);
        $trip = mysqli_real_escape_string($conn, $_REQUEST['trip']);
        $ahr = mysqli_real_escape_string($conn, $_REQUEST['ahr']);

        $strSQL = "SELECT * FROM sx4_account WHERE email = '$email' AND delete_status = 'N' AND active_status = 'Y'";
        $res = $db->fetch($strSQL, false, false);
        if($res){
            $return['error_message'] = 'Email already use.'; 
            echo json_encode($return); 
            mysqli_close($conn); 
            die();
        }

        if($vtype == '1'){
            $vtype = 'local';
        }else{
            $vtype = 'online';
        }

        $uid = base64_encode($dateu.generateRandomString(4));
        $sid = base64_encode($dateu.generateRandomString(9));

        $m = 1;
        $strSQL = "SELECT COUNT(uid) x FROM sx4_account WHERE 1";
        $resC = $db->fetch($strSQL, false, false);
        if($resC){
            $m = $resC['x'] + 1;  
        }

        $author = 'N';
        if($ptype == '1'){
            $author = 'Y';
        }

        $listener = 'N';
        if($ptype == '3'){
            $listener = 'Y';
        }

        $strSQL = "INSERT INTO sx4_account 
                 (
                    `uid`, `ucode`, `email`, `title`, `gender`, `fname`, `lname`, 
                    `passsword`, `role_author`, `presenter`, `listener`, `institution`, `address`, `country`, 
                    `jointype`, `regdatetime`, `join_ahr2023`, `join_trip`
                )
                VALUES 
                (
                    '$uid', '$m', '$email', '$title', '$gender', '$fname', '$lname', 
                    '$password', '$author', '$author', '$listener', '$university', '$address', '$country', 
                    '$vtype', '$datetime', '$ahr', '$trip'
                )";

        $resInsert = $db->insert($strSQL, false);
        if($resInsert){

            $exp_datetime = date("Y-m-d H:i:s", strtotime('+4 hours'));

            $strSQL = "INSERT INTO sx4_account_activation 
                      (
                        `acc_code`, `acc_isssue`, `acc_expire`, `acc_uid`
                      ) 
                      VALUES (
                        '$sid', '$datetime', '$exp_datetime', '$uid'
                      )";
            $resInsertActivate = $db->insert($strSQL, false);
            if($resInsert){
                $return['status'] = 'Success';

                $user_fullname = $fname . " " . $lname;
                $content = '<p>Dear ' . $user_fullname . '</p>';
                $content .= '<p>Just one step now and you are done, To confirm your email address and activate your account, click the link below. (or copy and paste to the web browser if the link not active)</p>';
                $content .= '<p><a href="' . ROOT_DOMAIN . 'pgf2023/api/php/authen?stage=activate&uid=' . $uid . '&sid=' . $sid .'">' . ROOT_DOMAIN . 'pgf2023/api/php/authen?stage=activate&uid=' . $uid . '&sid=' . $sid .'</a><p>';
                $content .= '<p>If you encountered any issues while confirming the email, do not hesitate to Contact Us.</p>';
                $content .= '<p>Regards, PFG2023 Auto mailer system</p>';

                if(sendEmail(MAIL_EMAIL, MAIL_PASSWORD, MAIL_EMAIL, 'PGF2023 Auto mailer system', $fname . " " . $lname, $email, 'PGF2023 Account Verification', $content)){

                }else{
                    $strSQL = "INSERT INTO sx4_error
                          (
                            `err_datetime`, `err_stage`, `err_code`, `err_message`, `err_relate_uid`
                          ) 
                          VALUES 
                          ('$datetime', 'Register verification', '10001', 'Can not send verification email', '$uid')
                          ";
                    $return['error_message'] = 'Can not send verification email.'; 
                }

            }else{
                $strSQL = "INSERT INTO sx4_error
                          (
                            `err_datetime`, `err_stage`, `err_code`, `err_message`, `err_relate_uid`
                          ) 
                          VALUES 
                          ('$datetime', 'Register verification', '10001', 'Can not send verification email', '$uid')
                          ";
                $return['error_message'] = 'Can not send verification email.'; 
            }
        }else{
            $return['error_message'] = 'Can not create account.'; 
        }
        
        echo json_encode($return); 
        mysqli_close($conn); 
        die();
        break;
    default: 
        break;
}

?>