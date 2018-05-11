<?php

if (! function_exists('nstack')) {
    /**
     * nstack
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @return \Nodes\NStack\Providers\NStackProvider
     */
    function nstack() : \Nodes\NStack\Providers\NStackProvider
    {
        return app('nodes.nstack');
    }
}
