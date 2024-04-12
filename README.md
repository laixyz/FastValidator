# FastValidator
The php Validation classes are based on Respect\Validation
## 单参数Example
```php
$result = FastValidator::stringVal("lai", [
    'rule'    => 'string',
    'require' => true,
    'length'  => [3, 30],
    'regex'   => '/^[a-z0-9]{1}[a-z0-9@\.]+$/',
    'name'    => '用户名',
    'msg'     => '{{name}} 必须由字母、数字、@、.组成，长度限制为3到30个字符串!'
]);
```
#### 以上示例以 json 会输出:
```json
{
    "ok": true,
    "error": null,
    "val": "lai"
}
```
### 单参数实例 2 :
```php
FastValidator::Validator("laixyz", ['rule' => 'email']);
```
#### 以上示例以 json 会输出
```json
{
    "ok": false,
    "error": "All of the required rules must pass for \"\"",
    "val": ""
}
```
### 多参数实例
```php
$values = [
    'user'     => 'necylus@126.com',
    'password' => 'abcd',
    'email'    => 'ok'
];
$rules  = [
    'user'     => [
        'rule'    => 'string',
        'require' => true,
        'length'  => [3, 30],
        'regex'   => '/^[a-z0-9]{1}[a-z0-9@\.]+$/',
        'name'    => '用户名',
        'msg'     => '{{name}} 必须由字母、数字、@、.组成，长度限制为3到30个字符串!'
    ],
    'password' => [
        'rule'    => 'string',
        'require' => true,
        'length'  => [6, 32],
        'name'    => '密码',
        'msg'     => '{{name}} 的长度限制为6到32个字符串!'
    ],
    'email'    => [
        'rule' => 'email',
        'name' => 'email'
    ],
    'gender'   => [
        'rule'    => 'int',
        'in'      => [0, 1, 2],
        'require' => true
    ]
];
$result = FastValidator::ValidatorAll($values, $rules);
```
#### 以上示例以 json 会输出：
```json
{
    "password": {
        "ok": false,
        "error": "密码 的长度限制为6到32个字符串!",
        "val": "abcd"
    },
    "email": {
        "ok": false,
        "error": "All of the required rules must pass for email",
        "val": "ok"
    },
    "gender": {
        "ok": false,
        "error": "All of the required rules must pass for gender",
        "val": null
    }
}
```
