<?php
define('INCLUDE_CHECK',true);
require 'connect.php';
$anio = $_POST['anio'];
if($_POST['anio']=='')
{
$anio = 2014;	
}

//$mes = 'January';
$profile = $_GET['profile'];
if($profile=='suscripciones' or $profile=='manager'){




function stylos(){
echo "
<style type='text/css'>


A:link {text-decoration:none;color:#000000;} 

A#negro {color:#000000;} 
 
 input, textarea, select {
	background-color:#848484;
	border:1px solid #000000;
	outline:0px;
	height:1.4em;
	margin-top:-2px;
	color:#ffffff;
	font-size:11px;
}


tr
{
	font-family:arial;
	height:18px;

}
td#cabeceranegra{

	background-color: #000000;
	font-weight:normal;
	border:1px solid #000000;
	color:#fff;
    height: 20px;
	font-size:9px;
	width:120px;

}



td#cabeceranegratasa{

	background-color: #000000;
	font-weight:normal;
	border:1px solid #000000;
	color:#fff;
    height: 20px;
	font-size:9px;
	width:60px;

}


td#cabeceragris{

	background-color: #A29694;
	font-weight:normal;
	border:1px solid #000000;
	color:#000;
    height: 20px;
	font-size:9px;
	width:110px;

}

td#cabeceraazul{

	background-color: #40AED3;
	font-weight:normal;
	border:1px solid #000000;
	color:#000;
    height: 20px;
	font-size:9px;

}

td#cabecerablanca{

	background-color: #ffffff;
	font-weight:normal;
	border:1px solid #ffffff;
	color:#ffffff;
    height: 20px;
	font-size:9px;
	width:120px;
}


td#cabeceraverdedata{

	background-color: #849D1F;
	font-weight:normal;
	border:1px solid #C1DAD7;
	color:#000000;
    height: 20px;
	font-size:9px;
	width:55px;

}


td#cabeceraazuldata{

	background-color: #40AED3;
	font-weight:normal;
	border:1px solid #C1DAD7;
	color:#000000;
    height: 20px;
	font-size:9px;
	width:55px;

}



td#cabecerablancadata{

	background-color: #ffffff;
	font-weight:normal;
	border:1px solid #C1DAD7;
	color:#000000;
    height: 20px;
	font-size:9px;
	width:55px;
}


td#semaforo{
	font-size:9px;
	font-weight:normal;
	border:1px solid #000000;
    color:#ffffff;
	width:60px;
}


td#data{
	font-size:9px;
	font-weight:normal;
	border:1px solid #C1DAD7;
	color:#4f6b72;
}


label{
font-size:11px;
}
</style>
";
	
	
}


function totalesmes($mesfiltro){
	
$longitud=strlen($mesfiltro);//retorna la longitud de la cadena
$anioextrae=substr($mesfiltro,0,5);//extrae la longitud especificada
$mesextrae=substr($mesfiltro,5,$longitud);
$anioextrae=$anioextrae-1;
$fecha2=$anioextrae." ".$mesextrae;
	
	
	$sqltotal="select sum(totalnuevos),sum(totalrenovados),sum(totales),sum(efectivonuevo),sum(efectivorenovacion),sum(efectivototal),
	(select sum(totalnuevos)from SUS_Dashboard where fecha like '%".$fecha2."%'),
	(select sum(totalrenovados)from SUS_Dashboard where fecha like '%".$fecha2."%')
	from SUS_Dashboard where fecha like '%".$mesfiltro."%'";
	
	
	//echo $sqltotal;
	$resulttotal=mysql_query($sqltotal);
	while ($rowtotal=mysql_fetch_array($resulttotal)){
	
	if ($rowtotal[6]!=0){
$totalnuevo=(($rowtotal[0]/$rowtotal[6])-1)*100;
}
	if ($rowtotal[6]==0){
$totalnuevo=1000;	
}
	

	if ($rowtotal[7]!=0){
$totalrenova=(($rowtotal[1]/$rowtotal[7])-1)*100;
}
	if ($rowtotal[7]==0){
$totalrenova=1000;	
}	
	
	
	$color1=colorsemaforo($totalrenova);
	$color2=colorsemaforo($totalnuevo);
			
echo "
	<tr>
		<td id=cabeceranegra align='center' colspan=2>Total</td>
		<td id=cabeceranegra align='center'>".$rowtotal[0]."</td>
		<td id=cabeceranegra align='center'>".$rowtotal[1]."</td>
		<td id=cabeceranegra align='center'>".$rowtotal[2]."</td>
		
		
		<td id=cabeceragris align='right'>".number_format($rowtotal[3],2)."</td>
		<td id=cabeceragris align='right'>".number_format($rowtotal[4],2)."</td>
		<td id=cabeceranegra align='right'>".number_format($rowtotal[5],2)."</td>
	</tr>
";
			
			
	}
	
	

	
}





