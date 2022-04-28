<?php
    date_default_timezone_set('America/Los_Angeles');
    session_start();
    include '../modelo/conexion.php';
    include 'correo.php';

    //valores pasador por el protrocolo HTTP
    $id = $_REQUEST['id_prestario'];
    $singer = $_REQUEST['Signer'];
    
     //datos basicos
     $name = $_POST['name'];
     $midName = $_POST['midName'];
     $lastName = $_POST['lastName'];
     $DOF = $_POST['DOF'];
     //dirreccion
     $address = $_POST['address'];
     $city = $_POST['city'];
     $state = $_POST['state'];
     $zip = $_POST['zip'];
     //contacto
     $homePh = $_POST['homePh'];
     $cellPh = $_POST['cellPh'];
     $email = $_POST['email'];  
     //datos de empleo 
     $NSS = $_POST['NSS'];
     $empleo = $_POST['empleo'];
     $eAddress = $_POST['eDireccion'];
     $eCiudad = $_POST['eCiudad'];
     $eState = $_POST['eState'];
     $eZIP = $_POST['eZIP'];
     $eOffPh = $_POST['eOffPh'];
     $eExt = $_POST['eExt'];

    if(isset($name)){
        
        $conn->set_charset('utf8');
        
        $consulta = $conn->prepare("INSERT INTO coborrower(name, midName, lastName, address, city, state, ZIP, homePh, cellPh, email, 
        NSS, nacimiento, empleo, eAddress, eCity, eState, eZIP, ePh, eExt, ePossition) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if($consulta){
            $consulta->bind_param('ssssssssssssssssssss',
            $name, $midName, $lastName, $address, $city, $state, $zip, $homePh, $cellPh, $email, 
            $NSS, $DOF, $empleo, $eAddress, $eCiudad, $eState, $eZIP, $eOffPh, $eExt, $empleo);

            if($consulta->execute()){
                    
                $consulta = $conn->prepare("SELECT * FROM  coborrower WHERE cellPh = ? AND email = ?");
                $consulta->bind_param('ss',$cellPh, $email);
                $consulta->execute();
                $resultado = $consulta->get_result();
                $datCoBorrower = $resultado->fetch_assoc();

                $consulta = $conn->prepare("UPDATE prestarios SET id_coBorrower = ? WHERE id_prestario = ?");
                $consulta->bind_param('ii',$datCoBorrower['id_coBorrower'] , $id);
                $consulta->execute();

                if( $consulta->affected_rows > 0){
                    if(strcmp($singer, "True") == 0){
                            header('location: ../regCoSigner?id_prestario='.$id);
                        }else{
                            if(enviarNotificacion('new registered BORROWER', 'has been registered a new BORROWER with Co-Borrower  by '.$_SESSION['name']. " witth email: ".$_SESSION['correo']). ' at: '. date('l jS \of F Y h:i:s A')){
                                header('location: ../newBorrower?Reg=True');
                            }else{
                                header('location: ../newBorrower?Reg=True');
                            }
                            //header('location: gen_Contrato.php?id_prestario='.$id);    
                        }
                }else{
                    header('location: ../regCoBorrower?Signer='.$singer.'&Reg=False&id_prestario='.$id.'&msg='.$consulta->error);
                }

                     
            }else{
                header('location: ../regCoBorrower?Signer='.$singer.'&Reg=False&id_prestario='.$id.'&msg='.$consulta->error);    
            }
        }
        echo 'aqui';  
    } 
    
    $conn->close();
    
?>