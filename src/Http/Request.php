<?php

namespace Laravelfy\Validator\Http;

use Illuminate\Http\Request as BaseRequest;
use Laravelfy\Validator\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

class Request extends BaseRequest
{
    public function validate($rules)
    {
        $params = array_merge(request()->all(), request()->route() ? request()->route()->parameters() : []);
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
            $list[$parameter] = $value;
        }
        if (!request()->exists($parameter)) {
            unset($list[$parameter]);
        }
        return $list;
    }
}
