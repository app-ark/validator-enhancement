<?php
namespace Laravelfy\Validator\Test;

use Illuminate\Container\Container;
use PHPUnit_Framework_TestCase;
use Illuminate\Http\Request;
use Laravelfy\Validator\ValidatorEnhancement;
use Illuminate\Validation\Factory as Validator;
use Illuminate\Translation\ArrayLoader as Loader;
use Illuminate\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Illuminate\Support\Facades\Facade;

/**
 * 测试
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, $data = [], $dataName = '')
    {
        $container = new \Illuminate\Container\Container();
        \Illuminate\Support\Facades\Facade::setFacadeApplication($container);

        $container->singleton('app', Container::class);
        $container->singleton('request', Request::class);
        $container->singleton('validator', function () {
            $loader = new Loader();
            $translator = new Translator($loader, null);
            $validatorFactory = new Validator($translator);
            return $validatorFactory;
        });

        $validator = new ValidatorEnhancement();
        $validator->extendDefault();
        $validator->validate();

        parent::__construct($name, $data, $dataName);
    }

    public function testNow()
    {
        $app = Facade::getFacadeApplication();
        $app->request->merge(['id' => 1, 'name' => 'aaa']);

        list($id, $name, $default) = $app->request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'default' => 'string|default:test'
        ]);
        $this->assertEquals(1, $id);
        $this->assertEquals('aaa', $name);
        $this->assertEquals('test', $default);
    }
}
