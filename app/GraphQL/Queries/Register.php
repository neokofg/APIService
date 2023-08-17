<?php

namespace App\GraphQL\Queries;

use App\Services\AuthService;
use GraphQL\Error\Error;

final class Register
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __construct(private AuthService $authService)
    {

    }

    public function __invoke($_, array $args)
    {
        $token = $this->authService->register($args);
        if($token){
            return $token;
        } else {
            throw new Error("Неверные данные!");
        }
    }
}
