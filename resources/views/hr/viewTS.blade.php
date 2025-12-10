<x-app-layout>

    {{-- ------------------------------
         HEADER
    ------------------------------- --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Staff Timesheets') }}
        </h2>
    </x-slot>

    {{-- ------------------------------
         MAIN CONTENT
    ------------------------------- --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- --------------------------
                         FILTER FORM
                    --------------------------- --}}
                    <form method="GET" action="{{ route('hr.viewTS') }}" class="mb-8 space-y-6" id="filterForm">

                    {{-- Year, Month, Week Selection --}}
                    <div class="flex flex-wrap gap-4 items-end">

                        <!-- Year -->
                        <div>
                            <label class="block font-medium mb-1">Select Year</label>
                            <select id="yearSelect" name="year"
                                class="border border-gray-300 rounded px-3 py-2 pr-10 w-64"
                                style="background-color: #F3F3F3;">
                                <option value="">-- Choose Year --</option>
                                @foreach(range(date('Y')-5, date('Y')+1) as $y) 
                                    <option value="{{ $y }}" {{ request('year')==$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Month -->
                        <div>
                            <label class="block font-medium mb-1">Select Month</label>
                            <select id="monthSelect" name="month"
                                class="border border-gray-300 rounded px-3 py-2 pr-10 w-64"
                                style="background-color: #F3F3F3;">
                                <option value="">-- Choose Month --</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month')==$m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0,0,0,$m,1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Week -->
                        <div>
                            <label class="block font-medium mb-1">Select Week</label>
                            <select id="weekSelect" name="week"
                                class="border border-gray-300 rounded px-3 py-2 pr-10 w-64"
                                style="background-color: #F3F3F3;" disabled>
                                <option value="">-- Choose Week --</option>
                                @foreach(range(1,5) as $w)
                                    <option value="{{ $w }}" {{ request('week')==$w ? 'selected' : '' }}>
                                        Week {{ $w }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Staff Search + Status --}}
                    <div class="flex flex-wrap items-end gap-4 mt-4">
                        <!-- Staff Search -->
                        <div class="relative flex-1 min-w-[250px]">
                            <input type="text" name="staff_name" placeholder="Search staff..."
                                value="{{ request('staff_name') }}"
                                class="border border-gray-300 rounded pl-10 pr-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-300"
                                style="background-color: #F3F3F3;">
                        </div>

                        <!-- Status Filter -->
                        <select name="status"
                            class="border border-gray-300 rounded px-3 py-2 pr-10 w-72"
                            style="background-color: #F3F3F3;">
                            <option value="">-- Choose Status --</option>
                            <option value="">All Status</option>
                            <option value="submitted" {{ request('status')=='submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="late" {{ request('status')=='late' ? 'selected' : '' }}>Late</option>
                            <option value="not submitted" {{ request('status')=='not submitted' ? 'selected' : '' }}>Not Submitted</option>
                        </select>

                        <!-- BUTTON GROUP -->
                        <div class="flex gap-3">
                            <!-- Filter Button -->
                            <button type="submit"
                                class="text-white px-4 py-2 rounded"
                                style="background-color: rgba(39, 173, 227, 0.73);">
                                Filter
                            </button>

                            <!-- Reset Button -->
                            <a href="{{ route('hr.viewTS') }}"
                                class="text-white px-4 py-2 rounded inline-block text-center"
                                style="background-color: rgba(39, 173, 227, 0.73);">
                                Reset
                            </a>
                        </div>

                    </div>

                </form>

                {{-- JS: Enable week dropdown only when month is selected --}}
                <script>
                    const monthSelect = document.getElementById('monthSelect');
                    const weekSelect = document.getElementById('weekSelect');

                    monthSelect.addEventListener('change', () => {
                        weekSelect.disabled = monthSelect.value === "";
                    });
                </script>

                    {{-- --------------------------
                         TABLE OR EMPTY STATE
                    --------------------------- --}}
                    @if($timesheets->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-lg">No timesheets found.</p>
                            <p class="text-sm mt-2">Staff members haven't submitted any timesheets yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 border border-gray-400">
                            <thead style="background-color: #818181;">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Week</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Date Range</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Hours</th>
                                </tr>
                            </thead>


                            <tbody>
                            @foreach($timesheets as $index => $timesheet)
                                <tr class="hover:bg-blue-50" style="background-color: #F3F3F3;">
                                    <td class="px-6 py-4 border border-gray-300 text-sm">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">
                                     <a href="{{ route('timesheet.view', ['user' => $timesheet->user->id]) }}"
                                    class="text-blue-800 hover:underline">
                                    {{ $timesheet->user->name }}
                                    </a>

                                    </td>

                                    <td class="px-6 py-4 border border-gray-300 text-sm">
                                        {{ request('week') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">
                                        {{ request('date_range') ?? \Carbon\Carbon::parse($timesheet->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-blue-200 text-blue-800">
                                            {{ ucfirst($timesheet->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">{{ $timesheet->total_hours }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                        </table>
                    </div>

                    @endif

                    {{-- BOTTOM-RIGHT GENERATE BUTTON --}}
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('hr.generateReport') }}"
                        class="hover:bg-opacity-90 text-white font-semibold px-6 py-2 rounded shadow"
                        style="background-color: rgba(39, 173, 227, 0.73);">
                            Generate
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
