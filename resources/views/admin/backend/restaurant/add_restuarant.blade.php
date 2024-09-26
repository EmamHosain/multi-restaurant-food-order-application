@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Restaurant</h4>
                    @if (Auth::guard('admin')->user()->can('restaurant_read'))
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('admin.all_restuarants') }}"
                                class="btn btn-primary waves-effect waves-light">All Restuarant</a>
                        </ol>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-9 col-lg-8">

                <div class="card-body p-4">
                    <form action="{{ route('admin.restuarant_store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            name="name" id="example-text-input" value="{{ old('name') }}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email"
                                            type="email" id="example-text-input" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Phone</label>
                                        <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            type="text" id="example-text-input" value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="shop_info" class="form-label">Restaurant Info</label>
                                        <textarea class="form-control @error('shop_info') is-invalid @enderror"
                                            name="shop_info" id="shop_info" placeholder="Enter restaurant info"
                                            style="height: 100px; text-align: left;">{{ old('shop_info') }}</textarea>
                                        @error('shop_info')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- status --}}
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>

                                        <select name="status" class="form-select">
                                            <option selected value="">Select status</option>
                                            <option value="1">Active
                                            </option>
                                            <option value="0">Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- shop cover photo --}}
                                    <div class="mb-3">
                                        <label for="cover_photo" class="form-label">Cover Image</label>
                                        <input class="form-control @error('cover_photo') is-invalid @enderror"
                                            name="cover_photo" type="file" id="cover_photo">
                                        @error('cover_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <img id="cover_photo_show" src="{{ asset('upload/no_image.jpg') }}"
                                            alt="Cover Photo" class="border border-primary" width="200" height="110"
                                            style="object-fit: cover; float: left;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Address</label>
                                        <input class="form-control @error('address') is-invalid @enderror"
                                            name="address" type="text" value="{{ old('address') }}"
                                            id="example-text-input">
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="city_id" class="form-label">City Name</label>
                                        <select name="city_id" class="form-select">
                                            <option value="">Select</option>
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

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Profile Image</label>
                                        <input class="form-control @error('photo') is-invalid @enderror" name="photo"
                                            type="file" id="image">
                                        @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <img id="showImage" src="{{ asset('upload/no_image.jpg') }}" alt=""
                                            class="rounded-circle p-1 bg-primary" width="110">
                                    </div>

                                    <!-- Password Field -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            name="password" type="password" id="password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation Field -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" type="password" id="password_confirmation">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>





                <!-- end tab content -->
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>


    </div> <!-- container-fluid -->
</div>


@endsection