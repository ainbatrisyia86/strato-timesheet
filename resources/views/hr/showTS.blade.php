<x-app-layout>
    
{{-- Header --}}
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Staff Timesheets: {{ $user->name }}
    </h2>
</x-slot>

<div class="bg-white flex flex-col items-center">

    <div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-col">

                <!-- Name & Role at top-left -->
                <div class="mb-5 text-left">
                    <p class="text-2xl font-semibold mb-1">Name: {{ $user->name }}</p>
                    <p class="text-lg font-semibold text-gray-700">Role: {{ ucfirst($user->role) }}</p>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('timesheet.view', $user->id) }}" 
                    class="flex gap-4 items-end mb-6 flex-wrap w-full justify-start">

                    {{-- Year Filter --}}
                    <div>
                        <label class="block font-medium mb-1">Year</label>
                        <select name="year" class="border border-blue-300 rounded px-3 py-2 w-40" style="background-color: #F3F3F3; min-height: 40px;">
                            <option value="">-- Choose Year --</option>
                            @foreach(range(date('Y') - 5, date('Y') + 5) as $y)
                                <option value="{{ $y }}" {{ request('year')==$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Month Filter --}}
                    <div>
                        <label class="block font-medium mb-1">Month</label>
                        <select name="month" class="border border-blue-300 rounded px-3 py-2 w-40" style="background-color: #F3F3F3; min-height: 40px;">
                            <option value="">-- Choose Month --</option>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ request('month')==$m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0,0,0,$m,1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Week Filter --}}
                    <div>
                        <label class="block font-medium mb-1">Week</label>
                        <select name="week" class="border border-blue-300 rounded px-3 py-2 w-40" style="background-color: #F3F3F3; min-height: 40px;">
                            <option value="">-- Choose Week --</option>
                            @foreach(range(1,5) as $w)
                                <option value="{{ $w }}" {{ request('week')==$w ? 'selected' : '' }}>Week {{ $w }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 items-end">
                        <button type="submit" class="text-white px-3 rounded inline-flex items-center justify-center" style="background-color: rgba(39, 173, 227, 0.73); height: 40px;">Filter</button>
                        <a href="{{ route('timesheet.view', $user->id) }}" class="text-white px-3 rounded inline-flex items-center justify-center" style="background-color: rgba(39, 173, 227, 0.73); height: 40px;">Reset</a>
                    </div>

                </form>


                {{-- Timesheet Table --}}
                @if($timesheets->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <p>No timesheets found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full max-w-7xl border border-gray-300 rounded">
                            <thead style="background-color: #818181;" class="text-white">
                                <tr>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase">No</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase">Week</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase">Submission Date</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase">Status</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray-100">
                                @foreach($timesheets as $index => $ts)
                                    @php
                                        $tsDate = \Carbon\Carbon::parse($ts->date);
                                        $weekNumber = ceil($tsDate->day / 7);
                                    @endphp
                                    <tr class="hover:bg-blue-50">
                                        <td class="px-6 py-4 border border-gray-300 text-sm">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm">Week {{ $weekNumber }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm">{{ $tsDate->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm">
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-blue-200 text-blue-800">
                                                {{ ucfirst($ts->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 border border-gray-300 text-sm">
                                            <a href="{{ route('timesheet.details', $ts->id) }}?week={{ $weekNumber }}&month={{ $tsDate->month }}&year={{ $tsDate->year }}&position={{ $ts->user->role }}" class="text-blue-500 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
</x-app-layout>
