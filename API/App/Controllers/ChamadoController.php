<?php



namespace App\Controllers; //controlers

use App\DAO\MySQL\qualihelp\ChamadosDAO;
use App\Models\MySQL\qualihelp\ChamadoModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use \Slim\Http\Response as Response;
use \App\libs\tel_design_pattern\App\Utilities;
use \App\Utilities\UtilFunctions;

use \App\libs\tel_design_pattern\App\Email;
use Slim\Http\UploadedFile;
final class ChamadoController
{


    public function getChamados(Request $request, Response $response, array $args): Response
    {

        $chamadosDAO = new ChamadosDAO();
        $chamados = $chamadosDAO->getAllChamados();
        $response = $response->withJson($chamados);

        return $response;
    }

    public function insertChamados(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();
        if (count($data) > 0) {

            $fieldsNecessary = [
                'motivo', 'solicitacao', 'textarea', 'anexo', 'assunto', 'matricula_usuario'
            ];

            $data = Utilities::limpaRequestBody($data, 'PDO');
            $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);

            if ($correctFieldsInformed) {

                $ChamadosDAO = new ChamadosDAO();
                $chamadosModel = new ChamadoModel;

                $chamadosModel->setMotivo($data['motivo']);
                $chamadosModel->setSolicitacao($data['solicitacao']);
                $chamadosModel->setTextarea($data['textarea']);
                $chamadosModel->setAnexo($data['anexo']);
                $chamadosModel->setAssunto($data['assunto']);
                $chamadosModel->setMatricula_usuario($data['matricula_usuario']);

                $insertedId =  $ChamadosDAO->insertChamados($chamadosModel);

                if ($insertedId > 0) {
                    $response = $response->withJson([
                        'message' => 'Chamado criado com sucesso!
                        ',
                        "insert_id" => $insertedId,
                        "error" => "false"
                    ]);
                } else {
                    $response = $response->withJson([
                        "message" => "Erro na inserção da ocorrência",
                        "error" => "true"
                    ]);
                }
            } else {
                $response = $response->withJson([
                    "message" => "Informe todos os dados necessários para a inserção",
                    "error" => "true"
                ]);
            }
        } else {
            $response = $response->withJson([
                "message" => "Informe os dados para inserção",
                "error" => "true"
            ]);
        }

