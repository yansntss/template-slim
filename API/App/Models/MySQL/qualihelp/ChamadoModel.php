<?php


namespace App\Models\MySQL\qualihelp;

final class ChamadoModel
{
    /**
     * @var int
     */
    private $id;

    /** @var string  */
    private $motivo;

    /** @var string  */
    private $assunto;

    /** @var string  */
    private $solicitacao;

    /** @var string  */
    private $textarea;

    // /** @var string  */
    // private $nome_arquivo;

    private $data_criacao;

    /** @var string  */
    private $status;

    /** @var int  */
    private $protocolo;

    /** @var int  */
    private $avaliacao;

    /** @var string  */
    private $matricula_usuario;

    /** @var string  */
    private $anexo;

    /** @var string  */
    private $tratativa;

    
    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId(int $id): ChamadoModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of motivo
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set the value of motivo
     *
     * @return  self
     */
    public function setMotivo(string $motivo): ChamadoModel
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get the value of solicitacao
     */
    public function getSolicitacao()
    {
        return $this->solicitacao;
    }

    /**
     * Set the value of solicitacao
     *
     * @return  self
     */
    public function setSolicitacao(string $solicitacao): ChamadoModel
    {
        $this->solicitacao = $solicitacao;

        return $this;
    }

    /**
     * Get the value of textarea
     */
    public function getTextarea()
    {
        return $this->textarea;
    }

    /**
     * Set the value of textarea
     *
     * @return  self
     */
    public function setTextarea(string $textarea): ChamadoModel
    {
        $this->textarea = $textarea;

        return $this;
    }

 

    /**
     * Get the value of data_criacao
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * Set the value of data_criacao
     *
     * @return  self
     */
    public function setDataCriacao($data_criacao): ChamadoModel
    {
        $this->data_criacao = $data_criacao;

        return $this;
    }

    /**
     * Get the value of protocolo
     */
    public function getProtocolo()
    {
        return $this->protocolo;
    }

    /**
     * Set the value of protocolo
     *
     * @return  self
     */
    public function setProtocolo($protocolo): ChamadoModel
    {
        $this->protocolo = $protocolo;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status): ChamadoModel
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of assunto
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * Set the value of assunto
     *
     * @return  self
     */
    public function setAssunto($assunto): ChamadoModel
    {
        $this->assunto = $assunto;

        return $this;
    }

    /**
     * Get the value of matriculaUsuario
     */
    public function getMatricula_usuario()
    {
        return $this->matricula_usuario;
    }

    /**
     * Set the value of matriculaUsuario
     *
     * @return  self
     */
    public function setMatricula_usuario($matricula_usuario): ChamadoModel
    {
        $this->matricula_usuario = $matricula_usuario;

        return $this;
    }

    /**
     * Get the value of anexo
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Set the value of anexo
     *
     * @return  self
     */
    public function setAnexo($anexo): ChamadoModel
    {
        $this->anexo = $anexo;

        return $this;
    }
    /**
     * Get the value of anexo
     */
    public function getAvaliacao()
    {
        return $this->avaliacao;
    }

    /**
     * Set the value of avaliacao
     *
     * @return  self
     */
    public function setAvaliacao($avaliacao): ChamadoModel
    {
        $this->avaliacao = $avaliacao;

        return $this;
    }
    /**
     * Get the value of tratativa,,,
     */
    public function getTratativa()
    {
        return $this->tratativa;
    }

    /**
     * Set the value of tratativa
     *
     * @return  self
     */
    public function setTratativa($tratativa): ChamadoModel
    {
        $this->tratativa = $tratativa;

        return $this;
    }
}
