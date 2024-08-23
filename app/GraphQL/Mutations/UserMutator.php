<?php
namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class UserMutator
{
    protected $user;
    protected $validator;

    public function __construct(
        User $user,
        Validator $validator
    )
    {
        $this->user = $user;
        $this->validator = $validator;
    }

    public function resolveOrder($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }
        return $user = auth()->user();
    }
}