        return $response;
    }


    public function buscarMatricula(Request $request, Response $response, array $args): Response

    {

        $data = $request->getParsedBody();

        $matricula = $data['matricula_usuario'];
        $chamadosDAO = new ChamadosDAO();
        $chamados = $chamadosDAO->usuarioMatricula($matricula);
        $response = $response->withJson($chamados);

        return $response;
    }
    public function buscarProtocolo(Request $request, Response $response, array $args): Response

    {

        $data = $request->getParsedBody();

        $protocolo = $data['protocolo'];
        $chamadosDAO = new ChamadosDAO();
        $chamados = $chamadosDAO->usuarioProtocolo($protocolo);
        $response = $response->withJson($chamados);

        return $response;
    }

    public function updateChamados(Request $request, Response $response, array $args): Response

    {
        $data = $request->getParsedBody();

        $ChamadosDAO = new ChamadosDAO();
        $chamados = new ChamadoModel;

        $chamados->setId((int)$data['id'])
            ->setMotivo($data['motivo'])
            ->setSolicitacao($data['solicitacao'])
            ->setTextarea($data['textarea'])
            ->setAnexo($data['anexo'])
            ->setAssunto($data['assunto'])
            ->setStatus($data['status'])
            ->setMatricula_usuario($data['matricula_usuario']);
        //  ->setNomeArquivo($data['anexo']);
        $ChamadosDAO->updateChamado($chamados);

        $response = $response->withJson([
            'message' => 'chamado atualizado com sucesso!',

        ]);
        // print_r($response);



        return $response;
    }

    public function updateStatus(Request $request, Response $response, array $args): Response

    {
        $data = $request->getParsedBody();

        $fieldsNecessary = [
            'id', 'status'
        ];

        $data = Utilities::limpaRequestBody($data, 'PDO');
        $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);


        if (count($data) == 2) {
            if ($correctFieldsInformed) {
                $ChamadosDAO = new ChamadosDAO();
                $chamados = new ChamadoModel;

                $chamados->setId((int)$data['id'])
                    ->setStatus($data['status']);
                //  ->setNomeArquivo($data['anexo']);
                $ChamadosDAO->updateStatus($chamados);



                $response = $response->withJson([
                    'message' => 'chamado atualizado com sucesso!',
                    'error' => 'false',
                    'data' => $data
                ]);
            } else {
                $response = $response->withJson([
                    'message' => 'Informe todos os campos de acordo com a documentação.',
                    'error' => 'true'

                ]);
            }
        } else {
            $response = $response->withJson([
                'message' => 'Informe todos os campos necessário, leia a documentação rs :)',
                'error' => 'true'

            ]);
        }

        // print_r($response);



        return $response;
    }


    public function deleteChamados(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $lojasDAO = new ChamadosDAO();
        $id = (int)$data['id'];
        $lojasDAO->deleteChamado($id);

        $response = $response->withJson([
            'message' => 'Chamado deletada com sucesso!'
        ]);
        // $response = $response->withJson("metodo delete funcionou ");

        return $response;
    }



    public function allStatusMatricula(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $arrayAllStatus = [];

        $matricula = $data['matricula_usuario'];

        $chamadosDAO = new ChamadosDAO();
        if (count($data) > 0) {
            if (!isset($matricula)) {
                $response = $response->withJson([
                    'message' => 'É necessario informar a matricula!',
                    'error' => 'true'
                ]);
            } else {

                $data = $chamadosDAO->countStatusAbertoMatricula($matricula);
                $arrayAllStatus[] = $data[0];

                $data = $chamadosDAO->countStatusTratativaMatricula($matricula);
                $arrayAllStatus[] = $data[0];


                $data = $chamadosDAO->countStatusFechadoMatricula($matricula);
                $arrayAllStatus[] = $data[0];

                $response = $response->withJson([
                    'message' => 'tudo ok!',
                    'data' => $arrayAllStatus,
                    'error' => 'false'
                ]);
            }
        } else {
            $response = $response->withJson([
                'message' => 'Não tem dados no array',
                'error' => 'true',
                'matricula' => $matricula
            ]);
        }


        // $response = $response->withJson($arrayAllStatus);

        return $response;
    }



    public function allStatus(Request $request, Response $response, array $args): Response
    {
        $arrayAllStatus = [];

        $chamadoDAO = new ChamadosDAO();

        $data = $chamadoDAO->countStatusAberto();
        $arrayAllStatus[] = $data[0];

        $data = $chamadoDAO->countStatusTratativa();
        $arrayAllStatus[] = $data[0];

        $data = $chamadoDAO->countStatusFechado();
        $arrayAllStatus[] = $data[0];


        $response = $response->withJson($arrayAllStatus);

        return $response;
    }

    public function anexoChamado(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();


        if (count($data) > 0) {
            $fieldsNecessary = ['id'];

            $data = Utilities::limpaRequestBody($data, 'PDO');
            $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);

            if ($correctFieldsInformed) {
                $id = $data['id'];

                if (is_numeric($id)) {
                    $ChamadosDAO = new ChamadosDAO();
                    $chamadosModel = new ChamadoModel;
                    $UtilFunctions = new UtilFunctions();

                    $uploadedFiles = $request->getUploadedFiles();
                    $uploadedFile = $uploadedFiles['file'];

                    $directory = "uploads/chamados/";

                    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                        $filename = $UtilFunctions->moveUploadedFile($directory, $uploadedFile);

                        $chamadosModel->setAnexo($filename);
                        $queryStatus = $ChamadosDAO->updateAnexoOcorrencia($chamadosModel, $id);

                        if ($queryStatus) {
                            $response = $response->withJson([
                                "message" => "Arquivo salvo com sucesso",
                                "file_name" => "$filename",
                                "modificated_id" => "$id",
                                "error" => "false"
                            ]);
                        } else {
                            $response = $response->withJson([
                                "message" => "Erro ao processar a consulta",
                                "error" => "true"
                            ]);
                        }
                    } else {
                        $response = $response->withJson([
                            "message" => "Erro ao realizar o upload do arquivo",
                            "error" => "true"
                        ]);
                    }
                } else {
                    $response = $response->withJson([
                        "message" => "Informe um id númerico",
                        "error" => "true"
                    ]);
                }
            } else {
                $response = $response->withJson([
                    "message" => "Informe o id da ocorrência",
                    "error" => "true"
                ]);
            }
        } else {
            $response = $response->withJson([
                "message" => "Informe o id da ocorrência",
                "error" => "true"
            ]);
        }

        return $response;
    }

    public function avaliacaoUsuario(Request $request, Response $response, array $args): Response
    {

        $data = $request->getParsedBody();
        if (count($data) > 0) {

            $ChamadosDAO = new ChamadosDAO();
            $chamadosModel = new ChamadoModel;

            $chamadosModel->setId((int)$data['id'])
                ->setAvaliacao($data['avaliacao']);

            //  ->setNomeArquivo($data['anexo']);
            $ChamadosDAO->updateAvaliacao($chamadosModel);



            $response = $response->withJson([
                'message' => 'nota inserida com sucesso!'
            ]);
            // print_r($response);

        } else {
            $response = $response->withJson([
                'message' => 'É necessario informar o id e a avaliação.'
            ]);
        }



        return $response;

        // $response = $response->withJson($arrayAllStatus);



    }

    public function updateTratativa(Request $request, Response $response, array $args): Response

    {
        $data = $request->getParsedBody();

        $fieldsNecessary = [
            'id', 'tratativa'
        ];

        $data = Utilities::limpaRequestBody($data, 'PDO');
        $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);


        if (count($data) == 2) {
            if ($correctFieldsInformed) {
                $ChamadosDAO = new ChamadosDAO();
                $chamados = new ChamadoModel;

                $chamados->setId((int)$data['id'])
                    ->setTratativa($data['tratativa']);
                //  ->setNomeArquivo($data['anexo']);
                $ChamadosDAO->updateTratativa($chamados);



                $response = $response->withJson([
                    'message' => 'tratativa atualizada com sucesso!',
                    'error' => 'false',
                    'data' => $data
                ]);
            } else {
                $response = $response->withJson([
                    'message' => 'Informe todos os campos de acordo com a documentação.',
                    'error' => 'true'

                ]);
            }
        } else {
            $response = $response->withJson([
                'message' => 'Informe todos os campos necessário, leia a documentação rs :)',
                'error' => 'true'

            ]);
        }

        // print_r($response);



        return $response;
    }
    public function updateAnexo(Request $request, Response $response, array $args): Response

    {
        $data = $request->getParsedBody();

        $fieldsNecessary = [
            'id', 'anexo'
        ];

        $data = Utilities::limpaRequestBody($data, 'PDO');
        $correctFieldsInformed = Utilities::verificaQtdCamposRequest($fieldsNecessary, $data);


        if (count($data) == 2) {
            if ($correctFieldsInformed) {
                $ChamadosDAO = new ChamadosDAO();
                $chamados = new ChamadoModel;

                $chamados->setId((int)$data['id'])
                    ->setAnexo($data['anexo']);
                //  ->setNomeArquivo($data['anexo']);
                $ChamadosDAO->updateAnexo($chamados);



                $response = $response->withJson([
                    'message' => 'anexo atualizado com sucesso!',
                    'error' => 'false',
                    'data' => $data
                ]);
            } else {
                $response = $response->withJson([
                    'message' => 'Informe todos os campos de acordo com a documentação.',
                    'error' => 'true'

                ]);
            }
        } else {
            $response = $response->withJson([
                'message' => 'Informe todos os campos necessário, leia a documentação rs :)',
                'error' => 'true'

            ]);
        }

        // print_r($response);



        return $response;
    }
    
}
