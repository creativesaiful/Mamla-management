@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-3">

        @if ($cases->isEmpty())
            <p>No cases scheduled for today.</p>
        @else
            <div class="table-responsive">
                <table id="today-cases-table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-today"></th>
                            <th>মামলা নং</th>
                            <th>কোর্ট</th>
                            <th>বাদী</th>
                            <th>বিবাদী</th>
                            <th>মোবাইল</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr>
                                <td>
                                    <input type="checkbox" class="case-checkbox" data-mobile="{{ $case->client_mobile }}">
                                </td>
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->court->court_name }}</td>
                                <td>{{ $case->plaintiff_name }}</td>
                                <td>{{ $case->defendant_name }}</td>
                                <td><a href="tel:{{ $case->client_mobile }}">{{ $case->client_mobile }}</a></td>
                                <td>
                                    <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- SEND SMS BUTTON --}}
            <button class="btn btn-success mt-3" onclick="showSmsModal()">Send SMS to Selected</button>
        @endif
    </div>
</div>

{{-- SMS MODAL --}}
<div class="modal fade" id="smsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('send.sms') }}" method="POST">
            @csrf
            <div class="modal-content p-3">

                <h4>Send SMS to Clients</h4>

                {{-- Static message --}}
                <textarea id="sms-message" class="form-control mt-2" name="sms_text" rows="5" required>
আপনার মামলার আপডেট এসেছে। অনুগ্রহ করে সময়মতো পদক্ষেপ গ্রহণ করুন।
                </textarea>

                {{-- HIDDEN INPUT FOR PHONE NUMBERS --}}
                <input type="hidden" name="mobiles" id="selectedMobiles">

                <button class="btn btn-primary mt-3">Send Now</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // DataTable
    $('#today-cases-table').DataTable({
        dom: 'Bfrtip',
        paging: true,
        pageLength: 25,
        lengthChange: true,
        info: true,
        buttons: [
            { extend: 'pdfHtml5', text: '📄 Export PDF', className: 'btn btn-danger btn-sm', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
            { extend: 'print', text: '🖨️ Print Table', className: 'btn btn-success btn-sm', exportOptions: { columns: ':not(:first-child):not(:last-child)' } }
        ]
    });

    // Select all
    document.getElementById('select-all-today').addEventListener('change', function(e){
        document.querySelectorAll('#today-cases-table .case-checkbox').forEach(cb => cb.checked = e.target.checked);
    });
});

// Show SMS modal
function showSmsModal() {
    let selected = document.querySelectorAll('#today-cases-table .case-checkbox:checked');
    if(selected.length === 0) { alert('Please select at least one case.'); return; }

    let phones = [];
    selected.forEach(cb => phones.push(cb.dataset.mobile));

    document.getElementById('selectedMobiles').value = phones.join(',');
    
    const smsModal = new bootstrap.Modal(document.getElementById('smsModal'));
    smsModal.show();
}
</script>
@endpush
