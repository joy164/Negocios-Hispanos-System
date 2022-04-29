<?php
    session_start();
    include '../modelo/conexion.php';

    $id_contrato = $_REQUEST['id_prestario'];

    $consulta = $conn->prepare("SELECT * FROM prestarios WHERE id_prestario = ?");
    $consulta->bind_param('s', $id_contrato);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $datosPrestario = $resultado->fetch_assoc();

    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $odometer = $_POST['odometer'];
    $VIN = $_POST['vin'];
    $transmision = $_POST['transmision'];
    $LicNo = $_POST['licencia'];
    $CoBorrower = $_POST['coBorrower'];
    $CoSigner = $_POST['coSigner'];
    $aceptar = $_POST['enviar'];

    if(isset($_POST['enviar'])){        
        $consulta = $conn->prepare("UPDATE vehicle SET year = ?, model = ?, odometer = ?, transmission = ?, make = ?, color = ?, VIN = ?, LicenseNo = ? WHERE id_auto = ?");

        if($consulta){
            $consulta->bind_param('isisssssi', $year, $model, $odometer, $transmision, $make, $color, $VIN, $LicNo, $datosPrestario['id_auto']);
            $consulta->execute();

            if( $consulta->affected_rows > 0){
                header('location: ../detalleVehicle?Actualizado=True&id_prestario='.$id_contrato);
            }else{
                header('location: ../detalleVehicle?Actualizado=False&id_prestario='.$id_contrato);
            }
        }else{
            header('location: ../detalleVehicle?Actualizado=False&id_prestario='.$id_contrato);
        }
        
    }
    
    $conn->close();
?>