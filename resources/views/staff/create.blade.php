@extends('layouts.app') 
@section('title', 'Add Staff')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add Staff</h5>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('staff.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror"
                                id="name" 
                                name="name"
                                placeholder="Enter name"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input 
                                type="tel" 
                                class="form-control @error('mobile') is-invalid @enderror"
                                id="mobile" 
                                name="mobile"
                                placeholder="01XXXXXXXXX"
                                required
                            >
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                id="password" 
                                name="password"
                                placeholder="Enter password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Staff</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
