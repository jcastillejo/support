
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Informe de Contactos</title>
<link rel="shortcut icon" href="http://http://reporteszoho.semanaeconomica.com/sisContac/images/favicon.ico">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" >
<link href="css/DT_bootstrap.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/menu.css" />


<!--Ventana Modal-->
<link rel="stylesheet" type="text/css" href="css/ventanas-modales.css">
<script type="text/javascript" src="js/ext/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/ventanas-modales.js"></script>

<!--End Ventana Modal-->


<!--js table paginacion-->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>



<script type="text/javascript"> 
function confirmdelete()
{ 
 return confirm("Se eliminara el contacto");  
} 
</script> 

<!--Funcion muestra HORA-->

<script>
function startTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
document.getElementById('txt').innerHTML=h+":"+m+":"+s;
t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}
</script>

</head>

<body onload="startTime()">
<!--menu admin-->
<center> 
 </center>
 <!--Header-->
  <center>
<?php
//include ('includes/header.php');

?>
 </center>
 <!--End Header-->


     <div class="mainContainerUserReg1">
		
		<div style="margin-left:0%;margin-top:50px;width:200px;height:70px;border-width:0px;border-style:solid;border-color:#ff9900">
 	 				<a href="#"><img src="http://lib.semanaeconomica.com/google_login/images/se.png"/></a>
		</div> 
		
	 <div class="row-fluid">
        <div class="span12">
		   <div class="alert alert-success">
		   
		  
                        Contacto: <?php echo utf8_decode($_GET['nombres']).' '.utf8_decode($_GET['apellidos'] ); ?>
               <div id="mens">
                        	   	
               </div>
                    </div>
                    
                  
				    
				<h5>INFORME DE SUSCRIPCI&Oacute;N: <?php echo $empresa; ?></h5>
               
                 <?php
				 
				 
                      
                   require_once 'connect/db.class.php';
			
                         echo "<table width='100%' cellpadding='20px' cellspacing='10px' border='1' class='table-border' id='example'>
	                           <thead>
                               <tr class='encabezado'>                        	
                               <th class='span6' style='text-transform:capitalize;font-size:11px'>Contacto</th>
                               <th style='text-align: center;text-transform:capitalize;font-size:11px'><a style='color:#FFFFFF;text-decoration:none'title='Ver contacto'' href='#'><img src='images/company.png'>&nbsp;&nbsp Empresa</a></th>
                            	<th style='text-align: center;text-transform:capitalize;font-size:11px'>Producto</th>
                            	<th style='text-align: center;text-transform:capitalize;font-size:11px'>Codigo</th>
                            	<th style='text-align: center;text-transform:capitalize;font-size:11px'>OV Interno</th>
                            	<th style='text-align: center;text-transform:capitalize;font-size:11px'>Estado</th>
                           		<th style='text-align: center;text-transform:capitalize;font-size:11px'>Tipo Suscripcion</th>
                           <th style='text-align: center;text-transform:capitalize;font-size:11px' >Fecha Inicio</th>
                           	<th style='text-align: center;text-transform:capitalize;font-size:11px'>Fecha Fin</th>
                           <th style='text-align: center;text-transform:capitalize;font-size:11px'>Condicion</th>
                          
                          </tr> 
                    	 </thead>
                    	<tbody>					
					";
					//$cuenta='+ 1 S.A.C.';
					//$ruc='20525043844';				
 						
						cargaData();
						
						/*obtener como valor del argumentos de la funcion los dos parametros obtenidos por url del zoho crm como le hago???*/
				                		
                echo"
    </tbody>

                </table>
			";       
				  
					  
				
					                          
					//	 contactos();  

