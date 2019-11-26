<?php require_once('../Connections/parkir.php'); ?>
<?php include('fungsi.php'); ?>
<?php include('head.php'); ?>
<?php include('foot.php'); ?>
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

mysql_select_db($database_parkir, $parkir);
$query_Recordset1 = "SELECT tanggal FROM parkir GROUP BY tanggal";
$Recordset1 = mysql_query($query_Recordset1, $parkir) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_isi_harian = 10;
$pageNum_isi_harian = 0;
if (isset($_GET['pageNum_isi_harian'])) {
  $pageNum_isi_harian = $_GET['pageNum_isi_harian'];
}
$startRow_isi_harian = $pageNum_isi_harian * $maxRows_isi_harian;

$datepick_isi_harian = "29-08-2014";
if (isset($_GET['datepick'])) {
  $datepick_isi_harian = $_GET['datepick'];
}
mysql_select_db($database_parkir, $parkir);
$query_isi_harian = sprintf("SELECT * FROM parkir WHERE tanggal = %s AND keluar != '00:00:00'", GetSQLValueString($datepick_isi_harian, "text"));
$query_limit_isi_harian = sprintf("%s LIMIT %d, %d", $query_isi_harian, $startRow_isi_harian, $maxRows_isi_harian);
$isi_harian = mysql_query($query_limit_isi_harian, $parkir) or die(mysql_error());
$row_isi_harian = mysql_fetch_assoc($isi_harian);

if (isset($_GET['totalRows_isi_harian'])) {
  $totalRows_isi_harian = $_GET['totalRows_isi_harian'];
} else {
  $all_isi_harian = mysql_query($query_isi_harian);
  $totalRows_isi_harian = mysql_num_rows($all_isi_harian);
}
$totalPages_isi_harian = ceil($totalRows_isi_harian/$maxRows_isi_harian)-1;

$datepick_total_isi = "0";
if (isset($_GET['datepick'])) {
  $datepick_total_isi = $_GET['datepick'];
}
mysql_select_db($database_parkir, $parkir);
$query_total_isi = sprintf("SELECT SUM(biaya) FROM parkir WHERE tanggal = %s", GetSQLValueString($datepick_total_isi, "text"));
$total_isi = mysql_query($query_total_isi, $parkir) or die(mysql_error());
$row_total_isi = mysql_fetch_assoc($total_isi);
$totalRows_total_isi = mysql_num_rows($total_isi);

mysql_select_db($database_parkir, $parkir);
$query_tempat = "SELECT * FROM t_parkir";
$tempat = mysql_query($query_tempat, $parkir) or die(mysql_error());
$row_tempat = mysql_fetch_assoc($tempat);
$totalRows_tempat = mysql_num_rows($tempat);
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
	table{
		width: 100%;
	}
</style>
</head>

<body>
<table width="900" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td align="center" valign="middle" style="text-align:center;width:745px;font-size:24px;font-family:Arial, Helvetica, sans-serif">LAPORAN HARIAN</td>
  </tr>
  <tr>
    <td align="center" valign="middle" style="text-align:center;font-size:18;font-family:Arial, Helvetica, sans-serif"><?php echo $row_tempat['nama_tempat']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><?php echo $row_tempat['alamat']; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1" cellpadding="0" cellspacing="0">
  <tr align="center" >
    <td>Nopol</td>
    <td>Tanggal</td>
    <td>Masuk</td>
    <td>Keluar</td>
    <td>Lama Parkir</td>
    <td>Petugas</td>
    <td>Biaya</td>
  </tr>
  <?php do { ?>
    <tr>
        <td style="width:100px;"><?php echo $row_isi_harian['nopol']; ?></td>
        <td style="width:100px;"><?php echo $row_isi_harian['tanggal']; ?></td>
        <td style="width:100px;"><?php echo $row_isi_harian['masuk']; ?></td>
        <td style="width:100px;"><?php echo $row_isi_harian['keluar']; ?></td>
        <td style="width:100px;"><?php echo $row_isi_harian['lama_parkir']; ?> Jam</td>
        <td style="width:100px;"><?php echo nama($row_isi_harian['id_petugas']); ?></td>
        <td style="width:100px;"><?php echo rp($row_isi_harian['biaya']); ?></td>
    </tr><?php } while ($row_isi_harian = mysql_fetch_assoc($isi_harian)); ?>
    <tr>
      <td colspan="6" style="text-align:right;">TOTAL    :</td>
      <td><?php echo rp($row_total_isi['SUM(biaya)']); ?></td>
    </tr>
</table>
<br />
<br />
<br />
<table width="300" border="0" align="right" cellpadding="1" cellspacing="1" class="table">
  <tr>
    <td align="center" valign="middle"><?php echo $row_tempat['kota']; ?>, <?php echo date("d F Y"); ?></td>
  </tr>
  <tr align="center" valign="middle">
    <td>Petugas</td>
  </tr>
  <tr>
    <td height="44" align="center" valign="middle"></td>
  </tr>
  <tr>
  <?php
  	$q = mysql_query("SELECT * FROM login WHERE username = '".$_SESSION['MM_Username']."'");
	$f = mysql_fetch_array($q);
	?>
    <td align="center" valign="middle"><?=$f['nama_lengkap'];?></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($park);

mysql_free_result($Recordset1);

mysql_free_result($isi_harian);

mysql_free_result($total_isi);

mysql_free_result($tempat);
?>
