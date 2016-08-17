<?php
namespace App\Lib;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;

// Source from http://dan.doezema.com/2015/08/php-debugbar-eloquent-collector/

class PHPDebugBarEloquentCollector extends PDOCollector
{
    private $capsule;

    public function __construct($capsule)
    {
        parent::__construct();
        $this->capsule = $capsule;
        $this->addConnection($this->getTraceablePdo(), 'Eloquent PDO');
    }

    /**
     * @return Illuminate\Database\Capsule\Manager;
     */
    protected function getEloquentCapsule() {
        return $this->capsule;
    }

    /**
     * @return PDO
     */
    protected function getEloquentPdo() {
        return $this->getEloquentCapsule()->getConnection()->getPdo();
    }

    /**
     * @return \DebugBar\DataCollector\PDO\TraceablePDO
     */
    protected function getTraceablePdo() {
        return new TraceablePDO($this->getEloquentPdo());
    }

    // Override
    public function getName() {
        return "eloquent_pdo";
    }

    // Override
    public function getWidgets()
    {
        return array(
            "eloquent" => array(
                "icon"    => "inbox",
                "widget"  => "PhpDebugBar.Widgets.SQLQueriesWidget",
                "map"     => "eloquent_pdo",
                "default" => "[]"
            ),
            "eloquent:badge" => array(
                "map"     => "eloquent_pdo.nb_statements",
                "default" => 0
            )
        );
    }
}
