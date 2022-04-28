 <?php
    require_once'../modelo/conexion.php';
    session_start();
    if( !var_dump(empty($_POST['correoF'])) && !var_dump(empty($_POST['passF']))){    
        sleep(1);
        $conn->set_charset('utf8');

        $usuario = $conn->real_escape_string($_POST['correoF']);
        $pass = $conn->real_escape_string($_POST['passF']);

        $nueva_consulta = $conn->prepare("SELECT * FROM users WHERE correo = ? AND password = ?");

        if($nueva_consulta){
            
            $nueva_consulta->bind_param('ss', $usuario, $pass);
            $nueva_consulta->execute();
            $resultado = $nueva_consulta->get_result();

            if($resultado->num_rows == 1){
                $datos = $resultado->fetch_assoc();
                $_SESSION['name'] = $datos['name'];
                $_SESSION['correo'] = $datos['correo'];
                $_SESSION['id_user'] = $datos['id_user'];
                $_SESSION['id_rol'] = $datos['rol'];
                $conn->close();
                header('location: ../init');
                
            }else{
                $conn->close();
                header('location: ../?error=True');
            }
        }else{
            $conn->close();
            header('location: ../?error=True');
        }
    }
?>