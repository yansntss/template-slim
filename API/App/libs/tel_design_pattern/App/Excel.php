<?php 
    namespace App;

    class Excel{
        private $conexaoBanco;

        public function __construct(object $conexaoBanco)
        {
            $this->conexaoBanco = $conexaoBanco;
        }

        public function download(
            array $heads, 
            array $bodyContent, 
            string $consulta, 
            string $utf8 = null, 
            bool $uppercase = false
        ): Excel
        {
            header('Content-Type: text/html; charset=utf-8');
            header("Content-type: application/vnd.ms-excel");
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=relatorio.xls");
            header("Pragma: no-cache");
            ?>
                <table border='1'>
                    <tr>
                        <?php 
                            foreach($heads as $head){
                                ?>
                                    <td>
                                        <?php 
                                            if($utf8 == null){
                                                if($uppercase){
                                                    echo strtoupper($head); 
                                                }
                                                else{
                                                    echo $head;
                                                }
                                            }
                                            else if($utf8 == 'encode'){
                                                if($uppercase){
                                                    echo strtoupper(utf8_encode($head)); 
                                                }
                                                else{
                                                    echo utf8_encode($head);
                                                }
                                            }
                                            else if($utf8 == 'decode'){
                                                if($uppercase){
                                                    echo strtoupper(utf8_decode($head));
                                                }
                                                else{
                                                    echo utf8_decode($head);
                                                }
                                            }
                                        ?>
                                    </td>
                                <?php
                            }
                        ?>
                    </tr>

                    <?php 
                        $resultado = $this->conexaoBanco->query($consulta);
                        $qtdColunas = $this->conexaoBanco->field_count;

                        while($dados = $resultado->fetch_assoc()){
                            ?>
                               <tr>
                                    <?php
                                        for ($i = 0; $i < $qtdColunas; $i++) {
                                            ?>
                                                <td>
                                                    <?php 
                                                        if($utf8 == null){
                                                            if($uppercase){
                                                                echo strtoupper($dados[$bodyContent[$i]]);
                                                            }
                                                            else{
                                                                echo $dados[$bodyContent[$i]];
                                                            }
                                                        } 
                                                        else if($utf8 == 'encode'){
                                                            if($uppercase){
                                                                echo strtoupper(utf8_encode($dados[$bodyContent[$i]]));
                                                            }
                                                            else{
                                                                echo utf8_encode($dados[$bodyContent[$i]]);
                                                            }
                                                        }
                                                        else if($utf8 == 'decode'){
                                                            if($uppercase){
                                                                echo strtoupper(utf8_decode($dados[$bodyContent[$i]]));
                                                            }
                                                            else{
                                                                echo utf8_decode($dados[$bodyContent[$i]]);
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                            <?php
                                        }
                                    ?>
                               </tr> 
                            <?php
                        }
                    ?>
                </table>
            <?php

            return $this;
        }

        public function upload(
            string $nomeInput, 
            string $nomeTabela, 
            array $camposInsert, 
            string $tipoArquivo = 'CSV',
            string $utf8 = null
        ): array
        {
            if($tipoArquivo == 'CSV'){
                $query = "";
                $qtdCamposInsert = count($camposInsert);
                $qtdInserts = 0;

                $file = $_FILES[$nomeInput]["tmp_name"];
                $handle = fopen($file, "r");

                while ($data = fgetcsv($handle, 1000, ";", '"')){
                    if($data[0]){
                        // Montando query
                        $query .= "INSERT INTO $nomeTabela (";
                        for ($i = 0; $i < $qtdCamposInsert; $i++) { 
                            // O último campo do insert não pode receber vírgula
                            if($i == $qtdCamposInsert - 1){
                                $query .= "$camposInsert[$i]";
                            }
                            else{
                                $query .= "$camposInsert[$i],";
                            }
                        }
                        $query .= ")";

                        $query .= "VALUES (";
                        for ($i = 0; $i < $qtdCamposInsert; $i++) { 
                            // O último campo do insert não pode receber vírgula
                            if($i == $qtdCamposInsert - 1){
                                if($utf8 == null){
                                    $query .= "'$data[$i]'";
                                }
                                else if($utf8 == 'decode'){
                                    $query .= utf8_decode("'$data[$i]'");
                                }
                                else if($utf8 == 'encode'){
                                    $query .= utf8_encode("'$data[$i]'");
                                }
                            }
                            else{
                                if($utf8 == null){
                                    $query .= "'$data[$i]',";
                                }
                                else if($utf8 == 'decode'){
                                    $query .= utf8_decode("'$data[$i]',");
                                }
                                else if($utf8 == 'encode'){
                                    $query .= utf8_encode("'$data[$i]',");
                                }
                            }
                        }
                        $query .= ")";

                        $resultado = $this->conexaoBanco->query($query);

                        if($resultado){
                            $qtdInserts++;
                        }
                    }

                    $query = "";
                }

                if($qtdInserts > 0){
                    return array("resposta" => $qtdInserts);
                }
                else{
                    return array("resposta" => "Erro ao processar a consulta");
                }
            }
            else{
                return array("resposta" => "O upload deste tipo de arquivo ainda não foi implementado");
            }
        }
    }

