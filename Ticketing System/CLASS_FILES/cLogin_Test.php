<?php
    require_once("global_lib.php");
    require_once("cDatabase_Connection.php");
    session_start();
class cLogin_Test {
    private $username = "";
    private $password = "";
    public function setVar($i_Username, $i_Password)
    {
        $this->username = $i_Username;
        $this->password = $i_Password;
    }
    public function checkPriv()
    {
        $dbConnection = new cDatabase_Connection();
        $AgentID = $_SESSION['agentID'];
        $sql = "select P.fld_id_privilige from tbl_privilige P, tbl_agent A where A.fld_fk_id_privilige = P.fld_id_privilige and A.fld_id_agent = $AgentID";
        foreach ($dbConnection->getfromDB($sql) as $row)
        {
            if ($row['fld_id_privilige'] > 1)
            {
                return header("location:dashboard.php");
            }else
            {
                return null;
            }
        }
        return die("no user found, sql error");
    }
    public function login_test()
    {
        $dbConnection = new cDatabase_Connection();
        try
        {
            $sql = 'select fld_password_salt from tbl_agent where fld_username = ' . $this->username . '';
            foreach ($dbConnection->oConn()->query($sql) as $row)
            {
                $salt = $row['fld_password_salt'];

            }
            $sql = 'select fld_id_agent from tbl_agent where fld_username = "'.$this->username .'" AND fld_password = "' . hashPassword($this->password, $salt) . '"';
            foreach ($dbConnection->oConn()->query($sql) as $row)
            {
                $_SESSION['agentID'] = $row['fld_id_agent'];
                return true;
            }
            return false;
        }
        catch (PDOException $oException) {
            return false;
        }
    }
    public function checkLogin(){
        if (!isset($_SESSION['agentID'])) {
           return header("location:index.php");
        }
        return false;
    }
}