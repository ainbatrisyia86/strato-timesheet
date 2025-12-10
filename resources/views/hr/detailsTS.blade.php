<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center w-full">
            Timesheet Details
        </h2>
    </x-slot>

    <div class="py-1 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Filters (readonly) --}}
                    <div class="flex gap-4 mb-6">
                    <div>
                        <label>Week</label>
                        <input type="text" value="{{ $selectedWeek ?? '-' }}" readonly class="border px-3 py-2 rounded bg-gray-100 w-32">
                    </div>
                    <div>
                        <label>Month</label>
                        <input type="text" value="{{ $selectedMonth ? date('F', mktime(0,0,0,$selectedMonth,1)) : '-' }}" readonly class="border px-3 py-2 rounded bg-gray-100 w-32">
                    </div>
                    <div>
                        <label>Year</label>
                        <input type="text" value="{{ $selectedYear ?? '-' }}" readonly class="border px-3 py-2 rounded bg-gray-100 w-32">
                    </div>
                    <div>
                        <label>Position</label>
                        <input type="text" value="{{ $selectedPosition ?? '-' }}" readonly class="border px-3 py-2 rounded bg-gray-100 w-32">
                    </div>
                </div>



                    {{-- Timesheet Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 border border-gray-400">
                            {{-- Table Header --}}
                            <thead style="background-color: #818181;">
                                <tr>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase text-white">DATE</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase text-white">PROJECT</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase text-white">TASK</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase text-white">START</th>
                                    <th class="px-6 py-3 border border-gray-400 text-left text-xs font-medium uppercase text-white">END</th>
                                </tr>
                            </thead>

                            {{-- Table Body (dummy data) --}}
                            <tbody style="background-color: #F3F3F3;">
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4 border border-gray-300 text-sm">17/11/2025</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Project A</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Updating receipt records</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">09:00</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">18:00</td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4 border border-gray-300 text-sm">18/11/2025</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Project B</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Preparing monthly reports</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">09:00</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">18:00</td>
                                </tr>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4 border border-gray-300 text-sm">19/11/2025</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Project A</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm">Updating receipt records</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">09:00</td>
                                    <td class="px-6 py-4 border border-gray-300 text-sm text-center">18:00</td>
                                </tr>
                            </tbody>

                            {{-- Table Footer --}}
                            <tfoot style="background-color: #F3F3F3;">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 border border-gray-300 text-right font-semibold">Total Hours</td>
                                    <td class="px-6 py-4 border border-gray-300 text-center font-semibold">27:00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
