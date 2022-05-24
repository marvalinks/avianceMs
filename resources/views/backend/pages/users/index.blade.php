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
                <a href="{{ route('backend.users.create') }}" class="btn btn-secondary me-4 mb-2 mb-md-0">
                    <i class="uil-plus me-1"></i> Add a new user
                </a>

                <div class="table-responsive mt-4">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">staffID</th>
                                <th scope="col">username</th>
                                <th scope="col">name</th>
                                <th scope="col">email</th>
                                <th scope="col">telephone</th>
                                <th scope="col">role</th>
                                <th scope="col">statusCode</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user['staffid'] ?? 'NO ID' }}</td>
                                    <td>{{ $user['username'] ?? '' }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['telephone'] ?? '-' }}</td>
                                    <td>{{ $user['designation'] }}</td>
                                    <td>
                                        <div class="badge bg-{{ $user['active'] ? 'success' : 'danger' }}">
                                            {{ $user['active'] ? 'online' : 'offline' }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.users.edit', [$user['id']]) }}">edit user</a>
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
