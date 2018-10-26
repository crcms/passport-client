<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-30 07:10
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client\Contracts;

/**
 * Interface PassportUserContract
 * @package CrCms\Foundation\Passport\Client\Contracts
 */
interface PassportUserContract
{
    /**
     * @param array $attributes
     * @return PassportUserContract
     */
    public static function getPassportUser(array $attributes): PassportUserContract;
}