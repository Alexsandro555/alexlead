<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';


$main=DB_DataObject::factory('shneki');
$main->get($_GET['id']);
$template->set('title','�����.��. - '.$main->title);
$template->data('content');

echo '<div class="content">';
echo "<h1>{$main->name}</h1>";
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
echo $main->description;
echo "<br />";
$sklad=DB_DataObject::factory('sklad');
$sklad->shnekid=$main->id;
$sklad->orderBy('sorting DESC');
$num_shneks=$sklad->find();
if ($num_shneks>0)
{
echo "<h1>����� �� ������</h1>";
echo "<table cellpadding=0 cellspacing=0 width=100% ><tbody valign='top'>";
echo "<tr>";
$i=0;
while ($sklad->fetch())
{
$filename='';
if (strlen($sklad->priceid)>0)
{
$totalnumber=0;
$idarray=explode(";",$sklad->priceid);
for ($j=0;$j<count($idarray);$j++)
{
$crm_price=DB_DataObject::factory('crm_price');
$crm_price->get($idarray[$j]);
$totalnumber+=$crm_price->stock+$crm_price->ourstock;
$files=DB_DataObject::factory('crm_price_files');
$files->priceid=$idarray[$j];
if ($files->find(true))
{
$filename=$files->filename;
}
}
if ($totalnumber>0)
{$i++;
echo "<td width=225 style='text-align:justify;padding:4px'><center>";
$shneki=$sklad->getLink('shnekid','shneki','id');
echo "<a href='/show.php?id={$shneki->id}' class='partition'>{$shneki->name}</a><br />";
echo "<br />";
echo "<span class='skladheader'>�����:</span> {$sklad->length} ��<br />";
$images=DB_DataObject::factory('arsenal_photos');
$images->tabl='shneki';
$images->remoteid=$shneki->id;
$images->find(true);
echo "<a href='/show.php?id={$shneki->id}' title='{$images->description}' ><img src='{$shneki->arsenal_photos_path}{$images->miniphoto}' alt='{$images->description}' title='{$images->description}' onclick=popUpImage(''{$shneki->arsenal_photos_path}{$images->photo}',400,400,0,0) /></a>";
echo "</center>";
echo "<span class='skladheader'>����������:</span> ".min(5,$totalnumber)."<br />";
echo "<span class='skladheader'>�������:</span> &#216;{$sklad->diametr} ��<br />";
//echo "<span class='skladheader'>�����:</span> {$sklad->length} ��<br />";
echo "<span class='skladheader'>���� �������:</span> {$sklad->degree}&#176;<br />";
echo "<span class='skladheader'>������������������:</span> ~{$sklad->power} �<sup>3</sup>/���<br />";
echo "<span class='skladheader'>��������:</span> ".strip_tags($sklad->description)."<br /><br />";
if (trim($filename)!='') echo "<center><a href='/files/$filename'>������</a> </center><br />";
echo "</td>";
}
}
if ($i%3==0) echo "</tr><tr>";
}
echo "</tr>";
echo "</tbody></table>";
}

echo "<h1>����� ������</h1>";
echo "
<script type='text/javascript'>
function checkForm()
{
ret=true;
if (document.zakaz_tovara.fio.value=='') {ret=false;}
if (document.zakaz_tovara.tel.value=='') {ret=false;}
if (!ret) alert('�� ��� ���� ����� ������ ���������!');
return ret;
}
</script>";
echo "<form action='/zakaz.php' method='post' name='zakaz_tovara' onsubmit='return checkForm()'>";
echo "<input type='hidden' name='tabl' value='shneki'><input type='hidden' name='tablid' value='{$main->id}' />";
echo "<center><table class='orderform' cellpadding='0' cellspacing='0'><tbody valign='top'>";
echo "<tr valign='middle'><td class='aright'>��� ��� �����? (�.�.�): <span class='red'>*</span>&nbsp;</td><td><input name='fio' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>��� ���������� �������: <span class='red'>*</span>&nbsp;</td><td><input type='text' name='tel' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>��� ����������� ����� (E-mail):</td><td><input name='email' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td >����������:</td></tr>";
echo "<tr><td colspan=2><textarea name='description' style='width:100%;height:100px'></textarea></td></tr>";
echo "<tr><td><span class='red'>* ���� ������������ ��� ����������</span></td><td class='aright'><input type='submit' name='zakazat' value='��������' class='noborder' border=0 /></td></tr>";
echo "</tbody></table>";
// echo "<script type='text/javascript'>document.zakaz_tovara.fio.focus();</script>";
echo "</form><br /></center>";
echo "</div>";
$template->data();
$template->finish();
?>