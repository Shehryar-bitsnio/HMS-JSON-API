<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use App\Models\UserRole;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Utilities\Helper;
use Illuminate\Support\Arr;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use HelperTrait;
    public function login(Request $request)
    {
        try
        {
            $input = $request->only('email', 'password');


            $validateUser = Validator::make($input, [
                'email' => 'required',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return  $this->errorResponse($this->validationErrorsToString($validateUser->errors()),400);
            }

            if (! $token = JWTAuth::attempt($input)) {
                return  $this->errorResponse("Invalid login credentials", 400);
            }

            $user = User::where('email', $request->email)->first();
            $customClaims = ($user->roles == null) ? ['user_id' => $user->id, 'user_name' => $user->name, 'company_id' => $user->company_id, 'property_id' => 0] : ['user_id' => $user->id, 'user_name' => $user->name, 'company_id' => $user->company_id, 'property_id' => $user->roles['property_id']];
            $token = JWTAuth::claims($customClaims)->attempt($input);
            // $data = Helper::usersModules( $user->id);
            return $this->successResponse($user,'User Logged In Successfully',200,$token);

        }
        catch (JWTException $e) {
            return $this->errorResponse(null, $e->getMessage());
        }
        catch (\Throwable $th) {
            return $this->errorResponse(null, $th->getMessage());
        }
    }

    public function logoutUser(){
        JWTAuth::parseToken()->invalidate();
        return $this->successResponse( 'Logout successful');
    }
}
