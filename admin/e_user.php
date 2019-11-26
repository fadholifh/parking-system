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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE login SET nama_lengkap=%s, username=%s, password=%s, `level`=%s WHERE id_petugas=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "int"));

  mysql_select_db($database_parkir, $parkir);
  $Result1 = mysql_query($updateSQL, $parkir) or die(mysql_error());

  $updateGoTo = "tampil_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_parkir, $parkir);
$query_Recordset1 = sprintf("SELECT * FROM login WHERE id_petugas = %s", GetSQLValueString($colname_Recordset1, "int"));
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
<h2 align="center">Edit User</h2>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="600" align="center">
    <tr valign="baseline">
      <td height="59" align="left" valign="middle" nowrap="nowrap"><h4>Id Petugas</h4></td>
      <td class="form-control input-lg"><?php echo $row_Recordset1['id_petugas']; ?></td>
    </tr>
    <tr valign="baseline">
      <td height="60" align="left" valign="middle" nowrap="nowrap"><h4>Nama Lengkap</h4></td>
      <td><input type="text" name="nama_lengkap" value="<?php echo htmlentities($row_Recordset1['nama_lengkap'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-lg" /></td>
    </tr>
    <tr valign="baseline">
      <td height="58" align="left" valign="middle" nowrap="nowrap"><h4>Username</h4></td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_Recordset1['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-lg" /></td>
    </tr>
    <tr valign="baseline">
      <td height="59" align="left" valign="middle" nowrap="nowrap"><h4>Password</h4></td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_Recordset1['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-lg" /></td>
    </tr>
    <tr valign="baseline">
      <td height="60" align="left" valign="middle" nowrap="nowrap"><h4>Level</h4></td>
      <td><select name="level" class="form-control input-lg">
        <option value="admin" <?php if (!(strcmp("admin", htmlentities($row_Recordset1['level'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>admin</option>
        <option value="petugas" <?php if (!(strcmp("petugas", htmlentities($row_Recordset1['level'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>petugas</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="middle" nowrap="nowrap"><h4>&nbsp;</h4></td>
      <td><input type="submit" value="Update record" class="btn btn-primary" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_petugas" value="<?php echo $row_Recordset1['id_petugas']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
