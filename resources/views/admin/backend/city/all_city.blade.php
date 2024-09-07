@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All City</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#myModal">Add City</button>
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
                                    <th>City Name</th>
                                    <th>City Slug</th>
                                    <th>Action </th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($cities as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->city_name }}</td>
                                    <td>{{ $item->city_slug }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#myEdit" id="{{ $item->id }}"
                                            onclick="cityEdit(this.id)">Edit</button>

                                        <a href="{{ route('admin.city_item_delete',$item->id) }}"
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


<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="myForm" action="{{ route('admin.city_store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label @error('city_name')
                                        is-invalid
                                    @enderror">City Name</label>
                                    <input class="form-control" type="text" name="city_name">

                                    @error('city_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<!-- Edit modal content -->
<div id="myEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="myForm" action="{{ route('admin.city_item_update') }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="id" id="cat_id">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label">City Name</label>
                                    <input class="form-control @error('city_name')
                                        is-invalid
                                    @enderror" type="text" name="city_name" id="cat">
                                    @error('city_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
    function cityEdit(id){
            $.ajax({
                type: 'GET',
                url: '/admin/city/edit/' + id,
                dataType: 'json',

                success:function(data){
                     console.log(data)
                    $('#cat').val(data.city_name);
                    $('#cat_id').val(data.id);
                }
                   
            })
        }

        $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                city_name: {
                    required : true,
                },
                
            },
            messages :{
                category_name: {
                    required : 'Please Enter City Name',
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