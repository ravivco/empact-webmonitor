<?php
/**
 * Created by PhpStorm.
 * User: DevTeam5
 * Date: 2020-02-10
 * Time: 03:21
 */

namespace Empact\WebMonitor\Clients;


class BaseClient
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;
    
    public $query_params;

    /**
     * @return array
     */
    protected function getQueryParams()
    {
        return $this->query_params;
    }

    /**
     * @param array $query_params
     */
    protected function setQueryParams($query_params): void
    {
        $this->resetQueryParams();
        $this->query_params = $query_params;
    }

    protected function resetQueryParams()
    {
        unset($this->query_params);
    }

    /**
     * @param string $param
     * @return mixed|null
     */
    public function getQueryParam(string $param)
    {
        if (!empty($param) && isset($this->getQueryParams()[$param])) {
            return $this->getQueryParams()[$param];
        }

        return null;
    }

    /**
     * @param array $query
     * @return array
     */
    protected function extractQueryParams(array $query)
    {
        $query_params = [];
        
        foreach ($query as $key => $value) {
            if (in_array($key, $this->allowed_query_params)) {
                $query_params[$key] = $value;
            }
        }
        
        return $query_params;
    }

    /**
     * @param array $query
     */
    public function init(array $query)
    {
        $this->setQueryParams($this->extractQueryParams($query));
    }
}