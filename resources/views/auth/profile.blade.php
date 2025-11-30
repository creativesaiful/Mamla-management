@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-sm border-0">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ $user->name }}</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ asset($user->images[0]->image ?? 'assets/img/profile.jpg')   }}"
                                 class="img-fluid rounded-circle border border-secondary"
                                 alt="Profile Picture"
                                 style="width:180px; height:180px; object-fit:cover;">
                        </div>

                        <!-- Profile Info -->
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-person-fill me-2 text-primary"></i>
                                    <strong>Name:</strong> &nbsp; {{ $user->name }}
                                </li>

                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-award-fill me-2 text-warning"></i>
                                    <strong>Role:</strong> &nbsp; 
                                    <span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span>
                                </li>

                                @if ($user->isLawyer())
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-briefcase-fill me-2 text-success"></i>
                                        <strong>Bar Association:</strong> &nbsp; {{ $user->bar_number }}
                                    </li>
                                @elseif ($user->isStaff())
                                    @php
                                        $lawyer = \App\Models\User::where('chamber_id', $user->chamber_id)
                                                                 ->where('role', 'lawyer')->first();
                                    @endphp
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-person-badge-fill me-2 text-success"></i>
                                        <strong>Lawyer Name:</strong> &nbsp; {{ $lawyer->name ?? 'N/A' }}
                                    </li>
                                @endif

                                @if ($user->isLawyer() || $user->isStaff())
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-building me-2 text-secondary"></i>
                                        <strong>Chamber No:</strong> &nbsp; {{ $user->chamber->chamber_no ?? 'N/A' }}
                                    </li>
                                @endif

                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                                    <strong>Address:</strong> &nbsp; {{ $user->address ?? 'N/A' }}
                                </li>

                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-telephone-fill me-2 text-info"></i>
                                    <strong>Phone:</strong> &nbsp; {{ $user->mobile ?? 'N/A' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center text-muted">
                    Last updated: {{ $user->updated_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
