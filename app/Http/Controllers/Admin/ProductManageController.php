<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Menu;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;


// image intervention package 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// id generator 
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class ProductManageController extends Controller
{
    public function index()
    {
        $products = Product::with('client')->orderByDesc('id')->get();
        return view(
            'admin.backend.product.all_product',
            ['products' => $products]
        );
    }

    public function create(Request $request)
    {
        $menus = Menu::orderByDesc('id')->get();
        $categories = Category::orderByDesc('id')->get();
        $cities = City::orderByDesc('id')->get();
        $clients = Client::orderByDesc('id')->get();


        return view('admin.backend.product.add_product', [
            'category' => $categories,
            'menu' => $menus,
            'city' => $cities,
            'client' => $clients,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'menu_id' => 'required|exists:menus,id',
            'city_id' => 'required|exists:cities,id',
            'client_id' => 'required|exists:clients,id',

            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'size' => 'nullable|string|max:50',
            'qty' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'best_seller' => 'integer',
            'most_popular' => 'integer',
            // 'status' => 'required'
        ]);

        $product_code = IdGenerator::generate(['table' => 'products', 'length' => 6, 'prefix' => date('y')]);

        // Create a new product instance
        $product = new Product();

        // Assign validated data to the product model
        $product->admin_id = Auth::guard('admin')->id();

        $product->category_id = $request->category_id;
        $product->menu_id = $request->menu_id;
        $product->city_id = $request->city_id;
        $product->client_id = $request->client_id;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->size = $request->size;
        $product->qty = $request->qty;
        $product->best_seller = $request->input('best_seller');
        $product->most_popular = $request->input('most_popular');
        $product->code = $product_code;
        $product->created_at = Carbon::now();




        // Handle image upload
        if ($request->hasFile('image')) {
            // Use image intervention for resizing and saving
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize and store image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $image_name));

            // Store image path in the database
            $product->image = 'upload/product/' . $image_name;
        }

        // Save the product to the database
        $product->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Product created successfully.'
        ];
        // Redirect or return success message
        return redirect()->route('admin.all_products')->with($notification);
    }



    public function edit(Product $product)
    {
        $menus = Menu::orderByDesc('id')->get();
        $categories = Category::orderByDesc('id')->get();
        $cities = City::orderByDesc('id')->get();
        $clients = Client::orderByDesc('id')->get();


        return view('admin.backend.product.edit_product', [
            'category' => $categories,
            'menu' => $menus,
            'city' => $cities,
            'client' => $clients,
            'product' => $product,
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'menu_id' => 'required|exists:menus,id',
            'city_id' => 'required|exists:cities,id',
            'client_id' => 'required|exists:clients,id',

            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'size' => 'nullable|string|max:50',
            'qty' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'best_seller' => 'integer',
            'most_popular' => 'integer',
            'status' => 'nullable|numeric|between:0,1'
        ]);


        // Assign validated data to the product model
        $product->admin_id = Auth::guard('admin')->id();

        $product->category_id = $request->category_id;
        $product->menu_id = $request->menu_id;
        $product->city_id = $request->city_id;
        $product->client_id = $request->client_id;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->size = $request->size;
        $product->qty = $request->qty;
        $product->best_seller = $request->input('best_seller');
        $product->most_popular = $request->input('most_popular');
        $product->status = $request->input('status');
        $product->created_at = Carbon::now();





        // Handle image upload
        if ($request->hasFile('image')) {

            // delete old image
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }


            // Use image intervention for resizing and saving
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize and store image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $image_name));

            // Store image path in the database
            $product->image = 'upload/product/' . $image_name;
        }

        // Save the product to the database
        $product->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Product updated successfully.'
        ];
        // Redirect or return success message
        return redirect()->route('admin.all_products')->with($notification);
    }


    public function destroy(Product $product)
    {
        // delete old image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Product updated successfully.'
        ];
        // Redirect or return success message
        return redirect()->route('admin.all_products')->with($notification);
    }
}