function indicadores($anio,$mes)
{

$anio1= $anio-1;
$anio2= $anio-2;
echo "
<table>
	<tr>
		<td id=cabeceranegra align='center'>Indicadores</td>
		<td id=cabecerablanca></td>
		<td id=cabeceragris  align='center' colspan='2'>".$anio."</td>
		<td id=cabecerablanca></td>
		<td id=cabecerablanca></td>
	</tr>

	<tr>
		<td id=cabeceranegra align='center'>Fecha</td>
		<td id=cabeceranegra> Paquete</td>
		<td id=cabeceranegra align='center'>Total Nuevas</td>
		<td id=cabeceranegra align='center'>Total Renovadas</td>
		<td id=cabeceranegra align='center'>Totales</td>
		
		
		<td id=cabeceragris align='center'>Efectivo Nuevas</td>
		<td id=cabeceragris align='center'>Efectivo Renovadas</td>
		<td id=cabeceranegra align='center'>Efectivo Total</td>
		
	</tr>";

//ingresar data

	$mesfiltro= $anio. " ".$mes;
	$sqlpaquete="select distinct(paquete) from SUS_Dashboard where fecha like '%".$mesfiltro."%' order by paquete";
	$resulpaquete= mysql_query($sqlpaquete);
	while($rowpaquete=mysql_fetch_array($resulpaquete))
	{
	$paquete=$rowpaquete[0];
	data($mesfiltro,$paquete);
	}
	
	
	
	totalesmes($mesfiltro);
	
	

	echo"</table><br>";	
}

function colorsemaforo($tasa){
	if($tasa>=0){
		$color='#05A205';
	}
	if($tasa<0){
		$color='#870404';
	}
	if($tasa==1000){
		$color='#ffffff';
	}
	
	return $color;
}


function data($mesfiltro,$paquete){

$sql="select * from SUS_Dashboard where fecha like '%".$mesfiltro."%' and paquete='".$paquete."'";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)){

$color1=colorsemaforo($row[6]);
$color2=colorsemaforo($row[7]);
$_paquete=$row['paquete'];
$fecha=$row['fecha'];

$url="pruebaedicion.php?fecha=".urlencode($mesfiltro)."&paquete=".urlencode($paquete)."";
//echo $url."<br>";
$totalcantidad=$row[4]+$row[3];

echo"
	<tr>
		<td id=cabeceragris align='center'>".$row[1]."</td>
<td id=data align='left' style='text-transform:capitalize;'>".$row[2]."</td>
<td id=data  align='center'><a style='color:#4F6B72' class='clsVentanaIFrame' rel='".$_paquete."' href='dashboard_mkt/zrep_details_dashboard_mk_nuevos.php?fecha=".$fecha."&paquete=".urlencode($_paquete)."'>".$row[4]."</a></td>
<td id=data  align='center'><a style='color:#4F6B72' class='clsVentanaIFrame' rel='".$_paquete."' href='dashboard_mkt/zrep_details_dashboard_mkt.php?fecha=".$fecha."&paquete=".urlencode($_paquete)."'>".$row[3]."</a></td>
		<td id=cabeceragris  align='center'><a id=negro href=".$url.">".$totalcantidad."</a></td>
		
		
		<td id=data align='right'>". number_format($row[9],2)."</td>
		<td id=data align='right'>".number_format($row[8],2)."</td>
		<td id=cabeceragris align='right'>".number_format($row[10],2)."</td>
	</tr>
	";



}

}




