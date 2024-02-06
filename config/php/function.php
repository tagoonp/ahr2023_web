<?php 
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function is_livetoken($db, $token, $uid, $ip){
    $compare_datetime = date("Y-m-d H:i:s", strtotime('+5 hours'));
    $strSQL = "SELECT * FROM rs939_access_token WHERE token = '$token' AND uid = '$uid' AND gen_ip = '$ip' AND gen_datetime < '$compare_datetime'";
        $res = $db->fetch($strSQL, false, false);
        if($res){
            return true;
        }else{
            return false;
        }
}

function send_line_message($access_token, $userId, $message){
    
    $access_token = 'sd1LYdRoNQsmoQq18KLDKWnyemEbi/0XpNfwoL9PN7Zy2QHZq4JAPJYKf/jDopS55KjwS6KhMhAwpp58r1l/ecbh0JQpWsbGsUN3QDs8bz8m+XNn/FCDRDXlR0bJaSfBIVtJmtGE80l/7BiTDhgySQdB04t89/1O/w1cDnyilFU=s';
    // User ID
    $userId = 'U8e3b43331e128e6bf11ed9aa55f5d21e';
    // ข้อความที่ต้องการส่ง
    $messages = array(
        'type' => 'text',
        'text' => $message,
    );
    $post = json_encode(array(
        'to' => array($userId),
        'messages' => array($messages),
    ));
    // URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
    $url = 'https://api.line.me/v2/bot/message/multicast';
    $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    // echo $result;
}

function isMobileDev(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
       $user_ag = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
          return true;
       };
    };
    return false;
}


?>

