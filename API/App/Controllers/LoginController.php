<?php

namespace App\Controllers; //controlers

use App\DAO\MySQL\qualihelp\LoginDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Slim\Http\Response as Response;
use App\libs\tel_design_pattern\App\Login;

use App\libs\tel_design_pattern\App\Utilities;
use App\Models\MySQL\qualihelp\LoginModel;

final class LoginController
{


    public function authVerificaLogin(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();


        if (count($data) > 0) {
            $fieldsNecessary = ['site', 'login', 'senha'];

            $data = Utilities::limpaRequestBody($data);
            $fieldIsCorrect = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);

            if ($fieldIsCorrect) {

                $login = $data['login'];
                $senha = $data['senha'];
                $site = $data['site'];

                if ($site == "" || $login == "" || $senha == "") {
                    $resposta =
                        [
                            "message" => "Informe os campos necessários para a realização do login",
                            "erro" => "true"
                        ];
                        return $response;
                }

                $Login_tel = new Login($site, $login, $senha);
                $LoginDAO = new LoginDAO();
                $LoginModel = new LoginModel();

                $authLogin = $Login_tel->logarAd();



                if ($authLogin[0] == 0) {
                    $resposta =
                        [
                            "message" => "Credenciais inválida.",
                            "erro" => "true"

                        ];
                } elseif ($authLogin[0] == 1) {
                    $connection = $Login_tel->listaConexoesSisfreq();
                    $userData = $Login_tel->buscaUsuarioSisfreq($connection);
                    $LoginModel->setLogin($login);

                    $arrayFormat = [];

                    foreach ($userData as $key => $user) {
                        $arrayFormat[$key] = utf8_encode($user);
                    }

                    $userDataFormat = array($arrayFormat);

                    $queryStatus = $LoginDAO->insertBaseAcesso($LoginModel);

                    if ($queryStatus) {
                       
                        $resposta =
                            [
                                "message" => "Tudo ok!",
                                "erro" => "false",
                                "type_access" => $site,

                                "user_data" => $userDataFormat,

                            ];
                    }
                } else {
                    $resposta =
                        [
                            "message" => "Estamos passando por instabilidade no sistema, por favor informe ao MIS.",
                            "erro" => "false"
                        ];
                }
            } else {
                $resposta =
                    [
                        "message" => "Informe os campos necessário.",
                        "erro" => "true"
                    ];
            }
        }

        $response = $response->withJson($resposta);


        return $response;
    }
    public function logout(Request $request, Response $response, array $args): void
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ./../');
        exit();
    }
}
