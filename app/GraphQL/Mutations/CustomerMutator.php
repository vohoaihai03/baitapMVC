<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Models\WishList;
use Illuminate\Support\Facades\Validator;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CustomerMutator
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

    public function resolveAddWishList($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();
        $dataWishList = WishList::where('id_hotel', $args['id_hotel'])
            ->where('user_id', $user->id)
            ->first();

        if(empty($dataWishList)){
            WishList::create([
                'user_id' => $user->id,
                'id_hotel' => $args['id_hotel'],
            ]);
        }
        $wishLists = WishList::where('user_id', $user->id)->get();

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'wish_list' => $wishLists,
        ];
    }


    public function resolveDeleteWishList($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }

        $user = auth()->user();
        $dataWishList = WishList::where('id', $args['id'])
            ->where('user_id', $user->id)
            ->first();
        if(empty($dataWishList)){
            throw new \Exception('Wish List not found!');
        }

        return [
            'orderHistory' => $dataWishList,
        ];
    }


    public function resolveUpdateInformation($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validator = Validator::make($args, [
            'username' => 'required|string|max:255',
            'sex' => 'required|integer',
            'birthday' => 'required|date',
            'phone_number' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new \Exception('Validation error: ' . $errors);
        }

        if (!auth()->check()) {
            throw new \Exception('Unauthorized access');
        }
        
        $user = auth()->user();
        $customer = User::findOrFail($user->id);

        $updateData = [
            'username' => $args['username'],
            'sex' => $args['sex'],
            'birthday' => $args['birthday'],
            'phone_number' => $args['phone_number'],
        ];

        if (!empty($args['image'])) {
            $updateData['image'] = $args['image'];
        }

        $customer->update($updateData);

        $customer = User::findOrFail($user->id);

        return [
            'username' => $customer->username,
            'sex' => $customer->sex,
            'email' => $customer->email,
            'birthday' => $customer->birthday,
            'address' => $customer->address,
            'phone_number' => $customer->phone_number,
            'image' => $customer->image,
        ];
    }

}
