@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Admin</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Admin </li>
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

                        <form id="myForm" action="{{ route('admin.update_admin', $admin->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <!-- Admin Name -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="admin-name" class="form-label">Admin Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            name="name" id="admin-name" value="{{ old('name', $admin->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Email -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="admin-email" class="form-label">Admin Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" id="admin-email" value="{{ old('email', $admin->email) }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Phone -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="admin-phone" class="form-label">Admin Phone</label>
                                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                            name="phone" id="admin-phone" value="{{ old('phone', $admin->phone) }}">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Address -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="admin-address" class="form-label">Admin Address</label>
                                        <input class="form-control @error('address') is-invalid @enderror" type="text"
                                            name="address" id="admin-address"
                                            value="{{ old('address', $admin->address) }}">
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <!-- Role Name -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="admin-role" class="form-label">Role Name</label>
                                        <select name="role" class="form-select @error('role') is-invalid @enderror"
                                            id="admin-role">
                                            <option selected disabled>Select</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role', $admin->roles->first()->id ??
                                                '') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
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