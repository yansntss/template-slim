<?php

namespace App\DAO\MySQL\qualihelp;

use App\Models\MySQL\qualihelp\ChamadoModel;


class ChamadosDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllChamados(): array
    {
        $chamados = $this->pdo
            ->query('SELECT id, motivo,textarea,  assunto, solicitacao, anexo, data_criacao, protocolo, status, matricula_usuario, tratativa, avaliacao FROM chamados ;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $chamados;
    }

    // public function chamadosMatricula(): array
    // {
    //     $chamadosMatricula = $this->pdo
    //         ->query('SELECT id, motivo,textarea,  assunto, solicitacao, anexo, data_criacao, protocolo, status, matricula_usuario FROM chamados where matricula_usuario = "1411107";')
    //         ->fetchAll(\PDO::FETCH_ASSOC);
    //     return $chamadosMatricula;
    // }


    public function insertChamados(ChamadoModel $chamados)
    {
        $protocolo = uniqid();

        $statement = $this->pdo
            ->prepare('INSERT INTO chamados ( motivo, solicitacao, textarea, anexo,  
            data_criacao, protocolo, assunto, matricula_usuario) 
            VALUES(
                    :motivo,
                    :solicitacao,
                    :textarea,
                    :anexo,
                    current_timestamp, 
                    :protocolo,
                    :assunto,
                    :matricula_usuario
                    
                );');

        $statement->execute([
            'motivo' => $chamados->getMotivo(),
            'solicitacao' => $chamados->getSolicitacao(),
            'textarea' => $chamados->getTextarea(),
            'anexo' => $chamados->getAnexo(),
            'protocolo' => $protocolo,
            'assunto' => $chamados->getAssunto(),
            'matricula_usuario' => $chamados->getMatricula_usuario(),

        ]);
        $insertedId = $this->pdo->lastInsertId();

        return $insertedId;
    }

    public function usuarioMatricula($matricula_usuario)
    {

        $chamadosMatricula = $this->pdo
            ->query("SELECT id, motivo,textarea,  assunto, solicitacao, anexo, data_criacao, protocolo, status, matricula_usuario FROM chamados where matricula_usuario = '$matricula_usuario';")
            ->fetchAll(\PDO::FETCH_ASSOC);


        return $chamadosMatricula;
    }
    public function usuarioProtocolo($protocolo)
    {

        $chamadosProtocolo = $this->pdo
            ->query("SELECT id, motivo,textarea,  assunto, solicitacao, anexo, data_criacao, data_fechamento, protocolo, status, matricula_usuario, tratativa, avaliacao FROM chamados where protocolo = '$protocolo';")
            ->fetchAll(\PDO::FETCH_ASSOC);


        return $chamadosProtocolo;
    }





    public function updateChamado(ChamadoModel $chamados)
    {
        $statement = $this->pdo
            ->prepare('UPDATE chamados SET 
                      motivo = :motivo,
                      solicitacao = :solicitacao,
                      textarea = :textarea,
                      anexo = :anexo,
                      status = :status,
                      assunto = :assunto,
                      matricula_usuario = :matricula_usuario,
                      data_criacao = current_timestamp
                      WHERE
                        id = :id        
         ;');

        $statement->execute([
            'id' => $chamados->getId(),
            'motivo' => $chamados->getMotivo(),
            'solicitacao' => $chamados->getSolicitacao(),
            'textarea' => $chamados->getTextarea(),
            'anexo' => $chamados->getAnexo(),
            'status' => $chamados->getStatus(),
            'assunto' => $chamados->getAssunto(),
            'matricula_usuario' => $chamados->getMatricula_usuario(),

        ]);
        return $statement;
    }


    public function updateStatus(ChamadoModel $notaFeedback)
    {
        $statement = $this->pdo
            ->prepare('UPDATE chamados SET
                      status = :status
                      WHERE
                        id = :id        
         ;');

        $statement->execute([
            'id' => $notaFeedback->getId(),
            'status' => $notaFeedback->getStatus()
        ]);
        return $statement;
    }
    public function updateTratativa(ChamadoModel $tratativa)
    {
        $statement = $this->pdo
            ->prepare('UPDATE chamados SET
                      tratativa = :tratativa
                      WHERE
                        id = :id        
         ;');

        $statement->execute([
            'id' => $tratativa->getId(),
            'tratativa' => $tratativa->getTratativa()
        ]);
        return $statement;
    }


    public function deleteChamado(int $id)
    {
        $statement = $this->pdo
            ->prepare('DELETE FROM chamados WHERE id = :id;
            ');

        $statement->execute([
            'id' => $id
        ]);
        return $statement;
    }


    public function countStatusAbertoMatricula($matricula_usuario): array
    {
        $aberto = $this->pdo
            ->query(
                "  SELECT COUNT(status) 
                AS quantidade_aberto 
                FROM chamados
                WHERE status LIKE '%aberto%' and matricula_usuario = '$matricula_usuario';
                "
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $aberto;
    }


    public function countStatusTratativaMatricula($matricula_usuario): array
    {
        $tratativa = $this->pdo
            ->query(
                "SELECT COUNT(status) 
            AS quantidade_tratativa 
            FROM chamados 
            WHERE status LIKE '%Tratativa%'  and matricula_usuario = '$matricula_usuario';"
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $tratativa;
    }

    public function countStatusFechadoMatricula($matricula_usuario): array
    {
        $fechado = $this->pdo
            ->query(
                "SELECT COUNT(status) 
            AS quantidade_fechado 
            FROM chamados 
            WHERE status LIKE '%Fechado%'  and matricula_usuario = '$matricula_usuario';"
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $fechado;
    }





    public function countStatusAberto(): array
    {
        $aberto = $this->pdo
            ->query(
                "  SELECT COUNT(status) 
                AS quantidade_aberto 
                FROM chamados
                WHERE status LIKE '%Aberto%';
                "
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $aberto;
    }

    public function countStatusTratativa(): array
    {
        $tratativa = $this->pdo
            ->query(
                'SELECT COUNT(status) 
            AS quantidade_tratativa 
            FROM chamados 
            WHERE status LIKE "%Tratativa%" ;'
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $tratativa;
    }

    public function countStatusFechado(): array
    {
        $fechado = $this->pdo
            ->query(
                'SELECT COUNT(status) 
            AS quantidade_fechado 
            FROM chamados 
            WHERE status LIKE "%Fechado%" ;'
            )
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $fechado;
    }

    public function updateAnexoOcorrencia(ChamadoModel $anexoOcorrencia, int $idOcorrencia): bool
    {
        $query = "UPDATE chamados
                SET
                anexo = :anexo
            WHERE id = :id
        ";

        $statement = $this->pdo->prepare($query);
        $statement = $statement->execute([
            "anexo" => $anexoOcorrencia->getAnexo(),
            "id" => $idOcorrencia
        ]);

        if ($statement) {
            return true;
        } else {
            return false;
        }
    }


    public function updateAvaliacao(ChamadoModel $avaliacao)
    {


        $statement = $this->pdo
            ->prepare("UPDATE chamados SET 
                      avaliacao = :avaliacao,
                      data_fechamento = current_timestamp
                      WHERE
                        id = :id
                                
         ;");



        $statement->execute([
            'id' => $avaliacao->getId(),
            'avaliacao' => $avaliacao->getAvaliacao(),

        ]);
        return $statement;
    }


    public function updateAnexo(ChamadoModel $anexoOcorrencia): bool
    {
        $query = "UPDATE chamados
                SET
                anexo = :anexo
            WHERE id = :id
        ";

        $statement = $this->pdo->prepare($query);
        $statement = $statement->execute([
            "anexo" => $anexoOcorrencia->getAnexo(),
            "id" => $anexoOcorrencia->getId(),
        ]);

        if ($statement) {
            return true;
        } else {
            return false;
        }
    }

}
