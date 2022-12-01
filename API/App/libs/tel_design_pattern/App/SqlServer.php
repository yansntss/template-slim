<?php 
    namespace App\libs\tel_design_pattern\App;
    
    class SqlServer{
        private $servidor;
        private $banco;
        private $usuario;
        private $senha;

        public function __construct(
            string $servidor,
            string $banco,
            string $usuario,
            string $senha
        )
        {
            $this->servidor = $servidor;
            $this->banco = $banco;
            $this->usuario = $usuario;
            $this->senha = $senha; 
        }

        public function query(string $query): array  
        {
            $dadosResposta = [];

            global $conn;
    
            $connectionInfo = array("Database" => $this->banco, "UID" => $this->usuario, "PWD" => $this->senha);
            $conn = sqlsrv_connect($this->servidor, $connectionInfo);

            $statement = sqlsrv_query($conn, $query);

        //     if( $conn === false ) {
        //         die( print_r( sqlsrv_errors(), true));
        //    }

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
    }