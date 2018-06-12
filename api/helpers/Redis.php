<?php
/**
 * Created by PhpStorm.
 * User: wangyu
 * Date: 2018/5/11
 * Time: 18:02
 */
namespace api\helpers;


class Redis
{
    private static $instance;

    private function __construct()
    {
        self::$instance = new \Redis();
        self::$instance->connect('127.0.0.1',6379);
    }

    private function __clone()
    {
    }

    public static function getRedis()
    {
        if(!self::$instance) {
            new self;
        }
        return self::$instance;
    }

}