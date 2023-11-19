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

  <div class="container m-5 ">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card report">
          <div class="card-header title-header d-inline-flex align-items-center">
            <div class="rounded profile-picture"><img src="{{ asset('image/No-profile.png') }}"
                                                      alt="profile"></div>
            <div
              class="ps-2">{{ $profile->first_name . " " . $profile->middle_name  }}</div>
            <div class="m-auto ps-4">Preparatory / A</div>
            <div class="">
              <div class="col-md-6 logo-center">
                <a href="/profile/classroom/{{auth()->user()->staff->teacher->classroom->id }}"
                   class="btn btn-primary text-bg-warning btn-outline-light" style="width: 150px;">
                  Done
                </a>
              </div>
            </div>
            <input type="hidden" id="profile-id" value="{{ $profile->id }}">
          </div>
          <div class="card-body">

            <!-- Grade Report-->
            <div class="table-data row mb-3">
              <div class="small-heading">
                Grade Report
              </div>
              <div class="grade">
                <div class="quarters">
                  <div class="chevron-btn" id="prev-quarter-btn">
                    <i id="prev" class='bx bx-chevrons-left'></i>
                  </div>
                  <span id="quarter-number"> Quarter 1 </span>
                  <div class="chevron-btn" id="next-quarter-btn">
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
                  </tr>
                  </thead>

                  @php
                    global $count;
                    $count = 0;
                  @endphp

                  @foreach($grades as $grade)
                    @php
                      $count++;
                      $subjects = explode(',', $grade->subjects);
                      $midterm = explode(',', $grade->midterm);
                      $assignment = explode(',', $grade->assignment);
                      $final = explode(',', $grade->final);
                    @endphp


                    <tbody
                      class="quarter {{$grade->quarter}} @if($grade->quarter != 1) {{ 'collapse' }} @endif ">
                    <form method="POST" action="/grade/{{ $grade->id }}/update">
                      @csrf

                      @method('patch')

                      @for($i=0; $i < count($subjects); $i++)

                        <tr id="{{ $i }}">
                          <td>{{ $subjects[$i] }}</td>
                          <td>
                            <input type="number" name="midterm{{$i}}" max="20" min="0"
                                   class="number-input form-control me-2 @error('midterm'.$i) is-invalid @enderror"
                                   value="{{ old('midterm'.$i) ?? trim($midterm[$i] ) }}"
                                   required>
                            @error('comment')
                            <span class="invalid-feedback"
                                  role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                          </td>
                          <td>
                            <input type="number" name="assignment{{$i}}" max="30" min="0"
                                   class="number-input form-control me-2 @error('assignment'.$i) is-invalid @enderror"
                                   value="{{ old('assignment'.$i) ?? old('')?? trim($assignment[$i]) }}"
                                   required>
                          </td>
                          <td>
                            <input type="number" name="final{{$i}}" max="50" min="0"
                                   class="number-input form-control me-2 @error('final'.$i) is-invalid @enderror"
                                   value="{{ old('final'.$i) ?? old('')?? trim($final[$i]) }}"
                                   required>
                          </td>
                        </tr>
                      @endfor
                      <tr>
                        <td>Status</td>
                        <td>
                          <select type="text"
                                  name="status"
                                  class="text-input bg-gradient form-control @error('status') is-invalid @enderror"
                                  required>
                            <option {{ !old('status') ? 'selected': '' }} disabled> Status</option>
                            <option
                              {{ old('status') === 'hide' || $grade->status == 'hide' ? 'selected': '' }} value="hide">
                              Hidden
                            </option>
                            <option
                              {{ old('status') === 'show' || $grade->status == 'show' ? 'selected': '' }} value="show">
                              Show
                            </option>
                          </select>
                        </td>
                        <td></td>
                        <td>
                          <button type="submit" class="btn btn-primary mb-1" title="Update"><i
                              class='bx bx-edit-alt'></i> <span
                              class="show-detail">Update Quarter {{$grade->quarter}}</span>
                          </button>
                        </td>
                      </tr>
                    </form>
                    </tbody>
                  @endforeach

                  @for($i=($count + 1); $i < 5; $i++)

                    <tbody class="quarter {{ $i }} collapse">
                    <tr>
                      <td class="primary-text">
                        No Grades Yet
                      </td>
                    </tr>
                    </tbody>

                  @endfor
                </table>
              </div>
            </div>

            <hr>

            <!-- Attendance Report Table data -->
            <div class="table-data row mb-3">
              <div class="">
                <div id="addAbsenceBtn" class="float-end mb-2 btn btn-secondary d-inline">
                  Add Absence Record
                </div>
                <div class="small-heading float-start">
                  Absence / Attendance
                </div>
              </div>
              <div class="grade">
                <table id="attendance">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Reasons</th>
                    <th>Permission</th>
                    <th>Remark</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody id="absenceTable" class="flex-column-reverse">

                  <form method="POST" action="/attendance/{{ $profile->progress->id }}/create" id="create-attendance">
                    @csrf
                    <tr id="additional" class="collapse">
                      <td><input type="date" name="date" class="text-input form-control"
                                 min="{{ \Carbon\Carbon::now()->startOfYear()->format('Y-m-d') }}"
                                 max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                 required></td>
                      <td><input type="text" name="reason" class="text-input form-control " placeholder="Reasons"
                                 required></td>
                      <td>
                        <select type="text" name="permission" class="text-input form-control" required>
                          <option selected disabled> Permission</option>
                          <option value="Yes"> Yes</option>
                          <option value="No"> No</option>
                        </select>
                      </td>
                      <td><input type="text" name="remark" class="text-input form-control " placeholder="Remarks"
                                 required>
                      <td class="d-flex justify-content-between">
                        <button
                          type="submit"
                          class="d-flex btn btn-success mb-1 align-items-center">
                          <i class='bx bx-save'></i> <span class="show-detail">Save</span>
                        </button>
                      </td>
                    </tr>
                  </form>


                  @foreach($profile->progress->attendance as $attendance)

                    <form method="POST" action="/attendance/{{ $attendance->id }}/update">
                      @csrf
                      @method('patch')

                      <tr>
                        <td>
                          <input type="date" value="{{old('date') ?? $attendance->date}}"
                                 name="date" class="text-input form-control @error('date') is-invalid @enderror"
                                 max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                 required>
                          @error('comment')
                          <span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>
                          @enderror
                        </td>
                        <td>
                          <input type="text" value="{{old('date') ?? $attendance->reason}}"
                                 name="reason" class="text-input form-control @error('reason') is-invalid @enderror"
                                 required>
                          @error('reason')
                          <span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>
                          @enderror
                        </td>
                        <td>
                          <select type="text"
                                  name="permission"
                                  class="text-input form-control @error('permission') is-invalid @enderror"
                                  required>
                            <option
                              {{ old('permission') === 'Yes' || $attendance->permission == 'Yes' ? 'selected': '' }} value="Yes">
                              Yes
                            </option>
                            <option
                              {{ old('permission') === 'No' || $attendance->permission == 'No' ? 'selected': '' }} value="No">
                              No
                            </option>
                          </select>
                          @error('permission')
                          <span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>
                          @enderror
                        </td>
                        <td>
                          <input type="text" value="{{old('date') ?? $attendance->remark}}"
                                 name="remark" class="text-input form-control @error('remark') is-invalid @enderror"
                                 required>
                          @error('remark')
                          <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                          @enderror
                        </td>
                        <td class="d-flex justify-content-between">
                          <button type="submit" class="d-flex align-items-center btn btn-primary mb-1"><i
                              class='bx bx-edit-alt'></i> <span
                              class="show-detail">Update</span></button>
                          <button class="d-flex align-items-center btn btn-danger mb-1"
                                  onclick="
                                                            event.preventDefault();
                                                            document.getElementById('deleteAttendance{{$attendance->id}}').submit(); ">
                            <i class='bx bx-trash'></i> <span class="show-detail">Remove</span>
                          </button>
                        </td>
                      </tr>
                    </form>

                    <form id="deleteAttendance{{$attendance->id}}" method="POST"
                          action="/attendance/{{ $attendance->id }}"
                          onsubmit="let x = confirm('Are you sure you want to delete the message')">
                      @csrf
                      @method('delete')

                    </form>
                  @endforeach

                  </tbody>
                </table>
              </div>
            </div>

            <hr>

            <!-- Performance data -->
            <form method="POST" action="/progress/{{ $profile->progress->id }}">
              @csrf

              @method('patch')

              <div class="row mb-3">
                <div class="small-heading">
                  Performance
                </div>
                <div class="d-flex">
                  <div class="col-md-4">
                    <lable for="behavior" class="pb-2">Behavior</lable>
                    <label>
                      <select id="behavior" type="text" name="behavior" class="form-control me-2">
                        <option
                          {{ !($profile->progress->behavior) ? 'selected' : '' }} disabled>
                          Not Selected
                        </option>
                        <option
                          value="Excellent" {{ old('behavior' == 'Excellent') || ($profile->progress->behavior == 'Excellent') ? 'selected' : '' }}>
                          Excellent
                        </option>
                        <option
                          value="Very Good" {{ old('behavior' == 'Very Good') || ($profile->progress->behavior == 'Very Good') ? 'selected' : '' }}>
                          Very Good
                        </option>
                        <option
                          value="Good" {{ old('behavior' == 'Good') || ($profile->progress->behavior == 'Good') ? 'selected' : '' }}>
                          Good
                        </option>
                        <option
                          value="Poor" {{ old('behavior' == 'Poor') || ($profile->progress->behavior == 'Poor') ? 'selected' : '' }}>
                          Poor
                        </option>
                        <option
                          value="Alarming" {{ old('behavior' == 'Alarming') || ($profile->progress->behavior == 'Alarming') ? 'selected' : '' }}>
                          Alarming
                        </option>
                      </select>
                    </label>
                  </div>
                  <div class="col-md-4">
                    <lable for="participation" class="pb-2">Participation</lable>
                    <label>
                      <select id="participation" type="text" name="participation"
                              class="form-control me-2 @error('participation') is-invalid @enderror">
                        <option
                          {{ !($profile->progress->participation) ? 'selected' : '' }} disabled>
                          Not Selected
                        </option>
                        <option
                          value="Excellent" {{ old('behavior' == 'Excellent') || ($profile->progress->participation == 'Excellent') ? 'selected' : '' }}>
                          Excellent
                        </option>
                        <option
                          value="Very Good" {{ old('behavior' == 'Very Good') || ($profile->progress->participation == 'Very Good') ? 'selected' : '' }}>
                          Very Good
                        </option>
                        <option
                          value="Good" {{ old('behavior' == 'Good') || ($profile->progress->participation == 'Good') ? 'selected' : '' }}>
                          Good
                        </option>
                        <option
                          value="Poor" {{ old('behavior' == 'Poor') || ($profile->progress->participation == 'Poor') ? 'selected' : '' }}>
                          Poor
                        </option>
                        <option
                          value="Alarming" {{ old('behavior' == 'Alarming') || ($profile->progress->participation == 'Alarming') ? 'selected' : '' }}>
                          Alarming
                        </option>
                      </select>
                    </label>
                  </div>
                  <div class="col-md-4">
                    <lable for="teamwork" class="pb-2">Teamwork</lable>
                    <label>
                      <select id="teamwork" type="text" name="teamwork"
                              class="form-control me-2 @error('teamwork') is-invalid @enderror">
                        <option
                          {{ !($profile->progress->teamwork) ? 'selected' : '' }} disabled>
                          Not Selected
                        </option>
                        <option
                          value="Excellent" {{ old('behavior' == 'Excellent') || ($profile->progress->teamwork == 'Excellent') ? 'selected' : '' }}>
                          Excellent
                        </option>
                        <option
                          value="Very Good" {{ old('behavior' == 'Very Good') || ($profile->progress->teamwork == 'Very Good') ? 'selected' : '' }}>
                          Very Good
                        </option>
                        <option
                          value="Good" {{ old('behavior' == 'Good') || ($profile->progress->teamwork == 'Good') ? 'selected' : '' }}>
                          Good
                        </option>
                        <option
                          value="Poor" {{ old('behavior' == 'Poor') || ($profile->progress->teamwork == 'Poor') ? 'selected' : '' }}>
                          Poor
                        </option>
                        <option
                          value="Alarming" {{ old('behavior' == 'Alarming') || ($profile->progress->teamwork == 'Alarming') ? 'selected' : '' }}>
                          Alarming
                        </option>
                      </select>
                    </label>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="small-heading">
                  Focus Area
                </div>
                <div class="d-flex">
                  <div class="col-md-6 me-2">
                    <label for="strength" class="pb-2">Strength (Comma Separated)</label>
                    <input id="strength" type="text" name="strength"
                           class="form-control me-2 @error('strength') is-invalid @enderror"
                           value="{{ $profile->progress->strength}}">
                    @error('strength')
                    <span class="invalid-feedback"
                          role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                  <div class="col-md-6 me-2">
                    <label for="weakness" class="pb-2">Poor Performance (Comma Separated)</label>
                    <input id="weakness" type="text" name="weakness"
                           class="form-control me-2 @error('weakness') is-invalid @enderror"
                           value="{{ $profile->progress->weakness}}">
                    @error('weakness')
                    <span class="invalid-feedback"
                          role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="small-heading">
                  Comment
                </div>
                <label for="comment" class="col-md-4 col-form-label text-md-end"> Teacher's
                  Comment </label>

                <div class="col-md-6">
                                    <textarea id="comment" type="text"
                                              class="form-control @error('comment') is-invalid @enderror"
                                              name="comment"
                                              required>{{ old('comment') ?? $profile->progress->comment}}</textarea>
                  @error('comment')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="d-flex justify-content-around">
                <div class="col-md-6 logo-center">
                  <button type="submit" class="btn btn-primary"><i
                      class='bx bx-edit-alt'></i> <span
                      class="show-detail">Update</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
