@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Banner</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Banner </li>
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

                        <form id="myForm" action="{{ route('admin.banner_store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Banner URL</label>
                                            <input class="form-control @error('banner_url')
                                                is-invalid
                                            @enderror" type="text" name="banner_url"
                                                id="example-text-input">

                                            @error('banner_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">

                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Banner Image</label>
                                            <input class="form-control @error('banner_image')
                                                is-invalid
                                            @enderror" name="banner_image" type="file" id="image">
                                            @error('banner_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">

                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt=""
                                                class="rounded-circle p-1 bg-primary" width="110">
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