<?php
    date_default_timezone_set('America/Los_Angeles');
    session_start();
    include '../modelo/conexion.php';
    include 'correo.php';

    $conn->set_charset('utf8');

    //numero de contrato 
    $contrato = $conn->real_escape_string($_REQUEST['id_contrato']);
    //referencia 1 
    $name1 = $conn->real_escape_string($_POST['name1']);
    $rel1 = $conn->real_escape_string($_POST['rel1']);
    $dir1 = $conn->real_escape_string($_POST['dir1']);
    $city1 = $conn->real_escape_string($_POST['city1']);
    $state1 = $conn->real_escape_string($_POST['state1']);
    $zip1 = $conn->real_escape_string($_POST['zip1']);
    $homePh1 = $conn->real_escape_string($_POST['homePh1']);
    $cellPh1 = $conn->real_escape_string($_POST['cellPh1']);
    //referencia 2 
    $name2 = $conn->real_escape_string($_POST['name2']);
    $rel2 = $conn->real_escape_string($_POST['rel2']);
    $dir2 = $conn->real_escape_string($_POST['dir2']);
    $city2 = $conn->real_escape_string($_POST['city2']);
    $state2 = $conn->real_escape_string($_POST['state2']);
    $zip2 = $conn->real_escape_string($_POST['zip2']);
    $homePh2 = $conn->real_escape_string($_POST['homePh2']);
    $cellPh2 = $conn->real_escape_string($_POST['cellPh2']);
    //referencia 3 
    $name3 = $conn->real_escape_string($_POST['name3']);
    $rel3 = $conn->real_escape_string($_POST['rel3']);
    $dir3 = $conn->real_escape_string($_POST['dir3']);
    $city3 = $conn->real_escape_string($_POST['city3']);
    $state3 = $conn->real_escape_string($_POST['state3']);
    $zip3 = $conn->real_escape_string($_POST['zip3']);
    $homePh3 = $conn->real_escape_string($_POST['homePh3']);
    $cellPh3 = $conn->real_escape_string($_POST['cellPh3']);
    //referencia 4 
    $name4 = $conn->real_escape_string($_POST['name4']);
    $rel4 = $conn->real_escape_string($_POST['rel4']);
    $dir4 = $conn->real_escape_string($_POST['dir4']);
    $city4 = $conn->real_escape_string($_POST['city4']);
    $state4 = $conn->real_escape_string($_POST['state4']);
    $zip4 = $conn->real_escape_string($_POST['zip4']);
    $homePh4 = $conn->real_escape_string($_POST['homePh4']);
    $cellPh4 = $conn->real_escape_string($_POST['cellPh4']);
    //referencia 5
    $name5 = $conn->real_escape_string($_POST['name5']);
    $rel5 = $conn->real_escape_string($_POST['rel5']);
    $dir5 = $conn->real_escape_string($_POST['dir5']);
    $city5 = $conn->real_escape_string($_POST['city5']);
    $state5 = $conn->real_escape_string($_POST['state5']);
    $zip5 = $conn->real_escape_string($_POST['zip5']);
    $homePh5 = $conn->real_escape_string($_POST['homePh5']);
    $cellPh5 = $conn->real_escape_string($_POST['cellPh5']);

    if(isset($_POST['enviar'])){
        
        $consulta = $conn->prepare("INSERT INTO referencias(
            Nombre1, relacion1, direccion1, ciudad1, estado1, ZIP1, homePh1, cellPh1, 
            Nombre2, relacion2, direccion2, ciudad2, estado2, ZIP2, homePh2, cellPh2,
            Nombre3, relacion3, direccion3, ciudad3, estado3, ZIP3, homePh3, cellPh3,
            Nombre4, relacion4, direccion4, ciudad4, estado4, ZIP4, homePh4, cellPh4,
            Nombre5, relacion5, direccion5, ciudad5, estado5, ZIP5, homePh5, cellPh5 
        )VALUES(
            ?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?,
            ?,?,?,?,?,?,?,?
        )");
    
        if($consulta){
            $consulta->bind_param('ssssssssssssssssssssssssssssssssssssssss',
            $name1, $rel1, $dir1, $city1, $state1, $zip1, $homePh1, $cellPh1,                         
            $name2, $rel2, $dir2, $city2, $state2, $zip2, $homePh2, $cellPh2,
            $name3, $rel3, $dir3, $city3, $state3, $zip3, $homePh3, $cellPh3,
            $name4, $rel4, $dir4, $city4, $state4, $zip4, $homePh4, $cellPh4,
            $name5, $rel5, $dir5, $city5, $state5, $zip5, $homePh5, $cellPh5
            );

            if($consulta->execute() ){
                    
                    $consulta = $conn->prepare("SELECT * FROM  referencias WHERE Nombre1 = ? AND relacion1 = ? AND direccion1 = ? AND  ciudad1 = ? AND estado1 = ? AND ZIP1 = ? AND homePh1 = ? AND cellPh1 = ?");
                    $consulta->bind_param('ssssssss',$name1, $rel1, $dir1, $city1, $state1, $zip1, $homePh1, $cellPh1);
                    $consulta->execute();
                    $resultado = $consulta->get_result();
                    $datReferencia = $resultado->fetch_assoc();

                    $consulta = $conn->prepare("UPDATE prestarios SET id_referencia  = ?, refRegistrada = ? WHERE numContrato = ?");
                    $estadoRef = 1;
                    $consulta->bind_param('iis',$datReferencia['idReferencia'], $estadoRef,  $contrato);
                    $consulta->execute();

                    if( $consulta->affected_rows > 0){
                        
                        if(enviarNotificacion('Borrower reference #'.$contrato.' registered', 'Negocios Hispanos System has been registered the references by the Borrower #'.$contrato)){
                            header('location: ../validar?Reg=True');
                        }else{
                            header('location: ../validar?Reg=True');
                        }

                    }else{
                        header('location: ../validar?Reg=False&msg='.$consulta->error);
                    }   

            }else{
                $conn->error;
                header('location: ../validar?Reg=False&msg='.$consulta->error);    
            }
        }
        $conn->error;
    }
        $conn->close();
?>
