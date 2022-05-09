@extends('backend.layouts.app')

@section('name')
    Users
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <a href="#" class="btn btn-secondary float-end ml-2">
                    <i class="uil uil-export me-1"></i> Export PDF
                </a>
                <a href="{{ route('backend.signees.create') }}" class="btn btn-secondary me-4 mb-2 mb-md-0">
                    <i class="uil-plus me-1"></i> Add a new signee
                </a>

                <div class="table-responsive mt-4">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">Designation</th>
                                <th scope="col">passcode</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['designation'] }}</td>
                                    <td>{{ substr($user['passcode'], 0, 3) }} ***</td>
                                    <td>
                                        <a href="{{ route('backend.signees.edit', [$user['userid']]) }}">edit user</a>
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
