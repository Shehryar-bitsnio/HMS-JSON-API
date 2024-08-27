<?php

namespace App\Http\Controllers\Api\Hms;

use App\Http\Controllers\Controller;
use App\JsonApi\Hms\Companies\CompanyRequest;
use App\JsonApi\Hms\Companies\CompanySchema;
use App\Models\Company;
use App\Models\User;
use App\Traits\HelperTrait;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LaravelJsonApi\Core\Facades\JsonApi;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Responses\DataResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Throwable;

class CompanyController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;
    use HelperTrait;

    public function store(CompanySchema $schema, CompanyRequest $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->data['attributes'];
            $auth_user =  JWTAuth::parseToken()->authenticate();
            $data['created_by'] = $auth_user->id;

            $user['email'] = $data['company_email'];
            $user['name'] = $data['name'];
            $user['password'] = Hash::make($data['password']);
            $user['user_type'] = 'Admin';
            $user['created_by'] = $auth_user->id;
            $modules = explode(',', $data['modules']);
            unset($data['password']);
            unset($data['name']);
            unset($data['modules']);

            // Create the company
            $company = Company::create($data);

            $user['company_id'] = $company->id;
            $user = User::create($user);

            $user_has_modules = [];
            foreach($modules as $module){
                $user_has_modules[] = ['user_id' => $user->id, 'module_id' => $module, 'created_at' => now()];
            }

            DB::table('user_has_modules')->insert($user_has_modules);

            DB::commit();
            return DataResponse::make($company)->didCreate();
        }
        catch(Throwable $th){
            DB::rollBack();
            $this->errorResponse($th->getMessage(), $th->getMessage());
        }
    }

}
