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
     $hostname_condb="http://hotspot.idms.pw:81/phpmyadmin/";
     $username_condb="root";
     $password_conndb="k1tsada2532";
     $db_name="checkid_db";

     $conndb=mysqli_connect($hostname_condb,$username_condb,$password_conndb,$db_name);
     if (mysqli_connect_errno())
     {
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = mysqli_connect_error();
     }
     $sql_check = "select * from tbl_cardid where tb_cardid = '".$idcard."'";
     $query_check = mysqli_query($conndb,$sql_check);
     $row_check = mysqli_num_rows($query_check);
     if($row_check>0){
       $fetch_check = mysqli_fetch_array($query_check);
       $msg = "";
       $cardid = "";
       $name = "";
       $tb_status = "";
       $msg = $fetch_check['tb_message'];
       $cardid = $fetch_check['tb_cardid'];
       $name = $fetch_check['tb_name'];
       $tb_status = $fetch_check['tb_status'];
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
     }else{
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "ไม่พบเลขบัตรประชาชน";
     }
     
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
