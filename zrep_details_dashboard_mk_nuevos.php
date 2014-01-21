<?php

define('INCLUDE_CHECK',true);
require '../connect.php';

//echo "hola suscriptores";

$paquete=$_GET['paquete'];

///hola hola holaaaaaa

$_fecha=$_GET['fecha'];

$query="Select distinct paquete, fecha  from SUS_Dashboard where paquete='$_obten_paquete' and fecha='$_fecha'";

$result=mysql_query($query)or die (mysql_error());



//HOLA DATA

function cargaData_renovacion($fecha){
	
	if($_GET['paquete']=='PAQUETE PREMIUM'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
			from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
			where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and p.productCode='SUSC-408' and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		
		$result=mysql_query($query)or die (mysql_error());

	}
	elseif($_GET['paquete']=='Paquete Semana Econ�mica'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
				where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and p.productCode='SUSC-404' and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		
		$result=mysql_query($query)or die (mysql_error());

	}
	
	elseif($_GET['paquete']=='Anal�tica'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
				where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and p.productCode='SUSC-420' and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		$result=mysql_query($query)or die (mysql_error());
	
	}
	
	elseif($_GET['paquete']=='Integral'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
				where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and (p.productCode ='SUSC-405' or p.productCode ='SUSC-411') and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		$result=mysql_query($query)or die (mysql_error());
	
	}
	
	elseif($_GET['paquete']=='Online'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
				where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and p.productCode ='SUSC-403' and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		$result=mysql_query($query)or die (mysql_error());
	
	}
	
	elseif($_GET['paquete']=='PAQUETE SE'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid
				where o.tipo like '%Nueva Susc%' and o.status!='Anulada' and p.productCode ='SUSC-407' and date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."'";
		
		$result=mysql_query($query)or die (mysql_error());
	
		
		
	}
	
	elseif($_GET['paquete']=='Per� Econ�mico'){
		
		$query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),
				date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
				from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid 
				where date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."' and o.tipo like '%Nueva Susc%' and o.status!='Anulada' and (p.productCode ='SUSC-300'
				or p.productCode ='SUSC-301')";
		
		$result=mysql_query($query)or die (mysql_error());
	
	}
	
	elseif($_GET['paquete']=='Se + Online'){
		
	
 $query="select o.numerodeordeninterno,o.accountname,o.contactname,date_format(o.fechadeiniciodesuscripcion,'%Y %M'),date_format(o.fechadefindesuscripcion, '%m-%d-%Y'),o.tipo,p.productCode
		from zoho_salesorder o join zoho_salesdetail d on o.salesorderid=d.salesorderid join zoho_product p on p.productid=d.productid where 
		date_format(o.fechadeiniciodesuscripcion,'%Y %M')='".$fecha."' 
		and o.tipo like '%Nueva Susc%' and o.status!='Anulada' and (p.productCode ='SUSC-404' or p.productCode ='SUSC-400')";
		
		
		$result=mysql_query($query)or die (mysql_error());
	
		
		
	}
	
	
	while($row=mysql_fetch_array($result)){
				
			
			echo"
			 
             <tr class=''>                        	
             <td  style=' text-align: center;text-transform:capitalize;' id='body-table'>".$row[0]."</td>
			 	<td style='text-align: center;text-transform:capitalize;'  id='body-table'>".$row[6]."</td>
             <td style='text-transform:capitalize;font-size:9px'  id='body-table'>".$row[2]."</td>
             <td style='text-transform:capitalize;font-size:9px'  id='body-table'>".$row[1]."</td>
                            	
                            	<td style='text-align: center;text-transform:capitalize;'  id='body-table'>".$row[4]."</td>
                            	<td style='text-align: center;text-transform:capitalize;'  id='body-table'>".$row[5]."</td>
                           	
                 
                          </tr> 
                    	 
			";

			}	
		
		
}		
?>
<html>
<head>
<!--js table paginacion-->
<script src="../js/jquery.js" charset="utf-8" type="text/javascript"></script>
<script src="../js/bootstrap.js" charset="utf-8" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript"  charset="utf-8" language="javascript" src="../js/DT_bootstrap.js"></script>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" >
<link href="../css/DT_bootstrap.css" rel="stylesheet" type="text/css" >

<style type="text/css">

#body-table{
	
 font-family:verdana;
 color: #4a3e41;
 font-size: 9px;
}
	
</style>

	</head>
	<body>
	<table cellpadding='5' cellspacing='0' border='0' class='table-striped table-bordered' id='example'>
	<?php
		
	        echo "  <thead>
          	  	<tr class='encabezado'>
				<th style='text-align:center;text-transform:uppercase; font-size:8px' width='8%'>OV Interno</th>   
				<th style='text-align: center;text-transform:uppercase;font-size:8px' width='12%'>Codigo</th>     
                <th class='' style='text-align: center;text-transform:uppercase;font-size:8px' width='25%'>Contacto</th>
                    <th style='text-align: center;text-transform:uppercase;font-size:8px'>Cuenta</th>
                   
                            	<th style='text-align: center;text-transform:uppercase;font-size:8px'>Fin de Suscripcion</th>
                           		<th style='text-align: center;text-transform:uppercase;font-size:8px'>Tipo</th>
                           
                          </tr> 
                     </thead>
                    <tbody>";					
					
					//$cuenta='+ 1 S.A.C.';
					//$ruc='20525043844';				
 						
					cargaData_renovacion($_fecha);
						
						/*obtener como valor del argumentos de la funcion los dos parametros obtenidos por url del zoho crm como le hago???*/
  ?>
  </tbody> 
  </table>
	</body>
</html>


