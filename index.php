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
if (trim($_GET['alt_name'])=='')
{
echo '			<div class="right">
    <div id="amazingslider-1" style="display:block;position:relative;float:left">
        <ul class="amazingslider-slides" style="display:none;">
            <li><a href="/spirale.html"><img src="/images/spirals.jpg" alt="Спирали для шнеков " /></a></li>
            <li><a href="/recycling.html"><img src="/images/consep2.jpg" alt="Установка по переработке отходов бетона из автобетоносмесителей по супер цене!" /></a></li>
            <li><a href="/separator.html"><img src="/images/sepcom2.jpg" alt="Сепаратор по переработке отходов животноводческой деятельности. Специальное предложение!!! " /></a></li>
        </ul>
    </div>
				<div class="thumbs" style="width:304px">
					<div class="thumb">
						<a href="/show.php?id=24"><img src="/images/1.png"></a>
						<div class="description">Песок</div>
					</div>
					<div class="thumb">
						<a href="/shneki_cement.html"><img src="/images/2.png"></a>
						<div class="description">Цемент</div>
					</div>
					<div class="thumb">
						<a href="/gibkiy_shnek.html"><img src="/images/3.png"></a>
						<div class="description">Мука</div>
					</div>
					<div class="thumb">
						<a href="/shneki_zerno.html"><img src="/images/4.png"></a>
						<div class="description">Зерно</div>
					</div>
					<div class="thumb">
						<a href="/gibkiy_shnek.html"><img src="/images/5.png"></a>
						<div class="description">Пеллеты</div>
					</div>
					<div class="thumb">
						<a href="/gibkiy_shnek.html"><img src="/images/6.png"></a>
						<div class="description">ПВХ</div>
					</div>
					<div class="thumb">
						<a href="/show.php?id=15"><img src="/images/7.png"></a>
						<div class="description">Мин. порошок</div>
					</div>
					<div class="thumb">
						<a href="/gibkiy_shnek.html"><img src="/images/8.png"></a>
						<div class="description">Сахар</div>
					</div>
				</div>
			</div>';
}
echo '<div class="content">';
echo "<h1>{$main->name}</h1>";
if (trim($_GET['alt_name'])=='gibkiy_shnek')
{
require_once 'flexcalc.php';
}

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
$main->description=str_replace($matches[$i][0],"<img src='".$matches[$i][2]."' onclick=popUpImage('".str_replace("medium","",str_replace("small","",$matches[$i][2]))."',400,400,0,0) style='cursor:hand;cursor:pointer;float:$float' ".$matches[$i][3]." />",$main->description);
 }
 }
if (preg_match_all('#\[price=([0-9]*)\]#i',$main->description,$matches,PREG_SET_ORDER))
{
foreach ($matches as $key=>$value)
{
$crm_price=DB_DataObject::factory('crm_price');
$crm_price->get(intval($value[1]));
if ($crm_price->ourstock>=50) {$writestr='много';} else {$writestr=$crm_price->ourstock;}
if ($crm_price->ourstock==0) {$writestr='-';}
$main->description=str_replace($value[0],$writestr,$main->description);
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
echo "<h1>Оформить запрос </h1>";
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
echo "<center><table class='orderform' cellpadding='0' cellspacing='0'><tbody valign='top'>";
echo "<tr valign='middle'><td class='aright'>Как Вас зовут? (Ф.И.О): <span class='red'>*</span>&nbsp;</td><td><input name='fio' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Название Вашей компании: <span class='red'>*</span>&nbsp;</td><td><input name='company' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш контактный телефон: <span class='red'>*</span>&nbsp;</td><td><input type='text' name='tel' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш электронный адрес (E-mail):</td><td><input name='email' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td >Примечание:</td></tr>";
echo "<tr><td colspan=2><textarea name='description' style='width:100%;height:100px'></textarea></td></tr>";
echo "<tr><td><span class='red'>* Поля обязательные для заполнения</span></td><td align='right'><input type='submit' name='zakazat' value='Оформить' class='noborder' border=0 /></td></tr>";
echo "</tbody></table></center>";
// echo "<script type='text/javascript'>document.zakaz_tovara.fio.focus();</script>";
echo "</form><br />";
}

echo '</div>';
$template->data();

$template->finish();

?>