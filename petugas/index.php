<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "petugas";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php require_once('../Connections/parkir.php'); ?>
<?php
@session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO parkir (nopol, id_petugas) VALUES (%s, %s)",
                       GetSQLValueString($_POST['nopol'], "text"),
					   GetSQLValueString($_POST['id_petugas'], "text")
					   );

  mysql_select_db($database_parkir, $parkir);
  $Result1 = mysql_query($insertSQL, $parkir) or die(mysql_error());
  $nopol=$_POST['nopol'];
  header("location:cetak.php?p=awal&nopol=".$nopol);
}
?>
<?php include('head.php'); ?>
<?php include('foot.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Loket Masuk</title>
<style>
body{
	margin:0px;
}
#tab{
	width:400px;
	top:40%;
	left:50%;
	margin-left:-200px;
	display:block;
	position:absolute;
}
#aidi{
	top:75%;
	left:50%;
	height:30px;
	width:400px;
	position:absolute;
	display:block;
	margin-top:-15px;
	margin-left:-200px;
	text-align: center;
}
#heade{
	width:250px;
	height:250px;
	display:block;
	position:absolute;
	//background-color:red;
	float:left;
	left:50%;
	margin-left:-125px;
	background-image:url(logo/park.png);
	background-repeat:no-repeat;
	background-size:100% auto;
	text-align:center;
	font-size:15px;
}
	#logos{
		width:130px;
		height:100%;
		margin-left:200px;
		//background-color:blue;
		background-image:url(logo/park.png);
		background-repeat:no-repeat;
		display:block;
		position:relative;
		background-size:100% auto;
		margin-top:10px;
		float:left;
	}
	#key{
		width:60%;
		height:80%;
		background-color:blue;
		display:block;
		position:relative;
		background-size:100% auto;
		margin-top:10px;
		float:left;
		margin-left:30px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:44px;
	}
</style>
</head>
<body>
<br />
<br />
<br />
<div class="container">
<div id="heade"></div>
<div id="tab">
<br>
<br>
<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:24px">Selamat Datang Di System Parkir</div>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="400" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <td height="50" colspan="2" align="center" valign="middle"><h3>
        <h3>Pendaftaran Parkir</h3></td>
    </tr>
    <tr>
      <td><input type="text" name="nopol" value="" size="32" class="input-lg form-control" placeholder="Masukan Nopol (ex: R 45 D)" /></td>
      <td><input type="submit" value="Go" class="input-lg btn btn-primary" /></td>
    </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1">
  <input name="id_petugas" type="hidden" value="<?=$_SESSION['id_petugas']?>" />
</form>
</div>
<div class="modal fade" id="petunjuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Petunjuk Parkir</h4>
      </div>
      <div class="modal-body">
        Masukan Nomor Kendaraan maka secara otamatis akan tercetak struk. Setelah selesai ketras diberikan kepada petugas parkir. Kartu Parkir Jangan Sampai Hilang. Jika hilang maka tunjukan STNK Terimakasih.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<div id="aidi">
  <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table">
    <tr>
      <td><div align="center"><button class="btn btn-default" data-toggle="modal" data-target="#petunjuk"><span class="network-name">Petunjuk Parkir</span></button></div></td>
      <td><a href="input_akhir.php" class="btn btn-default">Bayar Parkir</a></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><a href="../logout.php" class="btn btn-danger">Logout</a></td>
      </tr>
  </table>
</div>
</div>
</body>
</html>