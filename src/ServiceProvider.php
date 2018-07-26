<?php

/**
 * 服务提供者
 *
 * @category ServiceProvider
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
namespace Laravelfy\Validator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * 服务提供者
 *
 * @category ServiceProvider
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * 指示是否延迟加载
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * 在服务容器里注册
     *
     * @return void
     */
    public function boot()
    {
        ValidatorEnhancement::extendDefault();
        ValidatorEnhancement::injectRequest();
    }
}