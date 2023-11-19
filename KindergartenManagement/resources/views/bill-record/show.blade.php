@extends('layouts.app')

@section('content')
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Billing</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Billing</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bank-info center mb-2">
            <form id="paymentForm">
                <label for="bankSelect">To get bank account information select a particular bank</label>
                <select id="bankSelect" onchange="displayPaymentInfo()">
                    <option disabled selected>Select a bank...</option>
                    @foreach($bankInfos as $bankInfo)
                        <option value="{{ $bankInfo['bank'] }}">{{ $bankInfo['bank'] }}</option>
                    @endforeach
                </select>

                <div id="paymentInfoContainer">
                    <!-- Payment information will be displayed here based on the selected bank -->
                </div>
            </form>
        </div>

        <div class="quarter">
            <h2 class="heading">Monthly School Fee Records</h2>
            <div class="quarter-list">

                @foreach($months as $month)

                    @if($month->status == "Fully Paid" || $month->status == "Partially Paid")
                        <div class="month card">
                            <h2 class="sub-heading card-header">{{ $month->month }}</h2>
                            <p><strong>Status: </strong> <span class="float-end">{{ $month->status }}</span></p>
                            <p><strong>Amount: </strong> <span class="float-end">{{ $month->amount }} Br.</span></p>
                            <p><strong>Date: </strong> <span class="float-end">{{ $month->date }}</span></p>
                            <p><strong>Paid At: </strong> <span class="float-end">{{ $month->paid_at }}</span></p>
                            @if($month->late_payment)
                                <p><strong>Late Payment: </strong> <span
                                        class="float-end">{{ $month->late_payment}}</span></p>
                            @endif
                            @if($month->remainder)
                                <p><strong>Late Payment: </strong> <span
                                        class="float-end">T{{ $month->remainder}}</span></p>
                            @endif
                            <p><strong>Transaction No. : </strong> <span
                                    class="float-end">T{{ $month->tranx_no }}</span></p>
                        </div>
                    @elseif($monthlyFee[$month->month]['due_date'])
                        @if(\Carbon\Carbon::now()->isBefore(\Carbon\Carbon::createFromFormat('Y-d-m', $monthlyFee[$month->month]['due_date'])))
                            <div class="month card deadline">
                                <h2 class="sub-heading card-header">{{ $month->month }}</h2>
                                <p><strong>Status: </strong> <span class="float-end">Overdue</span></p>
                                <p><strong>Amount: </strong> <span class="float-end">
                                                {{ ($monthAmount = $monthlyFee[$month->month]['amount']) . " + ".  ($latePayment = ($monthlyFee[$month->month]['late_payment'] * \Carbon\Carbon::now()->diffInWeeks(\Carbon\Carbon::createFromFormat('Y-d-m', $monthlyFee[$month->month]['due_date']))) ) . " = " . ($monthAmount + $latePayment )  }}
                                                    Br.</span></p>
                                <p><strong>Due Date was: </strong> <span class="float-end">{{ $monthlyFee[$month->month]['due_date'] }}</span></p>
                                <p><strong>Where to pay: </strong> <span class="float-end"> List of Banks mentioned above</span>
                                </p>
                                <p><strong>Late Payment: </strong> <span class="float-end">{{ $latePayment }}</span></p>
                                <p><strong>Unpaid Amount: </strong> <span
                                        class="float-end">{{ $monthAmount + $latePayment }}</span></p>
                            </div>
                        @endif
                    @elseif($month->status == 'Unpaid')
                        <div class="month card un-paid">
                            <h2 class="sub-heading card-header">{{ $month->month }}</h2>
                            <p><strong>Status: </strong> <span class="float-end">Un Paid</span></p>
                            <p><strong>Amount: </strong> <span class="float-end">{{ $monthlyFee[$month->month]['due_date'] }} Br.</span></p>
                            <p><strong>Due Date: </strong> <span class="float-end">{{ $monthlyFee[$month->month]['due_date'] }}</span></p>
                            <p><strong>Where to pay: </strong> <span
                                    class="float-end"> List of Banks mentioned above</span></p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>
    <!-- MAIN -->

    <script>

        function displayPaymentInfo() {
            const bankSelect = document.getElementById('bankSelect');
            const selectedBank = bankSelect.value;
            const paymentInfoContainer = document.getElementById('paymentInfoContainer');

            // Clear the payment information container
            paymentInfoContainer.innerHTML = '';

            const bankInfos = {!! json_encode($bankInfos) !!};

            const bankInfo = bankInfos.filter((bankInfo) => bankInfo['bank'] === selectedBank)


            const bankAccountElement = document.createElement('p');
            bankAccountElement.textContent = 'Bank Account: ' + bankInfo[0]['account'];

            const accountNameElement = document.createElement('p');
            accountNameElement.textContent = 'Account Name: ' + bankInfo[0]['name'];

            // Append elements to the payment information container
            paymentInfoContainer.appendChild(bankAccountElement);
            paymentInfoContainer.appendChild(accountNameElement);

        }
    </script>
    <!-- MAIN -->

@endsection
