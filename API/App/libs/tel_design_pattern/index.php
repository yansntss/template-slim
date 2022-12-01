<?php 
    require_once "autoload.php";
 
use App\libs\tel_design_pattern\App\Login;

$site = 'FSA';
$usuario = 'mslima';
$senha = 'tel*4606';

$login = new Login($site, $usuario, $senha);




    // $email = new Email('qualidadenps@tel.inf.br', 'v#AP9S699T');
    // $response = $email->send(
    //     'qualidadenps@tel.inf.br',
    //     'NPS - NET',
    //     'joao.ferreira@tel.inf.br',
    //     'João Ferreira',
    //     'Teste',
    //     'Este é um email de <strong>teste</strong>'
    // );

    // print_r($response)