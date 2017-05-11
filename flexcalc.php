<?
if (trim($_GET['alt_name'])!='gibkiy_shnek')
{
require_once $_SERVER['DOCUMENT_ROOT'].'/arsenal/support.php';
$template->set('title','ШНЕКИ.РУ. Расчет стоимости гибкого шнекового конвейера');
$template->data('content');

echo '<div class="content">';
echo "<h1>Калькулятор гибкого шнека</h1>";
}
class PriceOfScrew
{
public $spiraltype;
public $tubetype;
public $loadtype;
public $diameter;
public $typeofscrew;
public $height;
public $width;
public $radiusline;
public $unload45;
public $motor;
public $load;
public $unload;
public $tube;
public $spiral;
public $totalprice;
public $schit;
public $motoroutput;
public $homutsilovoy;
public $homutstyagnoy;
public $items=array();
function __construct($post)
{
$this->income=1.25;
$this->typeofscrew=intval($post['typeofscrew']);
$this->diameter=intval($post['sp']);
$this->spiraltype=intval($post['spiral']);
$this->tubetype=$post['tube'];
$this->loadtype=intval($post['inout']);
$this->height=floatval(str_replace(",",".",$post['height']));
$this->width=floatval(str_replace(",",".",$post['width']));
$this->schit=intval($post['schit']);
$this->motoroutput=intval($post['motoroutput']);
$this->calculateQuantity();
$this->calculatePrice();
}
function calculateQuantity()
{
if ($this->typeofscrew==1)
{
$this->radiusline=1;
$this->unload45=1;
}
if ($this->typeofscrew==2)
{
$this->unload45=1;
}
if ($this->typeofscrew==3)
{
$this->radiusline=2;
}
$this->tube=max(0,abs($this->width-$this->height)+min($this->width,$this->height)*1.41-$this->radiusline*1.083);
if ($this->typeofscrew==4)
{
$this->tube=$this->width;
}
$this->spiral=ceil($this->radiusline*1.533+$this->tube+1);
$this->load=1;
$this->unload=0;
$this->motor=intval($_POST['motor']);
$this->homutstyagnoy=0;
$this->homutsilovoy=0;
if ($this->load==1) {$this->homutstyagnoy++;}
if ($this->unload==1) {$this->homutstyagnoy++;}
if (($this->tubetype==1)||($this->tubetype==2)) {$this->homutstyagnoy+=round($this->tube/3);$this->homutstyagnoy+=$this->radiusline;}
if ($this->tubetype=='pvc') {$this->homutsilovoy+=ceil($this->tube/3);$this->homutsilovoy+=$this->radiusline;}
}
function calculatePrice()
{
$loadprice[1][75]=4415;
$loadprice[1][90]=4416;
$loadprice[1][125]=4503;
$loadprice[2][75]=5541;
$loadprice[2][90]=5542;
$loadprice[2][125]=5687;
if ($this->load==1) {$this->addItems($loadprice[$this->loadtype][$this->diameter],1,$this->getPrice($loadprice[$this->loadtype][$this->diameter]));}
/*
$unloadprice[1][75]=3346;
$unloadprice[1][90]=3515;
$unloadprice[1][125]=3315;
$unloadprice[2][75]=3115;
$unloadprice[2][90]=2920;
$unloadprice[2][125]=3755;
$unloadpriceopora[1][75]=2961;
$unloadpriceopora[1][90]=3092;
$unloadpriceopora[1][125]=3087;
$unloadpriceopora[2][75]=2978;
$unloadpriceopora[2][90]=2742;
$unloadpriceopora[2][125]=3378;
if (($this->unload==1)&&($this->unload45!=1)) {$this->addItems($unloadprice[$this->loadtype][$this->diameter],1,$this->getPrice($unloadprice[$this->loadtype][$this->diameter]));
$this->addItems($unloadpriceopora[$this->loadtype][$this->diameter],1,$this->getPrice($unloadpriceopora[$this->loadtype][$this->diameter]));
}
$unload45price[1][75]=2955;
$unload45price[1][90]=3307;
$unload45price[1][125]=3094;
$unload45price[2][75]=2976;
$unload45price[2][90]=3391;
$unload45price[2][125]=3376;
if ($this->unload45==1) {$this->addItems($unload45price[$this->loadtype][$this->diameter],1,$this->getPrice($unload45price[$this->loadtype][$this->diameter]));$this->addItems($unloadpriceopora[$this->loadtype][$this->diameter],1,$this->getPrice($unloadpriceopora[$this->loadtype][$this->diameter]));}
*/
$motorprice[75]=4306;
$motorprice[90]=4306;
if ($this->spiral>8) $motorprice[90]=2208;
$motorprice[125]=3287;
if ($this->motor==1) {$this->addItems($motorprice[$this->diameter],1,$this->getPrice($motorprice[$this->diameter]));}
$radiuslineprice[1][75]=3806;
$radiuslineprice[1][90]=2519;
$radiuslineprice[1][125]=2317;
$radiuslineprice[2][75]=2189;
$radiuslineprice[2][90]=2190;
$radiuslineprice[2][125]=3426;
$radiuslineprice['pvc'][75]=3961;
$radiuslineprice['pvc'][90]=3962;
$radiuslineprice['pvc'][125]=3963;
$radiuslineprice['pnd']=$radiuslineprice['pvc'];
if ($this->radiusline>0) {$this->addItems($radiuslineprice[$this->tubetype][$this->diameter],ceil($this->radiusline),$this->getPrice($radiuslineprice[$this->tubetype][$this->diameter]));}
$tubeprice[1][75]=2603;
$tubeprice[1][90]=1214;
$tubeprice[1][125]=2106;
$tubeprice[2][75]=2187;
$tubeprice[2][90]=2188;
$tubeprice[2][125]=3425;
$tubeprice['pvc'][75]=3956;
$tubeprice['pvc'][90]=3958;
$tubeprice['pvc'][125]=3959;
$tubeprice['pnd'][75]=2951;
$tubeprice['pnd'][90]=1215;
$tubeprice['pnd'][125]=2343;
if ($this->tubetype=='pvc') {
	$this->tube=ceil($this->tube/3);
}
if ($this->tube>0) {$this->addItems($tubeprice[$this->tubetype][$this->diameter],ceil($this->tube),$this->getPrice($tubeprice[$this->tubetype][$this->diameter]));}
$spiralprice[1]=2000;
$spiralprice[2]=3000;
$spiralepriceid[1][75]=949;
$spiralepriceid[1][90]=947;
$spiralepriceid[1][125]=2685;
$spiralepriceid[2][75]=950;
$spiralepriceid[2][90]=948;
$spiralepriceid[2][125]=2685;
if ($this->spiral>0)  {$this->addItems($spiralepriceid[$this->spiraltype][$this->diameter],$this->spiral,$this->getPrice($spiralepriceid[$this->spiraltype][$this->diameter]));}
$silovoyhomutid[75]=2957;
$silovoyhomutid[90]=3309;
$silovoyhomutid[125]=2388;
if ($this->homutsilovoy>0)  {$this->addItems($silovoyhomutid[$this->diameter],$this->homutsilovoy,$this->getPrice($silovoyhomutid[$this->diameter]));}
$motoroutput[1][75]=5424;
$motoroutput[1][90]=5094;
$motoroutput[1][125]=5837;
$motoroutput[2][75]=7010;
$motoroutput[2][90]=7011;
$motoroutput[2][125]=7012;
if ($this->motoroutput>0)  {$this->addItems($motoroutput[$this->spiraltype][$this->diameter],$this->motoroutput,$this->getPrice($motoroutput[$this->spiraltype][$this->diameter]));}


/*
$styagnoyhomutid[75][2]=2977;
$styagnoyhomutid[75][1]=2960;
$styagnoyhomutid[90][1]=3308;
$styagnoyhomutid[90][2]=2921;
$styagnoyhomutid[125][1]=2210;
$styagnoyhomutid[125][2]=3377;
if ($this->homutstyagnoy>0)  {$this->addItems($styagnoyhomutid[$this->diameter][$this->spiraltype],$this->homutstyagnoy,$this->getPrice($styagnoyhomutid[$this->diameter][$this->spiraltype]));}
*/
$schitprice=2111;
if ($this->schit==1) {$this->addItems($schitprice,1,$this->getPrice($schitprice));}
}
function addItems($id,$quant,$price)
{
$this->items[]=array($id,$quant,round($price,-1));
$this->totalprice+=$quant*round($price,-1);
}
function showTable()
{
echo "<table cellpadding=0 class='maincontent' cellspacing=0 width=100%><tbody valign=top>";
echo "<tr><td>Описание</td><td>Кол-во</td><td>Цена</td><td>Сумма</td></tr>";
for ($i=0;$i<count($this->items);$i++)
{
echo "<tr><td style='text-align:left'>";
$crm_price=DB_DataObject::factory('crm_price');
$crm_price->get($this->items[$i][0]);
echo ucfirst(strtolower($crm_price->description));
echo "</td><td>";
echo $this->items[$i][1];
echo "</td><td>";
echo $this->items[$i][2];
echo "</td><td>";
echo $this->items[$i][1]*$this->items[$i][2];
echo "</td></tr>";
}
echo "<tr><td colspan=1>Итого</td><td colspan=3 align=center>{$this->totalprice}</td></tr>";
echo "</tbody></table>";
}
function getPrice($id)
{
$crm_price=DB_DataObject::factory('crm_price');
$crm_price->get($id);
if (intval($crm_price->recommendedprice==0)) {return $crm_price->price*$this->income*1.18;} else {return $crm_price->recommendedprice;}
}
}

