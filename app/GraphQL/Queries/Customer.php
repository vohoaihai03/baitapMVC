<?php
namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\SaleOrder;
use App\Models\User;
use App\Models\WishList;

class Customer
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

    public function resolveOrderHistory($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();
        $saleOrders = SaleOrder::where('user_id', $user->id)->with('address')->get();

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'orderHistory' => $saleOrders,
        ];
    }

    public function resolveWishList($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();
        $wishList = WishList::where('user_id', $user->id)->get();

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'wish_list' => $wishList,
        ];
    }

    public function resolveOrderDetail($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();
        $orderDetail = SaleOrder::where('id', $args['id'])
            ->where('user_id', $user->id)
            ->first();
        if(empty($orderDetail)){
            throw new \Exception('Order Detail not found!');
        }

        return $orderDetail;
    }


    public function resolveInformation($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();

        return $user;
    }
}
