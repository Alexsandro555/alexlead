<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';
$main=DB_DataObject::factory('main');
if (!isset($_GET['alt_name']))
{
$_GET['alt_name']='';
}
$main->whereAdd('alt_name="'.trim($_GET['alt_name']).'"');
$main->find(true);
$template->set('title',$main->title);
$template->data('content');
echo "<h1>{$main->name}<img src='/images/mini_logo.jpg' class='fright' /></h1>";
 if (preg_match_all('#<img([^>]*)src="([^>"]*)"([^>]*)>#i',$main->description,$matches,PREG_SET_ORDER))
 {
 for ($i=0;$i<count($matches);$i++)
 {
 $float='';
 if (preg_match("#float:? right#i",$matches[$i][1]))
 {
$float='right';
 }
if (preg_match("#float:? left#i",$matches[$i][1]))
 {
$float='left';
 }
$main->description=str_replace($matches[$i][0],"<img src='".$matches[$i][2]."' onclick=popUpImage('".str_replace("medium","",str_replace("small","",$matches[$i][2]))."',400,400,0,0) class='float$float' />",$main->description);
 }
 }

echo $main->description;
if (($main->alt_name!='contacts')&&($main->alt_name!='shneki_service'))
{
echo "&nbsp;<br />";
echo "<br />";
}
$links=DB_DataObject::factory('main_links_shneki');
$links->fromid=$main->id;
$num_links=$links->find();
if (($num_links>0)&&($main->id!=0))
{
echo "<table width='100%' cellpadding=0 cellspacing=0 ><tbody valign='top'>";
echo "<tr>";
$i=0;
while ($links->fetch())
{$i++;
echo "<td width=33%><center>";
$shneki=DB_DataObject::factory('shneki');
$shneki->get($links->toid);
echo "<a href='/show.php?id={$shneki->id}' class='partition'>{$shneki->name}</a><br />";
echo "<br />";
$images=DB_DataObject::factory('arsenal_photos');
$images->tabl='shneki';
$images->remoteid=$shneki->id;
$images->find(true);
echo "<a href='/show.php?id={$shneki->id}' title='{$images->description}' ><img src='{$shneki->arsenal_photos_path}{$images->miniphoto}' alt='{$images->description}' title='{$images->description}' /></a>";
echo "</center></td>";
if ($i%3==0) echo "</tr><tr>";
}
echo "</tr>";
echo "</tbody></table>";
}
if ($main->orderform==1)
{
if (($main->alt_name!='contacts')&&($main->alt_name!='shneki_service'))
{
echo "<br /><br />";
echo "<h1>Оформить запрос <img src='/images/mini_logo.jpg' class='fright' /></h1>";
}
echo "
<script type='text/javascript'>
function checkForm()
{
ret=true;
if (document.zakaz_tovara.fio.value=='') {ret=false;}
if (document.zakaz_tovara.company.value=='') {ret=false;}
if (document.zakaz_tovara.tel.value=='') {ret=false;}
if (!ret) alert('Не все поля формы заказа заполнены!');
return ret;
}
</script>";
echo "<form action='/zakaz.php' method='post' name='zakaz_tovara' onsubmit='return checkForm()'>";
echo "<input type='hidden' name='tabl' value='main'><input type='hidden' name='tablid' value='{$main->id}' />";
echo "<table class='orderform' cellpadding='0' cellspacing='0'><tbody valign='top'>";
echo "<tr valign='middle'><td class='aright'>Как Вас зовут? (Ф.И.О): <span class='red'>*</span>&nbsp;</td><td><input name='fio' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Название Вашей компании: <span class='red'>*</span>&nbsp;</td><td><input name='company' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш контактный телефон: <span class='red'>*</span>&nbsp;</td><td><input type='text' name='tel' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш электронный адрес (E-mail):</td><td><input name='email' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td >Примечание:</td></tr>";
echo "<tr><td colspan=2><textarea name='description' style='width:100%;height:100px'></textarea></td></tr>";
echo "<tr><td><span class='red'>* Поля обязательные для заполнения</span></td><td class='aright'><input type='image' name='zakazat' src='/images/form.jpg' class='noborder' border=0 /></td></tr>";
echo "</tbody></table>";
// echo "<script type='text/javascript'>document.zakaz_tovara.fio.focus();</script>";
echo "</form><br />";
}
$template->data();
$template->finish();
?>