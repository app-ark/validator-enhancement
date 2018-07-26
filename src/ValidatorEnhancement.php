<?php

/**
 * 服务提供者
 *
 * @category Validator
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
namespace Laravelfy\Validator;

use Validator;

/**
 * 验证器扩展
 *
 * @category Validator
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
class ValidatorEnhancement
{
    /**
     * 扩展 default 指令
     *
     * @return void
     */
    public static function extendDefault()
    {
        Validator::extendImplicit(
            'default',
            function ($attribute, $value, $parameter, $validator) {
                if ($value === "" || $value === null) {
                    request()->merge([$attribute => end($parameter)]);
                    $value = end($parameter);
                }
                return true;
            }
        );
    }

    /**
     * 注入到请求类中
     *
     * @return void
     */
    public static function injectRequest()
    {
        request()->macro(
            'validate',
            function ($rules) {
                $validator = Validator::make(
                    request()->all(), $rules
                );

                if ($validator->fails()) {
                    throw new \Exception($validator->errors());
                }

                $list = [];
                foreach ($rules as $parameter => $rule) {
                    if (preg_match('/(^|[\|])(file|image)/', $rule)) {
                        $value = request()->file($parameter);
                    } else {
                        $value = request()->input($parameter);
                    }
                    $list[] = $value;
                }
                return $list;
            }
        );
    }
}