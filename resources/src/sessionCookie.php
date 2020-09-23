<?php
namespace Session;
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Redirect\Redirect;
use PDO_CONN\Connection;
class SessionCookie
{
    public $redirect;
    public $dbConn;
    public function __construct()
    {
        $this->redirect = new Redirect;
        session_start();
        if (isset($_SESSION['lastact']) and time() - $_SESSION['lastact'] > 9000) {
            $this->sessionClear();
            $this->redirect->phploc('index.php');
        } else $_SESSION['lastact'] = time();
        if (isset($_SESSION['uid'])) {
            $this->dbConn = new Connection;
            $row = $this->dbConn->exeQuery('select type from user where uname = ?',$_SESSION['uid']);
            if ($row[0]['type'] == 'admin') $_SESSION['admin'] = $_SESSION['uid'];
        }
    }
    public function rememberMe()
    {
        $keygen = bin2hex(random_bytes(mt_rand(5, 10))) . $_SESSION['uid'] . bin2hex(random_bytes(mt_rand(1, 5)));
        $key = password_hash($keygen, PASSWORD_ARGON2ID);
        setcookie('remembering', $key, time() + 31556926);
        $this->dbConn->exeQuery('update user set remember=? where uname=?',$keygen, $_SESSION['uid']);
        unset($keygen);
    }
    public function sessionClear()
    {
        session_unset();
        session_destroy();
        setcookie("remembering", "", time() - 31556926);
        unset($_COOKIE['remembering']);
        session_start();
    }
    public function sessionCheck()
    {
        if (!isset($_SESSION['uid'])) $this->redirect->phploc('index.php');
    }
}