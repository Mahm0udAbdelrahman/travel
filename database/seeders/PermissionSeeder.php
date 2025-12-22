<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users-index','users-show','users-create','users-update','users-delete',
            'admins-index','admins-show','admins-create','admins-update','admins-delete',
            'roles-index','roles-show','roles-create','roles-update','roles-delete',
            'notifications-index','notifications-show','notifications-create','notifications-update','notifications-delete',
            'send_notifications-index','send_notifications-show','send_notifications-create','send_notifications-update','send_notifications-delete',
            'categories-index','categories-show','categories-create','categories-update','categories-delete',
            'sub_categories-index','sub_categories-show','sub_categories-create','sub_categories-update','sub_categories-delete',
            'cities-index','cities-create','cities-update','cities-delete',
            'excursions-index','excursions-create','excursions-update','excursions-delete',
            'additional_services-index','additional_services-create','additional_services-update','additional_services-delete',
            'order_additional_services-index','order_additional_services-show','order_additional_services-delete',

]
        ;
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
