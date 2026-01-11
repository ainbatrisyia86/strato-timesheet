@extends('layouts.app')

@section('content')

<div class="-mt-24 max-w-6xl mx-auto px-2 ">

    <!-- Heading + Add Button -->
<div class="flex items-center justify-between mb-8 mt-12">
        <!-- Heading -->
        <h1 style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 35px; margin: 0;">
            Weekly Timesheet
        </h1>

        <!-- Add Button -->
        <!-- <a href="{{ route('timesheet.create') }}"
           class="text-white font-bold px-4 py-2 rounded flex items-center gap-2 shadow"
           style="background-color: #7BCAEA;">
            + ADD
        </a> -->
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="w-full border-collapse border border-white">
    <thead>
        <tr style="background-color: #818181; color: white; height: 45px;">
            <th class="px-4 text-left" style="border: 2px solid white; width: 10%; text-align: center">WEEK</th>
            <th class="px-4 text-left" style="border: 2px solid white; width: 40%; text-align: center">DATE RANGE</th>
            <th class="px-4 text-left" style="border: 2px solid white; width: 25%; text-align: center">STATUS</th>
            <th class="px-4 text-left" style="border: 2px solid white; width: 25%; text-align: center">ACTION</th>
        </tr>
    </thead>

    <tbody style="background-color: #F3F3F3;">
        @foreach ($timesheets as $index => $t)

        <!-- logic implementation for due date 10am monday -->
        @php
        $now = \Carbon\Carbon::now();

        // Parse dates once (clean & readable)
        $startDate = \Carbon\Carbon::parse($t->start_date);
        $endDate   = \Carbon\Carbon::parse($t->end_date);

        // ✅ Correct deadline: Monday AFTER week end, 10:00 AM
        $deadline = $endDate->copy()->next(\Carbon\Carbon::MONDAY)->setTime(10,0,0);


        // Check if today is within this timesheet week
        $isCurrentWeek = $now->between($startDate, $endDate);

        // ✅ Status logic
            if ($t->submitted_at) {
                $submittedAt = \Carbon\Carbon::parse($t->submitted_at);
                if ($submittedAt->lte($deadline)) {
                    $status = 'submitted'; // on time
                } else {
                    $status = 'late submission';
                }
            } else {
                $status = 'not submitted';
            }


        @endphp

            <tr class="border-b" style="height: 45px;">
                <!-- Week number -->
                <td class="px-4 py-3">Week {{ $t->week }}</td>

                <!-- Date range -->
                <td class="px-4 py-3">
                {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y') }}
            </td>

                <!-- Status -->
                <td class="px-4 py-3 text-center">
                @if($status === 'submitted')
                    <span class="px-4 py-1 rounded shadow inline-block text-white text-sm font-semibold"
                        style="background-color:#22C55E ;">
                        Submitted
                    </span>
                @elseif($status === 'late submission')
                    <span class="px-3 py-1 rounded shadow inline-block text-white text-sm font-semibold"
                        style="background-color: #FF3B30;">
                        Late Submission
                    </span>
                @else
                    <span class="px-3 py-1 rounded shadow inline-block text-black text-sm font-semibold"
                        style="background-color: #E5E7EB;">
                        Pending
                    </span>
                @endif
            </td>

                <!-- Action -->
                <td class="px-4 py-3 flex justify-center items-center gap-2">

      {{-- ADD / EDIT button --}}
        @if($status === 'not submitted')
            <a href="{{ route('timesheet.edit', Crypt::encrypt($t->id)) }}"
            class="text-white px-3 py-1 rounded shadow inline-block text-sm font-semibold"
            style="background-color: rgba(255, 157, 0, 0.59);">
                Add/Edit
            </a>
        @endif


    {{-- VIEW button --}}
    <a href="{{ route('timesheet.show', Crypt::encrypt($t->id)) }}"
       class="text-white px-3 py-1 rounded shadow inline-block text-sm font-semibold"
       style="background-color: rgba(39, 173, 227, 0.59);">
        View
    </a>

</td>


            </tr>
        @endforeach
    </tbody>
</table>

    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $timesheets->links() }}
    </div>

</div>

@endsection