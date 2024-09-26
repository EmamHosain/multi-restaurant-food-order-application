@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Admin</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Admin </li>
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

                        <form id="myForm" action="{{ route('admin.store_admin') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Admin Name -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Admin Name</label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Email -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Admin Email</label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Phone -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Admin Phone</label>
                                        <input class="form-control" type="text" name="phone" id="phone"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Address -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Admin Address</label>
                                        <input class="form-control" type="text" name="address" id="address"
                                            value="{{ old('address') }}">
                                        @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Password -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Admin Password</label>
                                        <input class="form-control" type="password" name="password" id="password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Role Selection -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="roles" class="form-label">Role Name</label>
                                        <select name="role" class="form-select" id="roles">
                                            <option selected disabled>Select</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('roles')==$role->id ? 'selected' : ''
                                                }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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



@endsection