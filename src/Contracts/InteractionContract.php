<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-15 07:03
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Passport\Client\Contracts;

/**
 * Interface InteractionContract
 * @package CrCms\Passport\Client\Contracts
 */
interface InteractionContract
{
    /**
     * @param array $data
     * @return object
     */
    public function login(array $data): object;

    /**
     * @param array $data
     * @return object
     */
    public function register(array $data): object;

    /**
     * @param string $token
     * @return object
     */
    public function refresh(string $token): object;

    /**
     * @param string $token
     * @return object
     */
    public function user(string $token): object;

    /**
     * @param string $token
     * @return bool
     */
    public function check(string $token): bool;

    /**
     * @param string $token
     * @return bool
     */
    public function logout(string $token): bool;
}