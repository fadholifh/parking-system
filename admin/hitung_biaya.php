<?php require_once('../Connections/parkir.php'); ?>
<?php require_once('../Connections/parkir.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  
  return $theValue;
}
}
date_default_timezone_set("Asia/Jakarta");

mysql_select_db($database_parkir, $parkir);
$query_Recordset1 = "SELECT * FROM parkir WHERE nopol='".$_GET['nopol']."'";
$Recordset1 = mysql_query($query_Recordset1, $parkir) or die(mysql_error());
$row_park = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$perjam = 1000;
$masuk = $row_park['masuk'];
$sekarang = date("H:i:s");
$lama = $sekarang-$masuk;
$biaya = (($lama+1)*$perjam);
  $updateSQL = "UPDATE parkir SET keluar='".date("H:i:s")."', lama_parkir='".$lama."', biaya=".$biaya." WHERE nopol='".$_GET['nopol']."'";

  mysql_select_db($database_parkir, $parkir);
  $Result1 = mysql_query($updateSQL, $parkir) or die(mysql_error());
  
  
  header("location:cetak.php?p=akhir&nopol=".$_GET['nopol']);


?>

<?php
@mysql_free_result($row_park);
?>
