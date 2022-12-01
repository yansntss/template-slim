<?php 
    namespace App\libs\tel_design_pattern\App;

    abstract class Utilities{
        public static function limpaRequestBody($dados, $tipoConexao = 'MYSQLI', $conexao = null): array 
        {
            $dadosRetorno = [];

            foreach($dados as $key => $dado){
                $dado = Utilities::limpaCampo($dado, $conexao, $tipoConexao);
                $dado = Utilities::trataCampo($dado);

                $dadosRetorno[$key] = $dado;
            }

            return $dadosRetorno;
        }

        public static function limpaCampo($campo, $tipoConexao = 'MYSQLI', $conexao = null): string 
        {
            if($tipoConexao == 'MYSQLI'){
                $campo = mysqli_real_escape_string($conexao, $campo);
                $campo = htmlspecialchars($campo);
            }
            else{
                $campo = htmlspecialchars($campo);
            }

            return $campo;
        }

        public static function trataCampo($campo): string
        {
            $campo = str_replace(["'", '"', ";", "`", "{", "}", "-"], "", $campo);
            $campo = preg_replace("/\r|\n/", " ", $campo);
            $campo = trim($campo);

            return $campo;
        }

        public static function verificaQtdCamposRequest(array $camposNecessarios, array $camposInformados) 
        {
            foreach($camposNecessarios as $campoNecessario){
                if(!array_key_exists($campoNecessario, $camposInformados)){
                    return false;
                }
            }

            return true;
        }
    }