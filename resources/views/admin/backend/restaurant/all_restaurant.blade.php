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
                    <h4 class="mb-sm-0 font-size-18">All Restaurant</h4>

                    @if (Auth::guard('admin')->user()->can('restaurant_create'))
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('admin.add_restuarant') }}"
                                class="btn btn-primary waves-effect waves-light">Add Restuarant</a>
                        </ol>
                    </div>
                    @endif

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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action </th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($client as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ (!empty($item->photo)) ? asset($item->photo) : url('upload/no_image.jpg') }}"
                                            alt="" style="width: 70px; height:40px;"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>

                                    @if (!$item->phone)
                                    <td><span class="text-danger"><b>Empty</b></span></td>
                                    @else
                                    <td>{{ $item->phone }}</td>
                                    @endif
                                    <td>
                                        @if ($item->status == '1')
                                        <span class="text-success"><b>Active</b></span>
                                        @else
                                        <span class="text-danger"><b>InActive</b></span>
                                        @endif
                                    </td>

                                    <td>

                                        @if (Auth::guard('admin')->user()->can('restaurant_edit'))
                                        <a href="{{ route('admin.edit_restuarant',$item->id) }}"
                                            class="btn btn-info waves-effect waves-light"> <i class="fas fa-edit"></i>
                                        </a>
                                        @endif


                                        @if (Auth::guard('admin')->user()->can('restaurant_delete'))
                                        <a href="{{ route('admin.restuarant_delete',$item->id) }}"
                                            class="btn btn-danger waves-effect waves-light" id="delete"><i
                                                class="fas fa-trash"></i></a>
                                        @endif

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


@endsection