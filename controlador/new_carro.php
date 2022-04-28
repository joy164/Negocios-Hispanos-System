<?php
    date_default_timezone_set('America/Los_Angeles');
    session_start();
    include '../modelo/conexion.php';
    include 'correo.php';

    $id = $_REQUEST['id_contrato'];
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
        
        $conn->set_charset('utf8');
        $consulta = $conn->prepare("INSERT INTO vehicle(year, model, odometer, transmission, make, color, VIN, LicenseNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
        if($consulta){
            $consulta->bind_param('isisssss', $year, $model, $odometer, $transmision, $make, $color, $VIN, $LicNo);
            if($consulta->execute()){
                    
                    $consulta = $conn->prepare("SELECT * FROM  vehicle WHERE VIN = ?");
                    $consulta->bind_param('s',$VIN);
                    $consulta->execute();
                    $resultado = $consulta->get_result();
                    $datAuto = $resultado->fetch_assoc();

                    $consulta = $conn->prepare("UPDATE prestarios SET id_auto = ? WHERE id_prestario = ?");
                    $consulta->bind_param('ii',$datAuto['id_auto'] , $id);
                    $consulta->execute();

                    if( $consulta->affected_rows > 0){
                        //si las dos casillas estan seleccionadas
                        if(isset($CoBorrower) && isset($CoSigner)){
                            header('location: ../regCoBorrower?Signer=True&id_prestario='.$id);
                        }else{
                            //si las dos casillas no estan seleccionadas
                            if(!isset($CoBorrower) && !isset($CoSigner)){
                                if(enviarNotificacion('new registered BORROWER', 'Negocios Hispanos System has been registered a new BORROWER by '.$_SESSION['name']. " witth email: ".$_SESSION['correo']). ' at: '. date('l jS \of F Y h:i:s A')){
                                    header('location: ../newBorrower?Reg=True');
                                }else{
                                    header('location: ../newBorrower?Reg=True');
                                }
                                //header('location: gen_Contrato?id_prestario='.$id);
                            }else{
                                //solo una casilla esta seleccionada
                                //evaluamos cual de las dos casillas esta seleccionada
                                if(isset($CoBorrower)){
                                    header('location: ../regCoBorrower?Signer=False&id_prestario='.$id);
                                }else if(isset($CoSigner)){
                                    header('location: ../regCoSigner?&id_prestario='.$id);
                                }
                            }   
                        }

                        
                    }else{
                        header('location: ../regAuto?Reg=False&id_prestario='.$id);
                    }

                     
            }else{
                $conn->error;
                header('location: ../regAuto?Reg=False&id_prestario='.$id);    
            }
        }
        $conn->error;
    }
        $conn->close();
?>