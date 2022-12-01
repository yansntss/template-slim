<?php
namespace App\Models\MySQL\qualihelp;

final class LoginModel{
   
    private $login;
    private $data_acesso;
    private $id_acesso;


    /**
     * Get the value of login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of data_acesso
     */
    public function getDataAcesso()
    {
        return $this->data_acesso;
    }

    /**
     * Set the value of data_acesso
     *
     * @return  self
     */
    public function setDataAcesso($data_acesso)
    {
        $this->data_acesso = $data_acesso;

        return $this;
    }

    /**
     * Get the value of id_acesso
     */
    public function getIdAcesso()
    {
        return $this->id_acesso;
    }
}