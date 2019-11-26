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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO login (nama_lengkap, username, password, `level`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['level'], "text"));

  mysql_select_db($database_parkir, $parkir);
  $Result1 = mysql_query($insertSQL, $parkir) or die(mysql_error());
}

$maxRows_user = 10;
$pageNum_user = 0;
if (isset($_GET['pageNum_user'])) {
  $pageNum_user = $_GET['pageNum_user'];
}
$startRow_user = $pageNum_user * $maxRows_user;

mysql_select_db($database_parkir, $parkir);
$query_user = "SELECT * FROM login";
$query_limit_user = sprintf("%s LIMIT %d, %d", $query_user, $startRow_user, $maxRows_user);
$user = mysql_query($query_limit_user, $parkir) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);

if (isset($_GET['totalRows_user'])) {
  $totalRows_user = $_GET['totalRows_user'];
} else {
  $all_user = mysql_query($query_user);
  $totalRows_user = mysql_num_rows($all_user);
}
$totalPages_user = ceil($totalRows_user/$maxRows_user)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h2 align="center">Input User</h2>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="600" height="281" align="center">
    <tr valign="baseline">
      <td width="166" height="59" align="left" valign="middle" nowrap="nowrap"><h4>Nama Lengkap</h4></td>
      <td width="272"><input type="text" name="nama_lengkap" value="" size="32" class="input-lg form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td height="60" align="left" valign="middle" nowrap="nowrap"><h4>Username</h4></td>
      <td><input type="text" name="username" value="" size="32" class="input-lg form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td height="59" align="left" valign="middle" nowrap="nowrap"><h4>Password</h4></td>
      <td><input type="text" name="password" value="" size="32" class="input-lg form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td height="59" align="left" valign="middle" nowrap="nowrap"><h4>Level</h4></td>
      <td><select name="level" class="input-lg form-control">
        <option value="admin" <?php if (!(strcmp("admin", ""))) {echo "SELECTED";} ?>>admin</option>
        <option value="petugas" <?php if (!(strcmp("petugas", ""))) {echo "SELECTED";} ?>>petugas</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      <td><input type="submit" value="Insert record" class="btn btn-primary" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($user);
?>
