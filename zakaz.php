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
echo "<h1>���������� ������</h1>";
echo "<br /><strong>�� ������� �������� �����</strong><br /><br />";
echo "<span style='color:#f00;font-size:14pt'>&#8470; ������ ������ - <strong>$zakazid</strong></span><br /><br />";
echo "<strong>������ ����������!</strong><br /><br />";
echo "� ������� ���������� ����� ��� �������� �������� � ���� ��� ������� ������������� ������.<br /><br />";
echo "� ������ ��������� ���������� ������ �� ������ ������������ &#8470; ����������� ������ - $zakazid<br /><br />";
echo "<h1>�������, ��� �� ������� ���� ��������!</h1>";
echo "</div>";
$template->data();
$template->finish();
?>