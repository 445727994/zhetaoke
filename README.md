<h1 align="center">折淘客 SDK for PHP</h1>

基于 [折淘客开放平台](http://www.zhetaoke.com) 的 PHP 淘宝客组件

## 特点
- 封装了各种细节，你无需关注细节就可愉快地写代码了
- 已集成 [其它优惠券获取](http://www.zhetaoke.com/user/open/open_activity_id.aspx) ，无需额外处理
- 已对相应参数进行 Urlencode 编码，无需额外处理
- 已对返回结果格式化，你无需处理

## 安装

```shell
$ composer require levelooy/zhetaoke -vvv
```

## 配置

在使用本扩展之前，你需要去 [折淘客开放平台](http://www.zhetaoke.com/user/open/open_default.html) 注册账户，[获取 Appkey](http://www.zhetaoke.com/user/open/open_appkey.aspx)，并对淘宝客账号 [授权](http://www.zhetaoke.com/user/shouquan.html) 以获取 sid

## 使用

```php
<?php
use Levelooy\Zhetaoke\Application;

require __DIR__.'/vendor/autoload.php';

$options = [
    'app_key' => 'ac3d46dt3o4tt77a***',
    'sid' => '10',
];

$app = new Application($options);
```

### 智能高佣转链

- 只需一行代码搞定 N 个需求
- 可以传入: 商品编号/淘口令/带淘口令的文案/各种链接/喵口令
- 返回: 商品详情、最大佣金比例、转链后的淘口令、二合一链接、商品链接（长链接）、短链接

```php

$app->tool->smartConvert('商品编号/淘口令/带淘口令的文案/各种链接/喵口令', '要关联的淘宝客 Pid');

```

### 订单查询

- 对应开放平台 [订单查询API](http://www.zhetaoke.com/user/open/open_dingdanchaxun.aspx)

```php

// 查询从 2019-02-02 00:00:00 开始，1200 秒内创建的订单
$app->tool->ordersByCreateAt('2019-02-02 00:00:00', '1200');

// 查询从 2019-02-02 00:00:00 开始，1200 秒内结算的订单
$app->tool->ordersByCompleteAt('2019-02-02 00:00:00', '1200');

```

### 商品库
- 一行代码搞定所有商品库需求
- 所有查询条件支持链式操作，支持任意顺序
- 对应开放平台 [领券API](http://www.zhetaoke.com/user/extend/extend_lingquan_default.aspx)

```php

// 获取站内所有商品（第 2 页）
$app->good->list(2);

// 按分类获取站内商品：女装、第 3 页
$app->good->category(1)->list(3);

// 排序，支持'new', 'sale_num', 'commission_rate_asc', 'commission_rate_desc', 'price_asc', 'price_desc'
// 女装、按照总销量从大到小排序、第 1 页
$app->good->category(1)->sort('sale_num')->list(1);

// 每页显示 30 条
$app->good->category(1)->sort('sale_num')->pageSize(30)->list(1);

// 关键字（内衣）
$app->good->category(1)->keyword('内衣')->sort('sale_num')->pageSize(30)->list(1);

// 只显示天猫商品
$app->good->tmall()->category(1)->keyword('内衣')->sort('sale_num')->pageSize(30)->list(1);

// 金牌卖家商品
$app->good->goldSeller()->list(1);

// 淘抢购商品
$app->good->taoQiangGou()->list(1);

// 聚划算商品
$app->good->juHuaSuan()->list(1);

// 海淘商品
$app->good->haiTao()->list(1);

// 极有家商品
$app->good->jiYouJia()->list(1);

// 今日商品
$app->good->today()->list(1);

// 精选品牌商品
$app->good->brand()->list(1);

// 9.9 元商品
$app->good->price(0, 9.9)->list(1);

// 19.9 元商品
$app->good->price(0, 19.9)->list(1);

// 100 元到 199 元商品
$app->good->price(100, 199)->list(1);

// 高佣商品（佣金比例大于 40%）
$app->good->commission(40)->list(1);

// 高销量商品（销量大于 100000）
$app->good->volume(100000)->list(1);

// 高评分商品（评分大于 4.9）
$app->good->score(4.9)->list(1);

// 大额券商品（优惠券金额大于 200 元）
$app->good->couponAmount(200)->list(1);

// 两小时销量榜
$app->good->top('2hours')->sort('sale_num')->price(0, 19.9)->list(1);

// 24 小时销量榜
$app->good->top('1day')->sort('new')->score(4.9)->list(1);

// 实时人气榜
$app->good->top('now')->sort('new')->score(4.9)->list(1);

// 咚咚抢商品
$app->good->top('ddq')->sort('new')->score(4.9)->list(1);

```

---
> <font color=#0099ff size=5 face="黑体">一般情况下，以上接口就够用了，如果要单独调用，请继续往下看。。。</font>
---

### 站内商品详情

- 对应开放平台 [单品详情API接口](http://www.zhetaoke.com/user/extend/extend_lingquan_detail.aspx)

```php

$app->good->item('商品 ID');

```

### 对淘口令或者带淘口令的文案高佣转链

- 支持￥TdJCbN68klT￥、TdJCbN68klT、(TdJCbN68klT)、€TdJCbN68klT€、💰TdJCbN68klT💰等格式。
- 对应开放平台 [高佣转链API（淘口令）](http://www.zhetaoke.com/user/open/open_gaoyongzhuanlian_tkl.aspx)

```php

$app->tool->convertTpwd('要转链的淘口令或者带淘口令的文案', '要关联的淘宝客 Pid');

```

> 可以传第三个参数为 true，将同时返回额外的信息，包括创建淘口令、短地址、商品详情（全网）

### 对商品 ID 进行高佣转链

- 对应开放平台 [高佣转链API（商品ID）](http://www.zhetaoke.com/user/open/open_gaoyongzhuanlian.aspx)

```php

$app->tool->convertGoodId('商品 ID', '要关联的淘宝客 Pid');

```

> 可以传第三个参数为 true，将同时返回额外的信息，包括创建淘口令、短地址、商品详情（全网）

### 解析出商品 ID

- 对应开放平台 [解析商品编号API](http://www.zhetaoke.com/user/open/open_shangpin_id.aspx)
- 支持从淘口令、淘口令文案、长链接、二合一链接、短链接、喵口令中解析出商品 ID

```php

$app->tool->parseGoodId('需解析的内容');

```

### 解析获取其他优惠券

- 对应开放平台 [其它优惠券获取API](http://www.zhetaoke.com/user/open/open_activity_id.aspx)
- 支持从淘口令文案、二合一链接、长链接、短链接中解析出使用的其它优惠券编号

```php

$app->tool->parseActivityId('需解析的内容');

```

### 生成淘口令

- 对应开放平台 [淘口令生成API](http://www.zhetaoke.com/user/open/open_tkl_create.aspx)
- 支持二合一链接、长链接、短链接等各种淘宝高佣链接，必须以 https 开头

```php

$app->tool->createTpwd($title, $url, $logo);

```

### 全网商品详情（简版）

- 对应开放平台 [全网商品详情API（简版）](http://www.zhetaoke.com/user/open/open_item_info.aspx)
- 支持从淘口令文案、二合一链接、长链接、短链接中解析出使用的其它优惠券编号

```php

$app->tool->detail('商品编号');

```

### 生成短链接

- 对应开放平台 [新浪短链转换API](http://www.zhetaoke.com/user/open/open_shorturl_sina_get.aspx) 和 [百度短链转换API](http://www.zhetaoke.com/user/open/open_shorturl_baidu_get.aspx)

```php

$app->tool->shortUrl($url, 'sina');
$app->tool->shortUrl($url, 'baidu');

```

## 在 Laravel 中的使用

### 配置

1. 在 `config/app.php` 注册 ServiceProvider 和 Facade (Laravel 5.5 无需手动注册)

```php
'providers' => [
    // ...
    Levelooy\Zhetaoke\ServiceProviderForLaravel::class,
],
'aliases' => [
    // ...
    'Zhetaoke' => Levelooy\Zhetaoke\Facade::class,
],
```

2. 创建配置文件：

```shell
php artisan vendor:publish --tag="zhetaoke"
```

3. 修改应用根目录下的 `config/zhetaoke.php` 中对应的参数即可。

4. 支持多账号，默认为 `default`。

### 使用

```php
// 使用默认配置
app('zhetaoke')->tool->smartConvert('商品编号/淘口令/带淘口令的文案/各种链接/喵口令', '要关联的淘宝客 Pid');
// 使用 account1 的配置
app('zhetaoke.account1')->tool->smartConvert('商品编号/淘口令/带淘口令的文案/各种链接/喵口令', '要关联的淘宝客 Pid');
// 还可以使用外观
Zhetaoke::good()->list();
Zhetaoke::good('account1')->list();
```

## 打赏我？

感谢大家的支持，无论是 star 或者 donate，本人都衷心的感谢各位！

打赏时请记得备注上你的 github 账号或者其他链接，谢谢支持！

![image](//wx3.sinaimg.cn/wap720/0061xUcrly1g0kw49vd4zj30tz14qgo8.jpg)
![image](//wx3.sinaimg.cn/wap720/0061xUcrly1g0kw49z67mj30go0p075i.jpg)

## License

MIT