function indicadoresanual($anio)
{

$anio1= $anio-1;
$anio2= $anio-2;
echo "
<table>
	<tr>
		<td id=cabeceranegra align='center'>Indicadores</td>
		<td id=cabecerablanca></td>
		<td id=cabecerablanca></td>
		<td id=cabecerablanca></td>
		<td id=cabecerablanca></td>
		<td id=cabeceragris  align='center' colspan=2>".$anio."</td>
		<td id=cabecerablanca></td>
	</tr>

	<tr>
		<td id=cabeceranegra align='center'>Fecha</td>
		<td id=cabeceranegra> Paquete</td>
		<td id=cabeceranegra align='center'>Total Nuevas</td>
		<td id=cabeceranegra align='center'>Total Renovadas</td>
		<td id=cabeceranegra align='center'>Totales</td>
		<td id=cabeceranegratasa  align='center'>% Tasa C</td>
		<td id=cabeceranegratasa  align='center'>% Tasa R</td>
		<td id=cabeceragris align='center'>Efectivo Nuevas</td>
		<td id=cabeceragris align='center'>Efectivo Renovadas</td>
		<td id=cabeceranegra align='center'>Efectivo Total</td>
	</tr>";

//ingresar data

	
	$sqlpaquete="select distinct(paquete) from SUS_Dashboard where fecha like '%".$anio."%' order by paquete";
	$resulpaquete= mysql_query($sqlpaquete);
	while($rowpaquete=mysql_fetch_array($resulpaquete))
	{
	$paquete=$rowpaquete[0];
	dataanual($anio,$paquete);	
	}
	
	totalesanual($anio);
	
	mixpaquetes($anio);

	echo"</table><br>";	
}




function filtrarpaquete($paquete)
{
	if($paquete=='Analítica'){
		
		$texto=" and p.productCode ='SUSC-420' ";
		return $texto;
	}

	if($paquete=='Integral'){
		
		$texto=" and (p.productCode ='SUSC-405' or p.productCode ='SUSC-411') ";
		return $texto;
	}
	
	if($paquete=='Online'){
	
		$texto=" and p.productCode ='SUSC-403' ";
		return $texto;
	}
	
	if($paquete=='Perú Económico'){
	
		$texto=" and (p.productCode ='SUSC-300' or p.productCode ='SUSC-301')";
		return $texto;
	}
	
	if($paquete=='Se + Online'){
	
		$texto=" and (p.productCode ='SUSC-404' or p.productCode ='SUSC-400') ";
		return $texto;
	}

	if($paquete=='Integral y Online'){
	
		$texto=" and (p.productCode ='SUSC-404' or p.productCode ='SUSC-400' or p.productCode ='SUSC-405' or p.productCode ='SUSC-411') ";
		return $texto;
	}
	
	/*AGREGADO*/
	
	if($paquete=='PAQUETE PREMIUM'){
	
		$texto=" and (p.productCode ='SUSC-408') ";
		return $texto;
	}
	
	if($paquete=='Paquete Semana Económica'){
	
		$texto=" and (p.productCode ='SUSC-404' or p.productCode ='SUSC-407') ";
		return $texto;
	}
	
}


function tasaanualfinal($anio,$paquete,$tipotasa){

$filtro=filtrarpaquete($paquete);
	
$fecha2=$anio-1;
	
If($tipotasa=='Crecimiento'){
	if ($paquete=='Integral y Online')
	{
		$paquete2= "Se + Online";
		$paquete2= 'Integral';
	}
	else 
	{
		$paquete2=$paquete;
	}

$sqltotal=
	"
select sum(totales) as anioactual, 
(select sum(totales)from SUS_Dashboard where fecha like '%".$anio."%' and (paquete='".$paquete."' or paquete ='".$paquete2."') ) as Anioanterior
from SUS_Dashboard where fecha like '%".$fecha2."%' and (paquete='".$paquete."' or paquete ='".$paquete2."')
	";



	//echo $sqltotal."<br>";
}	

else {
$sqltotal=
	"
select count(d.salesorderid) as 'TotalFinSusAnual',
(select count(o.salesorderid) from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid 
 where Year(o.fechadeiniciodesuscripcion)='".$anio."' ".$filtro." 
 and o.status!='Anulada' and (o.tipo like '%Renov%')) as 'TotalRenovadasAnual'
from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid 
 where year(o.fechadefindesuscripcion)='".$anio."'  ".$filtro." 
 and o.status!='Anulada'
	";
	
}
	

$resulttotal=mysql_query($sqltotal);
	while ($rowtotal=mysql_fetch_array($resulttotal)){
	
	if ($rowtotal[0]!=0){
$totalnuevo=($rowtotal[1]/$rowtotal[0])*100;
						}
	if ($rowtotal[0]==0){
$totalnuevo=1000;	
						}
	

return	$totalnuevo;
	
	
		
			
	}
	
	

	
}

