<?php
namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetMe
{
    public function __invoke($_, array $args)
    {
        return auth()->user();
    }
}
