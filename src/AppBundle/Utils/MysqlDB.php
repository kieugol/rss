<?php
Namespace AppBundle\Utils;

/**
 *  Using for query builder that the user wants to customize query string
 */
class MysqlDB
{

    private $sql;
    private $mysql;
    private $result;
    private $database_name;

    /**
     * Database() constructor
     *
     * @param string $database_name
     * @param string $username
     * @param string $password
     * @param string $host
     * @throws Exception
     */
    function __construct($database_name, $username, $password, $host = 'localhost')
    {

        $this->database_name = $database_name;
        $this->mysql = mysqli_connect($host, $username, $password, $database_name);

        if (!$this->mysql) {
            throw new \Exception('Database connection error: ' . mysqli_connect_error());
        }
    }

    /**
     * Helper for throwing exceptions
     *
     * @param $error
     * @throws Exception
     */
    private function _error($error)
    {
        throw new \Exception('Database error: ' . $error);
    }

    /**
     * Get last executed query
     *
     * @return string|null
     */
    public function sql()
    {
        return $this->sql;
    }

    /**
     * Insert a row in a table
     *
     * @param $table
     * @param array $fields
     * @param bool|false $appendix
     * @param bool|false $ret
     * @return bool|Database
     * @throws Exception
     */
    function insertMulti($table_name, $column_names, $rows, $escape = true)
    {
        $this->result = null;
        $this->sql = null;

        //Build a list of column names
        $columns    = array_walk($column_names, [$this, 'prepareColumnName']);
        $columns    = implode(',', $column_names);

        // Escape each value of the array for insertion into the SQL string
        if($escape) {
            array_walk_recursive($rows, [$this, 'escapeValue']);
        }
        
        // Collapse each rows of values into a single string
        $length = count($rows);
        for($i = 0; $i < $length; $i++) {
            $rows[$i] = implode(',', $rows[$i]);
        }

        // Collapse all the rows
        $values = "(" . implode( '),(', $rows ) . ")";

        $this->sql = "INSERT INTO $table_name ( $columns ) VALUES $values";
        $this->result = mysqli_query($this->mysql, $this->sql);
        if (mysqli_error($this->mysql) != '') {
            $this->_error(mysqli_error($this->mysql));
            $this->result = null;
            return false;
        } else {
            return true;
        }
    }

    /**
     * [escapeValue description]
     * @param  [type] &$value [description]
     * @return [type]         [description]
     */
    function escapeValue(&$value)
    {
        if (is_string($value)){
            $value = "'" . mysqli_real_escape_string($this->mysql, $value) . "'";
        }
    }

    /**
     * [prepareColumnName description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    function prepareColumnName(&$name)
    {
        $name = "`$name`";
    }

    /**
     * Get the last error message
     *
     * @return string
     */
    public function error()
    {
        return mysqli_error($this->mysql);
    }
}