function tasaanual($anio,$paquete,$tipotasa){

$filtro=filtrarpaquete($paquete);
	
$fecha2=$anio-1;
	
If($tipotasa=='Crecimiento'){

$sqltotal=
	"
select sum(totales) as anioactual, 
(select sum(totales)from SUS_Dashboard where fecha like '%".$anio."%' and paquete='".$paquete."' ) as Anioanterior
from SUS_Dashboard where fecha like '%".$fecha2."%' and paquete='".$paquete."'
	";


	//echo $sqltotal."<br>";
}	

else {
$sqltotal=
	"
select count(d.salesorderid) as 'TotalFinSusAnual',
(select count(o.salesorderid) from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid 
 where Year(o.fechadeiniciodesuscripcion)='".$anio."' ".$filtro." 
 and o.status!='Anulada' and (o.tipo like '%Renov%')) as 'TotalRenovadasAnual'
from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid 
 where year(o.fechadefindesuscripcion)='".$anio."'  ".$filtro." 
 and o.status!='Anulada'
	";
	
}
	

$resulttotal=mysql_query($sqltotal);
	while ($rowtotal=mysql_fetch_array($resulttotal)){
	
	if ($rowtotal[0]!=0){
$totalnuevo=($rowtotal[1]/$rowtotal[0])*100;
						}
	if ($rowtotal[0]==0){
$totalnuevo=1000;	
						}
	

return	$totalnuevo;
	
	
		
			
	}
	
	

	
}



function dataanual($mesfiltro,$paquete){


$sql="select 
id,
fecha,paquete,
sum(totalrenovados),
sum(totalnuevos),
sum(totales), 
sum(efectivorenovacion),
sum(efectivonuevo),
(select count(o.salesorderid)  from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid where year(o.fechadefindesuscripcion)='".$mesfiltro."' and (p.productCode ='SUSC-420' or p.productCode ='SUSC-405' or p.productCode ='SUSC-411' or p.productCode ='SUSC-404' or p.productCode ='SUSC-407' or p.productCode ='SUSC-403' or p.productCode ='SUSC-300' or p.productCode ='SUSC-301' or p.productCode ='SUSC-408') and o.status!='Anulada'),
efectivototal from SUS_Dashboard where fecha like '%".$mesfiltro."%' and paquete='".$paquete."' group by paquete";


$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)){



if($row[2]=='Integral' or $row[2]=='Se + Online' )
{
	 $totnuevas=$totnuevas+$row[4];
	 $totrenov=$totrenov+$row[3];
	 $totnuevasefe=$totnuevasefe+$row[4];
	 $totrenovefe=$totrenovefe+$row[3];
}




//$Tnuevo=tasaanual($mesfiltro,$paquete,"totalnuevos");
$Tnuevo=tasaanual($mesfiltro,$paquete,"Crecimiento");
//$Trenovados=tasaanual($mesfiltro,$paquete,"totalrenovados");
$Trenovados=tasaanual($mesfiltro,$paquete,"totalrenovados");



$color1=colorsemaforo($Trenovados);
$color2=colorsemaforo($Tnuevo);


$url="pruebaedicion.php?fecha=".urlencode($mesfiltro)."&paquete=".urlencode($paquete)."";
//echo $url."<br>";
$totalcantidad=$row[4]+$row[3];
$totalNewRen=$row[7]+$row[6];




echo"
	<tr>
		<td id=cabeceragris align='center'>".$mesfiltro."</td>
		<td id=data align='left'>".$row[2]."</td>
		<td id=data  align='center'>".$row[4]."</td>
		<td id=data  align='center'>".$row[3]."</td>
		<td id=cabeceragris  align='center'><a id=negro href=".$url.">".$totalcantidad."</a></td>
		<td id=semaforo  align='center' bgcolor='".$color2."'>".number_format($Tnuevo,0)."%</td>
		<td id=semaforo  align='center' bgcolor='".$color1."'>".number_format($Trenovados,0)."%</td>
		<td id=data align='right'>". number_format($row[7],2)."</td> 
		<td id=data align='right'>".number_format($row[6],2)."</td>
		<td id=cabeceragris align='right'>".number_format($totalNewRen,2)."</td>
	</tr>
	";



}

	
	// insertar linea acumulada Intagral y Se+Online
	
	
	
}

