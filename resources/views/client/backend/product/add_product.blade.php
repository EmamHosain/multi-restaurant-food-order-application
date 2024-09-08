@extends('client.client_dashboard')
@section('client')
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

                        <form id="myForm" action="{{ route('client.product_store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category_id" class="form-label">Category Name</label>
                                        <select name="category_id" class="form-select">
                                            <option>Select</option>
                                            @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected'
                                                : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="menu_id" class="form-label">Menu Name</label>
                                        <select name="menu_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($menus as $men)
                                            <option value="{{ $men->id }}" {{ old('menu_id')==$men->id ? 'selected' : ''
                                                }}>
                                                {{ $men->menu_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('menu_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city_id" class="form-label">City Name</label>
                                        <select name="city_id" class="form-select">
                                            <option>Select</option>
                                            @foreach ($cities as $cit)
                                            <option value="{{ $cit->id }}" {{ old('city_id')==$cit->id ? 'selected' : ''
                                                }}>
                                                {{ $cit->city_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                            id="name">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input class="form-control" type="text" name="price" value="{{ old('price') }}"
                                            id="price">
                                        @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="discount_price" class="form-label">Discount Price</label>
                                        <input class="form-control" type="text" name="discount_price"
                                            value="{{ old('discount_price') }}" id="discount_price">
                                        @error('discount_price')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <input class="form-control" type="text" name="size" value="{{ old('size') }}"
                                            id="size">
                                        @error('size')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="qty" class="form-label">Product QTY</label>
                                        <input class="form-control" type="text" name="qty" value="{{ old('qty') }}"
                                            id="qty">
                                        @error('qty')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Product Image</label>
                                        <input class="form-control" name="image" type="file" id="image">
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="" selected disabled>Select status</option>

                                            <option value="1" {{ old('status') }}>
                                                Active
                                            </option>
                                            <option value="0" {{ old('status') }}>
                                                Inactive
                                            </option>

                                        </select>
                                        @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt=""
                                            class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="best_seller" type="checkbox" id="formCheck1"
                                        value="1" {{ old('best_seller') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="formCheck1">
                                        Best Seller
                                    </label>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="most_popular" type="checkbox" id="formCheck2"
                                        value="1" {{ old('most_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="formCheck2">
                                        Most Populer
                                    </label>
                                </div>

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