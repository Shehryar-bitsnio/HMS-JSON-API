<?php

namespace App\JsonApi\Hms\Companies;

use App\Models\Company;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

/**
 * @property Company $resource
 */
class CompanyResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'company_name' => $this->resource->company_name,
            'company_email' => $this->resource->company_email,
            'company_phone' => $this->resource->company_phone,
            'country' => $this->resource->country,
            'city' => $this->resource->city,
            'street_address' => $this->resource->street_address,
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('users'),
        ];
    }

}
