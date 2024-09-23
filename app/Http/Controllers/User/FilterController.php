<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function filterProductPage()
    {
        $categories = Category::withCount('products')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $products = Product::paginate(9);

        $cities = City::withCount('products')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();


        $menus = Menu::withCount('products')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();


        return view('frontend.list_restaurant', [
            'products' => $products,
            'categories' => $categories,
            'cities' => $cities,
            'menus' => $menus
        ]);
    }

    public function productFilter(Request $request)
    {
        // Log::info('request data' , $request->all());
        $categoryId = $request->input('categorys'); // array
        $menuId = $request->input('menus'); // array
        $cityId = $request->input('citys'); // array
        $products = Product::query();
        if ($categoryId) {
            $products->whereIn('category_id', $categoryId);
        }
        if ($menuId) {
            $products->whereIn('menu_id', $menuId);
        }
        if ($cityId) {
            $products->whereIn('city_id', $cityId);
        }
        $filterProducts = $products->get();
        return view('frontend.product_list', compact('filterProducts'))->render();
    }
}
