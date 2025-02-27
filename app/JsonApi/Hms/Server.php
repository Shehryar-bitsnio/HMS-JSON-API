<?php

namespace App\JsonApi\Hms;

use App\Models\UserHasModule;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/hms';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            Users\UserSchema::class,
            Companies\CompanySchema::class,
            Modules\ModuleSchema::class,
            UserHasModules\UserHasModuleSchema::class,
        ];
    }
}
