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
$query_Recordset1 = "SELECT * FROM login";
$Recordset1 = mysql_query($query_Recordset1, $parkir) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2 align="center">Tampil User</h2>
<a href="t_user.php" class="btn btn-primary" align="center">Tambah User</a>
<br />
<br />
<div class="container">
<table width="80%" border="1" align="center" cellpadding="4" cellspacing="4" class="table">
  <tr align="center" class="bg-primary">
    <td width="5%" align="center">Id</td>
    <td width="18%">Nama Lengkap</td>
    <td width="16%">Username</td>
    <td width="15%">Password</td>
    <td width="13%">Level</td>
    <td colspan="2" valign="middle">Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_Recordset1['id_petugas']; ?></td>
      <td><?php echo $row_Recordset1['nama_lengkap']; ?></td>
      <td><?php echo $row_Recordset1['username']; ?></td>
      <td><?php echo $row_Recordset1['password']; ?></td>
      <td><?php echo $row_Recordset1['level']; ?></td>
      <td width="7%" align="center" valign="middle"><a class="btn-danger btn-sm" href="d_user.php?id=<?php echo $row_Recordset1['id_petugas'];?>">Delete</a></td>
      <td width="7%" align="center" valign="middle"><a class="btn-sm btn-info" href="e_user.php?id=<?php echo $row_Recordset1['id_petugas']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
