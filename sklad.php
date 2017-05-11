<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';
$title='�����.��. ����� �� ������ �� ����: '.strftime("%d %B %Y");
$template->set('title',$title);
$template->data('content');

echo '<div class="content">';
$sklad=DB_DataObject::factory('sklad');
$sklad->orderBy('sorting DESC');
echo "<h1>����� �� ������ /".strftime("%B %d, %Y")."/</h1>";
echo "<p>�� ������ ������ � ������� �� ������ �� ������ ����� ��������� �����:</p><br />";
$num_shneks=$sklad->find();
if ($num_shneks>0)
{
echo "<table cellpadding=0 cellspacing=0 width=100% class='maincontent'><tbody valign='top'>";
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
echo "<a href='/show.php?id={$shneki->id}' title='{$images->description}' ><img src='{$shneki->arsenal_photos_path}{$images->miniphoto}' alt='{$images->description}' title='{$images->description}' /></a>";
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
echo "<td width=225 style='text-align:justify;padding:4px'><center><a href='/separator.html' class='partition'>�������� ��������� ��� ����������� ������</a><br /><span class='skladheader'>����������:</span> 1 <br /><a href='/separator.html' ><img src='/images/55_smallimage.jpg' /></a></center><br/>

<span class='skladheader'>������������������:</span> 65 �<sup>3</sup>/���<br />
<span class='skladheader'>��������:</span> 
�������� ��������� ��� �����������/���������� ������� �������������� - ������ ��� ������.
</center></td>";
echo "</tr>";
echo "</tbody></table>";
}
echo "<br />";
echo "<h1 id='zapros'>����� �������</h1>";
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
echo "<center><form action='/zakaz.php' method='post' name='zakaz_tovara' onsubmit='return checkForm()'>";
echo "<input type='hidden' name='tabl' value='main'><input type='hidden' name='tablid' value='1' />";
echo "<table class='orderform' cellpadding='0' cellspacing='0'><tbody valign='top'>";
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