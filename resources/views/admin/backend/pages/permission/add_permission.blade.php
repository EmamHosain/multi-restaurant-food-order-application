@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Permission</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Permission </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body p-4">

                        <form id="myForm" action="{{ route('admin.store_permission') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                    
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Permission Group</label>
                                            <select name="group_name"
                                                class="form-select @error('group_name') is-invalid @enderror">
                                                <option selected disabled>Select Permission</option>
                                                <option value="Category" {{ old('group_name')=='Category' ? 'selected'
                                                    : '' }}>Category</option>
                                                <option value="City" {{ old('group_name')=='City' ? 'selected' : '' }}>
                                                    City</option>
                                                <option value="Product" {{ old('group_name')=='Product' ? 'selected'
                                                    : '' }}>Product</option>
                                                <option value="Restaurant" {{ old('group_name')=='Restaurant'
                                                    ? 'selected' : '' }}>Restaurant</option>
                                                <option value="Banner" {{ old('group_name')=='Banner' ? 'selected' : ''
                                                    }}>Banner</option>
                                                <option value="Order" {{ old('group_name')=='Order' ? 'selected' : ''
                                                    }}>Order</option>
                                                <option value="Reports" {{ old('group_name')=='Reports' ? 'selected'
                                                    : '' }}>Reports</option>
                                                <option value="Review" {{ old('group_name')=='Review' ? 'selected' : ''
                                                    }}>Review</option>
                                            </select>
                                            @error('group_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Permission Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                name="name" id="example-text-input" value="{{ old('name') }}">
                                            @error('name')
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