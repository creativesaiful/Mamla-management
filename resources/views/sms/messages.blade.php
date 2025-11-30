@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📨 SMS Sending History</h3>

    <div class="card shadow">
        <div class="card-body">
            <table id="smsTable" class="table table-striped table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Mobile</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Response</th>
                        <th>Sent By</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $log)
                        <tr>
                            <td>{{ $log->mobile }}</td>
                            <td>{{ $log->message }}</td>

                            <td>
                                @if ($log->status == 'success')
                                    <span class="badge bg-success">Success</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>

                            @php
                                $res = json_decode($log->response, true);
                                $code = $res['response_code'] ?? null;
                            @endphp
                            <td>
                                @if($code == 202)
                                    <span class="badge bg-success">{{ sms_response_text($code) }}</span>
                                @elseif($code)
                                    <span class="badge bg-danger">{{ sms_response_text($code) }}</span>
                                @else
                                    <span class="badge bg-secondary">No Response</span>
                                @endif
                            </td>

                            <td>{{ $log->user->name }}</td>
                            <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No SMS records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#smsTable').DataTable({
        responsive: true,
        pageLength: 100,
        order: [[5, 'desc']],
        dom: 'Bfltip', // Buttons + filter + table + pagination
        buttons: [
            'pdf'
        ],
        language: {
            search: "🔍 Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ messages",
        },
        searchHighlight: true
    });
});
</script>
@endpush
