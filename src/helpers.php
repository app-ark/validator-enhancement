<?php

if (!function_exists('http')) {
    function http()
    {
        return app()->http;
    }
}
