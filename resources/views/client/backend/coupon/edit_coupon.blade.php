@extends('client.client_dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Coupon</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Coupon </li>
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

                        <form id="myForm" action="{{ route('client.coupon_update',$coupon->id) }}" method="post">
                            @csrf
                            @method('patch')

                            <div class="row">

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Coupon Name</label>
                                        <input class="form-control @error('coupon_name')
           is-invalid 
        @enderror" type="text" name="coupon_name" value="{{ old('coupon_name',$coupon->coupon_name) }}"
                                            id="example-text-input">

                                        {{-- Error message --}}
                                        @error('coupon_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label ">Coupon Discount </label>
                                        <input class="form-control @error('discount')
                                    is-invalid 
                                 @enderror" type="text" name="discount" id="example-text-input"
                                            value="{{ old('discount',$coupon->discount) }}">
                                        {{-- Error message --}}
                                        @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label @error('validity_date')
                                    is-invalid 
                                 @enderror">Coupon Validity </label>
                                        <input class="form-control" type="date" name="validity_date"
                                            id="example-text-input"
                                            value="{{ old('validity_date',$coupon->validity_date) }}">

                                        @error('validity_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                                            <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>





                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="floatingTextarea2" class="form-label">Coupon Description </label>

                                        {{-- <textarea class="form-control @error('coupon_desc') is-invalid @enderror"
                                            name="coupon_desc" placeholder="Coupon description" id="floatingTextarea2"
                                            style="height: 100px; text-align: left;">
                                            {{ $coupon->coupon_desc ?? '' }}
                                        </textarea> --}}

                                        <textarea class="form-control" name="coupon_desc" id="coupon_desc"
                                            placeholder="Coupon description" id="floatingTextarea2"
                                            style="height: 100px; text-align: left;">{{ $coupon->coupon_desc ?? ''
                                            }}</textarea>

                                        {{-- Error message --}}
                                        @error('coupon_desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="">
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                category_name: {
                    required : true,
                },
                image: {
                    required : true,
                }, 
                
            },
            messages :{
                category_name: {
                    required : 'Please Enter Category Name',
                },
                image: {
                    required : 'Please Select Image',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>


@endsection