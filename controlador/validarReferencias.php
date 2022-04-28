<?php
if( !var_dump(empty($_POST['correoF']))){
        require_once'../modelo/conexion.php';
        sleep(1);
        $conn->set_charset('utf8');

        $usuario = $conn->real_escape_string($_POST['correoF']);

        $nueva_consulta = $conn->prepare("SELECT * FROM prestarios WHERE id_prestario = ?");

        if($nueva_consulta){
            
            $nueva_consulta->bind_param('s', $usuario);
            $nueva_consulta->execute();
            $resultado = $nueva_consulta->get_result();

            if($resultado->num_rows == 1){
                header('location: ../regReferencias?id_contrato='.$usuario);
                
            }else{
                $conn->close();
                header('location: ../validar?error=True');
            }
        }else{
            $conn->close();
            header('location: ../validar?error=True');
        }
    }
    ?>