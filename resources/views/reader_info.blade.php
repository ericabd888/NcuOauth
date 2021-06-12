<?php
header("Content-Type:text/html; charset=utf-8");
// this function is : input user account and password, get correct token
function post_token($username, $password)
{
    $url = "https://argon.lib.nthu.edu.tw/patron/api/token-auth/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
             http_build_query(array('username' => 'ncu', 'password' => 'ncu;admin')));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $token = json_decode($result, true);
    return $token["token"];
}
// this function is : input reader's account and password, get correct return code
function get_correct($id, $pwd)
{
    $get_reader_info_url = "https://argon.lib.nthu.edu.tw/patron/api/auth/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $get_reader_info_url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'authorization: Token '.post_token("ncu", "ncu;admin")
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
             http_build_query(array('id' => $id, 'pwd' => $pwd)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $token = json_decode($result, true);
    return $token["status"]["code"];
}
// this function is : input studentid and then get reader's total's info
function get_readerInfo($id)
{
    $get_reader_info_url = "https://argon.lib.nthu.edu.tw/patron/api/profile/".$id."/" ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $get_reader_info_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'authorization: Token '.post_token("ncu", "ncu;admin")
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
// $reader_json_code is reader info data(.json)
$reader_json_code = get_readerInfo(($_GET['id']));
//$reader_json_code = get_readerInfo(($_GET['studentid']));


$reader_array = json_decode($reader_json_code, true);
if($reader_array['status']['code'] == 401890){
	echo "Input Error";
}
else{
	$student_name = $reader_array['data']['user_data']['last_name'];
	echo "    ".$student_name." 您好";
	echo '<br>以下為您的個人資訊 <br><br><br>';
	$reader_phone = $reader_array['data']['user_data']['phone'][0]['phone_number'];
	$reader_email = $reader_array['data']['user_data']['email'][0]['email_address'];
	echo '姓名 : '.$student_name;
	echo '<br> 電話 : '.$reader_phone;
	echo '<br> 信箱 : '.$reader_email;
}
// $student_name is reader name

// echo "<br><br>".$reader_json_code;

?>