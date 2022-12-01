<?php 
    namespace App\libs\tel_design_pattern\App;

    class Sisfreq{
        private $conexao;

        public function __construct(string $site)
        {
            switch ($site) {
                case 'FSA':
                    $servidor = "10.71.200.147";
                    $banco = "TEL_SISFREQ";
                    $usuario = "quali_bd";
                    $senha = "(@quali*2015)";
                break;
        
                case 'ITB':
                    $servidor = "10.73.20.242";
                    $banco = "TEL_SISFREQ";
                    $usuario = "plan_rel";
                    $senha = "plan_rel*itb2020";
                break;
                
                case 'SP':
                    $servidor = "172.30.150.245";
                    $banco = "TEL_SISFREQ";
                    $usuario = "ecarmo";
                    $senha = "mis@2021";
                break;
        
                case 'BARUERI':
                    $servidor = "172.30.150.245";
                    $banco = "TEL_SISFREQ";
                    $usuario = "ecarmo";
                    $senha = "mis@2021";
                break;
        
                case 'SSA':
                    $servidor = "172.16.0.227";
                    $banco = "TEL_SISFREQ";
                    $usuario = "plan_fsa";
                    $senha = "(001Ab@plan_fsa*2021)";
                break;
        
                case 'GARCIA':
                    $servidor = "172.16.0.227";
                    $banco = "TEL_SISFREQ";
                    $usuario = "plan_fsa";
                    $senha = "(001Ab@plan_fsa*2021)";
                break;

                case 'COMERCIO':
                    $servidor = "172.16.0.227";
                    $banco = "TEL_SISFREQ";
                    $usuario = "plan_fsa";
                    $senha = "(001Ab@plan_fsa*2021)";
                break;
            }

            $this->conexao = [$servidor, $banco, $usuario, $senha];
        }

        public function query(string $query): array
        {
            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            $dadosResposta = [];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                while($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)){
                    $dadosResposta[] = $row;
                }

                return $dadosResposta;
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            } 
        }

        public function buscaTodosUsuarios(): array
        {
            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            $dadosResposta = [];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    MATRICULA,
                FROM View_FUNCIONARIOS
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                while($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)){
                    $dadosResposta[] = $row;
                }

                return $dadosResposta;
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            } 
        }

        public function buscaUsuario(string $login): array 
        {
            $loginUsuario = strtoupper($login);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    MATRICULA,
                    SERVICO
                FROM View_FUNCIONARIOS
                WHERE LOGIN_REDE LIKE '%$loginUsuario'
            ";
            
            $statement = sqlsrv_query($conn, $query);

            if($statement){
                $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

                return $row ?? [];
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            }
        }

        public function buscaUsuarioComLoginSite(string $login, string $site): array 
        {
            $loginUsuario = strtoupper($login);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    MATRICULA,
                    SERVICO
                FROM View_FUNCIONARIOS
                WHERE LOGIN_REDE = '$site/$loginUsuario'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

                return $row ?? [];
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            }
        }

        public function buscarUsuarioMatricula(string $matricula): array 
        {
            $matriculaUsuario = strtoupper($matricula);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    MATRICULA,
                    SERVICO
                FROM View_FUNCIONARIOS
                WHERE MATRICULA = '$matriculaUsuario'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

                return $row ?? [];
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            }
        }

        public function buscarUsuarioPorNome(string $nome): array 
        {
            $nome = strtoupper($nome);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            $dadosResposta = [];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    SERVICO,
                    EMAIL, 
                    LOGIN_REDE,
                    LOGIN_PLATAFORMA,
                    MATRICULA
                FROM View_FUNCIONARIOS
                WHERE NOME LIKE '%$nome%'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                while($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)){
                    $dadosResposta[] = $row;
                }

                return $dadosResposta;
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            } 
        }

        public function buscarUsuarioPorServico(string $servico): array  
        {
            $servico = strtoupper($servico);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            $dadosResposta = [];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    COORDENADOR,
                    SERVICO,
                    EMAIL, 
                    LOGIN_REDE,
                    LOGIN_PLATAFORMA,
                    MATRICULA
                FROM View_FUNCIONARIOS
                WHERE SERVICO LIKE '%$servico%'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                while($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)){
                    $dadosResposta[] = $row;
                }

                return $dadosResposta;
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            } 
        }

        public function buscarEquipeGestor(string $login, string $cargo): array
        {
            $dadosResposta = [];

            $loginUsuario = strtoupper($login);

            $servidor = $this->conexao[0];
            $banco = $this->conexao[1];
            $usuario = $this->conexao[2];
            $senha = $this->conexao[3];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    AUTO_APELIDO_GESTORES
                FROM View_FUNCIONARIOS
                WHERE LOGIN_REDE LIKE '%$loginUsuario'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);
                $autoApelidoGestor = $row['AUTO_APELIDO_GESTORES'];

                $cargo = strtoupper($cargo);

                if($cargo == 'SUPERVISOR'){
                    $query = "SELECT 
                            NOME,
                            AUTO_APELIDO_GESTORES,
                            FUNCAO,
                            SUPERVISOR,
                            COORDENADOR,
                            SERVICO,
                            EMAIL, 
                            LOGIN_REDE,
                            LOGIN_PLATAFORMA,
                            MATRICULA
                        FROM View_FUNCIONARIOS
                        WHERE SUPERVISOR = '$autoApelidoGestor'
                    ";
                }
                else if($cargo == 'COORDENADOR'){
                    $query = "SELECT 
                            NOME,
                            AUTO_APELIDO_GESTORES,
                            FUNCAO,
                            SUPERVISOR,
                            COORDENADOR,
                            SERVICO,
                            EMAIL, 
                            LOGIN_REDE,
                            LOGIN_PLATAFORMA,
                            MATRICULA
                        FROM View_FUNCIONARIOS
                        WHERE COORDENADOR = '$autoApelidoGestor'
                    ";
                }
                else if($cargo == 'GERENTE'){
                    $query = "SELECT 
                            NOME,
                            AUTO_APELIDO_GESTORES,
                            FUNCAO,
                            SUPERVISOR,
                            COORDENADOR,
                            SERVICO,
                            EMAIL, 
                            LOGIN_REDE,
                            LOGIN_PLATAFORMA,
                            MATRICULA
                        FROM View_FUNCIONARIOS
                        WHERE COORDENADOR = '$autoApelidoGestor'
                    ";
                }
    
                $statement = sqlsrv_query($conn, $query);
    
                while($row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC)){
                    $dadosResposta[] = $row;
                }
    
                if($statement){
                    return $dadosResposta;
                }
                else{
                    return array("error" => "Erro ao processar a consulta");
                } 
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            }
        }
    }
