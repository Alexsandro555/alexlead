<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';

if (count($_POST)>0)
{
require_once 'Mail.php';
require_once 'Mail/mime.php';
$send=false;
if (preg_match("#[�-��-�]#i",$_POST['fio_opros'])) {$send=true;}
if ($send)
{
$oprosnik=DB_DataObject::factory('oprosnik');
$oprosnik->description.="--------------���� ----------------------\n<br />";
$screw=DB_DataObject::factory('shneki');
$screw->get(intval($_POST['shnek_type']));
$oprosnik->description.="��� �����: ".$screw->name;
$oprosnik->description.="\n<br />";
if ($_POST['privod']==1) {$oprosnik->description.="������: ��������";}
if ($_POST['privod']==2) {$oprosnik->description.="������: �������� ��������";}
if ($_POST['privod']==3) {$oprosnik->description.="������: �����";}
if ($_POST['privod']==4) {$oprosnik->description.="������: ������ ��������";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="����� �����: ".$_POST['length']." ��";
$oprosnik->description.="\n<br />";
$oprosnik->description.="������������������: ".$_POST['production']." �3/���";
$oprosnik->description.="\n<br />";
$oprosnik->description.="���� �������: ".$_POST['angel']." ��������";
$oprosnik->description.="\n<br />";
$oprosnik->description.="�������: ".$_POST['diam'];
$oprosnik->description.="\n<br />";
if ($_POST['regim']==1) {$oprosnik->description.="����� ������: ��������";}
if ($_POST['regim']==2) {$oprosnik->description.="����� ������: ��������";}
$oprosnik->description.="\n<br />";
if ($_POST['motor']==1) {$oprosnik->description.="��������� ������: � �����";}
if ($_POST['motor']==2) {$oprosnik->description.="��������� ������: � ������";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="����������: ".$_POST['description'];
$oprosnik->description.="\n<br />";
$oprosnik->description.="\n<br />";
$oprosnik->description.="--------------������� ----------------------\n<br />";
$oprosnik->description.="�������� ��������: ".$_POST['product'];
$oprosnik->description.="\n<br />";
$oprosnik->description.="�������� ���������: ".$_POST['plotnost'];
$oprosnik->description.=" �./�<sup>3</sup>\n<br />";
$oprosnik->description.="�����������: ".$_POST['temperature']."�";
$oprosnik->description.=" C\n<br />";
$oprosnik->description.="������ ������ ��: ".$_POST['sizefrom']." ��  ��:".$_POST['sizeto']." ��.";
$oprosnik->description.="\n<br />";
if ($_POST['tekuchest']==1) {$oprosnik->description.="���������: ���������";}
if ($_POST['tekuchest']==2) {$oprosnik->description.="���������: �������";}
if ($_POST['tekuchest']==3) {$oprosnik->description.="���������: ���������";}
$oprosnik->description.="\n<br />";
if ($_POST['abraziv']==1) {$oprosnik->description.="������������: ���������";}
if ($_POST['abraziv']==2) {$oprosnik->description.="������������: �������";}
if ($_POST['abraziv']==3) {$oprosnik->description.="������������: �������";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="\n<br />";
$oprosnik->description.="--------------���������� ������ ----------------------\n<br />";
$oprosnik->description.="���: ".$_POST['fio_opros']."\n<br />�������: ".$_POST['tel']."\n<br />E-mail:<a href='mailto:".$_POST['email']."'>".$_POST['email']."</a>\n<br />";
$oprosnikid=$oprosnik->insert();
$subject="�������� ��������� ���� �� ����� Shneks.ru";
$oprosnik->description="�������� �������� ���� &#8470;$oprosnikid �� ����� Shneks.ru\n<br />\n<br />".$oprosnik->description;
$email='info@shneks.ru';
$arsenal_config_mail=parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/arsenal/configs/emailsend.ini');
$params['sendmail_path'] = $arsenal_config_mail['sendmail_path'];
$params["port"]=25;
$headers['From']    = $arsenal_config_mail['from'];
$headers['Reply-to']=$zakazemail->replyto;
$headers['Content-Type']="text/html; charset=koi8-r";
$headers['Content-Transfer-Encoding']="8bit";
$headers['To']      = $email;
$headers['Subject'] = '=?koi8-r?B?'.base64_encode($subject).'?=';
$mail_object =& Mail::factory('sendmail', $params);
$mail_object->send(array('To'=>$email), $headers, $oprosnik->description);

$postdata=array('fio'=>$_POST['fio_opros'],'telephone'=>$_POST['tel'],'company'=>'�� �������','cityid'=>'0','typeid'=>'1','email'=>$_POST['email'],'request'=>str_replace("<br />","\n",$oprosnik->description));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'http://www.oooleader.ru/crm/requestprocess.php');
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt ($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_USERAGENT,  "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION,0);
curl_setopt ($ch, CURLOPT_HEADER,0);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$store = curl_exec ($ch);
}
$template->data('content');
echo "<div class='content'>";
echo "
<h1>�������� ���� </h1>
�������� ���� �������� � ��������� ���������. <br /><br />
<strong>������ ����������!</strong><br /><br />
����� ������� ����� ���������� ��� �������� �������� � ���� ��� ��������� ������ � ���������� ���������������� ������������� �����������<br /><br />";
echo "<h1>�������, ��� �� ������� ���� ��������!</h1>";
echo "</div>";
$template->data();
} else {
$template->data('content');

echo '<div class="content">';
echo "
<script type='text/javascript'>
function checkForm()
{
ret=true;
if (document.oprosny_list.fio_opros.value=='') {ret=false;}
if (document.oprosny_list.tel.value=='') {ret=false;}
if (!ret) alert('�� ��� ���� ����� ��������� ����� ���������!');
return ret;
}
</script>";
echo "
<h1>�������� ����</h1>
<form action='' name='oprosny_list' method='post' onsubmit='return checkForm()'>
<fieldset>
<legend>����</legend>
<center><img src='/images/shnek.png' style='border:none' /></center><br />
<table cellpadding='0' cellspacing='0' width=100% ><tbody valign='top'><tbody valign='top'>
<tr><td class='partition'>��� �����:</td><td colspan='4'><select name='shnek_type'>";
$screw=DB_DataObject::factory('shneki');
$screw->orderBy('id');
$screw->find();
while ($screw->fetch())
{
$writestr='';
if ($screw->id==15) $writestr='selected';
echo "<option $writestr value='{$screw->id}'>{$screw->name}</option>";
}
echo "</select>&nbsp;&nbsp;&nbsp;<a href='#' class='partition' target=_blank onclick=this.href='/show.php?id='+this.parentNode.childNodes[0].value>����������</a></td></tr>";
echo "<tr><td class='partition'>������:</td><td><input type='radio' name='privod' value=1 checked=true >������ (��������)</td><td><input type='radio' name='privod' value=3>����������������� �����</td><td><input type='radio' name='privod' value=2>�������� ��������</td><td style='width:100px'><input type='radio' name='privod' value=4 >������ ��������</td></tr>
<tr><td class='partition'>����� L:</td><td><input type='text' class='bord'name='length' size=8 /> ��.</td><td class='partition'>������������������:</td><td colspan=2><input size=8 type='text' class='bord'name='production' /> �<sup>3</sup>/���</td></tr>
<tr><td class='partition' style='width:125px'>���� ������� &alpha;:</td><td><input type='text' class='bord'name='angel' size=8 />�</td><td class='partition'>������� T:</td><td colspan=2><input size=5 type='text' class='bord'name='diam' /> ��.</td</tr>
<tr><td class='partition' style='width:125px'>����� ������:</td><td><input type='radio' name='regim' value=2 checked=true>&nbsp;��������</td><td><input type='radio' name='regim' value=1 >&nbsp;��������</td></tr>
<tr><td class='partition' style='width:125px'>������� ������:</td><td><input type='radio' name='motor' value=1 checked=true>&nbsp;� �����</td><td><input type='radio' name='motor' value=2>&nbsp;� ������</td></tr>
<tr><td class='partition' style='width:125px'>����������:</td><td colspan=4><textarea name='description' rows=2></textarea></td></tr>
</tbody></table>
</fieldset>";
echo "<fieldset>
<legend>��������</legend>
<table cellpadding='0' cellspacing='0' width=100% ><tbody valign='top'>
<tr><td class='partition'>�������� ��������:</td><td><input type='text' class='bord'name='product' size=25 /></td><td class='partition'>�������� ���������</td><td><input type='text' class='bord'name='plotnost' size=5 />&nbsp;�./�<sup>3</sup></td></tr>
<tr><td class='partition'>������ ������:</td><td>�� <input type='text' class='bord'name='sizefrom' size=5 /> ��. �� <input type='text' class='bord'name='sizeto' size=5 /> ��.</td><td class='partition'>�����������:</td><td><input type='text' class='bord'name='temperature' size=5 />�</td></tr>
<tr><td class='partition'>���������:</td><td colspan=2><input type='radio' name='tekuchest' value=1>��������� <input type='radio' name='tekuchest' value=2>������� <input type='radio' name='tekuchest' value=3>���������</td></tr>
<tr><td class='partition'>������������:</td><td colspan=2><input type='radio' name='abraziv' value=1>��������� <input type='radio' name='abraziv' value=2>������� <input type='radio' name='abraziv' value=3>�������</td></tr>
</tbody></table>
</fieldset>";
echo "<fieldset>
<legend>���������� � ���</legend>
<table cellpadding='0' cellspacing='0' width=100% class='oprosny_list'><tbody valign='top'>
<tr><td class='partition'>��� ��� �����? <span class='red'>*</span></td><td colspan=3><input type='text' class='bord' name='fio_opros' size=45 /></td></tr>
<tr><td class='partition'>�������: <span class='red'>*</span></td><td><input type='text' class='bord'name='tel' size=20 /></td><td class='partition'>E-mail:</td><td><input type='text' class='bord'name='email' size=20 /></td></tr>
</tbody></table>
</fieldset>";
echo "<span class='red'>*</span><span style='font-size:8pt'> ���� ������������ ��� ����������</span>";
echo "<center><input type='image' src='/images/form.jpg' /></center></form>";
echo "</div>";
$template->data();}
$template->finish();
?>