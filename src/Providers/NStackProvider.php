<?php

declare(strict_types = 1);

namespace Nodes\NStack\Providers;

use Nodes\NStack\Clients\Client;

/**
 * Class UrbanAirship.
 */
class NStackProvider
{
    /**
     * @var \Nodes\NStack\Clients\Client
     */
    protected $client;

    /**
     * NStackProvider constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param string $appId
     * @param string $restKey
     */
    public function __construct(string $appId, string $restKey)
    {
        $this->client = new Client($appId, $restKey);
    }

    public function countries(): array {
        $response = $this->client->get('geographic/countries');

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    public function pushLog(){
        #$this->client->
    }
}
