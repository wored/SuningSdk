<?php

namespace Wored\SuningSdk;


use Hanson\Foundation\Foundation;

/***
 * Class SuningSdk
 * @package \Wored\SuningSdk
 *
 * @property \Wored\SuningSdk\Api $api
 */
class SuningSdk extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    public function __construct($config)
    {
        $config['debug'] = $config['debug'] ?? false;
        parent::__construct($config);
    }

    public function request(string $appMethod, array $params=[])
    {
        return $this->api->request($appMethod, $params);
    }
}