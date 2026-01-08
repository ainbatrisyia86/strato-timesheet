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
                class="w-28 border border-gray-300 rounded-xl px-3 py-2 bg-gray-100"
                readonly />
        </div>

        <!-- Month -->
        <div class="flex items-center gap-2">
            <label class="font-semibold mb-1 text-sm">MONTH:</label>
            <input type="text"
                value="{{ \Carbon\Carbon::parse($timesheet->start_date)->format('F') }}"
                class="w-48 border border-gray-300 rounded-xl px-3 py-2 bg-gray-100"
                readonly />
        </div>

        <!-- Year -->
        <div class="flex items-center gap-2">
            <label class="font-semibold mb-1 text-sm">YEAR:</label>
            <input type="text" value="{{ $timesheet->year }}"
                class="w-48 border border-gray-300 rounded-xl px-3 py-2 bg-gray-100"
                readonly />
        </div>

        <!-- Position -->
        <div class="flex items-center gap-2">
            <label class="font-semibold mb-1 text-sm">POSITION:</label>
            <input type="text" value="{{ $timesheet->user->position ?? '-' }}"
                class="w-40 border border-gray-300 rounded-xl px-3 py-2 bg-gray-100"
                readonly />
        </div>

    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded mb-10">
        <table class="w-full border-collapse border border-white">

            <thead>
            <tr style="background-color: #818181; color: white; height: 45px;">
                    <th class="px-4" style="border: 2px solid white; width: 15%;">DATE</th>
                    <th class="px-4" style="border: 2px solid white; width: 30%;">PROJECT</th>
                    <th class="px-4" style="border: 2px solid white; width: 30%;">TASK</th>
                    <th class="px-4" style="border: 2px solid white; width: 12.5%;">START</th>
                    <th class="px-4" style="border: 2px solid white; width: 12.5%;">END</th>
                </tr>
            </thead>

            <tbody style="background-color: #F3F3F3;">

            @foreach($groupedRows as $date => $rows)
                @foreach($rows as $index => $row)
                    <tr class="border-b border-gray-300">

                        {{-- DATE  --}}
                        @if($index === 0)
                            <td class="py-3 px-4 align-top"
                                rowspan="{{ count($rows) }}">
                                <input type="text" value="{{ $date }}"
                                    class="w-full border border-gray-300 rounded px-2 py-1 bg-white"
                                    readonly>
                            </td>
                        @endif

                        {{-- PROJECT --}}
                        <td class="py-3 px-4">
                            <input type="text" value="{{ $row->project }}"
                                class="w-full border border-gray-300 rounded px-2 py-1 bg-white"
                                readonly>
                        </td>

                        {{-- TASK --}}
                        <td class="py-3 px-4">
                            <div class="w-full border border-gray-300 rounded px-2 py-1 bg-white">
                                {{ $row->task }}
                            </div>

                        </td>

                        {{-- START --}}
                        <td class="py-3 px-4">
                            <input type="text" value="{{ $row->start_time }}"
                                class="w-full border border-gray-300 rounded px-2 py-1 bg-white"
                                readonly>
                        </td>

                        {{-- END --}}
                        <td class="py-3 px-4">
                            <input type="text" value="{{ $row->end_time }}"
                                class="w-full border border-gray-300 rounded px-2 py-1 bg-white"
                                readonly>
                        </td>

                    </tr>
                @endforeach
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

</div>
@endsection
