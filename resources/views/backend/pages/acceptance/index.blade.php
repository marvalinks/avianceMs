@extends('backend.layouts.app')

@section('name')
    Acceptance
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <a href="#" class="btn btn-secondary float-end ml-2">
                    <i class="uil uil-export me-1"></i> Export PDF
                </a>
                <a href="{{ route('backend.acceptance.create') }}" class="btn btn-secondary me-4 mb-2 mb-md-0">
                    <i class="uil-plus me-1"></i> Create a new acceptance form
                </a>

                <div class="table-responsive mt-4">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">airWaybill</th>
                                <th scope="col">pieces</th>
                                <th scope="col">weight</th>
                                <th scope="col">volume</th>
                                <th scope="col">origin</th>
                                <th scope="col">destination</th>
                                <th scope="col">statusCode</th>
                                <th scope="col">issued by</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bills as $bill)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('backend.acceptance.details', [$bill->airWaybill]) }}">{{ $bill->airWaybill }}</a>
                                    </td>
                                    <td>{{ $bill->pieces }}</td>
                                    <td>{{ $bill->weight }} KG</td>
                                    <td>{{ $bill->volume }} MC</td>
                                    <td>{{ $bill->origin }}</td>
                                    <td>{{ $bill->destination }}</td>
                                    <td>{{ $bill->statusCode }}</td>
                                    <td>{{ $bill->author_name }}</td>
                                    <td>
                                        <a href="{{ route('backend.acceptance.details', [$bill->airWaybill]) }}">view
                                            details</a> |
                                        <a style="color:#8b0000;" href="#">update request</a>
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
