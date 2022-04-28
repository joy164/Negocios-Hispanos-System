<?php
    date_default_timezone_set('America/Los_Angeles');
    session_start();
    include '../modelo/conexion.php';
    include 'correo.php';

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dir = $_POST["direccion"];
    $correo= $_POST["corr"];
    $pas = $_POST["pass"];

    if(!var_dump(empty($nombre))  && !var_dump(empty($apellido)) && !var_dump(empty($dir)) && !var_dump(empty($correo)) && !var_dump(empty($pas)) ){
        $conn->set_charset('utf8');
        $consulta = $conn->prepare("INSERT INTO users(name, lastName, address, correo, password, rol) VALUES (?,?,?,?,?,'1')");
    
        if($consulta){
            $consulta->bind_param('sssss', $nombre, $apellido, $dir, $correo, $pas);
            if($consulta->execute()){
                header('location: ../newAdmin?Reg=True');
                enviarNotificacion('new registered ADMINISTRATOR', 'Negocios Hispanos System has been registered a new ADMINISTRATOR by: '.$_SESSION['name']. " witth email: ".$_SESSION['correo']. ' at: '. date('l jS \of F Y h:i:s A') );
            }else{
                header('location: ../newAdmin?Reg=False');
            }
            
                
        }else{
            header('location: ../newAdmin?Reg=False');
        }
        $conn->close();
    }else{
        $conn->close();
        header('location: ../newAdmin?Reg=False');
    }
    
?>