<?php
 
$strAccessToken = "DAKyOAjIvsV0U4PVa55SaTsRYPT3ln8jy8jddwQO2R6lcrYUOJ3uu9WAnhHhDuo+hR/GVqHjc64rHosh/EQ3GrvLzoVhxzScExmQKg+zq4W1GrMDsKRXcEmccYcKEl6jphw/GtJkB8WjQ5mbNJWargdB04t89/1O/w1cDnyilFU=";
 
$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);
 
$strUrl = "https://api.line.me/v2/bot/message/reply";
 
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$show = substr($arrJson['events'][0]['message']['text'],0,1);
$idcard = substr($arrJson['events'][0]['message']['text'],1);
if($show == "#"){
 if($idcard!=""){
   $countid = strlen($idcard);
   if($countid == "13"){
    
     $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

//$conn = new mysqli($server, $username, $password, $db);
     $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = $server;
     /*$sql_check = "select * from tbl_customer where cus_id = '".$idcard."'";
     $result = $conn->query($sql_check);
     if($result->num_rows > 0){
      while($row = $result->fetch_assoc()) {
       $msg = "";
       $cardid = "";
       $name = "";
       $tb_status = "";
       $msg = $row['tb_message'];
       $cardid = $row['cus_id'];
       $name = $row['cus_firstname'];
       $tb_status = $row['cus_nickname'];
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = $idcard;
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = $msg;
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "เลขบัตร ".$cardid;
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "ชื่อ ".$name;
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "สถานะ ".$tb_status;
      }
     }else{
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "ไม่พบเลขบัตรประชาชน ".$idcard;
     }*/
   }else{
     $arrPostData = array();
     $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
     $arrPostData['messages'][0]['type'] = "text";
     $arrPostData['messages'][0]['text'] = "เลขบัตรประชาชนไม่ถูกต้อง";
   }
    
 }else{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "บุคคลดังกล่าวไม่มีหมายจับ";
 }
  
}else{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ข้อความไม่ถูกต้อง";
}
 
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);
 
?>
