<?php
define('INCLUDE_CHECK',true);
require 'connect.php';
//include('GoogChart.class.php');

$mes = $_GET['mes'];
$anio = $_GET['anio'];
$Gestado=$_GET['gestado'];
$estadoov= $_GET['estadoov'];
$id= $_GET['salesorderid'];
$fechaF=$_GET['fechaF'];
$fechaI=$_GET['fechaI'];
$filtro=$_GET['filtro'];

if($_GET['filtro']=='')
{
$filtro='a.accountname';	
}

if ($estadoov!='' and $id!='')
{
	UpdateEstado($estadoov,$id);
}
?>


<?php


function fechalimite($fecha){
	


	$texto= "select DATE_ADD('".$fecha."',INTERVAL -14 DAY)";
	$result=mysql_query($texto);
	while($row=mysql_fetch_array($result)){
	$fechafinal= $row[0];	
	}
	return $fechafinal;
	
	
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


function UpdateEstado($estado,$id){
$sql="update SUS_Renovacion set estado = '".$estado."' where Id='".$id."'";
//echo $sql;
mysql_query($sql);
}



Function cabeceratablaresumen($anio,$mes,$Gestado,$fechaI,$fechaF)
{
echo 	"<tr>
			
			<td id='fecha' width='1%' align ='center'>N&oacute;</td>
			
			<td id='fecha' width='5%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=r.estado'>Estado</a></td>
			
			<td id='fecha' width='5%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=o.numerodeordeninterno'>Ov Interno</a></td>
			
			<td id='fecha' width='25%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=a.accountname'>Empresa</a></td>
			
			<td id='fecha' width='5%' align ='center'><a id='filtro' href=''>RUC</a></td>
			
			<td id='fecha' width='7%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=o.fechadefindesuscripcion'>Fin de Suscripci&oacute;n</a></td>
			
						<td id='fecha' width='7%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=o.fechadefindesuscripcion'>Limite de Renovaci&oacute;n</a></td>
			
			<td id='fecha' width='15%' align ='center'><a id='filtro' href='repdetren.php?&mes=".$mes."&anio=".$anio."&gestado=&fechaF=".$fechaF."&fechaI=".$fechaI."&filtro=o.contactname'>Contacto</a></td>
			
			<td id='fecha' width='10%' align ='center'><a id='filtro' href=''>Titulo</a></td>
			<td id='fecha' width='25%' align ='center'><a id='filtro' href=''>Direcci&oacute;n Correspondencia</a></td>
			<td id='fecha' width='15%' align ='center'><a id='filtro' href=''>Saludo</a></td>
			<td id='fecha' width='15%' align ='center'><a id='filtro' href=''>Email</a></td>
			<td id='fecha' width='15%' align ='center'><a id='filtro' href=''>Email Asistente</a></td>
			<td id='fecha' width='25%' align ='center'><a id='filtro' href=''>Codigo de Envio</a></td>
			
		</tr>";
		


}



Function datatabla($anio,$mes,$Gestado,$fechaI,$fechaF,$filtro)

{
	
if($fechaF=='')
{
	
	$fechaF=$fechaI;
}

if($fechaI=='')
{
	
	$fechaI=$fechaF;
}


if ($Gestado!='' and $mes!=''){
$sql="select 
r.estado,
o.numerodeordeninterno,
a.accountname,
a.ruc,
date_format(o.fechadefindesuscripcion,'%Y-%m-%d') as FinSuscripcion,
o.contactname,
c.title,
o.shippingstreet,
o.shippingcode, 
c.salutation,
c.email,
c.correoelectronicodeasistente,
o.shippingcode,
r.Id,
r.salesorderid
from 
SUS_Renovacion r join zoho_salesorder o on r.salesorderid=o.salesorderid 
join zoho_salesdetail d on d.salesorderid=o.salesorderid left join zoho_contact c on o.contactid=c.contactid
 left join zoho_account a on o.accountid=a.accountid
 where r.estado='".$Gestado."' and  o.status !='Anulada'  
 and date_format(o.fechadefindesuscripcion,'%Y-%c') ='".$anio."-".$mes."' order by ".$filtro." ";
}

elseif ($Gestado=='' and $mes!='')
{

$sql="select 
r.estado,
o.numerodeordeninterno,
a.accountname,
a.ruc,
date_format(o.fechadefindesuscripcion,'%Y-%m-%d') as FinSuscripcion,
o.contactname,
c.title,
o.shippingstreet,
o.shippingcode,
c.salutation,
c.email,
c.correoelectronicodeasistente,
o.shippingcode,
r.Id,
o.salesorderid,
r.comentario
from 
SUS_Renovacion r join zoho_salesorder o on r.salesorderid=o.salesorderid 
join zoho_salesdetail d on d.salesorderid=o.salesorderid left join zoho_contact c on o.contactid=c.contactid
 left join zoho_account a on o.accountid=a.accountid where   o.status !='Anulada'  and
 date_format(o.fechadefindesuscripcion,'%Y-%c') ='".$anio."-".$mes."' order by ".$filtro." ";
}



elseif ($mes=='' and $fechaI!='' and $fechaF!=''){

$sql="select 
r.estado,
o.numerodeordeninterno,
a.accountname,
a.ruc,
date_format(o.fechadefindesuscripcion,'%Y-%m-%d') as FinSuscripcion,
o.contactname,
c.title,
o.shippingstreet,
o.shippingcode,
c.salutation,
c.email,
c.correoelectronicodeasistente,
o.shippingcode,
r.Id,
o.salesorderid,
r.comentario
from 
SUS_Renovacion r join zoho_salesorder o on r.salesorderid=o.salesorderid 
join zoho_salesdetail d on d.salesorderid=o.salesorderid left join zoho_contact c on o.contactid=c.contactid
 left join zoho_account a on o.accountid=a.accountid
 where o.fechadefindesuscripcion>= '".$fechaI."%' and  o.status !='Anulada' 
 and o.fechadefindesuscripcion<= '".$fechaF."%' order by ".$filtro."";
}
 


$i=1;
$result = mysql_query($sql) or die("Error en: $sql: " . mysql_error());
while ($row = mysql_fetch_array($result))
{
$selectedR='';
$selectedNR='';
$selectedP='';
$selectedC='';
$selectedEE='';

if($row[0]=='Renovado'){
	$color='#CCC621';
	$colorL='#CCC621';
	$selectedR='selected';
}

elseif($row[0]=='No Renovado'){
	$color='#E0242B';
	$colorL='#E0242B';
	$selectedNR='selected';
}

elseif($row[0]=='Pendiente'){
	$color='#ffffff';
	$colorL='#ACD7E8';
	$selectedP='selected';
}

elseif($row[0]=='Contactado'){
	$color='#148F29';
	$colorL='#148F29';
	$selectedC='selected';
}

elseif($row[0]=='En espera'){
	$color='#E65812';
	$colorL='#E65812';
	$selectedEE='selected';
}

if($row[15]!='')
{
	$coment="(*)";
	
}
else 
{

	if($row[15]==' ' )
	{
	$coment="";
	}
	else{
	$coment="";	
	}
	
}


echo "	<tr id='data' VALIGN='MIDDLE'>
			<td id='data'  align ='center'  bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$i."</td>
			<td id='data'  align ='center' bgcolor='".$color."'style='border:1px solid ".$colorL.";'>
			<form name ='form' action='repdetren.php' method='GET'>
			<input type=hidden name='salesorderid' value ='".$row[13]."'>
			<input type=hidden name='mes' value ='".$mes."'>
			<input type=hidden name='anio' value ='".$anio."'>
			<input type=hidden name='gestado' value ='".$Gestado."'>
			";
$Fechalimite=fechalimite($row[4]);


echo '			
			
			<select name="estadoov" onChange="this.form.submit();">
				<option value="Renovado" '.$selectedR.'>Renovado</option>
  				<option value="Pendiente" '.$selectedP.'>Pendiente</option>
  				<option value="Contactado" '.$selectedC.'>Contactado</option>
  				<option value="En espera" '.$selectedEE.'>En espera</option>
				<option value="No Renovado" '.$selectedNR.'>No Renovado</option>
			</select></td>
			</form>';
				
			echo"<td id='data'  align ='center' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>
			<a href='https://crm.zoho.com/crm/ShowEntityInfo.do?module=SalesOrders&id=".$row[14]."&isload=true' target='_blank'>".$row[1]." ".$coment."</a>
			</td>
			
			<td id='data'  align ='left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>
			<a href=\"javascript: window.open('zman_comentsren.php?salesorderid=".$row[14]."&color=".$colorL."', 'Apoyo Publicaciones',
			'width = 335, height = 260, toolbar=0,resizable=0, top=100px,left=0px ');\">".$row[2]."</a></td>
			 
			<td id='data'  align ='center' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[3]."</td>
			<td id='data'  align ='center' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[4]."</td>
			<td id='data'  align ='center' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$Fechalimite."</td>
			<td id='data'  align ='left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".strtoupper($row[5])."</td>
			<td id='data'  align ='left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".strtoupper($row[6])."</td>
			<td id='data'  align ='left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[7]."</td>
			<td id='data'  align ='Left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[9]."</td>
			<td id='data'  align ='Left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[10]."</td>
			<td id='data'  align ='Left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[11]."</td>
			<td id='data'  align ='Left' bgcolor='".$color."' style='border:1px solid ".$colorL.";'>".$row[8]."</td>
			
		</tr>";

		$i++;
		$selected=' ';


}
}
echo "<html>

