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

$maxRows_kasbulanan = 10;
$pageNum_kasbulanan = 0;
if (isset($_GET['pageNum_kasbulanan'])) {
  $pageNum_kasbulanan = $_GET['pageNum_kasbulanan'];
}
$startRow_kasbulanan = $pageNum_kasbulanan * $maxRows_kasbulanan;

$tahun_kasbulanan = "2000";
if (isset($_GET['tahun'])) {
  $tahun_kasbulanan = $_GET['tahun'];
}
$bulan_kasbulanan = "1";
if (isset($_GET['bulan'])) {
  $bulan_kasbulanan = $_GET['bulan'];
}
mysql_select_db($database_parkir, $parkir);
$query_kasbulanan = sprintf("SELECT * FROM parkir WHERE parkir.tanggal > '%s-%s-00' AND parkir.tanggal < '%s-%s-32' AND keluar != '00:00:00'", GetSQLValueString($tahun_kasbulanan, "int"),GetSQLValueString($bulan_kasbulanan, ""),GetSQLValueString($tahun_kasbulanan, "int"),GetSQLValueString($bulan_kasbulanan, ""));
$query_limit_kasbulanan = sprintf("%s LIMIT %d, %d", $query_kasbulanan, $startRow_kasbulanan, $maxRows_kasbulanan);
$kasbulanan = mysql_query($query_limit_kasbulanan, $parkir) or die(mysql_error());
$row_kasbulanan = mysql_fetch_assoc($kasbulanan);

if (isset($_GET['totalRows_kasbulanan'])) {
  $totalRows_kasbulanan = $_GET['totalRows_kasbulanan'];
} else {
  $all_kasbulanan = mysql_query($query_kasbulanan);
  $totalRows_kasbulanan = mysql_num_rows($all_kasbulanan);
}
$totalPages_kasbulanan = ceil($totalRows_kasbulanan/$maxRows_kasbulanan)-1;

$bulan_jumlah_total = "1";
if (isset($_GET['bulan'])) {
  $bulan_jumlah_total = $_GET['bulan'];
}
$tahun_jumlah_total = "2000";
if (isset($_GET['tahun'])) {
  $tahun_jumlah_total = $_GET['tahun'];
}
mysql_select_db($database_parkir, $parkir);
$query_jumlah_total = sprintf("SELECT SUM(biaya) FROM parkir WHERE parkir.tanggal > '%s-%s-00' AND parkir.tanggal < '%s-%s-32'", GetSQLValueString($tahun_jumlah_total, "int"),$bulan_jumlah_total,GetSQLValueString($tahun_jumlah_total, "int"),$bulan_jumlah_total);
$jumlah_total = mysql_query($query_jumlah_total, $parkir) or die(mysql_error());
$row_jumlah_total = mysql_fetch_assoc($jumlah_total);
$totalRows_jumlah_total = mysql_num_rows($jumlah_total);

mysql_select_db($database_parkir, $parkir);
$query_ambil_bulan = "SELECT tanggal FROM parkir GROUP BY SUBSTRING(tanggal,6,2)";
$ambil_bulan = mysql_query($query_ambil_bulan, $parkir) or die(mysql_error());
$row_ambil_bulan = mysql_fetch_assoc($ambil_bulan);
$totalRows_ambil_bulan = mysql_num_rows($ambil_bulan);

mysql_select_db($database_parkir, $parkir);
$query_ambil_tahun = "SELECT tanggal FROM parkir GROUP BY LEFT(tanggal,4)";
$ambil_tahun = mysql_query($query_ambil_tahun, $parkir) or die(mysql_error());
$row_ambil_tahun = mysql_fetch_assoc($ambil_tahun);
$totalRows_ambil_tahun = mysql_num_rows($ambil_tahun);

mysql_select_db($database_parkir, $parkir);
$query_Recordset1 = "SELECT * FROM t_parkir";
$Recordset1 = mysql_query($query_Recordset1, $parkir) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_parkir, $parkir);
$query_Recordset2 = "SELECT tanggal FROM parkir GROUP BY tanggal";
$Recordset2 = mysql_query($query_Recordset2, $parkir) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

echo $_GET['bulan'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td style="width:745px;text-align:center;font-size:24px;font-family:Arial, Helvetica, sans-serif">LAPORAN BULANAN</td>
  </tr>
  <tr>
    <td style="width:745px;text-align:center;font-size:18px;font-family:Arial, Helvetica, sans-serif"><?php echo $row_Recordset1['nama_tempat']; ?></td>
  </tr>
  <tr>
    <td style="width:745px;text-align:center;font-size:18px;font-family:Arial, Helvetica, sans-serif"><?php echo $row_Recordset1['alamat']; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle">
    <td style="width:100px">Nopol</td>
    <td style="width:100px">Tanggal</td>
    <td style="width:100px">Masuk</td>
    <td style="width:100px">Keluar</td>
    <td style="width:100px">Lama Parkir</td>
    <td style="width:100px">Petugas</td>
    <td style="width:100px">Biaya</td>
  </tr>
  <?php do { ?>
    <tr valign="middle">
        <td><?php echo $row_kasbulanan['nopol']; ?></td>
        <td><?php echo $row_kasbulanan['tanggal']; ?></td>
        <td><?php echo $row_kasbulanan['masuk']; ?></td>
        <td><?php echo $row_kasbulanan['keluar']; ?></td>
        <td><?php echo $row_kasbulanan['lama_parkir']; ?> Jam</td>
        <td><?php echo nama($row_kasbulanan['id_petugas']); ?></td>
        <td><?php echo rp($row_kasbulanan['biaya']); ?></td>
    </tr>
	<?php } while ($row_kasbulanan = mysql_fetch_assoc($kasbulanan)); ?>
    <tr valign="middle">
      <td colspan="6" align="right">TOTAL    :</td>
      <td><?php echo rp($row_jumlah_total['SUM(biaya)']); ?></td>
    </tr>
    
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="right" cellpadding="1" cellspacing="1">
  <tr align="center" valign="middle">
    <td><?php echo $row_Recordset1['kota']; ?>, <?php echo date("d F Y"); ?></td>
  </tr>
  <tr align="center" valign="middle">
    <td>Petugas</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td><?php
		$q = mysql_query("SELECT * FROM login WHERE username = '".$_SESSION['MM_Username']."'");
		$f = mysql_fetch_array($q);
		?><?=$f['nama_lengkap'];?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($kasbulanan);

mysql_free_result($jumlah_total);

mysql_free_result($ambil_bulan);

mysql_free_result($ambil_tahun);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
