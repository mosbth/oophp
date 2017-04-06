<?php
/**
 * Class to collect all database activities.
 */
class Database
{
    /** @var $pdo the PDO connection. */
    private $pdo;



    /**
     * Create a connection to the database.
     *
     * @param array $config details on how to connect.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD)
     */
    public function connect($config)
    {
        try {
            $this->pdo = new PDO(...array_values($config));
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Exception $e) {
            // Rethrow to hide connection details, through the original
            // exception to view all connection details.
            //throw $e;
            throw new PDOException("Could not connect to database, hiding details.");
        }
    }



    /**
     * Do SELECT with optional parameters and return a resultset.
     *
     * @param string $sql   statement to execute
     * @param array  $param to match ? in statement
     *
     * @return array with resultset
     */
    public function executeFetchAll($sql, $param = [])
    {
        $sth = $this->execute($sql, $param);
        $res = $sth->fetchAll();
        if ($res === false) {
            $this->statementException($sth, $sql, $param);
        }
        return $res;
    }



    /**
     * Do INSERT/UPDATE/DELETE with optional parameters.
     *
     * @param string $sql   statement to execute
     * @param array  $param to match ? in statement
     *
     * @return PDOStatement
     */
    public function execute($sql, $param = [])
    {
        $sth = $this->pdo->prepare($sql);
        if (!$sth) {
            $this->statementException($sth, $sql, $param);
        }

        $status = $sth->execute($param);
        if (!$status) {
            $this->statementException($sth, $sql, $param);
        }

        return $sth;
    }



    /**
     * Through exception with detailed message.
     *
     * @param PDOStatement $sth statement with error
     * @param string       $sql     statement to execute
     * @param array        $param   to match ? in statement
     *
     * @return void
     *
     * @throws Exception
     */
    public function statementException($sth, $sql, $param)
    {
        throw new Exception(
            $sth->errorInfo()[2]
            . "<br><br>SQL:<br><pre>$sql</pre><br>PARAMS:<br><pre>"
            . implode($param, "\n")
            . "</pre>"
        );
    }



    /**
     * Return last insert id from an INSERT.
     *
     * @return void
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