<head>";

$nombremesactual=NombreMes($mes);
echo"
<title>".$nombremesactual." - Renovaciones </title>
";
?>

<script type="text/javascript" src= "login_panel/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src= "login_panel/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="login_panel/js/jquery.ui.datepicker-es.js"></script>
<link rel="stylesheet" type="text/css" href="login_panel/css/ui-lightness/jquery-ui-1.8.16.custom.css"></link>

<script type="text/javascript">
$(document).ready(function(){
  $(document).ready(function () {
    $('#micontenido').fadeIn(2200);
  });
});
</script>



<style type="text/css">
input, textarea {
	
	border:1px solid #000000;
	outline:0px;
	height:15px;
	margin-top:-2px;
	color:#000000;
	font-size:9px;
	
}

input#edita{
	border:1px solid #000000;
	outline:0px;
	height:15px;
	color:#000000;
	width:40px;
	font-size:9px;
}

tr
{
	font-family:calibri;
	height:5px;

}
th#cabecera{

	background-color: #BFBFBF;
	font-weight:normal;
	border:1px solid #000;
	color:#000;
    height: 20px;
	font-size:9px;

}

td#semana{
	font-size:.45em;
	font-weight:normal;
	border:1px solid #000000;
	color:#4f6b72;


}


td#semaforo{
	font-size:11px;
	font-weight:normal;
	border:1px solid #000000;
    color:#ffffff;
}

