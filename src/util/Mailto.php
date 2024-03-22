<?php

namespace MyApplication\util{

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mailto {

        public static function send( $receive, $name, $subject, $body ){

            try {
                
                $mail = new PHPMailer(true);

                $mail->Host = 'smtp.live.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;

                $mail->Username = $_ENV['PROPHETA_MAIL_COMMERCIAL'];
                $mail->Password = $_ENV['PROPHETA_MAIL_COMMERCIAL_PASS'];

                $mail->setFrom($_ENV['PROPHETA_MAIL_COMMERCIAL'], 'Commercial Propheta');

                $mail->addAddress('suporte@propheta.net', 'Reply');
                $mail->addAddress($receive, $name);
                
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; // Definindo a codificação como UTF-8
                
                $mail->Subject = $subject;

                $body =  "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>" . $body;

                $mail->Body = $body;

                return $mail->send();

            } catch (Exception $e) {
                echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
            }

        }

        
    }

}
