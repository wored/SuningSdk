<h1 align="center">苏宁开放接口SDK</h1>

## 安装

```shell
$ composer require wored/beibei-sdk -vvv
```

## 使用
```php
<?php
use \Wored\SuningSdk\SuningSdk;

$config = [
    'appKey'    => '****************',
    'appSecret' => '**********************',
    "rootUrl"   => 'https://open.suning.com',
];
//苏宁SDK
$suning = new SuningSdk($config);
//获取物流
$ret = $suning->request('suning.custom.logisticcompany.query',[
    "logisticCompany" => [
       'pageSize' => 10,
       'pageNo'   => 1
    ]
]);
```
## License

MIT