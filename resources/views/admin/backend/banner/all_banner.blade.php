@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Banner</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('admin.banner_create') }}"
                                class="btn btn-primary waves-effect waves-light">Add
                                Banner</a>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Banner Image</th>
                                    <th>Banner Url</th>
                                    <th>Action </th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($banner as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ asset($item->banner_image) }}" alt=""
                                            style="width: 70px; height:40px;">
                                    </td>


                                    <td>
                                        @if ($item->banner_url)
                                        {{ $item->banner_url }}
                                        @else
                                        <span class="text-danger"><b>Empty</b></span>
                                        @endif
                                    
                                    </td>


                                    <td>

                                        <a href="{{ route('admin.banner_edit',$item->id) }}"
                                            class="btn btn-info waves-effect waves-light">Edit</a>

                                        {{-- @if (Auth::guard('admin')->user()->can('category.delete')) --}}

                                        <a href="{{ route('admin.banner_delete',$item->id) }}"
                                            class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


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