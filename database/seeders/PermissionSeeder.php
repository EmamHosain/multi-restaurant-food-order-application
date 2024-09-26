<?php

namespace Database\Seeders;

use App\Helper\DestroyTable;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $permissions = new DestroyTable();
        $permissions->destroy();
        // Product permissions
        $products_groups = [
            'product_menu',
            'product_create',
            'product_edit',
            'product_read',
            'product_delete',
        ];

        foreach ($products_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Product',
            ]);
        }

        // Category permissions
        $category_groups = [
            'category_menu',
            'category_create',
            'category_edit',
            'category_read',
            'category_delete',
        ];

        foreach ($category_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Category',
            ]);
        }

        // City permissions
        $city_groups = [
            'city_menu',
            'city_create',
            'city_edit',
            'city_read',
            'city_delete',
        ];

        foreach ($city_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'City',
            ]);
        }

        // Restaurant permissions
        $restaurant_groups = [
            'restaurant_menu',
            'restaurant_create',
            'restaurant_edit',
            'restaurant_read',
            'restaurant_delete',
            'set_restaurant_inactive',
            'set_restaurant_active',

            'pending_restaurant_read',
            'approve_restaurant_read'

        ];

        foreach ($restaurant_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Restaurant',
            ]);
        }

        // Banner permissions
        $banner_groups = [
            'banner_menu',
            'banner_create',
            'banner_edit',
            'banner_read',
            'banner_delete',
        ];

        foreach ($banner_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Banner',
            ]);
        }

        // Order permissions
        $order_groups = [
            'order_menu',
            'order_details',

            'processing_to_confirm_order',
            'pending_to_confirm_order',
            'confirm_to_processing_order',
            'processing_to_deliverd_order',


            'pending_order_read',
            'processing_order_read',
            'confirm_order_read',
            'deliverd_order_read',
        ];

        foreach ($order_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Order',
            ]);
        }

        // Report permissions
        $report_groups = [
            'report_menu',
        ];

        foreach ($report_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Report',
            ]);
        }

        // Review permissions
        $review_groups = [
            'review_menu',
        ];

        foreach ($review_groups as $item) {
            Permission::create([
                'name' => $item,
                'guard_name' => 'admin',
                'group_name' => 'Review',
            ]);
        }

    }
}
