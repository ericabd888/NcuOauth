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
// input reader's account and password, get correct return code
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
// get reader's total's info
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
// "example reader_info: '109522026', '109522026'"
if(isset($_GET["a"]))
{
    echo"okok";
	$temp_code = get_readerInfo($_GET["id"]);
	var_dump($temp_code);
    $temp_code = json_decode($temp_code, true);
    $pwd = "";
    if($temp_code['status']['code'] != '200')
    {
        echo "<br>查無此帳號請您再輸入一次謝謝<br>";

    }
    else
    {
        var_dump(get_correct($_GET["id"], $_GET["password"]));
		if(get_correct($_GET["id"], $_GET["password"]) != "200")
        {
            echo "<br>密碼錯誤請您再輸入一次謝謝<br>";
        }
        else
        {
            echo "<br> ok";
            // header("Location: http://localhost/reader_info.php?studentid=".$_POST['studentid']);
            //header("Location: login?studentid=".$_POST['studentid']);
            // use get method to get studentid
        }
    }

}
// the following is html page.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-tw" lang="zh-tw">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>國立中央大學圖書館-讀者權益確認暨個資蒐集同意書簽署 The Statement of Patron's Right and Agreement for Personal Data Collection</title>
     <!-- <style type="text/css">
.style19 {color: #000000}
.style8 {font-family: "Times New Roman", Times, serif}
.style20 {font-family: Geneva, Arial, Helvetica, sans-serif}
.style22 {font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; }
.style23 {color: #FFFFFF}
.style24 {color: #990000}
.style25 {color: #006600}
.style6 {color: #990000}
.style10 {color: #660066}
#warning { display:none; color:red; font-weight:bold; }
.style11 {color: #660099}
body{
    position: relative;
    top:10px;
    left:50px;
}
     </style> -->
     
</head>
<body>
<div id="container">

<div id="head">
	<div id="header">
	<div id="header_inner">
		<h1>&nbsp;</h1>
	  </div>
	</div>
</div>

<div id="content">

<div class="post">
    <div class="table_header"><strong>國立中央大學圖書館啟用借閱權限 - 讀者權益確認暨個資蒐集同意書簽署 </strong></div> 
	<div class="posttext">
	<p>各位讀者好,
	    <br />
	    <br />
	  　
	  為了讓您了解本館入館閱覽及借閱資料之相關規定，並確認您個人聯絡資料的正確性，以確保各位讀者於借書之後，能如期收到本館發出的各項電子郵件(如：圖書到期通知、圖書逾期通知、預約書到館通知單…等)，您必須簽署「國立中央大學圖書館-讀者權益確認暨個資蒐集同意書」，完成簽署後，才可開始借閱館藏資料。 
	  <br />
	  　
	  每位讀者簽署一次即可，簽署後請至您登錄之電子郵件信箱確認後，即完成簽署程序，轉換不同身份如仍沿用相同證號，則不須再重新簽署。 
	  <br />
	  　
	  為確保您的權益，請務必詳閱「圖書館閱覽規則」、「圖書館館藏資料借閱規則」、「個人資料蒐集告知暨同意書」並留下有效的電子信箱；為避免影響借閱權利，請上網完成簽署。 
	  <br />
	  　
	  特別提醒您，各項email通知，僅供提醒用，逾期時不能以未收到email為不繳滯還金之申訴理由。若有任何問題，歡迎洽詢中央大學圖書館借還書櫃臺，聯絡電話：(03)4227151分機57417，或寄信至<a href="mailto:cirlib@ncu.edu.tw">cirlib<strong>@</strong>ncu.edu.tw</a> 。 </p>
	<div class="eposttext">
	<p><strong>The Statement of Patron's Right and Agreement for Personal Data Collection </strong><br />
	  <br />
	  Dear Patrons:<br />
	  <br />
	  　
	  Welcome to National Central University Library. To ensure your full understanding of the Library's regulations and to confirm your e-mail address, you have to sign “ The Statement of Patron's Right and Agreement for Personal Data Collection” to activate library accounts.Please complete the procedure.
	  <br />
	  　The library enforces the policy as   follow:<br />　　
	  1.The library will send out e-mail reminders; however, the library is not   accountable  for the delivery of all e-mail reminders. <br />　　
	  If you have any questions and/or suggestions, please feel free to contact   the circulation desk at 03-4227151 (ext. 57417 ), or email to <a href="mailto:cirlib@ncu.edu.tw">cirlib<strong>@</strong>ncu.edu.tw</a>. </p>
	</div>
</div>
<form method="get" action=""><div align="left">
<table align="center">
<tr>
  <th bgcolor="#FFFFFF">證號/User ID:</th>
  <td bgcolor="#FFFFFF"><input type="password" name="id" /></td>
</tr>
<tr>
  <th bgcolor="#FFFFFF">密碼/Password:</th>
  <td bgcolor="#FFFFFF"><input type="password" name="password" /></td>
</tr>
<tr>
  <th>&nbsp;</th>

  <td> 若有問題請洽總圖館借書櫃台，(03)4227151分機57417，或寄信至<a href="mailto:cirlib@ncu.edu.tw">cirlib<strong>@</strong>ncu.edu.tw</a> 。 <br />
<div class="eposttext"> Any problem for User ID or Password, please contact the circulation desk at (03)4227151 ext. 57417 or email to <a href="mailto:cirlib@ncu.edu.tw">cirlib<strong>@</strong>ncu.edu.tw</a></div></td>
</tr>
<tr>
<th>&nbsp;</th>
<td><br>
	<input type="submit" name="a" value="確定/OK" />
	<input type="reset" name="a2" value="取消/Cancel" />
	<a href="..\login">Login with Portal Account</a>
</td>
</tr>
</table>
<br />
<table width="90%" border="1" align="center" cellpadding="1" cellspacing="1" bgcolor='#000000'>
  <tr bgcolor="#FFFFFF">
    <td height="26" colspan="3" bgcolor="#CCFFFF" class="style16"><p><strong>登</strong><span class="style27"><strong>&#20837;&#24115;&#34399;&#23494;&#30908;&#35498;&#26126;<span class="style20">(About ID / Password)&#65306;</span></strong></span></p></td>
  </tr>
  <tr bgcolor="#FFFFFF" align='center'>
    <td bgcolor="#99CCFF" width="28%"><span class="style23">&nbsp;<strong>&#35712;&#32773;&#39006;&#21029;</strong><br />    
        <span class="style22">Reader Type </span></span><br />
          <br />    </td>
    <td bgcolor="#99CCFF" width="36%">&nbsp;<span class="style16 style23"><strong>&#30331;&#20837;&#35657;&#34399;</strong></span><span class="style23"><br />
        <span class="style22">User ID </span></span><br />    </td>
    <td width="36%" bgcolor="#99CCFF">&nbsp;<span class="style7"><span class="style16 style23"><strong>&#38928;&#35373;&#30331;&#20837;&#23494;&#30908;</strong></span></span><span class="style23"><br />    
        <span class="style20"><strong>Default Password </strong></span></span><br />
        </span></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="28%" bgcolor="#FFFFCC"><span class="style19">&#20013;&#22823;&#25945;&#32887;&#21729;&#12289;學生</span><strong><br />
          <span class="style8">NCU User</span> <br />
          <br />
    </strong></td>
    <td rowspan="5" bgcolor="#FFFFCC"><div align="center"><span class="style3">學生證號碼<br />
        <span class="style8">student card number</span> <br />
    </span></div></td>
    <td rowspan="5" bgcolor="#FFFFCC"><div align="center"><span class="style7">自定義密碼<br />
            <span class="style3 style8">user define password </span></span></span></div></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#FFFFCC">中大壢中教職員<br />
NCU CLHS Faculty </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="28%" bgcolor="#FFFFCC">中大校友借書證<strong><br />
          <span class="style8">NCU Alumni </span></strong></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#FFFFCC" class="style4">台灣聯大系統(UST)讀者
      <br />
      <span class="style8">UST User </span></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td height="54" bgcolor="#FFFFCC">本館核發臨時證
      <br />
      <span class="style8">NCU Library Card </span></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#CCFFFF">外籍教職員　
      <span class="style8">Foreign Faculty</span></td>
    <td rowspan="2" bgcolor="#CCFFFF"><div align="center">居留證編號<br />
        <span class="style8">ARC Number </span></div></td>
    <td rowspan="2" bgcolor="#CCFFFF"><div align="center">居留證編號<br />
        <span class="style8">ARC Number </span></div></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#CCFFFF">外籍學生　 
      <span class="style8">Foreign Student <br />
      (<span class="style24">Registered</span> <span class="style25">before</span> <span class="style24">Sept. 2012</span>) </span></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="28%" bgcolor="#FFFFCC">外籍學生　
      <span class="style8">Foreign Student<br />
      (<span class="style24">Registered</span> <span class="style25">after</span> <span class="style24">Sept. 2012</span>) <br />
</span></td>
    <td bgcolor="#FFFFCC"><div align="center">學生證號碼<br />
      Student ID No. <br />
      <strong><br />
          </strong></div></td>
    <td bgcolor="#FFFFCC"><div align="center">學生證號碼<br />
Student ID No. <br />
        </span><span class="style3"><br />
          </span></div></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="28%" bgcolor="#CCFFFF">館際合作借書證  <br />
            <span class="style8">ILL Card </span><strong><br />
    </strong></td>
    <td bgcolor="#CCFFFF"><p align="center">證件條碼號<br />
      <span class="style8">Barcode Number </span></p>
      <p>&nbsp;</p></td>
    <td bgcolor="#CCFFFF"><div align="center">證件條碼號<br />
        <span class="style8">Barcode Number </span></div></td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="3" bgcolor="#FFFFCC"><span class="style3">附註：讀者登入個人借閱記錄後可自行修改預設密碼。</span><br />
        <span class="style8">Note: Readers can modify the default password after login opac personal account. </span><span class="style3"><br />
    </span></td>
    </tr>
</table>
</form>
</div>

<div id="foot">
	<div id="footer">
	<p><center><a href="http://www.cc.ncu.edu.tw/page/privacy/">隱私權政策聲明</a></center></p>
	<p><center>Copyright &copy; National Central University Library, All Rights Reserved.2019/12/24 updated.</center></p>
	</div>
</div>


</div>

</body>
</html>