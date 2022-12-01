<?php 
    namespace App\libs\tel_design_pattern\App;

    class Login{
        private $site;
        private $login;
        private $senha;
        private $porta;

        public function __construct(string $site, string $login, string $senha)
        {
            $this->site = strtoupper($site);
            $this->login = $login;
            $this->senha = $senha;
            $this->porta = 389;
        }

        public function logarAd(): array
        {
            $site = $this->site;
            $login = $this->login;
            $senha = $this->senha;
            $porta = $this->porta;
            
            switch ($site) {
                case 'FSA':
                    $servidor = "10.71.200.241";
                    $dominio = "@teltelematica.com.br";
                break;
                
                case 'ITB':
                    $servidor = "10.73.20.244";
                    $dominio = "@teltelematica.com.br";
                break;
        
                case 'SP':
                    $servidor = "172.26.0.230";
                    $dominio = "@tel.inf.br";
                break;
        
                case 'SSA':
                    $servidor = "10.71.138.240";
                    $dominio = "@teltelematica.com.br";
                break;
        
                case 'GARCIA':
                    $servidor = "172.16.3.241";
                    $dominio = "@tel.local";
                break;
        
                case 'BARUERI':
                    $servidor = "172.30.150.240";
                    $dominio = "@barueri.tel.local";
                break;

                case 'COMERCIO':
                    $servidor = "172.31.50.240";
                    $dominio = "@tel.local";
                break;
            }
        
            $conexao = ldap_connect($servidor, $porta);
    
            if (!$conexao) {
                $resultado = -1;
            }

            $bind = @ldap_bind($conexao, $login.$dominio, $senha);

            if (!$bind) {
                $resultado = 0;
            }
            else{
                $resultado = 1;
            }
    
            ldap_close($conexao);  
                
            return array($resultado, $login);
        }

        public function listaConexoesSisfreq(): array
        {
            $site = $this->site;

            switch ($site) {
                case 'FSA':
                    $servidor = "172.16.0.227";
                    $banco = "TEL_SISFREQ";
                    $usuario = "plan_fsa";
                    $senha = "(001Ab@plan_fsa*2021)";
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
        
            return array($servidor, $banco, $usuario, $senha);
        }

        public function buscaUsuarioSisfreq(array $conexao): array
        {
            $loginUsuario = strtoupper($this->login);

            $servidor = $conexao[0];
            $banco = $conexao[1];
            $usuario = $conexao[2];
            $senha = $conexao[3];

            global $conn;
    
            $connectionInfo = array("Database" => $banco, "UID" => $usuario, "PWD" => $senha);
            $conn = sqlsrv_connect($servidor, $connectionInfo);

            $query = "SELECT 
                    NOME,
                    AUTO_APELIDO_GESTORES,
                    FUNCAO,
                    SUPERVISOR,
                    MATRICULA,
                    COORDENADOR,
                    SERVICO
                FROM View_FUNCIONARIOS
                WHERE LOGIN_REDE LIKE '%$loginUsuario'
            ";

            $statement = sqlsrv_query($conn, $query);

            if($statement){
                $row = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

                return $row;
            }
            else{
                return array("error" => "Erro ao processar a consulta");
            }
        }
    }
