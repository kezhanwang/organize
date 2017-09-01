# kezhanwang.cn Organize API PHP Client

这是 Kezhan Organize API 的 PHP 版本封装开发包，是由ke课栈网官方提供的，一般支持最新的 API 功能。

> 支持的 PHP 版本: 5.3.3 ～ 5.6.x, 7.0.x
## Installation

#### 使用 Composer 安装

- 在项目中的 `composer.json` 文件中添加 Organize 依赖：

```json
"require": {
    "kezhanwang/organize": "v1.0.*"
}
```

- 执行 `$ php composer.phar install` 或 `$ composer install` 进行安装。

#### 直接下载源码安装

> 直接下载源代码也是一种安装 SDK 的方法，不过因为有版本更新的维护问题，所以这种安装方式**十分不推荐**，但由于种种原因导致无法使用 Composer，所以我们也提供了这种情况下的备选方案。

- 下载源代码包，解压到项目中
- 在项目中引入 autoload：

```php
require 'path_to_sdk/autoload.php';
```

#### 初始化

```php
use Organize\Client as Organize;
...
...

    $client = new Organize($merchant, $signature, $data, $rsaPublicFile);

...
```

OR

```php
$client = new \Organize\Client($merchant, $signature, $data, $rsaPublicFile,);
```

#### 简单推送

```php
$client->push()
    ->setProduction()
    ->send();
```

#### 异常处理

```php
$pusher = $client->push();
$pusher->setProduction();
try {
    $pusher->send();
} catch (\Organize\Exceptions\OrganizeExceptions $e) {
    // try something else here
    print $e;
}
```

## Testing

```bash
# 编辑 tests/bootstrap.php 文件，填入必须的变量值
# OR 设置相应的环境变量

# 运行全部测试用例
$ composer tests

# 运行某一具体测试用例
$ composer tests/Organize/xxTest.php
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/kezhanwang/organize

## License

The library is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).
