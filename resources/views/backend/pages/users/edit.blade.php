@extends('backend.layouts.app')

@section('name')
    Users
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.users.edit', [$user->id]) }}" autocomplete="off" class="row mtop-30"
                    method="post">
                    @csrf
                    <div class="col-md-12">
                        <p class="sub-header">User info</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="span-red">*</span></label>
                            <input type="text" required name="name" class="form-control flatpickr-input"
                                value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Email <span class="span-red">*</span></label>
                            <input type="text" required name="email" class="form-control flatpickr-input"
                                value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Telephone</label>
                            <input type="text" name="telephone" class="form-control flatpickr-input"
                                value="{{ $user->telephone }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Change password </label>
                            <input type="text" name="password" class="form-control flatpickr-input" value="Change password">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Role <span class="span-red">*</span></label>
                            <select name="role" required id="" class="form-control">
                                <option value="">-choose-</option>
                                <option value="1" {{ $user->roleid == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $user->roleid == 2 ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Staff ID</label>
                            <input type="text" name="staffid" class="form-control flatpickr-input"
                                value="{{ $user->staffid }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Username <span class="span-red">*</span></label>
                            <input type="text" name="username" required class="form-control flatpickr-input"
                                value="{{ $user->username ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Active <span class="span-red">*</span></label>
                            <select required name="active" id="" class="form-control">
                                <option value="">-choose-</option>
                                <option value="1" {{ $user->active ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $user->active ? '' : 'selected' }}>No</option>
                            </select>
                        </div>
                    </div>

            </div>
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary submit-btn">Save & Submit</button>
                </div>
            </div>
            </form>

        </div>
    </div>
    </div>
@endsection
