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
$query_kasbulanan = sprintf("SELECT * FROM parkir WHERE parkir.tanggal > '%s-%s-00' AND parkir.tanggal < '%s-%s-32' AND keluar != '00:00:00'", GetSQLValueString($tahun_kasbulanan, "int"),$bulan_kasbulanan,GetSQLValueString($tahun_kasbulanan, "int"),$bulan_kasbulanan);
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="cetak_bulanan.php">
  <label for="bulan"></label>
  <label for="tahun"></label>
  <table width="300" border="0" cellspacing="1" cellpadding="1"  align="center">
    <tr>
      <td width="94"><select name="bulan" id="bulan" class="form-control input-sm">
        <?php
do {  
?>
        <option value="<?php echo substr($row_ambil_bulan['tanggal'],5,2)?>"><?php echo substr($row_ambil_bulan['tanggal'],5,2)?></option>
        <?php
} while ($row_ambil_bulan = mysql_fetch_assoc($ambil_bulan));
  $rows = mysql_num_rows($ambil_bulan);
  if($rows > 0) {
      mysql_data_seek($ambil_bulan, 0);
	  $row_ambil_bulan = mysql_fetch_assoc($ambil_bulan);
  }
?>
      </select></td>
      <td width="97"><select name="tahun" id="tahun" class="form-control input-group-lg">
        <?php
do {  
?>
        <option value="<?php echo substr($row_ambil_tahun['tanggal'],0,4)?>"><?php echo substr($row_ambil_tahun['tanggal'],0,4)?></option>
        <?php
} while ($row_ambil_tahun = mysql_fetch_assoc($ambil_tahun));
  $rows = mysql_num_rows($ambil_tahun);
  if($rows > 0) {
      mysql_data_seek($ambil_tahun, 0);
	  $row_ambil_tahun = mysql_fetch_assoc($ambil_tahun);
  }
?>
      </select></td>
      <td width="99"><input type="submit" value="Submit" class="btn btn-primary" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($kasbulanan);

mysql_free_result($jumlah_total);

mysql_free_result($ambil_bulan);

mysql_free_result($ambil_tahun);
?>
