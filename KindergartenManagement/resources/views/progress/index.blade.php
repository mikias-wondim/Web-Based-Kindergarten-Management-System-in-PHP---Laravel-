@extends('layouts.app')

@section('content')
            <!-- MAIN -->
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1 class="heading">Report</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="/home" class="active">Dashboard</a>
                            </li>
                            <li><i class="bx bx-chevron-right"></i></li>
                            <li>
                                <a class="active" href="#">Report</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="social-skills">
                    <div class="headline">
                        <h3 class="heading">Performances</h3>
                    </div>
                    <ul class="box-info">
                        <li>
                            <i class="bx bxs-calendar-check"></i>
                            <span class="text">
                <h3>{{ $profile->progress->behavior ?? 'Not Evaluated'}} </h3>
                <p>Behaviour</p>
              </span>
                        </li>
                        <li>
                            <i class="bx bxs-group"></i>
                            <span class="text">
                <h3>{{ $profile->progress->teamwork ?? 'Not Evaluated'}}</h3>
                <p>Team Work</p>
              </span>
                        </li>
                        <li>
                            <i class="bx bxs-hand-up"></i>
                            <span class="text">
                <h3>{{ $profile->progress->participation ?? 'Not Evaluated'}}</h3>
                <p>Participation</p>
              </span>
                        </li>
                    </ul>

                    <div class="headline">
                        <h3 class="heading">Focus Area</h3>
                    </div>
                    <ul class="box-info">
                        <li>
                            <i class='bx bx-like'></i>
                            <span class="text">
                <h3>{{ $profile->progress->strength ?? 'Not Evaluated'}}</h3>
                <p>Areas of Strength</p>
              </span>
                        </li>
                        <li>
                            <i class='bx bx-target-lock'></i>
                            <span class="text">
                <h3>{{ $profile->progress->weakness ?? 'Not Evaluated'}}</h3>
                <p>Area of Poor Performance</p>
              </span>
                        </li>
                    </ul>

                </div>

                <!-- Grade Report Table Data's -->

                <div class="table-data">
                    <div class="grade">
                        <div class="head">
                            <h3 class="heading">Grade Report</h3>
                            <!-- <i class='bx bx-search' ></i>
                                      <i class='bx bx-filter' ></i> -->
                        </div>
                        <div class="quarters">
                            <div id="prev-quarter-btn" class="chevron-btn">
                                <i id="prev" class='bx bx-chevrons-left'></i>
                            </div>
                            <span id="quarter-number">
                                Quarter 1
                            </span>
                            <div id="next-quarter-btn" class="chevron-btn">
                                <i id="next" class='bx bx-chevrons-right'></i>
                            </div>
                        </div>
                        <table>
                            <thead>
                            <tr>
                                <th>Subject</th>
                                <th><span class="show-detail">Mid Term </span>(30%)</th>
                                <th>
                                    <span class="show-detail">Assignment & Worksheet </span>(20%)
                                </th>
                                <th><span class="show-detail">Final Exam </span>(50%)</th>
                                <th><span class="show-detail">Total </span>(100%)</th>
                                <th>Grade<span class="show-detail">/Remark </span></th>
                            </tr>
                            </thead>

                            @php
                                global $count;
                                $count = 0;

                                function getLetter($total){
                                        if ($total >= 90){
                                            return 'A';
                                        } else if ($total >= 80){
                                            return 'B';
                                        }
                                        else if ($total >= 70){
                                            return 'C';
                                        }
                                        else if ($total >= 60){
                                            return 'D';
                                        } else{
                                            return 'F';
                                        }
                                    }

                                    function getRemark($letter){
                                        if ($letter == 'A'){
                                            return 'Excellent';
                                        } else if ($letter == 'B'){
                                            return 'Very Good';
                                        } else if ($letter == 'C'){
                                            return 'Good';
                                        } else if ($letter == 'D'){
                                            return 'Poor';
                                        } else{
                                            return 'fail';
                                        }
                                    }

                            @endphp

                            @foreach($grades as $index => $grade)
                                @if($grade->status == 'show')
                                    @php
                                        $count++;
                                        $subjects = explode(',', $grade->subjects);
                                        $midterm = explode(',', $grade->midterm);
                                        $assignment = explode(',', $grade->assignment);
                                        $final = explode(',', $grade->final);
                                    @endphp
                                    <tbody
                                        class="quarter {{$grade->quarter}} @if($grade->quarter != 1) {{ 'collapse' }} @endif ">

                                    @for($i=0; $i < count($subjects); $i++)

                                        <tr>
                                            <td>{{ $subjects[$i] }}</td>
                                            <td>{{ $mid =  $midterm[$i] ?? 0 }}</td>
                                            <td>{{ $assign = $assignment[$i] ?? 0}}</td>
                                            <td>{{ $final = $final[$i] ?? 0}}</td>
                                            <td>{{ $total = intval($mid) + intval($assign) + intval($final) }}</td>
                                            <td>
                                            <span class="status {{ strtolower (getRemark(getLetter($total)))}}">
                                                {{ getLetter($total) }}
                                                <span class="show-detail">/ {{ getRemark(getLetter($total)) }}</span>
                                            </span>
                                            </td>
                                        </tr>
                                    @endfor

                                    </tbody>
                                @else
                                    <tbody
                                        class="quarter {{$grade->quarter}} @if($grade->quarter != 1) {{ 'collapse' }} @endif ">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="center"><i class='bx bx-bell-off bx-tada fs-3' style='color:#272def' ></i></td>
                                            <td class="primary-text">
                                               <h3 class="nunito"> Not Graded Yet </h3>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                @endif

                            @endforeach
                        </table>
                    </div>
                </div>

                <!-- Attendance Report Table data -->
                <div class="table-data">
                    <div class="grade">
                        <div class="head">
                            <h3 class="heading">Absence Report (Attendance)</h3>
                        </div>
                        <table>
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reasons</th>
                                <th>Permission</th>
                                <th>Remark</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date }}</td>
                                    <td>{{ $attendance->reason }}</td>
                                    <td>{{ $attendance->permission }}</td>
                                    <td class="status good">{{ $attendance->remark }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Teacher's Comment -->
                <div class="table-data">
                    <div class="grade">
                        <div class="head center">
                            <h1 class="sub-heading">Teacher's Comment</h1>
                            <p class="text fs-5">
                                {{ $profile->progress->comment }}
                            </p>
                            @if($profile->classroom->teacher->toArray())
                                <p class="small-heading">From {{ $profile->classroom->teacher[0]->staff->first_name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
            <!-- MAIN -->
        <!-- CONTENT -->
@endsection
