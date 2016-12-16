<?php

/**
 * Eine Helperklasse
 * User: Anwender
 * Date: 13.12.2016
 * Time: 10:39
 */

class Database {


    private $mysqliObj; // mysqli object
    // sql connection data
    private $DBhost = 'localhost';
    private $DBuser = 'root';
    private $DBpassword = '';
    private $DBname = 'journey';

    /**
     * Singelton Teil
     *
     * @return Database
     */
    static private $instance = null;

    static public function getDB() {
        if (null === self::$instance) {
            self::$instance = new database();
        }
        return self::$instance;
    }

    /**
     * Privater Konstruktor, damit diese Klasse nur über den Singelton instanziert werden kann
     */
    private function __construct() {
        //mit der DB konnektieren
        $this->mysqliObj = new mysqli($this->DBhost, $this->DBuser, $this->DBpassword);
        $this->mysqliObj->set_charset('UTF_8');
        if ($this->mysqliObj->select_db($this->DBname) === FALSE) {
            include_once('initialize/init_db.php');
        }
    }

    public function __destruct() {
        $this->mysqliObj->close();
    }

    /**
     * @param $sqlstr
     * @return array|bool|mixed
     */
    public function query($sqlstr) {
        $db_array = [];
        if (!empty($sqlstr)) {
            $result = $this->mysqliObj->query($sqlstr);
            $this->mysqliObj->next_result();
            if (is_object($result)) {
                while ($row = $result->fetch_assoc()) {
                    $db_array[] = $row;
                }
                mysqli_free_result($result);
                return $db_array;
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param $values
     * @param $where
     * @return bool|mixed
     */
    public function update($table, $values, $where = 'true') {
        if (!empty($table) && is_array($values)) {
            $sqlstr = 'UPDATE ' . $table . ' SET ';
            foreach ($values as $row => $value) {
                $sqlstr .= $row . '=\'' . $value . '\', ';
            }
            $sqlstr = trim($sqlstr, ', ');
            $sqlstr .= 'WHERE ' . $where;
            $result = $this->mysqliObj->query($sqlstr);
            if ($result === TRUE) {
                return $this->mysqliObj->insert_id;
            }
        }
        return false;
    }

    /**
     * @param $sqlstr
     * @return bool
     */
    public function delete($sqlstr) {
        if (!empty($sqlstr)) {
            $result = $this->mysqliObj->query($sqlstr);
            if ($result === TRUE) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param $values
     * @return bool
     */
    public function insert($table, $values) {
        if (!empty($table) && (is_array($values) || is_object($values))) {
            // Das SQL-Statement zusammenbauen
            $sqlstr = 'INSERT INTO ' . $table . ' ';
            $rowstr = '(';
            $valuestr = '(';
            foreach ($values as $row => $value) {
                $rowstr .= $row . ',';
                $valuestr .= '\'' . $value . '\',';
            }
            $sqlstr .= trim($rowstr, ",") . ') VALUES ';
            $sqlstr .= trim($valuestr, ",") . ');';
            $result = $this->mysqliObj->query($sqlstr);
            if ($result === TRUE) {
                return true;
            }
        }
        return false;
    }


}
