<?php require_once('../Connections/parkir.php'); ?>
<?php include('foot.php'); ?>
<?php include('head.php'); ?>
<?php include('fungsi.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Loket Pembayaran</title>
<style>
#tab{
	width: 500px;
	top: 50%;
	left: 50%;
	margin-left: -250px;
	display: block;
	position: absolute;
	text-align:center;
}
#aidi{
	top:75%;
	left:50%;
	height:30px;
	width:400px;
	position:absolute;
	display:block;
	margin-top:-15px;
	margin-left:-200px;
}
#heade{
	width:250px;
	height:250px;
	display:block;
	position:absolute;
	//background-color:red;
	float:left;
	left:50%;
	margin-left:-125px;
	background-image:url(../logo/park.png);
	background-repeat:no-repeat;
	background-size:100% auto;
	text-align:center;
	font-size:15px;
}
</style>
</head>

<body>
<br />
<div class="container">
<div id="heade"></div>
<div id="tab">
<div align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:24px">Selamat Datang Di System Parkir</div>
<form id="form1" name="form1" method="get" action="hitung_biaya.php">
  <label for="nopol"></label>
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="50" colspan="2" align="center"><h3>Pembayaran Parkir</h3></td>
      </tr>
    <tr>
      <td width="400"><input type="text" name="nopol" id="nopol" class="input-lg form-control" placeholder="Masukan Nopol (ex: R 45 D)" /></td>
      <td width="45" align="center"><input type="submit" name="button" id="button" value="Go" class="input-lg btn btn-primary" /></td>
    </tr>
  </table>
  <input name="id_user" type="hidden" value="<?php echo $_SESSION['id_user'];?>" />
</form>
</div>
<div id="aidi">
<br />
  <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table">
    <tr>
      <td><div align="center"><button class="btn btn-default" data-toggle="modal" data-target="#petunjuk"><span class="network-name">Petunjuk Parkir</span></button></div></td>
      <td><a href="input_awal.php" class="btn btn-default">Daftar Parkir</a></td>
    </tr>
  </table>
</div>
</div>
<div class="modal fade" id="petunjuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Petunjuk Parkir</h4>
      </div>
      <div class="modal-body">
        Masukan Nomor Kendaraan maka secara otamatis akan tercetak struk. Setelah selesai ketras diberikan kepada petugas parkir. Kartu Parkir Jangan Sampai Hilang. Jika hilang maka tunjukan STNK Terimakasih.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>