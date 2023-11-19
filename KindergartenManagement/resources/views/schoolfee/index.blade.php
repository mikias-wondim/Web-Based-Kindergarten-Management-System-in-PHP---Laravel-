@extends('layouts.app')

@section('content')

    @if(Session::has('success'))
        <div class="bg-transparent d-flex justify-content-center fixed-bottom mb-3 p-3 ">
            <div id="flash-message" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            <script>
                setTimeout(function () {
                    document.getElementById('flash-message').classList.add('collapse');
                }, 3000);
            </script>
        </div>
    @endif

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1 class="heading">School Fee</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li>
                            <a class="active" href="#">School Fee</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="">
                <div class="center">
                    <div class="card" style="max-width: 500px">
                        <div class="card-header title-header ">School Fee </div>

                        <div class="card-body">
                            <form method="POST" action="/schoolfee" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <input id="id" type="hidden" name="id">

                                <div class="row mb-3">
                                    <label for="classroom" class="col-md-4 col-form-label text-md-end">
                                        Program</label>
                                    <div class="dropdown col-md-4">
                                        <select id="classroom" onchange="classroomSelected()"
                                                class="form-control dropdown-input @error('classroom') is-invalid @enderror"
                                                style="min-width: 200px;"
                                                name="classroom" autofocus >
                                            <option disabled selected>Grade</option>
                                            @foreach($classroomList as $classroom)
                                                <option
                                                    value="{{ $classroom}}" {{ old('classroom') == $classroom ? 'selected': ''}}>{{ $classroom }}</option>
                                            @endforeach
                                        </select>
                                        @error('classroom')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="month" class="col-md-4 col-form-label text-md-end">Month</label>
                                    <div class="dropdown col-md-4">
                                        <select id="month" onchange="selectMonth()"
                                                class="form-control dropdown-input @error('month') is-invalid @enderror"
                                                style="min-width: 200px;"
                                                name="month" autofocus >
                                            <option disabled selected>Month</option>
                                            @foreach($months as $month)
                                                <option
                                                    onselect="alert('selected')"
                                                    value="{{ $month }}" {{ old('month') == $month ? 'disabled': ''}}>{{ $month }}</option>
                                            @endforeach

                                        </select>
                                        @error('month')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="amount" class="col-md-4 col-form-label text-md-end"> Amount
                                    </label>

                                    <div class="col-md-6">
                                        <input id="amount" type="number" style="max-width: 200px"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               name="amount" value="{{ old('amount') }}" required autofocus>

                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="due_date" class="col-md-4 col-form-label text-md-end">Due
                                        Date</label>

                                    <div class="col-md-6">
                                        <input id="due_date" type="date" style="max-width: 200px"
                                               min="{{ \Carbon\Carbon::now()->firstOfYear()->format('Y-m-d') }}"
                                               max="{{ \Carbon\Carbon::now()->firstOfYear()->addYear()->format('Y-m-d') }}"
                                               class="form-control @error('due_date') is-invalid @enderror"
                                               name="due_date" value="{{ old('due_date') }}" required
                                               autofocus>

                                        @error('due_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="late_payment" class="col-md-4 col-form-label text-md-end"> Late Payment (Birr Per Week)
                                    </label>

                                    <div class="col-md-6">
                                        <input id="late_payment" type="number" style="max-width: 200px"
                                               class="form-control @error('late_payment') is-invalid @enderror"
                                               name="late_payment" value="{{ old('late_payment') }}" required autofocus>

                                        @error('late_payment')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-12 logo-center">
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->

        <script>


            const programFees = {!! json_encode($schoolFee) !!};

            const classroomOption = document.getElementById('classroom');
            const programFeeId = document.getElementById('id');
            const monthOption = document.getElementById('month');
            const amountField = document.getElementById('amount');
            const dueDateField = document.getElementById('due_date');
            const latePaymentField = document.getElementById('late_payment');

            let selectedProgram;
            let month;

            function classroomSelected(){
                selectedProgram = classroomOption.value;
                if(month){
                    programFees[selectedProgram].forEach((monthlyFee)=>{
                        if(monthlyFee['month'] === month){
                            programFeeId.value = monthlyFee['id'];
                            amountField.value = monthlyFee['amount'];
                            dueDateField.value = dateFormat(monthlyFee['due_date']);
                            latePaymentField.value = monthlyFee['late_payment'];
                        }
                    })
                }
            }

            function selectMonth(){
                month = monthOption.value;
                if(selectedProgram){
                    programFees[selectedProgram].forEach((monthlyFee)=>{
                        if(monthlyFee['month'] === month){
                            programFeeId.value = monthlyFee['id'];
                            amountField.value = monthlyFee['amount'];
                            dueDateField.value = dateFormat(monthlyFee['due_date']);
                            latePaymentField.value = monthlyFee['late_payment'];
                        }
                    })
                }
            }

            function dateFormat(originalDateValue){
                const originalDateObject = new Date(originalDateValue);

                // Step 3: Format the date as a string in the desired format
                const year = originalDateObject.getFullYear();
                const month = String(originalDateObject.getMonth() + 1).padStart(2, '0');
                const day = String(originalDateObject.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

        </script>
        <!-- MAIN -->

@endsection
