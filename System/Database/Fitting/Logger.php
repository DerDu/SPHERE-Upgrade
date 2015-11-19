<?php
namespace SPHERE\System\Database\Fitting;

use Doctrine\DBAL\Logging\SQLLogger;
use SPHERE\System\Debugger\DebuggerFactory;
use SPHERE\System\Debugger\Logger\BenchmarkLogger;

/**
 * Class Logger
 * @package SPHERE\System\Database\Fitting
 */
class Logger implements SQLLogger
{
    /** @var array $Data */
    private $Data = array();

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param array|null $params The SQL parameters.
     * @param array|null $types The SQL parameter types.
     *
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {

        $this->Data = func_get_args();

        (new DebuggerFactory())->createLogger(new BenchmarkLogger())
            ->addLog('Parameter: ' . print_r($params, true))
            ->addLog('Types: ' . print_r($types, true))
            ->addLog('Query: ' . highlight_string($sql, true));
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery()
    {

        (new DebuggerFactory())->createLogger(new BenchmarkLogger())->addLog('Query finished');
    }
}
