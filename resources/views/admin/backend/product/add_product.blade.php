@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Product</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-4">

                        <form id="myForm" action="{{ route('admin.product_store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Category Name -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category_id" class="form-label">Category Name</label>
                                        <select name="category_id" class="form-select" id="category_id">
                                            <option>Select</option>
                                            @foreach ($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Menu Name -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="menu_id" class="form-label">Menu Name</label>
                                        <select name="menu_id" class="form-select" id="menu_id">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($menu as $men)
                                            <option value="{{ $men->id }}">{{ $men->menu_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('menu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- City Name -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city_id" class="form-label">City Name</label>
                                        <select name="city_id" class="form-select" id="city_id">
                                            <option>Select</option>
                                            @foreach ($city as $cit)
                                            <option value="{{ $cit->id }}">{{ $cit->city_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Client Name -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="client_id" class="form-label">Client Name</label>
                                        <select name="client_id" class="form-select" id="client_id">
                                            <option>Select</option>
                                            @foreach ($client as $clie)
                                            <option value="{{ $clie->id }}">{{ $clie->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Product Name -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" name="name" id="name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input class="form-control" type="text" name="price" id="price">
                                        @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Discount Price -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="discount_price" class="form-label">Discount Price</label>
                                        <input class="form-control" type="text" name="discount_price"
                                            id="discount_price">
                                        @error('discount_price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Size -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <input class="form-control" type="text" name="size" id="size">
                                        @error('size')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Product QTY -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="qty" class="form-label">Product QTY</label>
                                        <input class="form-control" type="text" name="qty" id="qty">
                                        @error('qty')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Product Image -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Product Image</label>
                                        <input class="form-control" name="image" type="file" id="image">
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt=""
                                            class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>

                                <!-- Best Seller -->
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="best_seller" type="checkbox" id="best_seller"
                                        value="1">
                                    <label class="form-check-label" for="best_seller">
                                        Best Seller
                                    </label>
                                </div>

                                <!-- Most Popular -->
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="most_popular" type="checkbox"
                                        id="most_populer" value="1">
                                    <label class="form-check-label" for="most_populer">
                                        Most Popular
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>










                <!-- end tab content -->
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })

</script>


@endsection