function mixpaquetes($anio)
{
$anioant=$anio-1;
$sql="select sum(totalrenovados),sum(totalnuevos),sum(totales),sum(efectivorenovacion),sum(efectivonuevo) from SUS_Dashboard where (paquete = 'Se + Online' or paquete = 'Integral') and fecha like '%".$anio."%'";

$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
$totalNR=	$row[3]+$row[4];


	$tasasnuevo==tasaanualfinal($anio,'Integral y Online',"Crecimiento");
	$tasarenova=tasaanualfinal($anio,'Integral y Online',"totalrenovados");
	
	
	$color1=colorsemaforo($tasasnuevo);
	$color2=colorsemaforo($tasarenova);





echo "
	<tr>
	<td colspan=2></td>
		<td ></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td id=cabeceranegra align='center' colspan=2>Integral con Se + Online</td>
		<td id=cabeceranegra align='center'>".$row[1]."</td>
		<td id=cabeceranegra align='center'>".$row[0]."</td>
		<td id=cabeceranegra align='center'>".$row[2]."</td>
		<td id=semaforo  align='center' bgcolor='".$color1."'>".number_format($tasasnuevo,2)."%</td>
		<td id=semaforo  align='center' bgcolor='".$color2."'>".number_format($tasarenova,2)."%</td>
		<td id=cabeceragris align='right'>".number_format($row[4],2)."</td>
		<td id=cabeceragris align='right'>".number_format($row[3],2)."</td>
		<td id=cabeceranegra align='right'>".number_format($totalNR,2)."</td>
	</tr>
	";

}


	
}


function totalesanual($mesfiltro){
	


$fecha2=$mesfiltro-1;
	
		$sqltotal="
	select sum(totalnuevos),
	sum(totalrenovados),
	sum(totales),
	sum(efectivonuevo),
	sum(efectivorenovacion),
	sum(efectivototal),

(select count(o.salesorderid)  from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid where year(o.fechadefindesuscripcion)='".$mesfiltro."' and (p.productCode ='SUSC-420' or p.productCode ='SUSC-405' or p.productCode ='SUSC-411' or p.productCode ='SUSC-404' or p.productCode ='SUSC-403' or p.productCode ='SUSC-300' or p.productCode ='SUSC-301' or p.productCode ='SUSC-408' or p.productCode ='SUSC-407') and o.status!='Anulada'),
	
	(select sum(totales)from SUS_Dashboard where fecha like '%".$fecha2."%')
	from SUS_Dashboard where fecha like '%".$mesfiltro."%'";
	
	
	

	
	//echo $sqltotal;
	$resulttotal=mysql_query($sqltotal);
	while ($rowtotal=mysql_fetch_array($resulttotal)){
	
	if ($rowtotal[7]!=0){
$totalnuevo=(($rowtotal[2]/$rowtotal[7])-1)*100;
}
	if ($rowtotal[7]==0){
$totalnuevo=1000;	

}
	
	if ($rowtotal[6]==0){
$totalrenova=1000;
}
	
	
	if ($rowtotal[6]!=0){
$totalrenova=(($rowtotal[1]/$rowtotal[6]))*100;
}

	
	$color1=colorsemaforo($totalrenova);
	$color2=colorsemaforo($totalnuevo);
	$totalNR=$rowtotal[3]+$rowtotal[4];
			
echo "
	<tr>
		<td id=cabeceranegra align='center' colspan=2>Total</td>
		<td id=cabeceranegra align='center'>".$rowtotal[0]."</td>
		<td id=cabeceranegra align='center'>".$rowtotal[1]."</td>
		<td id=cabeceranegra align='center'>".$rowtotal[2]."</td>
		<td id=semaforo  align='center' bgcolor='".$color2."'>".number_format($totalnuevo,2)."%</td>
		<td id=semaforo  align='center' bgcolor='".$color1."'>".number_format($totalrenova,2)."%</td>
		<td id=cabeceragris align='right'>".number_format($rowtotal[3],2)."</td>
		<td id=cabeceragris align='right'>".number_format($rowtotal[4],2)."</td>
		<td id=cabeceranegra align='right'>".number_format($totalNR,2)."</td>
	</tr>
";
			
			
	}
	
	

	
}