if (count($_POST)>0)
{
$priceofscrew=new PriceOfScrew($_POST);
echo "<center><img src='/img.php?typeid=".$_POST['typeofscrew']."&w={$priceofscrew->width}&h={$priceofscrew->height}'  style='border:none' /></center>";
$priceofscrew->showTable();


echo "<form action='/zakaz.php' method='post' name='zakaz_tovara' onsubmit='return checkForm()'>";
echo "<input type='hidden' name='tabl' value='main'><input type='hidden' name='tablid' value='{$main->id}' />";
echo "<input type='hidden' name='flexiblescrew' value='1' />";
echo "<table class='orderform' cellpadding='0' cellspacing='0'><tbody valign='top'>";
echo "<tr valign='middle'><td class='aright'>Как Вас зовут? (Ф.И.О): <span class='red'>*</span>&nbsp;</td><td><input name='fio' type='text' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш контактный телефон: <span class='red'>*</span>&nbsp;</td><td><input type='text' name='tel' size=40 value=''></td></tr>";
echo "<tr valign='middle'><td class='aright'>Ваш электронный адрес (E-mail):</td><td><input name='email' type='text' size=40 value=''></td></tr>";
echo "<tr><td><span class='red'>* Поля обязательные для заполнения</span></td><td class='aright'><input type='image' name='zakazat' src='/images/form.jpg' class='noborder' border=0 /></td></tr>";
echo "</tbody></table>";
$poststring='';
foreach ($_POST as $key=>$value)
{
$poststring.=$key." =>".$value.", ";	
}
for ($i=0;$i<count($priceofscrew->items);$i++)
{
$poststring.="~b_i=>".$priceofscrew->items[$i][0]."::".$priceofscrew->items[$i][1]."::".$priceofscrew->items[$i][2].",";
}
echo "<input type='hidden' name='description' value='$poststring' />";
echo "</form><br />";

} else {
echo "<form action='' method='post'>";
echo "<fieldset>";
echo "<legend>Типовая траектория</legend>";
$png=83;
echo "<table cellpadding=0 cellspacing=0 width=100% ><tbody valign='middle'>";
echo "<tr valign='middle'><td>";
echo "<center><img src='/images/".($png+1)."_smallimage.png' style='border:none' />";
echo "<br /><label><input type='radio' name='typeofscrew' checked value='1' /> Тип А</label></center>";
echo "</td><td>";
echo "<center><img src='/images/".($png+2)."_smallimage.png' style='border:none' />";
echo "<br /><label><input type='radio' name='typeofscrew' value='2' /> Тип B</label></center>";
echo "</td><td>";
echo "<center><img src='/images/".($png+3)."_smallimage.png' style='border:none' />";
echo "<br /><label><input type='radio' name='typeofscrew' value='3' /> Тип С</label></center>";
echo "</td><td>";
echo "<center><img src='/images/".($png+4)."_smallimage.png' style='border:none' />";
echo "<br /><label><input type='radio' name='typeofscrew' value='4'  /> Тип D</label></center>";
echo "</td></tr>";
echo "</tbody>";
echo "</table>";
echo "</fieldset>";
echo "<fieldset>";
echo "<legend>Шнек</legend>";
echo "<table cellpadding=0 cellspacing=0 width=100% class='oprosny_list'><tbody valign=middle>";
echo "<tr><td class='partition'>";
echo "Диаметр гибкого шнека:</td><td><label><input type='radio' name='sp' value='75' checked> 75мм</label><label><input type='radio' name='sp' value='90'  > 90мм</label><label><input type='radio' name='sp' value='125'> 125мм<label></td></tr>";
echo "<tr><td class='partition'>Спираль:</td><td><label><input type='radio' name='spiral' value='1' checked > Углеродистая сталь</label><label> <input type='radio' name='spiral' value='2'  > Нержавеющая сталь</label></td></tr>";
echo "<tr><td class='partition'>Труба:</td><td><label><input type='radio' name='tube' value='pvc' checked  > ПВХ</label><label><input type='radio' name='tube' value='1' > Углеродистая сталь</label><label><input type='radio' name='tube' value='2' > Нержавеющая сталь</label></td></tr>";
echo "<tr><td class='partition'>Загрузка/выгрузка:</td><td><label><input type='radio' name='inout' value='1' checked> Углеродистая сталь</label><label><input type='radio' name='inout' value='2'  > Нержавеющая сталь</label></td></tr>";
echo "<tr><td class='partition' colspan=2>По высоте (высота подъема,0 - если в горизонте):<input type='text' name='height' value='3.0' size=6 /> м. (не более 8.00м)</td></tr>";
echo "<tr><td class='partition' colspan=2>По длине (от центра загрузки до выгрузки):<input type='text' name='width' value='4.0' size=6 /> м. (не более 10.00м)</td></tr>";
echo "</tbody></table>";
echo "</fieldset>";
echo "<fieldset>";
echo "<legend>Комплектация</legend>";
echo "<table cellpadding=0 cellspacing=0 width=100% class='oprosny_list'><tbody valign=top>";
echo "<tr><td class='partition'>Шнек:</td><td>";
#echo "<label><input type='checkbox' name='load' value='1' checked > Загрузка </label><label><input type='checkbox' name='unload' value='1' checked > Выгрузка</label>";
echo "<input type='hidden' name='motor' value='1'  > <label><input type='checkbox' name='motoroutput' value='1'  > Мотор-редуктор на выходе</label><label><input type='checkbox' name='schit' value='1'  > Щит управления</label></td></tr>";
echo "<tr><td class='partition'>";
echo "Бункер:</td><td><input type='text' name='bunker' size=5 value='0'> литров. (0 - если бункер не требуется)</td></tr>";
echo "<tr><td class='partition'>";
echo "Растариватель:</td><td><label><input type='checkbox' name='meshok' value='1' /> Мешков</label><label><input type='checkbox' name='bigbag' value='1' /> Биг-бегов </label></td></tr>";
echo "</tbody></table>";
echo "</fieldset>";
echo "<center><input type='submit' value='Рассчитать' /></center>";
echo "</form>";
echo "<br />";
}
if (trim($_GET['alt_name'])!='gibkiy_shnek')
{
echo "</div>";
$template->data();
$template->finish();
}
?>