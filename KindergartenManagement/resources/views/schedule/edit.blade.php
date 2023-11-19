@php use Carbon\Carbon; @endphp
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

    <div class="container my-5 ">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card report mx-0">
                    <div class="card-header title-header d-inline-flex align-items-baseline justify-content-between">
                        <h3 class="headlines">Schedule</h3>
                        <h5 class="blue-text">{{ Carbon::now()->monthName }}, {{ Carbon::now()->year }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="/schedule/{{ $schedule->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="table-data">
                                <div class="grade">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="text-center">Time/Day</th>
                                            <th class="text-center">Mon<span class="show-detail">day</span></th>
                                            <th class="text-center">Tue<span class="show-detail">sday</span></th>
                                            <th class="text-center">Wed<span class="show-detail">nesday</span></th>
                                            <th class="text-center">Thu<span class="show-detail">rsday</span></th>
                                            <th class="text-center">fri<span class="show-detail">day</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="pe-1">2:00 <span class="show"> – </span> 3:00</td>
                                            @foreach(explode(',', $schedule->two) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="two{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">3:00 <span class="show"> – </span> 4:00</td>
                                            @foreach(explode(',', $schedule->three) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="three{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">4:00 <span class="show"> – </span> 5:00</td>
                                            @foreach(explode(',', $schedule->four) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="four{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">5:00 <span class="show"> – </span> 6:00</td>
                                            @foreach(explode(',', $schedule->five) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="five{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">6:00 <span class="show"> – </span> 7:00</td>
                                            @foreach(explode(',', $schedule->six) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="six{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">7:00 <span class="show"> – </span> 8:00</td>
                                            @foreach(explode(',', $schedule->seven) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="seven{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="pe-1">8:00 <span class="show"> – </span> 9:00</td>
                                            @foreach(explode(',', $schedule->eight) as $activity)
                                                <td class="px-1">
                                                    <label>
                                                        <select class="form-control dropdown-input"
                                                                name="eight{{$loop->index}}" autofocus>
                                                            <option value="none" disabled selected>Activity</option>
                                                            @foreach(explode(',', $schedule->classroom->subjects) as $subject)
                                                                <option
                                                                    value="{{ $subject }}" {{old('two'.$loop->index) == $subject || trim($activity) == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                                            @endforeach
                                                            <option
                                                                value="lunch break" {{old('two'.$loop->index) == 'lunch break' || trim($activity) == 'lunch break' ? 'selected': ''}}>
                                                                Lunch Break
                                                            </option>
                                                            <option
                                                                value="tea break" {{old('two'.$loop->index) == 'tea break' || trim($activity) == 'tea break' ? 'selected': ''}}>
                                                                Tea Break
                                                            </option>
                                                            <option
                                                                value=play"" {{ old('two'.$loop->index) == 'play' || trim($activity) == 'play' ? 'selected': ''}}>
                                                                Play with toy
                                                            </option>
                                                            <option
                                                                value="music" {{old('two'.$loop->index) == 'music' || trim($activity) == 'music' ? 'selected': ''}}>
                                                                Music
                                                            </option>
                                                            <option
                                                                value="none" {{old('two'.$loop->index) == 'none' || trim($activity) == 'none' ? 'selected': ''}}>
                                                                No Class
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="comment" class="my-auto"><span
                                                        class="show-detail">Schedule</span> Comment</label>
                                            </td>
                                            <td colspan="5">
                                                <textarea name="comment" id="comment"
                                                          class="form-control">{{ old('comment') ?? $schedule->comment }}</textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-6 logo-center mb-1">
                                    <a href="{{$schedule -> id}}" class="btn btn-dark">
                                        Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 logo-center mb-1">
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
    </div>
@endsection
