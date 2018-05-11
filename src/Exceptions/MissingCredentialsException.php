<?php

namespace Nodes\NStack\Exceptions;

use Nodes\Exceptions\Exception as NodesException;

/**
 * Class MissingCredentialsException
 *
 * @package Nodes\NStack\Exceptions
 */
class MissingCredentialsException extends NodesException
{
    /**
     * MissingCredentialsException constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, 500);
    }
}
