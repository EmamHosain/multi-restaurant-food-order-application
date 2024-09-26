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
            'restaurant_create',
            'restaurant_edit',
            'restaurant_read',
            'restaurant_delete',
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
            'order_create',
            'order_edit',
            'order_read',
            'order_delete',
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
            'report_create',
            'report_edit',
            'report_read',
            'report_delete',
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
            'review_create',
            'review_edit',
            'review_read',
            'review_delete',
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
