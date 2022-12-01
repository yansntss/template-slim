<?php


namespace App\Models\MySQL\qualihelp;

final class EmailModel
{
    /**
     * @var int
     */
    private $email;

    /** @var string  */
    private $senha;
    
    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }   

     /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    /**
     * Get the value of email
     */
    public function getSenha()
    {
        return $this->senha;
    }   

     /**
     * Set the value of senha
     *
     * @return  self
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }


}