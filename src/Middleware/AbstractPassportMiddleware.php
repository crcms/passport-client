<?php

/**
 * @author simon <simon@crcms.cn>
 * @datetime 2018-08-18 22:07
 * @link http://crcms.cn/
 * @copyright Copyright &copy; 2018 Rights Reserved CRCMS
 */

namespace CrCms\Foundation\Passport\Middleware;

use CrCms\Foundation\App\Helpers\InstanceTrait;
use CrCms\Foundation\Passport\Client\Contracts\InteractionContract;
use Illuminate\Http\Request;

/**
 * Class AbstractPassportMiddleware
 * @package CrCms\Foundation\Passport\Middleware\Passport
 */
abstract class AbstractPassportMiddleware
{
    use InstanceTrait;

    /**
     * @var InteractionContract
     */
    protected $passport;

    /**
     * AbstractPassportMiddleware constructor.
     * @param InteractionContract $passport
     */
    public function __construct(InteractionContract $passport)
    {
        $this->passport = $passport;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function token(Request $request): string
    {
        return $request->input('token', str_replace('Bearer ', '', $request->header('Authorization', '')));
    }
}