function fechaActual(){

$db = new mysqldb();//creo una instancia de la BD
$db->select_db_reportes();
	
$query2="SELECT CURDATE()";

$result_fecha=$db->query($query2);
												  
while($hora=mysql_fetch_array($result_fecha)){
$fechaSistema=$hora[0];									
}
return $fechaSistema;		
}

	
function cargaData(){

//global $empresa;
//global $ruc_empresa;
$contacto_nombres=utf8_decode($_GET['nombres']);
$contacto_apellidos=utf8_decode($_GET['apellidos']);
$dni=$_GET['dni'];
$cuenta=$_GET['cuenta'];	
//reporteszoho.semanaeconomica.com/suscrip/cuenta.php?	
	
$db = new mysqldb();//creo una instancia de la BD
$db->select_db_reportes();
				

						
$query ="select p.productcategory,p.productname,sd.salesorderid,c.firstname,c.lastname,c.contactid,so.accountname,c.dni,so.numerodeordeninterno,so.status,
		so.tipo,date_format(so.fechadeiniciodesuscripcion,'%Y-%m-%d'),date_format(so.fechadefindesuscripcion,'%Y-%m-%d'),p.productcode, ac.ruc
		from zoho_product p left join zoho_salesdetail sd on 
		p.productid=sd.productid left join zoho_salesorder so on 
		so.salesorderid=sd.salesorderid left join zoho_contact c on
		c.contactid=so.contactid  left join zoho_account ac on ac.accountid=so.accountid
		where p.productcategory like '%Suscripcion%' and so.tipo!='' 
		and c.firstname='".$contacto_nombres."' and c.lastname='".$contacto_apellidos."' order by so.fechadefindesuscripcion desc	             
        ";	
	
	$result_contact=$db->query($query);	
	
	while($row=mysql_fetch_array($result_contact)){
		
		$cuenta=$row[6];
		$ruc=$row[14];
		
		
		$nombres=utf8_decode($row[3]);
		$apellido=utf8_decode($row[4]);
		
/*dibulo los resultados en otra columna de la tabla*/		
		
$fechafin_suscripcion=$row[12];

echo "<tr>";
echo "<td id='' width='30%' style='font-size:9px;text-transform:capitalize'>".$nombres.' '.$apellido."</td>";
echo "<td id='' width='25%' style='font-size:9px;text-transform:uppercase'><a style='color:#000000;' href='cuentas.php?cuenta=$cuenta&ruc=$ruc' target='_blank' title='Ver cuenta''>".utf8_decode($row[6])."</a></td>";
echo "<td id='' width='20%'style='text-align: left;font-size:9px'>".$row[1]."</td>";
echo "<td id=''width='8%' style='text-align: center;color:#E16C26;font-size:9px'><b>".$row[13]."</b></td>";
echo "<td id=''style='text-align: center;font-size:9px'>".$row[8]."</td>";
echo "<td id=''style='text-align: center;font-size:9px'>".$row[9]."</td>";
echo "<td id=''style='text-align: center;font-size:9px'>".$row[10]."</td>";
echo "<td  width='10%' style='text-align: center;color:#001FEB;font-size:9px'>".$row[11]."</td>";
echo "<td width='14%' style='text-align: center;color:#D50A0A;font-size:9px'>".$row[12]."</td>";

$fechaSistema=fechaActual();

if($fechafin_suscripcion>$fechaSistema){
	$color='#347F2C';
								
echo "<td id='' bgcolor='#347F2C' style='color:#FFFFFF;font-weight:bold;text-align: center;' >Activo</td>";	
								}
if($fechafin_suscripcion<$fechaSistema){
								//$color='#D50A0A';
echo "<td id='' bgcolor='#D50A0A' style='color:#FFFFFF;font-weight:bold;text-align: center;' >No Activo</td>";
								
	}

							
if($fechafin_suscripcion>$fechaSistema && $estado_suscripcion=='Anulada'){
								//$color='#D50A0A';
echo "<td id='' bgcolor='#D50A0A' style='color:#FFFFFF;font-weight:bold;text-align: center;' >No Activo</td>";
								
	}

echo "</tr>";

	//	echo $fechafin_suscripcion;		
	}
	
}	  
   
$cargaData=cargaData;                       
                       
           echo $empresa;            
               
               ?>
        </div>
    </div>	
     </div>
   <center>
   <?php include("includes/footer.php"); ?>
  </center>

    <script type="text/javascript">
        $(document).ready( function() {

	
	
            $('.btn-danger').click( function() {
		
                var id = $(this).attr("id");
         
                if(confirm("Are you sure you want to delete this Member?")){
                    $.ajax({
                        type: "POST",
                        url: "delete_member.php",
                        data: ({id: id}),
                        cache: false,
                        success: function(html){
                            $(".del"+id).fadeOut('slow'); 
                        } 
                    }); 
                }else{
                    return false;}
            });				
        });
    </script>
</body>
</html>
