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
            'cities-index','cities-create','cities-update','cities-delete',
            'category_excursions-index','category_excursions-create','category_excursions-update','category_excursions-delete',
            'excursions-index','excursions-show','excursions-create','excursions-update','excursions-delete',
            'additional_services-index','additional_services-create','additional_services-update','additional_services-delete',
            'order_additional_services-index','order_additional_services-show','order_additional_services-delete',
            'category_events-index','category_events-show','category_events-create','category_events-update','category_events-delete',
            'events-index','events-show','events-create','events-update','events-delete',
            'category_real_estates-index','category_real_estates-show','category_real_estates-create','category_real_estates-update','category_real_estates-delete',
            'real_estates-index','real_estates-show','real_estates-create','real_estates-update','real_estates-delete',


]
        ;
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
