<?php
// PHP 4.1

error_reporting(E_ALL ^ E_NOTICE); 
$header = ""; 
$emailtext = "";
//$email = "info@antyca.es"; 
//$email = "alejandrozorita@consultaclicki.es"; 
$email = "acra@ono.com"; 
// Direccion de notificacion incidencias: https://ppmts-es.custhelp.com/app/account/overview

include "../configs/configuracion.inc.php";
include "../includes/ezsql/shared/ez_sql_core.php";
include "../includes/ezsql/mysql/ez_sql_mysql.php";
include("../includes/formhandler/class.dbFormHandler.php");
include "../includes/funciones.php";

$head = "MIME-Version: 1.0\r\n"; 
$head .= "Content-Type: text/html; charset=\"ISO-8859-1\""; 
$head .= "Content-Transfer-encoding: 8bit\r\n"; 
$head .= "From:Teledermic.com <info@teledemric.com>\r\n"; 
$head .= "X-Spam-Status: No, hits=0.5 required=8.0\r\n"; 
$head .= "Importance: High\r\n"; 
$head .= "X-Priority: 1 (Higuest)\r\n"; 
$head .= "X-MSMail-Priority: High\r\n"; 
$head .= "X-Mailer: Microsoft Office Outlook, Build 11.0.5510\r\n"; 
$head .= "X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441\r\n"; 

mail("alejandro.zorita@consultaclick.es", "Ejecutado Paypal", "Se ha ejecutado el fichero deo paypal. ", $head); 

// conexion BBDD mediante la clase ezmysql
$db = new ezSQL_mysql(MYSQL_USER,MYSQL_PASSWD,DATABASE,HOST);

$configuracion=$db->get_row("select * from config where id = 1");


// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}
// post back to PayPal system to validate

//Codigo actualizado el 22-7-13 por peticion de PayPal
$header="POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .="Content-Type: application/x-www-form-urlencoded\r\n";
$header .="Host: www.paypal.com\r\n"; 
$header .="Connection: close\r\n\r\n";

//Tras los cambios de paypal parece que esta linea se suprime segun el codigo que nos facilitaron por email
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";


$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
if (!$fp) {
// HTTP ERROR
} 
else {
    /*fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        $res = trim($res);*/

        //if (strcmp ($res, "VERIFIED") == 0) {
        if ($_POST['payer_status'] == "verified") {      

            // check the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process payment

            // obtenemos los datos necesarios para procesar el pedido segun la respuesta de tpv

            
            if ($payment_status == "Completed"){
                $datospedido = $db->get_row("select * from pedidos where codigopedido = $item_number");
                $datoscliente = $db->get_row("select * from clientes where userid = $datospedido->idcliente");
            
                // actualizamos pedido independientemente que 'tipo' sea cliente o profesional
                $db->query("update pedidos set estado = 'pagado',  metodopago = 'paypal' where codigopedido = $item_number");
                //$db->debug();  
                
                if ($datospedido->tipo == "profesional") {
                    //calculamos fecha de caducidad sumando a time liunux de fecha actual lo segundos guardados en configuracion para tiempocaducidadbonos      
                    $nuevafechacaducidadcreditos = date ("Y-m-d",time() + $configuracion->tiempocadicidadbonos);  
                  
                    $db->query("update clientes set creditos = creditos + $datospedido->creditoscomprados, caducidadcreditos = '$nuevafechacaducidadcreditos'  where userid = '$datospedido->idcliente'");    
                    //$db->debug();  
                }
                
                if ($datospedido->tipo == "particular") {
                    $db->query("update consultas set estado_pago = '1' where IdCrm = '$datospedido->idconsulta'");    
                    //$db->debug();  
                }       
                mail("alejandro.zorita@consultaclick.es", "Pago Teldermic PayPal", "Se ha realizado un pago mediante la plataforma PayPal en Teledermic. ".$emailtext, $head); 
                mail("sergio.ramos@consultaclick.es", "Pago Teldermic PayPal", "Se ha realizado un pago mediante la plataforma PayPal en Teledermic", $head);
                mail($email, "Pago Teldermic PayPal", "Se ha realizado un pago mediante la plataforma PayPal en Teledermic", $head);                                                         
            }

            foreach ($_POST as $key => $value){ 
                $emailtext .= $key . " = " .$value ."\n\n"; 
            }
                
            $emailtext .= $datospedido->tipo."\n\n";
             
            
            
        }
        else if ($_POST['payer_status'] == "invalid") {
            // log for manual investigation

            // If 'INVALID', send an email. TODO: Log for manual investigation. 
            foreach ($_POST as $key => $value){ 
                $emailtext .= $key . " = " .$value ."\n\n"; 
            } 
            //mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req, $head ); 
            mail("alejandro.zorita@consultaclick.es", "Pago Teldermic", "Fallo en el pago por paypal Teledermic", $head);

        }
    //}
    fclose ($fp);
}
?>