<?php

namespace Wored\SuningSdk;

use Hanson\Foundation\AbstractAPI;
use Hanson\Foundation\Http;
use Hanson\Foundation\Log;

class Api extends AbstractAPI
{
    public $config;
    public $timestamp;

    /**
     * Api constructor.
     * @param $appkey
     * @param $appsecret
     * @param $sid
     * @param $baseUrl
     */
    public function __construct(SuningSdk $suningSdk)
    {
        $this->config = $suningSdk->getConfig();
    }


    /**
     * api请求方法
     * @param $method域名后链接
     * @param $params账后相关参数以外请求参数
     * @return mixed
     * @throws \Exception
     */
    public function request(string $appMethod, array $params = [])
    {
        $request = [
            'appMethod'      => $appMethod,
            'appRequestTime' => date('Y-m-d H:i:s'),
            'format'         => 'json',
            'appKey'         => $this->config['appKey'],
            'versionNo'      => 'v1.2',
        ];
        $params = [
            'sn_request' => [
                'sn_body' => $params
            ]
        ];
        $request['signInfo'] = $this->sign($request, $params);
        $url = $this->config['rootUrl'] . '/api/http/sopRequest/' . $appMethod;

        $http = new Http();
        $http->setDefaultOptions([
            'curl' => [
                CURLOPT_HTTPHEADER => $this->headers($request)
            ]
        ]);
        $ret = $http->json($url, $params);
        return json_decode(strval($ret->getBody()), true);
    }

    /**
     * 设置请求头
     * @param $request
     * @return array
     */
    public function headers($request)
    {
        $headers = [
            'Content-type: application/json'
        ];
        foreach ($request as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $headers;
    }

    /**
     * 生成签名
     * @param array $params请求的所有参数
     * @return string
     */
    public function sign(array $request, array $params)
    {
        $str = $this->config['appSecret'] . $request['appMethod'] . $request['appRequestTime'] . $request['appKey'] . $request['versionNo'] . base64_encode(json_encode($params));
        return md5($str);
    }
}