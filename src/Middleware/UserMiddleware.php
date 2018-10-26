<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-18 22:03
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client\Middleware;

use Illuminate\Http\Request;
use Closure;

/**
 * Class UserMiddleware
 * @package CrCms\Foundation\Passport\Client\Middleware
 */
class UserMiddleware extends AbstractPassportMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param null|string $user
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $user = null)
    {
        $response = $this->passport->user($this->token($request));

        if (is_null($user)) {
            $user = $this->config->get('passport-client.user');
        }

        $this->guard()->setUser($user::getPassportUser((array)$response->data));

        return $next($request);
    }
}