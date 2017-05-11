<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';

if (count($_POST)>0)
{
require_once 'Mail.php';
require_once 'Mail/mime.php';
$send=false;
if (preg_match("#[а-яА-Я]#i",$_POST['fio_opros'])) {$send=true;}
if ($send)
{
$oprosnik=DB_DataObject::factory('oprosnik');
$oprosnik->description.="--------------Шнек ----------------------\n<br />";
$screw=DB_DataObject::factory('shneki');
$screw->get(intval($_POST['shnek_type']));
$oprosnik->description.="Тип шнека: ".$screw->name;
$oprosnik->description.="\n<br />";
if ($_POST['privod']==1) {$oprosnik->description.="Привод: Редуктор";}
if ($_POST['privod']==2) {$oprosnik->description.="Привод: Ременная передача";}
if ($_POST['privod']==3) {$oprosnik->description.="Привод: Муфта";}
if ($_POST['privod']==4) {$oprosnik->description.="Привод: Цепная передача";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="Длина шнека: ".$_POST['length']." мм";
$oprosnik->description.="\n<br />";
$oprosnik->description.="Производительность: ".$_POST['production']." м3/час";
$oprosnik->description.="\n<br />";
$oprosnik->description.="Угол наклона: ".$_POST['angel']." градусов";
$oprosnik->description.="\n<br />";
$oprosnik->description.="Диаметр: ".$_POST['diam'];
$oprosnik->description.="\n<br />";
if ($_POST['regim']==1) {$oprosnik->description.="Режим работы: Конвейер";}
if ($_POST['regim']==2) {$oprosnik->description.="Режим работы: Питатель";}
$oprosnik->description.="\n<br />";
if ($_POST['motor']==1) {$oprosnik->description.="Положение мотора: У входа";}
if ($_POST['motor']==2) {$oprosnik->description.="Положение мотора: У выхода";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="Примечание: ".$_POST['description'];
$oprosnik->description.="\n<br />";
$oprosnik->description.="\n<br />";
$oprosnik->description.="--------------Продукт ----------------------\n<br />";
$oprosnik->description.="Название продукта: ".$_POST['product'];
$oprosnik->description.="\n<br />";
$oprosnik->description.="Насыпная плотность: ".$_POST['plotnost'];
$oprosnik->description.=" т./м<sup>3</sup>\n<br />";
$oprosnik->description.="Температура: ".$_POST['temperature']."°";
$oprosnik->description.=" C\n<br />";
$oprosnik->description.="Размер частиц от: ".$_POST['sizefrom']." мм  до:".$_POST['sizeto']." мм.";
$oprosnik->description.="\n<br />";
if ($_POST['tekuchest']==1) {$oprosnik->description.="Текучесть: Свободная";}
if ($_POST['tekuchest']==2) {$oprosnik->description.="Текучесть: Средняя";}
if ($_POST['tekuchest']==3) {$oprosnik->description.="Текучесть: Медленная";}
$oprosnik->description.="\n<br />";
if ($_POST['abraziv']==1) {$oprosnik->description.="Абразивность: Умеренная";}
if ($_POST['abraziv']==2) {$oprosnik->description.="Абразивность: Средняя";}
if ($_POST['abraziv']==3) {$oprosnik->description.="Абразивность: Высокая";}
$oprosnik->description.="\n<br />";
$oprosnik->description.="\n<br />";
$oprosnik->description.="--------------Контактные данные ----------------------\n<br />";
$oprosnik->description.="ФИО: ".$_POST['fio_opros']."\n<br />Телефон: ".$_POST['tel']."\n<br />E-mail:<a href='mailto:".$_POST['email']."'>".$_POST['email']."</a>\n<br />";
$oprosnikid=$oprosnik->insert();
$subject="Оформлен запросный лист на сайте Shneks.ru";
$oprosnik->description="Оформлен опросный лист &#8470;$oprosnikid на сайте Shneks.ru\n<br />\n<br />".$oprosnik->description;
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

$postdata=array('fio'=>$_POST['fio_opros'],'telephone'=>$_POST['tel'],'company'=>'не указана','cityid'=>'0','typeid'=>'1','email'=>$_POST['email'],'request'=>str_replace("<br />","\n",$oprosnik->description));
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
<h1>Опросный лист </h1>
Опросный лист заполнен и отправлен оператору. <br /><br />
<strong>Важная информация!</strong><br /><br />
После анализа Вашей информации наш оператор свяжется с Вами для уточнения данных и подготовки предварительного коммерческого предложения<br /><br />";
echo "<h1>Спасибо, что Вы выбрали нашу компанию!</h1>";
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
if (!ret) alert('Не все поля формы опросного листа заполнены!');
return ret;
}
</script>";
echo "
<h1>Опросный лист</h1>
<form action='' name='oprosny_list' method='post' onsubmit='return checkForm()'>
<fieldset>
<legend>Шнек</legend>
<center><img src='/images/shnek.png' style='border:none' /></center><br />
<table cellpadding='0' cellspacing='0' width=100% ><tbody valign='top'><tbody valign='top'>
<tr><td class='partition'>Тип шнека:</td><td colspan='4'><select name='shnek_type'>";
$screw=DB_DataObject::factory('shneki');
$screw->orderBy('id');
$screw->find();
while ($screw->fetch())
{
$writestr='';
if ($screw->id==15) $writestr='selected';
echo "<option $writestr value='{$screw->id}'>{$screw->name}</option>";
}
echo "</select>&nbsp;&nbsp;&nbsp;<a href='#' class='partition' target=_blank onclick=this.href='/show.php?id='+this.parentNode.childNodes[0].value>Посмотреть</a></td></tr>";
echo "<tr><td class='partition'>Привод:</td><td><input type='radio' name='privod' value=1 checked=true >Прямой (редуктор)</td><td><input type='radio' name='privod' value=3>Предохранительная муфта</td><td><input type='radio' name='privod' value=2>Ременная передача</td><td style='width:100px'><input type='radio' name='privod' value=4 >Цепная передача</td></tr>
<tr><td class='partition'>Длина L:</td><td><input type='text' class='bord'name='length' size=8 /> мм.</td><td class='partition'>Производительность:</td><td colspan=2><input size=8 type='text' class='bord'name='production' /> м<sup>3</sup>/час</td></tr>
<tr><td class='partition' style='width:125px'>Угол наклона &alpha;:</td><td><input type='text' class='bord'name='angel' size=8 />°</td><td class='partition'>Диаметр T:</td><td colspan=2><input size=5 type='text' class='bord'name='diam' /> мм.</td</tr>
<tr><td class='partition' style='width:125px'>Режим работы:</td><td><input type='radio' name='regim' value=2 checked=true>&nbsp;Питатель</td><td><input type='radio' name='regim' value=1 >&nbsp;Конвейер</td></tr>
<tr><td class='partition' style='width:125px'>Позиция мотора:</td><td><input type='radio' name='motor' value=1 checked=true>&nbsp;У входа</td><td><input type='radio' name='motor' value=2>&nbsp;У выхода</td></tr>
<tr><td class='partition' style='width:125px'>Примечание:</td><td colspan=4><textarea name='description' rows=2></textarea></td></tr>
</tbody></table>
</fieldset>";
echo "<fieldset>
<legend>Материал</legend>
<table cellpadding='0' cellspacing='0' width=100% ><tbody valign='top'>
<tr><td class='partition'>Название продукта:</td><td><input type='text' class='bord'name='product' size=25 /></td><td class='partition'>Насыпная плотность</td><td><input type='text' class='bord'name='plotnost' size=5 />&nbsp;т./м<sup>3</sup></td></tr>
<tr><td class='partition'>Размер частиц:</td><td>от <input type='text' class='bord'name='sizefrom' size=5 /> мм. до <input type='text' class='bord'name='sizeto' size=5 /> мм.</td><td class='partition'>Температура:</td><td><input type='text' class='bord'name='temperature' size=5 />°</td></tr>
<tr><td class='partition'>Текучесть:</td><td colspan=2><input type='radio' name='tekuchest' value=1>Свободная <input type='radio' name='tekuchest' value=2>Средняя <input type='radio' name='tekuchest' value=3>Медленная</td></tr>
<tr><td class='partition'>Абразивность:</td><td colspan=2><input type='radio' name='abraziv' value=1>Умеренная <input type='radio' name='abraziv' value=2>Средняя <input type='radio' name='abraziv' value=3>Высокая</td></tr>
</tbody></table>
</fieldset>";
echo "<fieldset>
<legend>Информация о Вас</legend>
<table cellpadding='0' cellspacing='0' width=100% class='oprosny_list'><tbody valign='top'>
<tr><td class='partition'>Как Вас зовут? <span class='red'>*</span></td><td colspan=3><input type='text' class='bord' name='fio_opros' size=45 /></td></tr>
<tr><td class='partition'>Телефон: <span class='red'>*</span></td><td><input type='text' class='bord'name='tel' size=20 /></td><td class='partition'>E-mail:</td><td><input type='text' class='bord'name='email' size=20 /></td></tr>
</tbody></table>
</fieldset>";
echo "<span class='red'>*</span><span style='font-size:8pt'> Поля обязательные для заполнения</span>";
echo "<center><input type='image' src='/images/form.jpg' /></center></form>";
echo "</div>";
$template->data();}
$template->finish();
?>