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

use Illuminate\Http\Request;
use Laravelfy\Validator\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

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
                    \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->merge([$attribute => end($parameter)]);
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
        Request::macro(
            'validate',
            function ($rules) {
                $params = array_merge(\Illuminate\Support\Facades\Facade::getFacadeApplication()->request->all(), \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->route() ? \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->route()->parameters():[]);
                $validator = Validator::make($params, $rules);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $list = [];
                foreach ($rules as $parameter => $rule) {
                    if (preg_match('/(^|[\|])(file|image)/', $rule)) {
                        $value = \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->file($parameter);
                    } else {
                        $value = \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->input($parameter);
                        if (!$value && \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->route($parameter)) {
                            $value = \Illuminate\Support\Facades\Facade::getFacadeApplication()->request->route($parameter);
                        }
                    }
                    $list[] = $value;
                }
                return $list;
            }
        );
    }
}
