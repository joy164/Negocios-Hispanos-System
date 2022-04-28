<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    function enviarContrato($correo1, $correo2, $asunto, $mensaje, $nombreContrato ){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0; //0 no se activa el debugeador, 1 para producion, 2 para mensaje entre cliente y servidor
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';//AWS SES SMTP
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth  = true;
        $mail->Username = 'AKIAV7ICXXQNZPR55KEG'; //AWS SES CREDENTIALS USERNAME
        $mail->Password = 'BKSfR+2d43nC8j4hsojPyYYrtH9qwmdeTtCj1Cm0fjMj'; //AWS SES SMTP CREDENTIALS PASSWORD
        $mail->setFrom('noreplay@amigosprestamos.com');//tiene que ser un correo o dominio verificado por amazon ses desde su consola
        $mail->addAddress($correo1);
        $mail->addAddress($correo2);
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);
        $mail->AddAttachment('contratos/'.$nombreContrato);
        $mail->AltBody = 'NO soporta HTML';

        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }

    function enviarNotif($correo1, $correo2, $asunto, $mensaje){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0; //0 no se activa el debugeador, 1 para producion, 2 para mensaje entre cliente y servidor
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';//AWS SES SMTP
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth  = true;
        $mail->Username = 'AKIAV7ICXXQNZPR55KEG'; //AWS SES CREDENTIALS USERNAME
        $mail->Password = 'BKSfR+2d43nC8j4hsojPyYYrtH9qwmdeTtCj1Cm0fjMj'; //AWS SES SMTP CREDENTIALS PASSWORD
        $mail->setFrom('noreplay@amigosprestamos.com');//tiene que ser un correo o dominio verificado por amazon ses desde su consola
        $mail->addAddress($correo1);
        $mail->addAddress($correo2);
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);
        $mail->AltBody = 'NO soporta HTML';

        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }

    if(isset($_POST['submit']) ){
        $correo1 = $_POST['correo1'];
        $correo2 = $_POST['correo2'];
        $asunto = $_POST['subject'];
        $contenido = $_POST['mensaje'];

        if(enviarContrato($correo1, $correo2, $asunto, $contenido, 'contrato1.pdf')){
            echo 'mensaje enviado con exito!!!';
        }else{
            echo 'error al enviar mensaje';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo SMPT</title>
</head>
<body>
    <center>
        <form action="prueba"  method="POST">
            <p>correo 1:</p>
            <input type="email" name="correo1"><br>
            <p>correo 2:</p>
            <input type="email" name="correo2"><br>
            <p>asunto:</p>
            <input type="subject" name="subject"><br>
            <p>mensaje: </p>
            <textarea name="mensaje"></textarea><br><br>
            <input type="submit" name="submit">
        </form>
    </center>
</body>
</html>