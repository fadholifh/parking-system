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

mysql_select_db($database_parkir, $parkir);
$query_ambil_tanggal = "SELECT tanggal FROM parkir GROUP BY tanggal";
$ambil_tanggal = mysql_query($query_ambil_tanggal, $parkir) or die(mysql_error());
$row_ambil_tanggal = mysql_fetch_assoc($ambil_tanggal);
$totalRows_ambil_tanggal = mysql_num_rows($ambil_tanggal);

$maxRows_kasharian = 10;
$pageNum_kasharian = 0;
if (isset($_GET['pageNum_kasharian'])) {
  $pageNum_kasharian = $_GET['pageNum_kasharian'];
}
$startRow_kasharian = $pageNum_kasharian * $maxRows_kasharian;

$datepick_kasharian = "29-08-2014";
if (isset($_GET['datepick'])) {
  $datepick_kasharian = $_GET['datepick'];
}
mysql_select_db($database_parkir, $parkir);
$query_kasharian = sprintf("SELECT a.*, b.nama_lengkap FROM parkir a LEFT OUTER JOIN login b on a.id_petugas = b.id_petugas WHERE tanggal = %s AND keluar != '00:00:00'", GetSQLValueString($datepick_kasharian, "text"));
$query_limit_kasharian = sprintf("%s LIMIT %d, %d", $query_kasharian, $startRow_kasharian, $maxRows_kasharian);
$kasharian = mysql_query($query_limit_kasharian, $parkir) or die(mysql_error());
$row_kasharian = mysql_fetch_assoc($kasharian);

if (isset($_GET['totalRows_kasharian'])) {
  $totalRows_kasharian = $_GET['totalRows_kasharian'];
} else {
  $all_kasharian = mysql_query($query_kasharian);
  $totalRows_kasharian = mysql_num_rows($all_kasharian);
}
$totalPages_kasharian = ceil($totalRows_kasharian/$maxRows_kasharian)-1;

$datepick_total_harian = "29-08-2014";
if (isset($_GET['datepick'])) {
  $datepick_total_harian = $_GET['datepick'];
}
mysql_select_db($database_parkir, $parkir);
$query_total_harian = sprintf("SELECT SUM(biaya) FROM parkir WHERE tanggal = %s", GetSQLValueString($datepick_total_harian, "text"));
$total_harian = mysql_query($query_total_harian, $parkir) or die(mysql_error());
$row_total_harian = mysql_fetch_assoc($total_harian);
$totalRows_total_harian = mysql_num_rows($total_harian);

mysql_select_db($database_parkir, $parkir);
$query_petugas = "SELECT a.tanggal,b.nama_lengkap FROM parkir a LEFT OUTER JOIN login b on a.id_petugas = b.id_petugas";
$petugas = mysql_query($query_petugas, $parkir) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2 align="center">Laporan Harian</h2>
<br>
<br>

<form id="form1" name="form1" method="get" action="">
  <label for="datepick"></label>
  <table width="300" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="193"><select name="datepick" id="datepick" class="input-group-lg form-control">
        <?php
do {  
?>
        <option value="<?php echo $row_ambil_tanggal['tanggal']?>"><?php echo $row_ambil_tanggal['tanggal']?></option>
        <?php
} while ($row_ambil_tanggal = mysql_fetch_assoc($ambil_tanggal));
  $rows = mysql_num_rows($ambil_tanggal);
  if($rows > 0) {
      mysql_data_seek($ambil_tanggal, 0);
	  $row_ambil_tanggal = mysql_fetch_assoc($ambil_tanggal);
  }
?>
      </select></td>
      <td width="94"><input type="submit" value="Submit" class="btn btn-primary" /></td>
    </tr>
  </table>
</form>
<div class="container">
  <?php if ($totalRows_kasharian > 0) { // Show if recordset not empty ?>
  <table align="center" class="table" border="1" cellpadding="4" cellspacing="4">
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
        <td><?php echo $row_kasharian['nopol']; ?></td>
        <td><?php echo $row_kasharian['tanggal']; ?></td>
        <td><?php echo $row_kasharian['masuk']; ?></td>
        <td><?php echo $row_kasharian['keluar']; ?></td>
        <td><?php echo $row_kasharian['lama_parkir']; ?> Jam</td>
        <td><?php echo $row_kasharian['nama_lengkap']; ?></td>
        <td><?php echo rp($row_kasharian['biaya']); ?></td>
        </tr>
      <?php } while ($row_kasharian = mysql_fetch_assoc($kasharian)); ?>
    <tr>
      <td colspan="6">TOTAL</td>
      <td><?php echo rp($row_total_harian['SUM(biaya)']); ?></td>
      </tr>
    
  </table>
  <a href="cetak_isi_harian_pertama.php" class="btn btn-primary">Cetak</a><br />
<?php } // Show if recordset not empty ?>
</div>
</body>
</html>
<?php
mysql_free_result($ambil_tanggal);

mysql_free_result($kasharian);

mysql_free_result($total_harian);

mysql_free_result($petugas);
?>
