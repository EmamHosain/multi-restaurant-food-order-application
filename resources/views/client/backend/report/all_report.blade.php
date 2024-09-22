@extends('client.client_dashboard')
@section('client')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Client All Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col">
                <div class="card">
                    <div class="card-body">

                        <div>

                            <div class="">
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <form id="myFormDate" action="{{ route('client.get_all_report_by_date') }}"
                                                method="post">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <h4>Search By Date</h4>
                                                            <div class="form-group mb-3">
                                                                <label for="example-text-input"
                                                                    class="form-label">Date</label>
                                                                <input
                                                                    class="form-control @error('date') is-invalid @enderror"
                                                                    type="date" name="date" id="example-text-input">
                                                                @error('date')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mt-4">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light">Search</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <form id="myFormMonth" action="{{ route('client.get_all_report_by_month') }}"
                                                method="post">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <h4>Search By Month</h4>
                                                            <div class="form-group mb-3">
                                                                <label for="example-text-input"
                                                                    class="form-label">Select Month:</label>
                                                                <select name="month"
                                                                    class="form-select @error('month') is-invalid @enderror">
                                                                    <option disabled selected>Select Month</option>
                                                                    <option value="January">January</option>
                                                                    <option value="February">February</option>
                                                                    <option value="March">March</option>
                                                                    <option value="April">April</option>
                                                                    <option value="May">May</option>
                                                                    <option value="June">June</option>
                                                                    <option value="July">July</option>
                                                                    <option value="August">August</option>
                                                                    <option value="September">September</option>
                                                                    <option value="October">October</option>
                                                                    <option value="November">November</option>
                                                                    <option value="December">December</option>
                                                                </select>
                                                                @error('month')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror

                                                                <label for="example-text-input"
                                                                    class="form-label">Select Year:</label>
                                                                <select name="year_name"
                                                                    class="form-select @error('year_name') is-invalid @enderror">
                                                                    <option disabled selected>Select Year</option>
                                                                    @for ($year = 2015; $year <= 2024; $year++) <option
                                                                        value="{{ $year }}">{{ $year }}</option>
                                                                        @endfor
                                                                </select>
                                                                @error('year_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mt-4">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light">Search</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <form id="myFormYear" action="{{ route('client.get_all_report_by_year') }}"
                                                method="post">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <h4>Search By Year</h4>
                                                            <div class="form-group mb-3">
                                                                <label for="example-text-input"
                                                                    class="form-label">Select Year:</label>
                                                                <select name="year"
                                                                    class="form-select @error('year') is-invalid @enderror">
                                                                    <option disabled selected>Select Year</option>
                                                                    @for ($year = 2015; $year <= 2024; $year++) <option
                                                                        value="{{ $year }}">{{ $year }}</option>
                                                                        @endfor
                                                                </select>
                                                                @error('year')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="mt-4">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect waves-light">Search</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div> <!-- end col -->




        </div> <!-- end row -->


    </div> <!-- container-fluid -->
</div>






@endsection