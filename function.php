
<?php

define('INCLUDE_CHECK',true);

require($_SERVER['DOCUMENT_ROOT'] . '/connect/connect.php');

//$mes=$_POST['mes'];
//$año=$_POST['anio'];


//$profile = $_GET['profile'];
//if($profile=='suscripciones' or $profile=='manager'){

function totalesmes($mesfiltro){
	
$longitud=strlen($mesfiltro);
$anioextrae=substr($mesfiltro,0,5);
$mesextrae=substr($mesfiltro,5,$longitud);
$anioextrae=$anioextrae-1;
$fecha2=$anioextrae." ".$mesextrae;//obtiene el año y mes en dos variables diferentes,concatena la fecha
		
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
	//indicador_por_mes();
	
//	
		
	}
	
	totalesmes($mesfiltro);
	
	

	echo"</table><br>";	
	
	
	
	$cod_prod="select distinct (productcode) from zoho_product where productcode like '%SUSC-404%'";
	$result=mysql_query($cod_prod);
	while($row=mysql_fetch_array($result)){
		
		$cod=$row[0];
		
		product_renovacion($cod,$mesfiltro);
		
		
		}
	
}

function product_renovacion($codProd,$fecha){
	
	
$sql="select o.tipo, o.salesorderid,sd.productid,sd.productname,sd.productid,sd.productdescription,p.productcode, 
	  sum(o.tipo='Renovación') as renovacion from zoho_salesorder o join zoho_salesdetail sd on 
	  o.salesorderid=sd.salesorderid join zoho_product p on p.productid=sd.productid where p.productcode='".$codProd."' and date_format      (o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		  
		  $resulsusc404= mysql_query($sql);
		
		while($row=mysql_fetch_array($resulsusc404))
	{
		
		$nombre_paquete=$row[3];
		$nro_renovacion=$row[7];
		
		
		
	
		
		//ahora vamos a extraer la data del producto susc 404
	
echo "
<table>
	<tr>
		<td id=cabeceranegra align='center'>Indicadores</td>
		<td id=cabecerablanca></td>
		<td id=cabeceragris  align='center' colspan='2'>".$anio."</td>
		<td id=cabeceragris  align='center' colspan='2'>Productos Nuevos</td>
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
	</tr>
	<tr>
		<td id=cabeceranegra align='center'>Falta la fecha</td>
		<td style='font-size:9px;'>".$nombre_paquete."</td>
		<td id='data'align='center'>0</td>
		<td  id='data'align='center'>".$nro_renovacion."</td>
		<td id=cabeceranegra align='center'>".$codProd."</td>
		
		<td id=cabeceragris align='center'>".$fecha."</td>
		<td id=cabeceragris align='center'>Efectivo Renovadas</td>
		<td id=cabeceranegra align='center'>Efectivo Total</td>
	</tr>
	
	
	";
	
	echo"</table><br>";

}	

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

function indicador_por_mes($mes,$anio){

/*$anio1= $anio-1;
$anio2= $anio-2;*/
$extrae_mes=strlen($mes);
$fecha_solomes=substr($paquete, 5,$paquete2);
echo "
<table>
	<tr>
		<td id=cabeceranegra align='center'>Indicador por Mes</td>
		<td id=cabecerablanca></td>
		<td id=cabeceragris  align='center' colspan='2'>".$mes."</td>
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


//if($_POST['mes']){


	$mesfiltro= $anio. " ".$mes;

$query="select * from SUS_Dashboard where fecha like '%".$anio."%' and fecha like '%".$mes."%' order by fecha desc";

//$sql2="select * from SUS_Dashboard where fecha like '%".$_POST['mes']."%'";	

$result=mysql_query($query);
while ($row=mysql_fetch_array($result)){
	
	$paquete=$rowpaquete[0];
	//data($mesfiltro,$paquete);
	//indicador_por_mes();	
	$totalcantidad=$row[4]+$row[3];

echo"
	<tr>
		<td id=cabeceragris align='center'>".$row[1]."</td>
		<td id=data align='left'>".$row[2]."</td>
		<td id=data  align='center'>".$row[4]."</td>
		<td id=data  align='center'>".$row[3]."</td>
		<td id=cabeceragris  align='center'><a id=negro href=".$url.">".$totalcantidad."</a></td>
		<td id=data align='right'>". number_format($row[9],2)."</td>
		<td id=data align='right'>".number_format($row[8],2)."</td>
		<td id=cabeceragris align='right'>".number_format($row[10],2)."</td>
	</tr>
	";

	}
	totalesmes($mesfiltro);
	
echo"</table><br>";	

}


function indicador_por_paquete($paquete){

/*$anio1= $anio-1;
$anio2= $anio-2;*/
$extrae_mes=strlen($mes);
$fecha_solomes=substr($paquete, 5,$paquete2);
echo "
<table>
	<tr>
		<td id=cabeceranegra align='center'>Indicador por Paquete</td>
		<td id=cabecerablanca></td>
		<td id=cabeceragris  align='center' colspan='2'>".$paquete."</td>
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


//if($_POST['mes']){


	$mesfiltro= $anio. " ".$mes;

$query="select * from SUS_Dashboard where paquete='".$paquete."'";

//$sql2="select * from SUS_Dashboard where fecha like '%".$_POST['mes']."%'";	

$result=mysql_query($query);
while ($row=mysql_fetch_array($result)){
	
	$paquete=$rowpaquete[0];
	//data($mesfiltro,$paquete);
	//indicador_por_mes();	
	$totalcantidad=$row[4]+$row[3];

echo"
	<tr>
		<td id=cabeceragris align='center'>".$row[1]."</td>
		<td id=data align='left'>".$row[2]."</td>
		<td id=data  align='center'>".$row[4]."</td>
		<td id=data  align='center'>".$row[3]."</td>
		<td id=cabeceragris  align='center'><a id=negro href=".$url.">".$totalcantidad."</a></td>
		<td id=data align='right'>". number_format($row[9],2)."</td>
		<td id=data align='right'>".number_format($row[8],2)."</td>
		<td id=cabeceragris align='right'>".number_format($row[10],2)."</td>
	</tr>
	";

	}
	totalesmes($mesfiltro);
	
echo"</table><br>";	

}



/*dibuja la tabla con toda la data del paquete*/
function data($mesfiltro,$paquete){

//if($_POST['anio']){
$sql="select * from SUS_Dashboard where fecha like '%".$mesfiltro."%' and paquete='".$paquete."'";


$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)){

$_paquete=$row['paquete'];
$color1=colorsemaforo($row[6]);
$color2=colorsemaforo($row[7]);


$url="pruebaedicion.php?fecha=".urlencode($mesfiltro)."&paquete=".urlencode($paquete)."";
//echo $url."<br>";
$totalcantidad=$row[4]+$row[3];

echo"
	<tr>
		<td id=cabeceragris align='center'>".$row[1]."</td>
		<td id=data align='left'><a href='detalle_paquete.php?paquete=$_paquete&fecha=$row[1]' class='clsVentanaIFrame' rel='Detalla de Suscripcion por paquete' >".$row[2]."</a></td>
		<td id=data  align='center'>".$row[4]."</td>
		<td id=data  align='center'>".$row[3]."</td>
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
	if($paquete=='Analitica'){
		
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
	
	if($paquete=='Peru Economico'){
	
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
	
	
}


function tasaanualfinal($anio,$paquete,$tipotasa){ //muestra el ultimo cuadro

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
function dataanual($mesfiltro,$paquete){//calculo total por año por cada paquete y por tipo de orden(Nuevas, Renovadas)


$sql="
select id,fecha,paquete,sum(totalrenovados),sum(totalnuevos),sum(totales), sum(efectivorenovacion),sum(efectivonuevo),
efectivototal from SUS_Dashboard where fecha like '%".$mesfiltro."%' and paquete='".$paquete."' group by paquete";

/*

select 
id,
fecha,paquete,
sum(totalrenovados),
sum(totalnuevos),
sum(totales), 
sum(efectivorenovacion),
sum(efectivonuevo),
(select count(o.salesorderid)  from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid where year(o.fechadefindesuscripcion)='".$mesfiltro."' and (p.productCode ='SUSC-420' or p.productCode ='SUSC-405' or p.productCode ='SUSC-411' or p.productCode ='SUSC-404' or p.productCode ='SUSC-403' or p.productCode ='SUSC-300' or p.productCode ='SUSC-301') and o.status!='Anulada'),
efectivototal from SUS_Dashboard where fecha like '%".$mesfiltro."%' and paquete='".$paquete."' group by paquete


*/

$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)){

if($row[2]=='Integral' or $row[2]=='Se + Online' )
{
	 $totnuevas=$totnuevas+$row[4];
	 $totrenov=$totrenov+$row[3];
	 $totnuevasefe=$totnuevasefe+$row[4];
	 $totrenovefe=$totrenovefe+$row[3];
}


//visualiza % Tasa C y% TR del consolidado anual
//$Tnuevo=tasaanual($mesfiltro,$paquete,"totalnuevos");
$Tnuevo=tasaanual($mesfiltro,$paquete,"Crecimiento");
//$Trenovados=tasaanual($mesfiltro,$paquete,"totalrenovados");
$Trenovados=tasaanual($mesfiltro,$paquete,"totalrenovados");



$color1=colorsemaforo($Trenovados);
$color2=colorsemaforo($Tnuevo);


$url="pruebaedicion.php?fecha=".urlencode($mesfiltro)."&paquete=".urlencode($paquete)."";
//echo $url."<br>";

//muestra efectivo total del consolidado anual
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

	(select count(o.salesorderid)  from zoho_salesorder o join zoho_salesdetail d on d.salesorderid=o.salesorderid join zoho_product p on d.productid=p.productid where year(o.fechadefindesuscripcion)='".$mesfiltro."' and (p.productCode ='SUSC-420' or p.productCode ='SUSC-405' or p.productCode ='SUSC-411' or p.productCode ='SUSC-404' or p.productCode ='SUSC-403' or p.productCode ='SUSC-300' or p.productCode ='SUSC-301') and o.status!='Anulada'),
	
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

/*muestra el grafico estadistico*/
function datagrafico($anio,$mes)
{
	
	//$sql="select campaignname,suscrip_nuevo,suscrip_renovado from zoho_edicion where campaignname like '%SE%' and date_format(enddate,'%Y') like '%".$anio."%' order by campaignname";
	
$fecha=$anio." ".$mes;	
if($mes){

$sql="select campaignname,suscrip_nuevo,suscrip_renovado from zoho_edicion where campaignname like '%SE%' and date_format(enddate,'%Y %M') like '%".$fecha."%' order by campaignname";

}

elseif($anio){

	$sql="select campaignname,suscrip_nuevo,suscrip_renovado from zoho_edicion where campaignname like '%SE%' and date_format(enddate,'%Y') like '%".$anio."%' order by campaignname";
}

else
	
	$sql="select campaignname,suscrip_nuevo,suscrip_renovado from zoho_edicion where campaignname like '%SE%' and date_format(enddate,'%M') like '%".$mes."%' order by campaignname";

	$data= "['Detalle', 'Nuevos', 'Renovados'],";
	
	$result= mysql_query($sql);
	while ($row=mysql_fetch_array($result)){
		$data.="['".$row[0]."',   ".$row[1].",       ".$row[2]."],";
	}
	
	return $data;
}

?>




