@extends('client.client_dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm order-2 order-sm-1">
                                <div class="d-flex align-items-start mt-3 mt-sm-0">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xl me-3">
                                            <img src="{{ (!empty($profileData->photo)) ? url($profileData->photo) : url('upload/no_image.jpg') }}"
                                                alt="" class="img-fluid rounded-circle d-block">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5 class="font-size-16 mb-1">{{ $profileData->name }}</h5>
                                            <p class="text-muted font-size-13">{{ $profileData->email }}</p>

                                            <div
                                                class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                                <div><i
                                                        class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{
                                                    $profileData->phone }}</div>
                                                <div><i
                                                        class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{
                                                    $profileData->address }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->


                <div class="card-body p-4">
                    <form action="{{ route('client.profile_update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            name="name" value="{{  $profileData->name }}" id="example-text-input">

                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email"
                                            type="email" value="{{ $profileData->email }}" id="example-text-input">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Phone</label>
                                        <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            type="text" value="{{$profileData->phone}}" id="example-text-input">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="shop_info" class="form-label">Restaurant info</label>
                                        <textarea class="form-control" name="shop_info" id="shop_info"
                                            placeholder="Enter restaurant info" id="floatingTextarea2"
                                            style="height: 100px; text-align: left;">{{ $profileData->shop_info ??
                                            '' }}</textarea>
                                        @error('shop_info')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    {{-- shop cover photo --}}
                                    <div class="mb-3">
                                        <label for="cover_photo" class="form-label">Conver Image</label>
                                        <input class="form-control @error('cover_photo') is-invalid @enderror"
                                            name="cover_photo" type="file" id="cover_photo">
                                        @error('cover_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <img id="cover_photo_show"
                                            src="{{ !empty($profileData->cover_photo) ? url($profileData->cover_photo) : url('upload/no_image.jpg') }}"
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
                                            name="address" type="text" value="{{ $profileData->address}}"
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
                                            <option value="{{ $cit->id }}" {{ $profileData->city_id == $cit->id ?
                                                'selected' : ''
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
                                        <input class="form-control @error('address') is-invalid @enderror" name="photo"
                                            type="file" id="image">
                                        @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">

                                        <img id="showImage"
                                            src="{{ (!empty($profileData->photo)) ? url($profileData->photo) : url('upload/no_image.jpg') }}"
                                            alt="" class="rounded-circle p-1 bg-primary" width="110">


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



        $('#cover_photo').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#cover_photo_show').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })






</script>


@endsection