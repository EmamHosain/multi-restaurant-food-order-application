<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


// image intervention package 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// id generator 
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    public function index()
    {
        $id = Auth::guard('client')->id();
        $products = Product::with(['category', 'menu'])->where('client_id', $id)->orderByDesc('id')->get();
        return view('client.backend.product.all_product', compact('products'));
    }

    public function create()
    {
        $id = Auth::guard('client')->id();

        $categories = Category::orderByDesc('id')->get();
        $menus = Menu::where('client_id', $id)->orderByDesc('id')->get();
        $cities = City::orderByDesc('id')->get();


        return view('client.backend.product.add_product', compact('categories', 'menus', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'menu_id' => 'required|exists:menus,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'size' => 'nullable|string|max:50',
            'qty' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'best_seller' => 'integer',
            'most_popular' => 'integer',
            'status' => 'required'
        ]);

        $product_code = IdGenerator::generate(['table' => 'products', 'length' => 6, 'prefix' => date('y')]);

        // Create a new product instance
        $product = new Product();

        // Assign validated data to the product model
        $product->category_id = $request->category_id;
        $product->menu_id = $request->menu_id;
        $product->city_id = $request->city_id;
        $product->client_id = Auth::guard('client')->id();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->size = $request->size;
        $product->qty = $request->qty;
        $product->best_seller = $request->input('best_seller');
        $product->most_popular = $request->input('most_popular');
        $product->code = $product_code;
        $product->status = $request->input('status');




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
        return redirect()->route('client.all_products')->with($notification);
    }

    public function edit(Request $request, Product $product)
    {
        $id = Auth::guard('client')->id();

        $categories = Category::orderByDesc('id')->get();
        $menus = Menu::where('client_id', $id)->orderByDesc('id')->get();
        $cities = City::orderByDesc('id')->get();


        return view('client.backend.product.edit_product', [
            'product' => $product,
            'categories' => $categories,
            'menus' => $menus,
            'cities' => $cities
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'menu_id' => 'required|exists:menus,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'size' => 'nullable|string|max:50',
            'qty' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'best_seller' => 'integer',
            'most_popular' => 'integer',
            'status' => 'required'
        ]);



        // Assign validated data to the product model
        $product->category_id = $request->category_id;
        $product->menu_id = $request->menu_id;
        $product->city_id = $request->city_id;
        // $product->client_id = Auth::guard('client')->id();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->size = $request->size;
        $product->qty = $request->qty;
        $product->best_seller = $request->input('best_seller');
        $product->most_popular = $request->input('most_popular');
        // $product->code = $product_code;
        $product->status = $request->input('status');
        $product->created_at = Carbon::now();





        // Handle image upload
        if ($request->hasFile('image')) {

            // delet old image
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
        return redirect()->route('client.all_products')->with($notification);
    }

    public function destroy(Request $request, Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Product deleted successfully.'
        ];
        return redirect()->back()->with($notification);
    }
}
