<?php

//usando o slim configuration que é uma função e que ta dentri di namespace src

use function src\slimConfiguration;

use App\Controllers\{
    ChamadoController,
    LoginController
};



$app = new \Slim\App(slimConfiguration());

$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . 'src/upload';
// =========================================

$app->post('/login', LoginController::class . ':authVerificaLogin');
//$app->post('/infoUser', LoginController::class . ':infoUsuario');

$app->get('/baseAcesso', LoginController::class . ':getLogin');
$app->get('/chamados', ChamadoController::class . ':getChamados');
$app->post('/matricula', ChamadoController::class . ':buscarMatricula');
$app->post('/protocolo', ChamadoController::class . ':buscarProtocolo');
$app->get('/status', ChamadoController::class . ':allStatus');
$app->get('/logout', AutenticarController::class.':logout');


$app->post('/statusMatricula', ChamadoController::class . ':allStatusMatricula');
$app->post('/insertChamados/anexo', ChamadoController::class . ':anexoChamado');
$app->post('/insertChamados', ChamadoController::class . ':insertChamados');


$app->put('/chamados', ChamadoController::class . ':updateChamados');
$app->put('/chamados/anexo', ChamadoController::class . ':updateAnexo');
$app->put('/avaliacao', ChamadoController::class . ':avaliacaoUsuario');
$app->put('/chamados/atualizarStatus', ChamadoController::class . ':updateStatus');
$app->put('/chamados/atualizarTratativa', ChamadoController::class . ':updateTratativa');


$app->delete('/chamados', ChamadoController::class . ':deleteChamados');

$app->run();

