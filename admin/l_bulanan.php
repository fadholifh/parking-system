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
$query_kasbulanan = sprintf("SELECT a.*, b.nama_lengkap FROM parkir a LEFT OUTER JOIN login b on a.id_petugas = b.id_petugas WHERE a.tanggal > '%s-%s-00' AND a.tanggal < '%s-%s-32' AND keluar != '00:00:00'", GetSQLValueString($tahun_kasbulanan, "int"),GetSQLValueString($bulan_kasbulanan, "int"),GetSQLValueString($tahun_kasbulanan, "int"),GetSQLValueString($bulan_kasbulanan, "int"));
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

$maxRows_petugas = 10;
$pageNum_petugas = 0;
if (isset($_GET['pageNum_petugas'])) {
  $pageNum_petugas = $_GET['pageNum_petugas'];
}
$startRow_petugas = $pageNum_petugas * $maxRows_petugas;

mysql_select_db($database_parkir, $parkir);
$query_petugas = "SELECT a.id, b.nama_lengkap FROM parkir a LEFT OUTER JOIN login b on a.id_petugas = b.id_petugas";
$query_limit_petugas = sprintf("%s LIMIT %d, %d", $query_petugas, $startRow_petugas, $maxRows_petugas);
$petugas = mysql_query($query_limit_petugas, $parkir) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);

if (isset($_GET['totalRows_petugas'])) {
  $totalRows_petugas = $_GET['totalRows_petugas'];
} else {
  $all_petugas = mysql_query($query_petugas);
  $totalRows_petugas = mysql_num_rows($all_petugas);
}
$totalPages_petugas = ceil($totalRows_petugas/$maxRows_petugas)-1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2 align="center">Laporan Bulanan</h2>
<br />
<br />
<form id="form1" name="form1" method="get" action="">
  <label for="bulan"></label>
  <label for="tahun"></label>
  <table width="300px" border="0" cellspacing="1" cellpadding="1" align="center">
    <tr>
      <td width="99"><select name="bulan" id="bulan" class="input-group-lg form-control">
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
      <td width="103"><select name="tahun" id="tahun" class="input-group-lg form-control">
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
      <td width="80"><input type="submit" value="Submit" class="btn btn-primary input-group-sm" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<table border="1" cellpadding="4" cellspacing="4">
  <tr>
    <td>id</td>
    <td>nama_lengkap</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_petugas['id']; ?></td>
      <td><?php echo $row_petugas['nama_lengkap']; ?></td>
    </tr>
    <?php } while ($row_petugas = mysql_fetch_assoc($petugas)); ?>
</table>
<p>&nbsp;</p>
<div class="container">
  <?php if ($totalRows_kasbulanan > 0) { // Show if recordset not empty ?>
    <?php if ($totalRows_kasbulanan > 0) { // Show if recordset not empty ?>
      <table border="1" cellpadding="4" cellspacing="4" align="center" class="table">
        <tr align="center">
          <td class="bg-primary">Nopol</td>
          <td class="bg-primary">Tanggal</td>
          <td class="bg-primary">Masuk</td>
          <td class="bg-primary">Keluar</td>
          <td class="bg-primary">Lama Parkir</td>
          <td class="bg-primary">Petugas</td>
          <td class="bg-primary">Biaya</td>
        </tr>
        <?php do { ?>
          <tr>
            <td><?php echo $row_kasbulanan['nopol']; ?></td>
            <td><?php echo $row_kasbulanan['tanggal']; ?></td>
            <td><?php echo $row_kasbulanan['masuk']; ?></td>
            <td><?php echo $row_kasbulanan['keluar']; ?></td>
            <td><?php echo $row_kasbulanan['lama_parkir']; ?> Jam</td>
            <td><?php echo $row_kasbulanan['nama_lengkap']; ?></td>
            <td><?php echo rp($row_kasbulanan['biaya']); ?></td>
          </tr>
          <?php } while ($row_kasbulanan = mysql_fetch_assoc($kasbulanan)); ?>
        <tr>
          <td colspan="6">TOTAL</td>
          <td><?php echo rp($row_jumlah_total['SUM(biaya)']); ?></td>
        </tr>
      </table>
      <br />
      <a href="cetak_isi_bulanan_pertama.php" class="btn btn-primary">Cetak</a><br />
<?php } // Show if recordset not empty ?>
    <?php } // Show if recordset not empty ?>
</div>
</body>
</html>
<?php
mysql_free_result($kasbulanan);

mysql_free_result($jumlah_total);

mysql_free_result($ambil_bulan);

mysql_free_result($ambil_tahun);

mysql_free_result($petugas);
?>
