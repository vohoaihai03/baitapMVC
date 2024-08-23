<?php
namespace App\GraphQL\Mutations;

use App\Models\User;
use Google_Client;
use Facebook\Facebook;
use Illuminate\Support\Facades\Validator;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;


class AuthMutator
{
    protected $user;
    protected $validator;
    protected $google;
    protected $facebook;

    public function __construct(
        User $user,
        Validator $validator,
        Google_Client $google,
        Facebook $facebook
    )
    {
        $this->user = $user;
        $this->validator = $validator;
        $this->google = $google;
        $this->facebook = $facebook;
    }

    public function resolveRegister($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validator = $this->validator::make($args, [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return [
                'access_token' => null,
                'token_type' => null,
                'expires_in' => null,
                'user' => null,
                'errors' => $validator->errors()->all()
            ];
        }

        $user = $this->user::create($args);

        $token = auth()->login($user);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => $user,
        ];
    }


    public function resolveLogin($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $validator = $this->validator::make($args, [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'token_device' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'access_token' => null,
                'token_type' => null,
                'expires_in' => null,
                'user' => null,
                'errors' => $validator->errors()->all(),
            ];
        }


        if (!$token = auth()->attempt(['email' => $args['email'], 'password' => $args['password']])) {
            return [
                'access_token' => null,
                'token_type' => null,
                'expires_in' => null,
                'user' => null,
                'errors' => ['Invalid credentials'],
            ];
        }


        $user = auth()->user();

        $updatedUser = User::find($user->id);
        $updatedUser->update([
            'token_device' => $args['token_device'],
        ]);
        
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()  * 60,
            'user' => $user,
        ];
    }

    public function resolveLogout($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (auth()->check()) {
            auth()->logout();
            return true;
        }
        return false;
    }

    public function resolveRefreshToken($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        try {
            $token = auth()->refresh();
            if (!$token) {
                throw new HttpException(401, 'Unauthenticated');
            }

            $user = auth()->user();

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => $user,
                'errors' => null,
            ];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            throw new HttpException(404, 'Invalid refresh token: ' . $e->getMessage());
        }
    }

    public function resolveGetMe($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (!auth()->check()) {
            return null;
        }
        return auth()->user();
    }

    public function resolveLoginGoogle($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client = new Google_Client(['client_id' => env('GOOGLE_WEB_CLIENT_ID')]);
        $payload = $client->verifyIdToken($args['social_token']);
        if ($payload) {
            $googleId = $payload['sub'];
            $name = $payload['name'];
            $email = $payload['email'];


            $user = $this->user->firstOrCreate(
                ['google_id' => $googleId],
                ['name' => $name, 'email' => $email]
            );

            $token = auth()->login($user);

            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL(),
                'user' => $user,
            ];
        } else {
            throw new \Exception('Invalid Google ID token');
        }
    }

    public function resolveLoginFacebook($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        try {
            $response = $this->facebook->get('/me?fields=id,name,email', $args['social_token']);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception('Graph returned an error: ' . $e->getMessage());
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception('Facebook SDK returned an error: ' . $e->getMessage());
        }

        $userNode = $response->getGraphUser();
        $facebookId = $userNode->getId();
        $name = $userNode->getName();
        $email = $userNode->getEmail();

        $user = $this->user::firstOrCreate(
            ['facebook_id' => $facebookId],
            ['name' => $name, 'email' => $email]
        );

        $token = auth()->login($user);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => $user,
        ];
    }

    public function resolveRequestPasswordReset($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $email = $args['email'];

        $user = User::where('email', $email)->first();
        if (!$user) {
            return [
                'code' => 404,
                'msg' => "Email của bạn không tồn tại"
            ];
        }
        
        $code = $this->generateRandomCode(4);
        
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $code,
                'created_at' => Carbon::now()
            ]
        );

        Mail::to($email)->send(new ResetPasswordMail($code));

        return [
            'code' => 200,
            'msg' => "Đã gửi mã đặt lại mật khẩu!"
        ];
        
    }

    public function resolveResetPassword($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       
        $email = $args['email'];
        $code = $args['code'];


        $resetRecord = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (!$resetRecord || Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            return [
                'code' => 400,
                'msg' => "Mã Code gửi sai hoặc hết hạn"
            ];
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return [
                'code' => 404,
                'msg' => "Email của bạn không tồn tại"
            ];
        }


        return [
            'code' => 200,
            'msg' => "Xác thực thành công"
        ];
    }

    public function resolveUpdatePassword($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       
        $email = $args['email'];
        $code = $args['code'];
        $password = $args['password'];
        $passwordConfirmation = $args['password_confirmation'];

        if ($password !== $passwordConfirmation) {
            return [
                'code' => 404,
                'msg' => "Mật khẩu không phù hợp"
            ];
        }


        $resetRecord = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (!$resetRecord || Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            return [
                'code' => 400,
                'msg' => "Mã Code gửi sai hoặc hết hạn"
            ];
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return [
                'code' => 404,
                'msg' => "Email của bạn không tồn tại"
            ];
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();

        return [
            'code' => 200,
            'msg' => "Cập nhật mật khẩu thành công"
        ];
    }

    private function generateRandomCode($length)
    {
        return str_pad(mt_rand(0, 9999), $length, '0', STR_PAD_LEFT);
    }
}
