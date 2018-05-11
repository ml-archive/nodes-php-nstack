<?php

namespace Nodes\NStack\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Push.
 */
class NStack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @static
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nodes.nstack';
    }
}
