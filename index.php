<?php
 
$strAccessToken = "MM1uvqbgl+BKc8he1jvtbsi7/jp/plSyd/I0OodQ+wc+VVXfnUyYXHkuJ+v4g4HzhR/GVqHjc64rHosh/EQ3GrvLzoVhxzScExmQKg+zq4VeokVlorbyQtnvSGXZpQ+HnSql1acO2OTD6dnZ8WUMBgdB04t89/1O/w1cDnyilFU=";
 
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
	   $error = "";
try {
   $url = 'http://122.155.209.75/SPL888/linebot/check_arrest.php'; 
   $data = 'operation=Add&a_cardid='.$idcard;
   $ch1 = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    $content = curl_exec( $ch1 );
    curl_close($ch1);
}

//catch exception
catch(Exception $e) {
  $error = $e->getMessage();
}
     $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);

	$conndb=mysqli_connect($server,$username,$password,$db);
   
	    mysqli_query($conndb,"SET NAMES 'utf8'");
     $sql_check = "select * from people where people_id = '".$idcard."'";
     $result = mysqli_query($conndb,$sql_check);
	   $rows = mysqli_num_rows($result);
     if($rows > 0){
      while($row = mysqli_fetch_array($result)) {
       $msg = "";
       $cardid = "";
       $name = "";
       $tb_status = "";
       $msg = $row['people_code'];
       $cardid = $row['people_id'];
       $name = $row['people_name'];
       $tb_status = $row['people_status'];
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "สถานะ ".$tb_status."ชื่อ ".$name."เลขบัตร ".$cardid." ".$msg;
      }
     }
	  /*   $ch1 = curl_init();
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
            }*/
     else{
       $arrPostData = array();
       $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
       $arrPostData['messages'][0]['type'] = "text";
       $arrPostData['messages'][0]['text'] = "ไม่พบเลขบัตรประชาชน ".$idcard." ".$error;
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
