@extends('layouts.nav-less')

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

    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="table-data">
                    <div class="grade">
                        <table>
                            <thead>
                            <tr>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Profile Image</div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Student ID</div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Full Name</div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Gender</div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Class / Section
                                    </div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Guardian Name</div>
                                </th>
                                <th>
                                    <div class="px-2 text-center text-black text-opacity-50 fw-bold">Guardian Phone
                                    </div>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td class="center">
                                    <img src="{{ asset('storage/'.$profile->profile_pic) }}" alt="profile picture"
                                         style="height: 50px; object-fit: contain; border-radius: 50%;"/>
                                </td>
                                <td>
                                    <div class="text-center my-auto">{{ $profile->child_id }}</div>
                                </td>
                                <td>
                                    <div
                                        class="text-center my-auto capitalize">{{ $profile->first_name." ".$profile->middle_name." ".$profile->last_name }}</div>
                                </td>
                                <td>
                                    <div class="text-center my-auto capitalize">{{ $profile->gender }}</div>
                                </td>
                                <td>
                                    <div
                                        class="text-center my-auto capitalize">{{ $profile->classroom->classroom_name }}</div>
                                </td>
                                <td>
                                    <div class="text-center my-auto capitalize">{{ $profile->current_guardian }}</div>
                                </td>
                                <td>
                                    <div class="text-center my-auto capitalize">{{ $profile->guardian_phone }}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="card ">
            <div class="card-header title-header d-inline-flex align-items-center"><h4 class="main-heading">
                    Monthly School Fee</h4></div>

            <div class="card-body">
                <div class="table-data">
                    <div class="grade">
                        <table>
                            <thead class="sticky-top" style="background: var(--light);">
                            <tr>
                                <th class="text-center">Month</th>
                                <th class="text-center">Paid Amount</th>
                                <th class="text-center">Paid At</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Transaction No.</th>
                                <th class="text-center">Late Payment</th>
                                <th class="text-center">Unpaid Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bills as $bill)
                                <tr>
                                    <form method="POST" action="/bill-record/{{ $bill->id }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')

                                        <td class="px-1"><label for="month" class="center">{{ $bill->month }}</label>
                                            <input id="month" type="hidden" name="month" value="{{ $bill->month }}">
                                        </td>

                                        <td class="px-1"><input id="amount-{{ $bill->month }}" class="form-control"
                                                                type="number" name="amount" value="{{ $bill->amount }}"
                                                                max=""
                                                                onchange="calculateRemainder(event)"
                                                                style="min-width: 100px;" required></td>

                                        <td class="px-1">
                                            <select id="paid_at-{{ $bill->month }}" class="form-control w-auto"
                                                    name="paid_at" autofocus>
                                                <option value="none" disabled selected>Paid At</option>
                                                <option
                                                    value="In School"
                                                    @if($bill->paid_at == 'In School' ) selected @endif>
                                                    In School
                                                </option>
                                                @foreach($bankInfos as $bankInfo)
                                                    <option
                                                        value="{{ $bankInfo['bank'] }}"
                                                        @if($bill->paid_at == $bankInfo['bank'] ) selected @endif>
                                                        {{$bankInfo['bank']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="px-1"><input id="date-{{ $bill->month }}" class="form-control w-auto"
                                                                type="date" name="date" value="{{ $bill->date }}"
                                                                style="min-width: 100px;" required></td>

                                        <td class="px-1"><input id="tranx_no-{{ $bill->month }}" class="form-control"
                                                                type="text" name="tranx_no"
                                                                value="{{ $bill->tranx_no }}" style="min-width: 100px;"
                                                                required></td>

                                        <td class="px-1"><input id="late_payment-{{ $bill->month }}" class="form-control"
                                                                type="number" name="late_payment"
                                                                value="{{ $bill->late_payment }}"
                                                                style="min-width: 100px;" required></td>

                                        <td class="px-1"><input id="remainder-{{ $bill->month }}" class="form-control"
                                                                type="number" name="remainder"
                                                                value="{{ $bill->remainder }}" style="min-width: 100px;"
                                                                required></td>

                                        <td class="px-1">
                                            <select
                                                id="status-{{ $bill->month }}"
                                                class="form-control w-auto"
                                                name="status" autofocus>
                                                <option disabled selected>Status</option>
                                                <option
                                                    value="Fully Paid"
                                                    @if($bill->status == 'Fully Paid' ) selected @endif >
                                                    Fully Paid
                                                </option>
                                                <option
                                                    value="Partially Paid"
                                                    @if($bill->status == 'Partially Paid' ) selected @endif>
                                                    Partially Paid
                                                </option>
                                                <option
                                                    value="Overdue" @if($bill->status == 'Overdue' ) selected @endif>
                                                    Overdue
                                                </option>
                                                <option
                                                    value="Unpaid" @if($bill->status == 'Unpaid' ) selected @endif>
                                                    Unpaid
                                                </option>
                                                <option
                                                    value="Dont Show"
                                                    @if($bill->status == 'Dont Show' ) selected @endif>
                                                    Dont Show
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row ">
                    <div class="logo-center mb-1">
                        <a href="/profile" class="btn btn-dark">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        const programFee = {!! json_encode($monthlyFee) !!};

        function calculateRemainder(event){
            let month = event.target.id.split('-')[1];

            const amountField = document.getElementById('amount-'+month);
            const paidDateField = document.getElementById('date-'+month);
            const latePaymentField = document.getElementById('late_payment-'+month);
            const remainderField = document.getElementById('remainder-'+month);
            const statusOption = document.getElementById('status-'+month);

            if (paidDateField.value && amountField.value){

                const weekDifference = getWeekDifference(paidDateField.value, programFee[month]['due_date'])
                const latePayment = programFee[month]['late_payment'] * weekDifference;
                const totalAmount = programFee[month]['amount'] + latePayment;
                const paidAmount = amountField.value;

                console.log(latePayment)
                console.log(totalAmount)

                latePaymentField.value = Math.round(latePayment);
                remainderField.value = Math.round(totalAmount - paidAmount);

                if (paidAmount === 0 && weekDifference > 0){
                    statusOption.value = 'Overdue';
                }
                else if (totalAmount === paidAmount){
                    statusOption.value = 'Fully Paid';
                } else{
                    statusOption.value = 'Partially Paid';
                }

            }
        }

        function getWeekDifference(startDateValue, endDateValue){
            const startDate = new Date(startDateValue);
            const endDate = new Date(endDateValue);

            // Step 3: Calculate the time difference between the two dates in milliseconds
            const timeDifferenceMs = endDate - startDate;

            // Step 4: Convert the time difference to weeks
            const millisecondsInWeek = 1000 * 60 * 60 * 24 * 7;

            return timeDifferenceMs / millisecondsInWeek;
        }
    </script>
@endsection
