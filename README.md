# tjustb-edusys

北京科技大学天津学院教务系统客户端（http://61.181.145.1:89/jsxsd/）


# Requirement

-   PHP >= 7.4

# Installation

```shell
$ composer require "airmole/tjustb-edusys"
```

# Usage

```php
use Airmole\TjustbEdusys\Edusys;

$usercode = '123456789'; // 系统账号
$password = '*********'; // 系统密码
$edusys = new Edusys();
$edusys->autoLogin($usercode, $password);
$profile = $edusys->profile();
$edusys->logout();
print_r($profile);
```

