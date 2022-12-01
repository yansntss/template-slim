<?php



namespace App\Controllers; //controlers

use App\DAO\MySQL\qualihelp\EmailDAO;
use App\Models\MySQL\qualihelp\EmailModel;

use \Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \App\libs\tel_design_pattern\App\Utilities;
use \App\libs\tel_design_pattern\App\Email;
use \App\Utilities\UtilFunctions;
// use Slim\Http\UploadedFile;


final class EmailController
{
    public function sendEmail(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();

        if (count($data) > 0) {
            $fieldsNecessary = ['email', 'senha'];

            $data = Utilities::limpaRequestBody($data, 'PDO');
            $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);


            if ($correctFieldsInformed) {
                $EmailDAO = new EmailDAO();
                $EmailModel = new EmailModel();
                $emailRemetente = "mslima@tel.inf.br";


                $EmailModel->setEmail($data['email']);
                $EmailModel->setEmail($data['email']);



                $email = new Email($emailRemetente, "tel");
               
                    $userIsNotify = $email->send(
                        $emailRemetente, 
                        "QualiHelp - Sistema de chamados da qualidade",
                        "$login",
                        "$nome",
                        "Chamado",
                        "   
                            <div style='font-size:12px; font-family:verdana'>
                                <p>Olá <strong>$nome!</strong></p>

                                <p>
                                   Seu chamado foi aberto com sucesso. <br>
                                    <br>
                                    Este aqui é o seu código de segurança: <br>
                                    <strong>$codigoSeguranca</strong><br>
                                    <br>
                                    Você pode deve usá-lo para seguir o procedimento de mudança de senha. <br>
                                    <br>
                                    Copie este código e cole na caixa de <strong>Código de Segurança</strong> para dar prosseguimento. 😃 <br>
                                    <br>
                                </p>

                                <div>
                                    <img src='cid:assinatura_email_mitra' width='70%' height='30%'>
                                </div>
                            </div>
                        ",
                        true,
                        "App/Assets/Images/assinatura_email.png",
                        "assinatura_email_mitra"
                    );
                
                $response = $response->withJson([
                    'message' => 'É necessario informar o id e a avaliação.'
                ]);
            }
        }
        return $response;
    }


}
