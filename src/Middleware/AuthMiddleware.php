<?php

/**
 * @author simon <crcms@crcms.cn>
 * @datetime 2018-07-09 06:47
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Client\Middleware;

use Closure;
use CrCms\Foundation\ConnectionPool\Exceptions\RequestException;
use CrCms\Foundation\MicroService\Client\Exceptions\ServiceException;
use CrCms\Foundation\MicroService\Client\ServiceData;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class AuthMiddleware
 * @package CrCms\Foundation\Passport\Client\Middleware
 */
class AuthMiddleware extends AbstractPassportMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response|mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $this->token($request);
        $response = $next($request);

        if ($this->passport->check($token)) {
            return $response;
        }

        try {
            $token = $this->passport->refresh($token);
            return $response->header('Authorization', $token->data('data.token'));
        } catch (ServiceException $exception) {
            throw new AuthenticationException(
                'Unauthenticated.' . $exception->getMessage(), [], $this->redirectTo($request)
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        //
    }
}