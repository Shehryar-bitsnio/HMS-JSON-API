<?php

namespace App\JsonApi\Hms\Companies;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CompanyRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string'],
            'company_email' => ['required', 'email',  Rule::unique('companies', 'company_email')],
            'company_phone' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'street_address' => ['required', 'string'],
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'modules' => ['required', 'string']
        ];
    }

}
