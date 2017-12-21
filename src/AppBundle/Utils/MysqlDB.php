<?php
Namespace AppBundle\Utils;

/**
 *  Using for query builder that the user wants to customize query string
 */
class MysqlDB
{

    private $sql;
    private $mysql;
    private $database_name;

    /**
     * Database() constructor
     *
     * @param string  $database_name  database name
     * @param string  $username       user name
     * @param string  $password       passsword
     * @param string  $host           ip/hostname
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
     * Get last executed query
     *
     * @return string|null
     */
    public function sql()
    {
        return $this->sql;
    }

    /**
     * Insert multiple rows into DB
     *
     * @param  string   $table_name    the table name
     * @param  array    $column_names  array column name will insert data
     * @param  array    $rows          array rows need to insert
     * @param  boolean  $escape        default escape string
     * @return boolean                 true if it's successful, otherwise is false
     */
    function insertMulti($table_name, $column_names, $rows, $escape = true)
    {
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

        // Execute query insert
        $this->sql = "INSERT INTO $table_name ( $columns ) VALUES $values";

        return mysqli_query($this->mysql, $this->sql);
    }

    /**
     * Escape the value to string
     *
     * @param  string  &$value  the value will be escaped
     * @return void
     */
    function escapeValue(&$value)
    {
        if (is_string($value)){
            $value = "'" . mysqli_real_escape_string($this->mysql, $value) . "'";
        }
    }

    /**
     * Building column name
     *
     * @param  string  $name  the name column
     * @return void
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
    public function getError()
    {
        return mysqli_error($this->mysql);
    }
}
