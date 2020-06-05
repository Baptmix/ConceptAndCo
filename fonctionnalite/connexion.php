<?php

/**
 * Class connexion
 */
class connexion
{
    /**
     * @var PDO
     */
    public $dbco;
    public $servname;
    public $dbname;
    public $user;
    public $pass;

    /**
     * connexion constructor.
     * @param $servname
     * @param $dbname
     * @param $user
     * @param $pass
     */
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

$dbco = new connexion("localhost", "ppedev", "root", "");