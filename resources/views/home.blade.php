@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="">
            <div class="card p-3">

                {{-- DATE DISPLAY --}}
                <h3>
                    Date:
                    @if ($selectedDate instanceof \Carbon\Carbon)
                        {{ $selectedDate->format('d-m-Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($selectedDate)->format('d-m-Y') }}
                    @endif
                </h3>

                {{-- DATE FILTER --}}
                <div class="mb-3 ">
                    <form id="date-filter-form" class="row justify-content-between" action="{{ route('dashboard') }}"
                        method="GET">
                        <div class="col-md-8 mb-2 row justify-content-between">
                            <div class="col-md-8">
                                <input type="date" id="date-filter" name="selected_date" class="form-control"
                                    value="{{ $selectedDate instanceof \Carbon\Carbon ? $selectedDate->format('d-m-Y') : $selectedDate }}">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Filter" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- TABLE --}}
                @if ($todayCases->isEmpty())
                    <p>No cases scheduled for today.</p>
                @else
                    <div class="table-responsive">
                        <table id="today-cases-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>মামলা নং</th>
                                    <th>কোর্ট </th>
                                    <th>বাদী</th>
                                    <th>বিবাদী</th>
                                    <th>মোবাইল</th>
                                    <th>স্টেজ</th>
                                    <th>পঃ তাং</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($todayCases as $case)
                                    @php
                                        $nextDate = \App\Models\Date::where('case_id', $case->case_id)
                                            ->where('next_date', '>', today())
                                            ->orderBy('next_date', 'asc')
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td>
                                            <input type="checkbox" class="case-checkbox"
                                            
                                                data-mobile="{{ $case->caseDiary->client_mobile }}"
                                                data-case="{{ $case->caseDiary->case_number }}"
                                                data-date="{{ $nextDate ? $nextDate->next_date->format('d-m-Y') : 'Not Set' }}"
                                            >
                                        </td>
                                        <td>{{ $case->caseDiary->case_number }}</td>
                                        <td>{{ $case->caseDiary->court->court_name }}</td>
                                        <td>{{ $case->caseDiary->plaintiff_name }}</td>
                                        <td>{{ $case->caseDiary->defendant_name }}</td>
                                        <td>
                                            <a href="tel:{{ $case->caseDiary->client_mobile }}">
                                                {{ $case->caseDiary->client_mobile }}
                                            </a>
                                        </td>
                                        <td>{{ $case->short_order }}</td>
                                        <td>
                                            @if ($nextDate)
                                                {{ $nextDate->next_date->format('m-d-Y') }}
                                            @else
                                                <span class="text-danger">Not Set</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($nextDate)
                                                <a href="{{ route('cases.date-edit', $nextDate->id) }}"
                                                    class="btn btn-sm btn-danger">Edit</a>
                                            @else
                                                <a href="{{ route('cases.next-date-create', $case->case_id) }}"
                                                    class="btn btn-sm btn-success">Set Next Date</a>
                                            @endif

                                            <a href="{{ route('cases.show', $case->case_id) }}" 
                                               class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{-- SEND SMS BUTTON --}}
                    <button class="btn btn-success mt-3" onclick="showSmsModal()">
                        Send SMS to Selected
                    </button>

                @endif
            </div>
        </div>
    </div>


    {{-- SMS MODAL --}}
    <div class="modal fade" id="smsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('send.sms') }}" method="POST">
                @csrf

                <div class="modal-content p-3">

                    <h4>Send SMS to Clients</h4>

                    <textarea class="form-control mt-2" name="sms_text" rows="5" required>
আপনার মামলার নাম্বার [case], পরবর্তী তারিখ [date]।
                    </textarea>

                    {{-- HIDDEN INPUT FOR PHONE NUMBERS --}}
                    <input type="hidden" name="mobiles" id="selectedMobiles">

                    <button class="btn btn-primary mt-3">
                        Send Now
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection


@push('scripts')
<script>
    // Select all checkbox
    document.getElementById("select-all").addEventListener("change", function(e) {
        document.querySelectorAll(".case-checkbox").forEach(cb => cb.checked = e.target.checked);
    });

    // Open modal
    function showSmsModal() {
        let selected = document.querySelectorAll(".case-checkbox:checked");

        if (selected.length === 0) {
            alert("Please select at least one case.");
            return;
        }

        let phones = [];

        selected.forEach(cb => {
            phones.push(cb.dataset.mobile);
        });

        document.getElementById("selectedMobiles").value = phones.join(",");

        $("#smsModal").modal("show");
    }
</script>

{{-- DATATABLE --}}
<script>
$(document).ready(function() {
    $('#today-cases-table').DataTable({
        dom: 'Bfrtip',
        paging: true,
        pageLength: 25,
        lengthChange: true,
        info: true,
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '📄 Export PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: { columns: ':not(:first-child):not(:last-child)' }
            },
            {
                extend: 'print',
                text: '🖨️ Print Table',
                className: 'btn btn-success btn-sm',
                exportOptions: { columns: ':not(:first-child):not(:last-child)' }
            }
        ]
    });
});
</script>
@endpush
