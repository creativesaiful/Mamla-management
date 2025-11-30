@extends('layouts.app')

@section('content')
    <div class="container-fluid">
         <h2>Update Next Date for Case: {{ $caseDiary->case_number }}</h2>
    <hr>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Set Next Date</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('cases.next-date-store', $caseDiary->id) }}">
                            @csrf
                  

                            <div class="mb-3">
                                <label for="next_date" class="form-label">Next Date</label>
                                <input type="date" id="next_date" name="next_date" class="form-control"
                                    required min="{{ date('Y-m-d') }}">
                                @error('next_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="short_order" class="form-label">Short Order</label>
                                <input type="text" id="short_order" name="short_order" class="form-control"
                                     required>
                                @error('short_order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea id="comments" name="comments" class="form-control" rows="4"> </textarea>
                                @error('comments')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
