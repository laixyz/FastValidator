<?php
/**
 * This file is part of FastValidator for PHP 8.3.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
declare(strict_types=1);

use Laixyz\FastValidator\FastValidator as v;

error_reporting(E_ALL);
require "../vendor/autoload.php";

function jsonPrint(mixed $val): void {
    echo json_encode($val, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}


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

$result = v::stringVal("lai", [
    'rule'    => 'string',
    'require' => true,
    'length'  => [3, 30],
    'regex'   => '/^[a-z0-9]{1}[a-z0-9@\.]+$/',
    'name'    => '用户名',
    'msg'     => '{{name}} 必须由字母、数字、@、.组成，长度限制为3到30个字符串!'
]);
jsonPrint($result);
$result = v::ValidatorAll($values, $rules);
jsonPrint($result);
$result = v::Validator("laixyz", ['rule' => 'email']);
jsonPrint($result);