td#data{
	font-size:11px;
	font-weight:normal;
	color:#000;

}

td#data2{
	background-color: #C9C299;
	font-size:11px;
	font-weight:normal;
	border:1px solid #C1DAD7;
	color:#4f6b72;

}

td#fecha{
	background-color:#272727;
	font-size:11px;
	font-weight:bold;
	border:1px solid #000;
	color:#BFBFBF;
}

td#eficost{
	background-color:#2B9941;
	font-size:11px;
	font-weight:bold;
	border:1px solid #000;
	color:#BFBFBF;
}


td#noeficost{
	background-color:#F2D02C;
	font-size:11px;
	font-weight:bold;
	border:1px solid #000;
	color:#BFBFBF;
}


td#fechas{
	background-color:#660000;
	font-size:11px;
	font-weight:bold;
	border:1px solid #000;
	color:#ffffff;
}



tr#data:hover {
	background-color: #BFBFBF;
	color:#fff;
	}



a:link  {

color: #272727;
text-decoration: none;
}

a:active {
color: #272727;
text-decoration: none;
}



a#filtro:link  {

color: #fff;
text-decoration: none;
}

a#filtro:active {
color: #0A7FAD;
text-decoration: none;
}

a#filtro:visited {
color: #fff;
text-decoration: none;
}




