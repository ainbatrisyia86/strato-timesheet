@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Heading -->
    <h1 style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 35px; margin: 0 0 20px 0; text-align: center;">
        Timesheet Details
    </h1>

    <!-- Top Filters -->
    <div class="flex items-center gap-4 mb-6 justify-center">

        <!-- Week -->
        <div class="flex items-center gap-2">
        <label class="font-semibold mb-1 text-sm">WEEK:</label>
        <input type="text" value="{{ $timesheet->week }}"
            class="w-28 border border-gray-300 rounded flex px-3 py-2"  style="background-color: #F3F4F6;" readonly />
        </div>

        <!-- Month -->
        <div class="flex items-center gap-2">
        <label class="font-semibold mb-1 text-sm">MONTH:</label>
        <input type="text" value="{{ $timesheet->month }}"
            class="w-48 border border-gray-300 rounded flex px-3 py-2"  style="background-color: #F3F4F6;" readonly />
        </div>

        <!-- Year -->
         <div class="flex items-center gap-2">
        <label class="font-semibold mb-1 text-sm">YEAR:</label>
        <input type="text" value="{{ $timesheet->year }}"
            class="w-48 border border-gray-300 rounded flex px-3 py-2"  style="background-color: #F3F4F6;" readonly />
        </div>

        <!-- Position -->
         <div class="flex items-center gap-2">
        <label class="font-semibold mb-1 text-sm">POSITION:</label>
        <input type="text" value="{{ $timesheet->user->position ?? '-' }}"

            class="w-40 border border-gray-300 rounded flex px-3 py-2"  style="background-color: #F3F4F6;" readonly />
    </div>
</div>
    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded mb-10">
        <table class="w-full border-collapse border border-white">

            <thead>
                <tr style="background-color: #818181;" class="text-white text-sm" height="45">
                    <th class="px-4 text-left" style="border: 2px solid white; width: 15%;">DATE</th>
                    <th class="py-3 px-4" style="border: 2px solid white; width: 30%;">PROJECT</th>
                    <th class="py-3 px-4" style="border: 2px solid white; width: 30%;">TASK</th>
                    <th class="py-3 px-4" style="border: 2px solid white; width: 12.5%;">START</th>
                    <th class="py-3 px-4" style="border: 2px solid white; width: 12.5%;">END</th>
                </tr>
            </thead>

            <tbody style="background-color: #F3F3F3;">

                @foreach($timesheet->rows as $row)
                <tr class="border-b border-gray-300">

                    <td class="py-3 px-4">
                        <input type="text" value="{{ $row->date }}"
                            class="w-full  border border-gray-300 rounded px-2 py-1" style="background-color: ##ffffff;" readonly>
                    </td>

                    <td class="py-3 px-4">
                        <input type="text" value="{{ $row->project }}"
                            class="w-full  border border-gray-300 rounded px-2 py-1" style="background-color: ##ffffff;" readonly>
                    </td>

                    <td class="py-3 px-4">
                        <textarea class="w-full border border-gray-300 rounded px-2 py-1" style="background-color: ##ffffff;" readonly>{{ $row->task }}</textarea>
                    </td>

                    <td class="py-3 px-4">
                        <input type="text" value="{{ $row->start_time }}"
                            class="w-full border border-gray-300 rounded px-2 py-1" style="background-color: ##ffffff;" readonly>
                    </td>

                    <td class="py-3 px-4">
                        <input type="text" value="{{ $row->end_time }}"
                            class="w-full border border-gray-300 rounded px-2 py-1"style="background-color: ##ffffff;" readonly>
                    </td>

                </tr>
                @endforeach

                <!-- TOTAL HOURS -->
                <tr>
    <td colspan="4" class="px-4 py-4 text-right font-semibold">
        Total Hours (Week):
    </td>
    <td class="px-4 py-4 font-semibold">
        {{ number_format($weeklyTotal, 2) }}
    </td>
</tr>

            </tbody>
        </table>
    </div>

    {{-- 
    /*<!-- Back Button -->
    <div class="flex justify-center mt-8">
        <a href="{{ route('timesheet.index') }}"
           class="px-6 py-2 rounded flex text-white font-semibold shadow"
           style="background-color: #7BCAEA;">
            BACK
        </a>
    </div>
    --}}

</div>
@endsection
