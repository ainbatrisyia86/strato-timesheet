@extends('layouts.app')

@section('content')

<div class="pt-24">

<div class="max-w-6xl mx-auto px-6 py-10 pt-30">

    <!-- Heading + Add Button -->
<div class="flex items-center justify-between mb-8 mt-12">
        <!-- Heading -->
        <h1 style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 35px; margin: 0;">
            Weekly Timesheet
        </h1>

        <!-- Add Button -->
        <a href="{{ route('timesheet.create') }}"
           class="text-white font-bold px-4 py-2 rounded flex items-center gap-2 shadow"
           style="background-color: #7BCAEA;">
            + ADD
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="w-full border-collapse border border-white">
            <thead>
                <tr style="background-color: #818181; color: white; height: 45px;">
                    <th class="px-4 text-left" style="border: 2px solid white; width: 50%;">WEEKLY REPORT</th>
                    <th class="px-4 text-left" style="border: 2px solid white; width: 25%;">STATUS</th>
                    <th class="px-4 text-left" style="border: 2px solid white; width: 25%;">ACTION</th>
                </tr>
            </thead>

        <tbody style="background-color: #F3F3F3;">
                @foreach ($timesheets as $t)
                    <tr class="border-b" style="height: 45px;">
                        <td class="px-4 py-3">Week {{ $t->week }}</td>

                        <td class="px-4 py-3" style="text-align: center !important;">
                            <span class="text-gray-700">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 flex justify-center items-center gap-2">
                            <!-- View Button -->
                            <a href="{{ route('timesheet.show', $t->id) }}"
                               class="text-white px-3 py-1 rounded shadow inline-block"
                               style="background-color: rgba(39, 173, 227, 0.59);">
                                View
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('timesheet.edit', $t->id) }}"
                               class="text-white px-3 py-1 rounded shadow inline-block"
                               style="background-color: rgba(255, 157, 0, 0.59);">
                                Edit
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