<?php

namespace Nodes\NStack\Clients;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 *
 * @package Riide\Services\NStack
 */
class Client extends GuzzleClient
{
    /**
     * Client constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param string $appId
     * @param string $restKey
     */
    public function __construct(string $appId, string $restKey)
    {
        parent::__construct([
            'base_uri' => 'https://nstack.io/api/v1/',
            'headers' => [
                'X-Application-Id' => $appId,
                'X-Rest-Api-Key'   => $restKey,
            ],
        ]);
    }
}