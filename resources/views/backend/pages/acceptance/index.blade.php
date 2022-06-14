@extends('backend.layouts.app')

@section('name')
    Acceptance
@endsection
@section('links')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
    <!-- third party js -->
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">

                <a href="{{ route('backend.acceptance.create') }}" class="btn btn-secondary me-4 mb-2 mb-md-0">
                    <i class="uil-plus me-1"></i> Create a new acceptance form
                </a>

                <div class="table-responsive mt-4">
                    <table id="datatable-buttons" class="table table-hover table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">airWaybill</th>
                                <th scope="col">pieces</th>
                                <th scope="col">weight</th>
                                <th scope="col">volume</th>
                                <th scope="col">origin</th>
                                <th scope="col">destination</th>
                                <th scope="col">statusCode</th>
                                <th scope="col">date</th>
                                <th scope="col">issued by</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bills as $bill)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('backend.acceptance.details', [$bill['airWaybill']]) }}">{{ $bill['airWaybill'] }}</a>
                                    </td>
                                    <td>{{ $bill['pieces'] }}</td>
                                    <td>{{ $bill['weight'] }} KG</td>
                                    <td>{{ $bill['volume'] }} MC</td>
                                    <td>{{ $bill['origin'] }}</td>
                                    <td>{{ $bill['destination'] }}</td>
                                    <td>{{ $bill['statusCode'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString() }}</td>
                                    <td>{{ $bill['author_name'] }}</td>
                                    <td>
                                        <a href="{{route('backend.acceptance.generate.pdf', [$bill['airWaybill']]) }}">print pdf</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>no data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div> <!-- end card-body-->
        </div>
    </div>
@endsection
