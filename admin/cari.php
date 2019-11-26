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

$maxRows_cari = 10;
$pageNum_cari = 0;
if (isset($_GET['pageNum_cari'])) {
  $pageNum_cari = $_GET['pageNum_cari'];
}
$startRow_cari = $pageNum_cari * $maxRows_cari;

$nomor_cari = "0";
if (isset($_GET['nomor'])) {
  $nomor_cari = $_GET['nomor'];
}
mysql_select_db($database_parkir, $parkir);
$query_cari = sprintf("SELECT * FROM parkir WHERE nopol LIKE %s", GetSQLValueString($nomor_cari, "text"));
$query_limit_cari = sprintf("%s LIMIT %d, %d", $query_cari, $startRow_cari, $maxRows_cari);
$cari = mysql_query($query_limit_cari, $parkir) or die(mysql_error());
$row_cari = mysql_fetch_assoc($cari);

if (isset($_GET['totalRows_cari'])) {
  $totalRows_cari = $_GET['totalRows_cari'];
} else {
  $all_cari = mysql_query($query_cari);
  $totalRows_cari = mysql_num_rows($all_cari);
}
$totalPages_cari = ceil($totalRows_cari/$maxRows_cari)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2 align="center">Cari Nopol</h2>
<br />
<br />
<div class="container">
<form id="form1" name="form1" method="get" action="">
  <label for="nomor"></label>
  <table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="396"><input type="text" name="nomor" id="nomor" class="input-lg form-control" placeholder="Nopol" /></td>
      <td width="91"><input type="submit" name="button" id="button" value="Cari Nopol" class="btn btn-primary" /></td>
    </tr>
</table>
</form>
</div>
<p>&nbsp;</p>
<?php if ($totalRows_cari > 0) { // Show if recordset not empty ?>
<div class="container">
  <table border="1" cellpadding="4" cellspacing="4" class="table" align="center">
    <tr align="center">
      <td class="bg-primary"><h4>Nopol</h4></td>
      <td class="bg-primary"><h4>Tanggal</h4></td>
      <td class="bg-primary"><h4>Masuk</h4></td>
      <td class="bg-primary"><h4>Keluar</h4></td>
      <td class="bg-primary"><h4>Lama Parkir</h4></td>
      <td class="bg-primary"><h4>Biaya</h4></td>
      <td class="bg-primary"><h4>Petugas</h4></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><h4><?php echo $row_cari['nopol']; ?></h4></td>
        <td><h4><?php echo $row_cari['tanggal']; ?></h4></td>
        <td><h4><?php echo $row_cari['masuk']; ?></h4></td>
        <td><h4><?php echo $row_cari['keluar']; ?></h4></td>
        <td><h4><?php echo $row_cari['lama_parkir']; ?> Jam</h4></td>
        <td><h4><?php echo rp($row_cari['biaya']); ?></h4></td>
        <td><h4><?php echo nama($row_cari['id_petugas']); ?></h4></td>
      </tr>
      <?php } while ($row_cari = mysql_fetch_assoc($cari)); ?>
  </table>
  </div>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($cari);
?>
