<?php
/**
 * 异常
 *
 * @category Validator
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
namespace Laravelfy\Validator\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException as BaseException;

/**
 * 异常
 *
 * @category Validator
 * @package  Validator
 * @author   xiaohui lam <xiaohui.lam@icloud.com>
 * @license  MIT LICENSE
 * @link     https://github.com/laravelfy/validator-enhancement
 */
class ValidationException extends BaseException
{
    /**
     * 设置异常消息
     *
     * @param string $message
     * @return void
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * 兼容以前没有errors方法的版本
     *
     * @return mixed
     */
    public function errors()
    {
        try {
            $messages = $this->validator->errors()->messages();
        } catch (Exception $exception) {
            $messages = $this->validator->messages()->messages();
        }
        return $messages;
    }
}
