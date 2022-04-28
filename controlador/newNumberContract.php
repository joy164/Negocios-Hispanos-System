<?php
    //date_default_timezone_set('America/Los_Angeles');
    session_start();
    include '../modelo/conexion.php';
    include 'correo.php';

    $id = $_REQUEST['id_prestario'];
    $numContrato = $_POST['ContractNumber'];

    if(!var_dump(empty($numContrato)) ){
        $conn->set_charset('utf8');
        $consulta = $conn->prepare("UPDATE prestarios SET numContrato = ? WHERE id_prestario = ?");
    
        if($consulta){
            $consulta->bind_param('si', $numContrato, $id);
            if($consulta->execute()){
                header('location: ../regPrestamos?Actualizado=True');
                //enviarNotificacion('new registered ADMINISTRATOR', 'Negocios Hispanos System has been registered a new ADMINISTRATOR by: '.$_SESSION['name']. " witth email: ".$_SESSION['correo']. ' at: '. date('l jS \of F Y h:i:s A') );
            }else{
                header('location: ../regPrestamos?Actualizado=False');
            }
            
                
        }else{
            header('location: ../regPrestamos?Actualizado=False');
        }
        $conn->close();
    }else{
        $conn->close();
        header('location: ../regPrestamos?Actualizado=False');
    }
    
?>