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
use Laravelfy\Validator\Http\Request;

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
     * 验证器
     *
     * @var ValidatorEnhancement
     */
    protected $validate = null;

    /**
     * 在服务容器里注册
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ValidatorEnhancement::class, function ($app) {
            return new ValidatorEnhancement();
        });
        $this->validate = app(ValidatorEnhancement::class);

        $this->validate->extendDefault();
        $this->validate->validate();

        $this->app->singleton('http', function () {
            return new Request(request()->query->all(), request()->request->all(), request()->attributes->all(), request()->cookies->all(), request()->files->all(), request()->server->all(), request()->getContent());
        });
    }
}
