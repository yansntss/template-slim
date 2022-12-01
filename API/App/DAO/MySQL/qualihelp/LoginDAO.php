<?php
    namespace App\DAO\MySQL\qualihelp;


    use App\Models\MySQL\qualihelp\LoginModel;

    class LoginDAO extends Conexao{
        public function __construct(){
            parent::__construct();
        }

        public function insertBaseAcesso(LoginModel $autenticarModel): bool 
        {
            $query = "INSERT INTO acesso(
                login,
                data_acesso
            ) VALUES (
                :login,
                CURRENT_TIMESTAMP
            )";

            $statement = $this->pdo->prepare($query);
            $statement = $statement->execute([
                "login" => $autenticarModel->getLogin()
            ]);

            if($statement){
                return true;
            }
            else{
                return false;
            }
        }
    }