function datagrafico($anio)
{
	
	$sql="select campaignname,suscrip_nuevo,suscrip_renovado from zoho_edicion where campaignname like '%SE%' and date_format(enddate,'%Y') like '%".$anio."%' order by campaignname";
	
	$data= "['Detalle', 'Nuevos', 'Renovados'],";
	
	$result= mysql_query($sql);
	while ($row=mysql_fetch_array($result)){
		$data.="['".$row[0]."',   ".$row[1].",       ".$row[2]."],";
	}
	
	return $data;
}


//Dibujar el Dashboard
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="stylesheet" type="text/css" href="zdemo.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script src="login_panel/js/slide.js" type="text/javascript"></script>

	<!--[if lt IE 7]>
	<script type="text/javascript" src="js/jquery/jquery.js"></script>
	<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
	<![endif]-->

<!-- / END -->


<!-- menu -->

<link href="login_panel/css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="login_panel/css/dropdown/themes/adobe.com/default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="login_panel/css/ui-lightness/jquery-ui-1.8.16.custom.css"></link>
<script type="text/javascript" src= "login_panel/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src= "login_panel/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="login_panel/js/jquery.ui.datepicker-es.js"></script>

<link rel="stylesheet" type="text/css" href="css/ventanas-modales.css">
<script type="text/javascript" src="js/ext/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/ventanas-modales.js"></script>


<!-- API -->

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	
	
   <script type="text/javascript">	
	function get()
{
   document.form.submit()
}
	</script>
	
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
	
      function drawVisualization() {
        // Create and populate the data table.
              var data = google.visualization.arrayToDataTable([
			  
<?php
			  
			  
$datagrafico=datagrafico($anio);
echo $datagrafico;  
			  
?>
			  
			  
                
                
              ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                  pointSize:5,
				  legend:{position: 'in', textStyle: {color: 'black', fontSize: 16}},
                  chartArea:{left:20,top:30,width:"100%",height:"75%"},
                  fontSize:9,
                  width: 2500, height: 300,
                              vAxis: {maxValue: 10}}
                      );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  
  <body>
  
  
  <!--/ Panel Slide -->
  
<div id="toppanel" width="105%">
	<div id="panel">
		<div class="content clearfix">

            <div class="left">

            <h1>Zona Marketing</h1>

            <p>Acceder a reportes de usuario</p>

<?php
$sqlmenu="select descripcion,link from zoho_menu where profile='".$_GET['profile']."'";
//echo $sqlmenu;
$result=mysql_query($sqlmenu);
while ($rowm=mysql_fetch_array($result))
{
	echo '<a href="'.$rowm[1].'">'.$rowm[0].'</a>
            <br>';
}


?>			
			
			
			</div>
			
		</div>
		
	</div> <!-- /login -->

    <!-- Panel de arriba -->
	<div class="tab" bgcolor="#272727">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Hola <?php echo ' '.$profile; ?></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Abrir Panel</a>
				<a id="close" style="display: none;" class="close" href="#">Cerrar Panel</a>
			</li>
	    	<li class="right">&nbsp;</li>
		</ul>
	</div>
</div>


<!--/ Panel Slide -->





<br><br>
<form name ="form" action="" method="POST">
<table width="100%">
<tr>
<td width="2%"><label>&nbsp;<b>Año:</b>&nbsp;&nbsp;</label></td>
<td width="30%"><select name="anio" id="filtro" size="1" onchange="get();" style="height: 18px; width: 150px">
<option value =""></option>
<option value ="2014">2014</option>
<option value ="2013">2013</option>
<option value ="2012">2012</option>
<option value ="2011">2011</option>


</select>
</td>
<td width="30%"></td>
<td width="30%"></td>
<td width="20%"><img src="login_panel/images/excel.png" width="103px" height="33px" style="cursor:pointer" onclick="excel()"></td>
<td>
</td>
<td></td>
</tr>

</table>
</form>

<div id="visualization" style="OVERFLOW: auto; WIDTH: 1250px; TOP: 48px; HEIGHT: 350px"></div>

<?php
stylos();
echo"<br><br><br><br>";
indicadores($anio,"January");
indicadores($anio,"February");
indicadores($anio,"March");
indicadores($anio,"April");
indicadores($anio,"May");
indicadores($anio,"June");
indicadores($anio,"July");
indicadores($anio,"August");
indicadores($anio,"September");
indicadores($anio,"October");
indicadores($anio,"November");
indicadores($anio,"December");
echo "<p>Consolidado Anual</p><br><br>";
indicadoresanual($anio);
}
?>
</body>
</html>