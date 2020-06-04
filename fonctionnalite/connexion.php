<?php

class connexion
{
    public $dbco;
    public $servname;
    public $dbname;
    public $user;
    public $pass;

    public function __construct($servname, $dbname, $user, $pass)
    {
        $this->servname = $servname;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
        $this->dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->dbco;
    }
}

?>