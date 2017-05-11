<?
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';

$main=DB_DataObject::factory('shneki');
$main->find();
while($main->fetch())
{
$main->description=str_replace("http://www.shneki.ru","",$main->description);
$main->update();
}
?>