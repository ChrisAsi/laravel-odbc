<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 20/02/2018
 * Time: 15:45
 */

namespace Abram\Odbc;

use Illuminate\Database\Connection;

class ODBCConnection extends Connection
{
    function getDefaultQueryGrammar()
    {
        $queryGrammar = $this->getConfig('options.grammar.query');
        if ($queryGrammar)
            return new $queryGrammar;
        return parent::getDefaultQueryGrammar();
    }

    function getDefaultSchemaGrammar()
    {
        $schemaGrammar = $this->getConfig('options.grammar.schema');
        if ($schemaGrammar)
            return new $schemaGrammar;
        return parent::getDefaultSchemaGrammar();
    }

    /**
     * Get the default post processor instance.
     *
     * @return ODBCProcessor
     */


    protected function getDefaultPostProcessor()
    {
        $processor = $this->getConfig('options.processor');
        if ($processor)
            return new $processor;
        return new ODBCProcessor;
    }
    
    public function beginTransaction()
    {
        odbc_autocommit($this->getPdo()->getConnection(), FALSE);
    }
    
    public function rollBack($toLevel=null)
    {
        odbc_rollback($this->getPdo()->getConnection());
        odbc_autocommit($this->getPdo()->getConnection(), TRUE);
    }
    
    public function commit()
    {
        odbc_commit($this->getPdo()->getConnection());
        odbc_autocommit($this->getPdo()->getConnection(), TRUE);
    }
}