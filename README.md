# LARAVEL-VALIDATOR-ENHANCEMENT

一个能帮你从 VALIDATOR/ 寻参/ 默认赋值 的逻辑中省代码的包。

## Install

```bash
composer require laravelfy/validator-enhancement
```

## Usage

```php
<?php
...

    public function someEndPoint()
    {
        list(
            $page,
            $page_size
        ) = request()->validate(
            [
                'page' => 'integer|default:1|min:1',
                'page_size' => 'integer|default:10|min:1|max:99',
            ]
        );

        ...
    }
```

## License

MIT