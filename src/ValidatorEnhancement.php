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
use Laravelfy\Validator\Exceptions\ValidationException;

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
    public function extendDefault()
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
    public function validate()
    {
        request()->macro(
            'validate',
            function ($rules) {
                $params = array_merge(request()->all(), request()->route()->parameters());
                $validator = Validator::make($params, $rules);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $list = [];
                foreach ($rules as $parameter => $rule) {
                    if (preg_match('/(^|[\|])(file|image)/', $rule)) {
                        $value = request()->file($parameter);
                    } else {
                        $value = request()->input($parameter);
                        if (!$value && request()->route($parameter)) {
                            $value = request()->route($parameter);
                        }
                    }
                    $list[] = $value;
                }
                return $list;
            }
        );
    }
}
