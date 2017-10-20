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
    
    /* $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$conndb=mysqli_connect($server,$username,$password,$db);
   
	    
     $sql_check = "select * from tbl_customer where cus_id = '".$idcard."'";
     $result = mysqli_query($conndb,$sql_check);
	   $rows = mysqli_num_rows($result);
     if($rows > 0){
      while($row = mysqli_fetch_array($result)) {
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
     }*/
	     $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_URL, 'http://122.155.209.75/SPL888/process/process_linebot.php?card_id='.$idcard);
            $result1 = curl_exec($ch1);
	    curl_close($ch1);
            $obj = json_decode($result1, true);
            if($obj['return_status']=="1"){
		$id = $obj['cus_id'];
		$cus_firstname = $obj['cus_firstname'];
                $arrPostData = array();
	       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
	       $arrPostData['messages'][0]['type'] = "text";
	       $arrPostData['messages'][0]['text'] = "เลขบัตร ".$id." ชื่อ ".$cus_firstname;
            }
     else{
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "ไม่พบเลขบัตรประชาชน ".$idcard;
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
