<?php

namespace MyApplication\util {

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mailto {

        public static function send($receive, $name, $subject, $body) {

            $smtp     = $_ENV['PRODUCT_MAIL_COMMERCIAL_SMTP'] ?? null;
            $user     = $_ENV['PRODUCT_MAIL_COMMERCIAL'] ?? null;
            $password = $_ENV['PRODUCT_MAIL_COMMERCIAL_PASS'] ?? null;

            // Verifica se todas as variáveis necessárias estão definidas
            if (!$smtp || !$user || !$password) {
                error_log("Email não enviado: variáveis de ambiente ausentes.");
                return false;
            }

            try {
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = $smtp;
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = $user;
                $mail->Password = $password;

                $mail->setFrom($user, 'Commercial');
                $mail->addAddress($user, 'Commercial Venda Feita');
                $mail->addAddress($receive, $name);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                $mail->Subject = $subject;
                $mail->Body = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>" . $body;

                return $mail->send();

            } catch (Exception $e) {
                error_log('Erro ao enviar o e-mail: ' . $mail->ErrorInfo);
                return false;
            }
        }
    }

}
