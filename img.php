<?
$png=83+intval($_GET['typeid']);
  $img =@imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/images/'.$png.'_image.png');
  imagecolortransparent($img,ImageColorAt($img, 1, 1));
  imagealphablending($img, true);
imageSaveAlpha($img, true);
putenv('GDFONTPATH=' . '/usr/share/fonts/truetype/msttcorefonts/');
 /* if ($img)
  {
    // Назначаем цвет
    
    // Пишем текст поверх изображения
    if ($_GET['id']==1)
	{
	$box = imagettftext($img, 9, 0, 220, 280,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['a']));
	$box = imagettftext($img, 9, 0, 450, 150,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['b']));
	$box = imagettftext($img, 9, 0, 103, 254,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['c']));
	$box = imagettftext($img, 9, 60, 235, 144,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['d']));
	$box = imagettftext($img, 9, 0, 280, 166,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['e']."°"));
	}
	if ($_GET['id']==2)
	{
	$box = imagettftext($img, 9, 0, 220, 265,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['a']));
	$box = imagettftext($img, 9, 0, 410, 160,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['b']));
	$box = imagettftext($img, 9, 0, 167, 245,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['c']));
	$box = imagettftext($img, 9, 60, 300, 132,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['d']));
	$box = imagettftext($img, 9, 0, 345, 164,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['e']."°"));
	}
	if ($_GET['id']==3)
	{
	$box = imagettftext($img, 9, 0, 220, 185,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['a']));
	$box = imagettftext($img, 9, 0, 220, 125,
           $color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['c']));
	}
	*/
	// Выводим изображение в браузер
	$color = imagecolorallocatealpha($img, 255,255,255, 0);
	    if ($_GET['typeid']==1) {$box = imagettftext($img,12, 0, 350,445,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['w']));$box = imagettftext($img, 12, 90, 630,270,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['h']));}
	    	    if ($_GET['typeid']==2) {$box = imagettftext($img,12, 0, 270,465,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['w']));$box = imagettftext($img, 12, 90, 520,290,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['h']));}
	    	    if ($_GET['typeid']==3) {$box = imagettftext($img,12, 0, 350,270,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['w']));$box = imagettftext($img, 12, 90, 670,140,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['h']));}
	    	    if ($_GET['typeid']==4) {$box = imagettftext($img,12, 0, 370,195,$color, "verdana.ttf", iconv("koi8-r","UTF-8",$_GET['w']));}

        header('Content-Type: image/png');
        imagepng($img);

?>