data:hover {
background-color: #BFBFBF;
color:#fff;

}


td#dataB:hover {
background-color: #ffffff;
color:#fff;

}

input.hover{

	background-color:#272727;
}


label{
font-size:11px;
}
</style>

<script type="text/javascript">

$(document).ready(function(){
   $("#campofecha2").datepicker({
      showOn: 'both',
	  changeYear: true,
	  dateFormat: 'yy/mm/dd',
      numberOfMonths: 1,
      onSelect: function(textoFecha, objDatepicker){
         $("#mensaje").html("<p>Has seleccionado: " + textoFecha + "</p>");
      }
   });
})

$(document).ready(function(){
   $("#campofecha").datepicker({
      showOn: 'both',
	  changeYear: true,
	  dateFormat: 'yy/mm/dd',
      numberOfMonths: 1,
      onSelect: function(textoFecha, objDatepicker){
         $("#mensaje").html("<p>Has seleccionado: " + textoFecha + "</p>");
      }
   });
})


</script>

<script type="text/javascript">

function guardar(){

	document.form.submit();
	
}


</script>


<?php

echo"</head>

<body>
<br>
<div id='micontenido' style='display:none;'>
";

//echo $estadoov. " ".$id."<br>";
$nombremes=strtoupper(NombreMes($mes));



if ($Gestado!='' ){

echo"
<table width='100%' >
	<tr>
	<td align='left'><h2>RENOVACIONES ".$nombremes." - SEMANA ECON&Oacute;MICA 405</h2></td>
	</tr>
</table>
</form>"
;	

}
else
{
echo"
<form name ='form' action='repdetren.php' method='GET'>
<table width='100%' >
	<tr >
	<td><h2>RENOVACIONES ".$nombremes." - SEMANA ECON&Oacute;MICA 405</h2></td>
	<td><label>&nbsp;<b>FECHA INICIO:</b>&nbsp;&nbsp;</label></td>
	<td><input type= 'text' name='fechaI' value='".$fechaI."' id='campofecha2'></td>
	<td><label>&nbsp;<b>FECHA FIN:</b>&nbsp;&nbsp;</label></td>
	<td><input type= 'text' name='fechaF' value= '".$fechaF."' id='campofecha'></td>
	<td><input type='submit' value=' Filtrar' style='cursor:pointer' /></td>
	<td width ='10%' align='right'><a href='http://reporteszoho.apoyopublicaciones.com/ren_cartas_word.php?mes=".$mes."&anio=".$anio."&fechaI=".$fechaI."&fechaF=".$fechaF."'><img src='login_panel/images/cartasword.png' width='103px' height='33px' style='cursor:pointer'></a><br></td>
	<td width ='10%' align='right'><a href='http://reporteszoho.apoyopublicaciones.com/ren_cartas_word_logo.php?mes=".$mes."&anio=".$anio."&fechaI=".$fechaI."&fechaF=".$fechaF."'><img src='login_panel/images/cartas_logo.png' width='103px' height='33px' style='cursor:pointer'></a><br></td>
	<input type=hidden name='anio' value ='".$anio."'>
	<input type=hidden name='gestado' value ='".$Gestado."'>
	<td></td>
	</tr>
</table>
</form>"
;	
}



echo "<table align='center' width='200%'>";
cabeceratablaresumen($anio,$mes,$Gestado,$fechaI,$fechaF);
datatabla($anio,$mes,$Gestado,$fechaI,$fechaF,$filtro);	


echo "</table>

<br>
</div>
</body>
</html>";
?>