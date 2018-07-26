# LARAVEL-VALIDATOR-ENHANCEMENT

一个能帮你从 VALIDATOR/ 寻参/ 默认赋值 的逻辑中省代码的包。

## Install

1. Install to your composer project
```bash
composer require laravelfy/validator-enhancement
```

2. Add service provider into `config/app.php` 's `providers` config array by filling:
```
Laravelfy\Validator\ServiceProvider::class,
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