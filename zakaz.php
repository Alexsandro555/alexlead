<?
if (isset($_POST['convert']))
{
$_POST['fio']=iconv("UTF-8","KOI8-R",$_POST['fio']);
$_POST['tel']=iconv("UTF-8","KOI8-R",$_POST['tel']);
$_POST['description']=iconv("UTF-8","KOI8-R",$_POST['description']);
unset($_POST['convert']);
}
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';
$template->data('content');
echo "<div class='content'>";
echo "<h1>Оформление заказа</h1>";
echo "<br /><strong>Вы успешно оформили заказ</strong><br /><br />";
echo "<span style='color:#f00;font-size:14pt'>&#8470; Вашего заказа - <strong>$zakazid</strong></span><br /><br />";
echo "<strong>Важная информация!</strong><br /><br />";
echo "В течение нескольких часов наш оператор свяжется с Вами для личного подтверждения заказа.<br /><br />";
echo "В случае уточнения параметров заказа Вы можете использовать &#8470; присовенный заказу - $zakazid<br /><br />";
echo "<h1>Спасибо, что Вы выбрали нашу компанию!</h1>";
echo "</div>";
$template->data();
$template->finish();
?>