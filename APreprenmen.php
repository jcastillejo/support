<?php

define('INCLUDE_CHECK',true);
require 'connect.php';
//include('GoogChart.class.php');
$anio = $_POST['anio'];

?>



<html>
<body>

<?php

Function Cantidades($estado,$mes,$anio)
{
$sql="
select count(r.salesorderid) from 
SUS_Renovacion r join zoho_salesorder o on r.salesorderid=o.salesorderid 
join zoho_salesdetail d on d.salesorderid=o.salesorderid 
where r.estado ='".$estado."' and o.status!='Anulada' and date_format(o.fechadefindesuscripcion,'%Y-%c') ='".$anio."-".$mes."'
";

//echo $sql."<br>";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
$total=$row[0];
}
return $total;
}



Function CantidadesTotales($estado,$anio)
{
$sql="
select count(r.salesorderid) from 
SUS_Renovacion r join zoho_salesorder o on r.salesorderid=o.salesorderid 
join zoho_salesdetail d on d.salesorderid=o.salesorderid where o.status!='Anulada' and
r.estado  like '".$estado."%' and date_format(o.fechadefindesuscripcion,'%Y') ='".$anio."'
";

//echo $sql."<br>";

$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
$total=$row[0];
}
return $total;
}




Function NombreMes($nmes)
{
switch ($nmes) {
    case 1:
        $texto=$anio." Enero";
		Return $texto;
        break;
    case 2:
        $texto="Febrero";
		Return $texto;
        break;
    case 3:
        $texto="Marzo";
		Return $texto;
        break;
	case 4:
        $texto="Abril";
		Return $texto;
        break;
	case 5:
        $texto="Mayo";
		Return $texto;
        break;
	case 6:
        $texto="Junio";
		Return $texto;
        break;
	case 7:
        $texto="Julio";
		Return $texto;
        break;
	case 8:
        $texto="Agosto";
		Return $texto;
        break;	
	case 9:
        $texto="Septiembre";
		Return $texto;
        break;	
	case 10:
        $texto="Octubre";
		Return $texto;
        break;
	case 11:
        $texto="Noviembre";
		Return $texto;
        break;		
	case 12:
        $texto="Diciembre";
		Return $texto;
        break;
	
	}
}

Function cabecera($anio){

for ($i = 1; $i <= 12; $i++) {


$mes=NombreMes($i);

$renovados=Cantidades('Renovado',$i,$anio);
if($renovados>0){
	$colorR='#CCC621';
}
else
{
	$colorR='#ffffff';
}

$norenovados=Cantidades('No Renovado',$i,$anio);
if($norenovados>0){
	$colorNR='#E0242B';
}
else
{
	$colorNR='#ffffff';
}
$pendientes=Cantidades('Pendiente',$i,$anio);
if($pendientes>0){
	$colorP='#ffffff';
}
else
{
	$colorP='#ffffff';
}
$contactados=Cantidades('Contactado',$i,$anio);
if($contactados>0){
	$colorC='#148F29';
}
else
{
	$colorC='#ffffff';
}

$enespera=Cantidades('En espera',$i,$anio);
if($enespera>0){
	$colorE='#E65812';
}
else
{
	$colorE='#ffffff';
}
$totales=$renovados+$norenovados+$pendientes+$contactados+$enespera;



echo "<tr>";
echo "	<th id= 'Cabecera' width= '10%' align= 'left'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">&nbsp;&nbsp;&nbsp;&nbsp;Ver&nbsp;".$mes."</a></th>
		
		<td id= 'data' width= '10%' align= 'center' bgcolor='".$colorR."'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=Renovado','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">".$renovados."</a></td>
		
		<td id= 'data' width= '10%' align= 'center' bgcolor='".$colorNR."'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=No Renovado','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">".$norenovados."</a></td>
		
		<td id= 'data' width= '10%' align= 'center' bgcolor='".$colorP."'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=Pendiente','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">".$pendientes."</a></td>
		
		<td id= 'data' width= '10%' align= 'center' bgcolor='".$colorC."'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=Contactado','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">".$contactados."</a></td>
		
		<td id= 'data' width= '10%' align= 'center' bgcolor='".$colorE."'><a id='linkcustom' href=\"javascript: window.open('repdetren.php?&mes=".$i."&anio=".$anio."&gestado=En espera','Renovación Semana Económica [405]', 'width = 1200, height =600 , toolbar=0,resizable=0, top=10px,left=60px ');\">".$enespera."</a></td>
		
		<th id= 'Cabecera' width= '10%' align= 'center'>".$totales."</th>";
echo "</tr>";

}

$Trenovados=CantidadesTotales('Renovado',$anio);
$Tnorenovados=CantidadesTotales('No Renovado',$anio);
$Tpendientes=CantidadesTotales('Pendiente',$anio);
$Tcontactados=CantidadesTotales('Contactado',$anio);
$Tenespera=CantidadesTotales('En espera',$anio);
$Ttotales=CantidadesTotales('',$anio);

echo "<tr>";
echo "	<td id= 'fecha' width= '10%' align= 'left'>&nbsp;&nbsp;&nbsp;&nbsp;Totales</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Trenovados."</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Tnorenovados."</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Tpendientes."</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Tcontactados."</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Tenespera."</td>
		<td id= 'fecha' width= '10%' align= 'center' >".$Ttotales."</td>";
echo "</tr>";
}

Function Data($estado)
{
$SQl="";

$result=mysql_query($SQl);
while ($row=mysql_fetch_array($result)){
	




}
}




//Cabecera
echo "<table  width= '100%'>";
echo "<tr>";
echo "	<td id= 'fecha' width= '10%' align= 'Left'>&nbsp;&nbsp;&nbsp;&nbsp;Fecha</td>
		<td id= 'fecha' width= '10%' align= 'center'>Renovado</td>
		<td id= 'fecha' width= '10%' align= 'center'>No Renovado</td>
		<td id= 'fecha' width= '10%' align= 'center'>Pendiente</td>
		<td id= 'fecha' width= '10%' align= 'center'>Contactado</td>
		<td id= 'fecha' width= '10%' align= 'center'>En espera</td>
		<td id= 'fecha' width= '10%' align= 'center'>Totales</td>";
		
echo "</tr>";
cabecera($anio);



echo "</table>";
echo "<br><br>";
?>
</body>
</html>
