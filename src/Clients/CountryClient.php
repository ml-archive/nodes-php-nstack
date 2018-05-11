<?php

namespace Nodes\NStack;

/**
 * Class CountryClient
 *
 * @package Riide\Services\NStack
 */
class CountryClient extends Client
{
    protected $slug = '';

    /**
     * getInstance
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @static
     * @access public
     * @return \Riide\Services\NStack\CountryClient
     */
    public static function getInstance() : CountryClient
    {
        if (!self::$instance) {
            self::$instance = new CountryClient();
        }

        return self::$instance;
    }

    /**
     * getCountryCodes
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @return array
     */
    public function getCountryCodes() : array
    {
        // Check memory
        if ($this->countryCodes) {
            return $this->countryCodes;
        }

        // Check cache
        if ($this->countryCodes = cache_get('nstack.countryCodes')) {
            return $this->countryCodes;
        }

        // Look up again
        $response = $this->getClient()->get($this->getFullUrl());

        $data =  json_decode($response->getBody()->getContents(), true);;

        // Parse
        $this->countryCodes = [];
        foreach ($data['data'] as $phoneArr) {
            if (!empty($phoneArr['phone'])) {
                $this->countryCodes[] = $phoneArr['phone'];
            }
        }

        // Cache
        cache_put('nstack.countryCodes', [], $this->countryCodes);

        return $this->countryCodes;
    }
}