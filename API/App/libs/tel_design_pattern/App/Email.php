<?php
    namespace App\libs\tel_design_pattern\App;


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    class Email{
        private $email;
        private $senha;  

        public function __construct(string $email, string $senha)
        {
            $this->email = $email;
            $this->senha = $senha;
        }

        public function send(
            string $emailRemetente,
            string $nomeRemetente,
            string $emailDestinatario,
            string $nomeDestinatario,
            string $assunto,
            string $corpoEmail
        ): Array
        {
            $mail = new PHPMailer();

            // Define o uso de SMTP no envio
            $mail->IsSMTP();   

            // Enviar por SMTP 
            $mail->Host = "email.tel.inf.br"; 

            // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
            $mail->Port = 26; 

            // Habilita a autenticação SMTP
            $mail->SMTPAuth = true; 

            // Usuário do servidor SMTP (endereço de email) 
            // obs: Use a mesma senha da sua conta de email 
            $mail->Username = $this->email; 
            $mail->Password = $this->senha; 

            // Configurações de compatibilidade para autenticação em TLS 
            $mail->SMTPOptions = array('ssl' => 
                array( 
                    'verify_peer' => false, 
                    'verify_peer_name' => false, 
                    'allow_self_signed' => true 
                ) 
            ); 

            // Define o remetente 
            // Seu e-mail 
            $mail->From = $emailRemetente; 

            // Seu nome 
            $mail->FromName = $nomeRemetente; 

            // Define o(s) destinatário(s) 
            $mail->AddAddress($emailDestinatario, $nomeDestinatario); 

            // Definir se o e-mail é em formato HTML ou texto plano 
            // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
            $mail->isHTML(true); 

            // Charset (opcional) 
            $mail->CharSet = 'UTF-8'; 

            // Assunto da mensagem 
            $mail->Subject = $assunto; 

            // Corpo do email 
            $mail->Body = $corpoEmail; 

            // Envia o e-mail 
            $enviado = $mail->Send(); 

            // Retorna a mensagem de envio
            if($enviado){ 
                return array("Email enviado");
            } 
            else{ 
                return array("Erro ao enviar o email");
            } 
        }
    }