<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';
$template->set('title','ШНЕКИ.РУ Bellojet видео');
$template->data('content');
?>
<h1>Видео телескопического погрузчика<img src='/images/mini_logo.jpg' class='fright' /></h1>
<br />
<object id="player" style="margin-left:100px" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="400" height="315" name="player">
<param name="movie" value="/flv/player-viral.swf" />
<param name="allowfullscreen" value="true" />
<param name="allowscriptaccess" value="always" />
<param name="flashvars" value="file=/flv/Bellojet.flv&amp;image=/flv/preview.jpg" /> <embed id="player2" type="application/x-shockwave-flash" width="400" height="315" src="http://www.shneks.ru/flv/player-viral.swf" flashvars="file=/flv/Bellojet.flv&amp;image=/flv/preview.jpg" allowfullscreen="true" allowscriptaccess="always" name="player2"></embed>
</object>
<?
$template->data();
$template->finish();
?>