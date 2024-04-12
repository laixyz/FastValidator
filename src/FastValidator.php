<?php
/**
 * This file is part of FastValidator for PHP 8.3.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
declare(strict_types=1);
namespace Laixyz\FastValidator;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

/**
 * @phpstan-type Value mixed
 * @phpstan-type Values array<string,mixed>
 * @phpstan-type Rule array<string,mixed|array<string,mixed>>
 * @phpstan-type Rules array<string, Rule>
 * @phpstan-type Return array<string, null|boolean|string|mixed>
 * @phpstan-type Returns array<string, Return>
 */
class FastValidator {
    public static function create(): self {
        return new self();
    }

    /**
     * @param Value $value
     * @param Rule  $rule
     *
     * @return Return
     */
    public static function Validator(mixed $value, array $rule): array {
        $ruleClass = 'string';
        switch($rule['rule']){
            case 'string':
            case 'int':
            case 'array':
            case 'false':
            case 'float':
            case 'numeric':
            case 'scalar':
            case 'true':
            case 'bool':
                $ruleClass = $rule['rule'] . 'Val';
                break;
            default:
                if(is_string($rule['rule']))
                    $ruleClass = $rule['rule'];
        }

        return self::create()->validate($ruleClass, $value, $rule);
    }

    /**
     * @param Values $values
     * @param Rules  $rules
     * @param bool   $hasOK
     *
     * @return Returns
     */
    public static function ValidatorAll(array $values, array $rules, bool $hasOK = false): array {
        $ret = [];
        foreach($rules as $key => $parameter){
            if( ! isset($parameter['name'])){
                $parameter['name'] = $key;
            }
            $result = self::Validator($values[$key], $parameter);
            if( ! $result['ok'] || $hasOK){
                $ret[$key] = $result;
            }
        }

        return $ret;
    }

    /**
     * @param string $name
     * @param Rules  $arguments
     *
     * @return Return
     */
    public static function __callStatic(string $name, array $arguments): array {
        return self::create()->validate($name, ...$arguments);
    }

    /**
     * @param string $ruleClass
     * @param mixed  $val
     * @param Rule   $rules
     *
     * @return Return
     */
    private function validate(string $ruleClass, mixed $val, array $rules): array {
        $ok        = false;
        $error     = null;
        $validator = Validator::$ruleClass();
        try{
            foreach($rules as $key => $value){
                switch($key){
                    case 'default':
                    case 'rule':
                        break;
                    case 'name':
                        if(is_string($value))
                            $validator->setName($value);
                        break;
                    case 'msg':
                        if(is_string($value))
                            $validator->setTemplate($value);
                        break;
                    case 'require':
                        if($value){
                            $validator->notEmpty();
                        }
                        break;
                    default:
                        if(is_array($value))
                            $validator->$key(...$value);
                        else{
                            $validator->$key($value);
                        }
                }
            }
            $validator->assert($val);
            $ok = $validator->validate($val);
        } catch(ValidationException $e){
            $error = $e->getMessage();
        }

        return ['ok' => $ok, 'error' => $error];
    }
}