<?php require_once('../Connections/parkir.php'); ?>
<?php
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

$colname_park = "-1";
if (isset($_GET['nopol'])) {
  $colname_park = $_GET['nopol'];
}
mysql_select_db($database_parkir, $parkir);
$query_park = sprintf("SELECT * FROM parkir WHERE nopol = %s ORDER BY id DESC", GetSQLValueString($colname_park, "text"));
$park = mysql_query($query_park, $parkir) or die(mysql_error());
$row_park = mysql_fetch_assoc($park);
$totalRows_park = mysql_num_rows($park);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
	.nopol{
		background-color:black;
		font-family:Arial, Helvetica, sans-serif;
		font-size:22px;
		color:white;
	}
	.sys{
		font-family:Arial, Helvetica, sans-serif;
		font-size:22px;
		text-align:center;
	}
	.ket{
		height:18px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:7px;
	}
	.under{
		height:20px;
		font-size:11px;
		font-family:Arial, Helvetica, sans-serif;
	}
	#brd{
		border-bottom:0.2px solid #000;
	}
	.unde{
		height:40px;
		font-size:9px;
		font-family:Arial, Helvetica, sans-serif;
	}
</style>
</head>

<body>
<table border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td colspan="2" class="sys">Sistem Parkir</td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="nopol"><?php echo $row_park['nopol']; ?></td>
  </tr>
  <tr>
    <td class="under" style="width:60px">Tanggal</td>
    <td class="under" id="brd" style="width:85px"><?php echo $row_park['tanggal']; ?></td>
  </tr>
  <tr>
    <td class="under">Jam Masuk</td>
    <td class="under" id="brd"><?php echo $row_park['masuk']; ?></td>
  </tr>
  <tr>
    <td class="under">Jam Keluar</td>
    <td class="under" id="brd"><?php echo $row_park['keluar']; ?></td>
  </tr>
  <tr>
    <td class="under">Lama Parkir</td>
    <td class="under" id="brd"><?php echo $row_park['lama_parkir']; ?> Jam</td>
  </tr>
  <tr>
    <td class="under">Total Bayar</td>
    <td class="under" id="brd">Rp. <?php echo $row_park['biaya']; ?>,00,-</td>
  </tr>
  <tr align="center">
    <td colspan="2" class="unde">Terima Kasih telah parkir dengan tertib</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($park);
?>
