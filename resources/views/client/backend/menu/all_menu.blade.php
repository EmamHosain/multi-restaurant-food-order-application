@extends('client.client_dashboard')
@section('client')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Menu</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('client.menu_create') }}"
                                class="btn btn-primary waves-effect waves-light">Add Menu</a>
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
                                    <th>Menu Name</th>
                                    <th>slug</th>
                                    <th>Image</th>
                                    <th>Action </th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($menus as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->menu_name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td><img src="{{ $item->image ? asset($item->image) : asset('upload/no_image.jpg') }}" alt="" style="width: 70px; height:40px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('client.menu_edit',$item->id) }}"
                                            class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a href="{{ route('client.menu_delete',$item->id) }}"
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



@endsection