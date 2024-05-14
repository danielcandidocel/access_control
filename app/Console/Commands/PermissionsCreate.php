<?php

namespace App\Console\Commands;

use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class PermissionsCreate extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'permissions:create';
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command to create permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('optimize:clear');

        $exclude         = [
            'ignition',
            'debugbar',
            'sanctum',
            'generated',
        ];
        $routeCollection = Route::getRoutes();

        foreach ($routeCollection as $value) {
            $name = $value->getName();

            if ($name === null) {
                continue;
            }
            $arrName = explode('.', $name);
            $module  = $arrName[0];
            if (in_array($module, $exclude)) {
                continue;
            }
            if (str_contains($name, 'generated')) {
                continue;
            }

            Permission::query()->insertOrIgnore([
                                                    'name'  => $name,
                                                    'group' => $module,
                                                ]);
            RolePermission::query()->insertOrIgnore([
                                                        'role_id'       => RolesEnum::SUPER_ADMIN,
                                                        'permission_id' => Permission::query()->where('name', $name)->first()->id,
                                                    ]);
        }
        $this->info('Permissions stored successfully.');
    }
}
