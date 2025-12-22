@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Heading -->
    <h1 style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 35px; margin: 0 0 20px 0; text-align: center;">
        Edit Timesheet
    </h1>

    <form action="{{ route('timesheet.update', $timesheet->id) }}" method="PUT">
        @csrf
        

        <!-- Top Filters -->
        <div class="flex items-center gap-4 mb-6 justify-center">

            <!-- WEEK -->
            <div class="flex items-center gap-2">
                <label class="font-semibold mb-1 text-sm">WEEK:</label>
                <input type="text" name="week" value="{{ $timesheet->week }}"
                    class="w-28 bg-gray-100 border border-gray-300 rounded-xl px-3 py-2"
                    readonly />
            </div>

            <!-- MONTH -->
            <div class="flex items-center gap-2">
                <label class="font-semibold mb-1 text-sm">MONTH:</label>
                <input type="text" name="month" 
                value="{{ \Carbon\Carbon::create()->month((int) $timesheet->month)->format('F') }}" 
                class="w-48 bg-gray-100 border border-gray-300 rounded-xl px-3 py-2"
                readonly />
                <!-- Convert numeric month to full month name using Carbon -->

            </div>

            <!-- YEAR -->
            <div class="flex items-center gap-2">
                <label class="font-semibold mb-1 text-sm">YEAR:</label>
                <input type="text" name="year" value="{{ $timesheet->year }}"
                    class="w-48 bg-gray-100 border border-gray-300 rounded-xl px-3 py-2"
                    readonly />
            </div>

            <!-- POSITION -->
            <div class="flex items-center gap-2">
                <label class="font-semibold mb-1 text-sm">POSITION:</label>
                <input type="text" name="position" value="{{ $timesheet->position }}"
                    class="w-40 bg-gray-100 border border-gray-300 rounded-xl px-3 py-2"
                    readonly />
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto bg-white shadow rounded mb-10">
            <table class="w-full border-collapse border border-white">

                <thead>
                    <tr style="background-color: #818181;" class="text-white text-sm" height="45">
                        <th class="px-4 text-left" style="border: 2px solid white; width: 15%;">DATE</th>
                        <th class="py-3 px-4" style="border: 2px solid white; width: 30%;">PROJECT</th>
                        <th class="py-3 px-4" style="border: 2px solid white; width: 30%;">TASK</th>
                        <th class="py-3 px-4" style="border: 2px solid white; width: 12.5%;">START</th>
                        <th class="py-3 px-4" style="border: 2px solid white; width: 12.5%;">END</th>
                        <th class="py-3 px-4" style="border: 2px solid white; width: 10%;">ACTION</th>
                    </tr>
                </thead>

                <tbody id="timesheet-body" style="background-color: #F3F3F3;">

                    <!-- EXISTING ROWS -->
                    @foreach($timesheet->rows as $index => $row)
                    <tr class="border-b border-gray-300">
                        <td class="py-3 px-4">
                            <input type="date" name="rows[{{ $index }}][date]"
                                   class="w-full bg-white border border-gray-300 rounded px-2 py-1"
                                   value="{{ $row->date }}" required>
                        </td>

                        <td class="py-3 px-4">
                            <select name="rows[{{ $index }}][project]"
                                    class="w-full bg-white border border-gray-300 rounded px-2 py-1" required>
                                <option value="">Select Project</option>
                                @foreach(['Project A','Project B','Project C'] as $p)
                                    <option value="{{ $p }}" {{ $row->project == $p ? 'selected' : '' }}>
                                        {{ $p }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="py-3 px-4">
                            <input type="text" name="rows[{{ $index }}][task]"
                                   class="w-full bg-white border border-gray-300 rounded px-2 py-1"
                                   value="{{ $row->task }}" required>
                        </td>

                        <td class="py-3 px-4">
                            <input type="time" name="rows[{{ $index }}][start_time]"
                                   class="w-full bg-white border border-gray-300 rounded px-2 py-1"
                                   value="{{ $row->start_time }}" required>
                        </td>

                        <td class="py-3 px-4">
                            <input type="time" name="rows[{{ $index }}][end_time]"
                                   class="w-full bg-white border border-gray-300 rounded px-2 py-1"
                                   value="{{ $row->end_time }}" required>
                        </td>

                        <td class="py-3 px-4">
                            <button type="button" onclick="deleteRow(this)"
                                style="background-color: #FFE5E5; border: none; padding: 8px 10px; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin: auto;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FF3B30" viewBox="0 0 24 24">
                                    <path d="M9 3V4H4V6H5V20C5 21.1 5.9 22 7 22H17C18.1 22 19 21.1 19 20V6H20V4H15V3H9ZM7 6H17V20H7V6ZM9 8V18H11V8H9ZM13 8V18H15V8H13Z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach

                    <!-- ADD ROW BUTTON -->
                    <tr id="add-row-wrapper" class="border-b border-gray-300" style="height: 45px;">
                        <td class="py-3 px-4">
                            <button type="button" onclick="addRow()"
                                class="px-4 py-1 rounded text-sm text-white flex items-center gap-2"
                                style="background-color: #7BCAEA;">
                                <span class="text-lg">+</span> ADD
                            </button>
                        </td>
                        <td colspan="5"></td>
                    </tr>

                    <!-- TOTAL HOURS -->
                    <tr style="height: 45px;">
                        <td colspan="6" class="py-4 px-4 text-right font-medium">
                            Total Hours
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4 justify-center" style="margin-top: 40px;">
            <button type="submit" class="px-6 py-2 rounded flex text-white font-semibold shadow"
                style="background-color:rgba(39,173,227,0.73)">
                UPDATE
            </button>

            <button type="submit" name="action" value="submit"
                class="px-6 py-2 rounded flex text-white font-semibold shadow rounded flex"
                style="background-color: rgba(36,210,65,0.71);">
                SUBMIT
            </button>
        </div>
    </form>
</div>

<!-- JS for Add/Delete Rows -->
<script>
let rowIndex = {{ count($timesheet->rows) }};

function deleteRow(btn) {
    btn.closest("tr").remove();
}

const weekNumber = {{ $timesheet->week }};
const year = {{ $timesheet->year }};

// Function to get Monday to Friday dates of the ISO week
function getWeekDates(weekNumber, year) {

    // ISO week: week 1 = first week with Jan 4th (first week of year always contain 4jan)
    const jan4 = new Date(year, 0, 4);

    // Get Monday of the first ISO week
    const dayOfWeek = jan4.getDay() || 7; // Sunday=7
    const firstMonday = new Date(jan4);
    firstMonday.setDate(jan4.getDate() - dayOfWeek + 1);

    // Monday of target week
    const mondayOfWeek = new Date(firstMonday);
    mondayOfWeek.setDate(firstMonday.getDate() + (weekNumber - 1) * 7);

    // Collect Monday → Friday dates
    const weekDates = [];
    for (let i = 0; i < 5; i++) {
        const d = new Date(mondayOfWeek);
        d.setDate(mondayOfWeek.getDate() + i);
        weekDates.push(d.toISOString().split('T')[0]);
    }

    return weekDates;
}



const weekDates = getWeekDates(weekNumber, year);
let weekDateIndex = 0;


function addRow() {
    if (weekDateIndex >= weekDates.length) {
        alert("All week dates have been added!");
        return;
    }

    const tbody = document.getElementById("timesheet-body");
    const addRowEl = document.getElementById("add-row-wrapper");

    const dateValue = weekDates[weekDateIndex]; // pick next date in week
    weekDateIndex++;

    const row = document.createElement("tr");
    row.classList.add("border-b", "border-gray-300");

    row.innerHTML = `
        <td class="py-3 px-4">
            <input type="date" name="rows[${rowIndex}][date]" 
                   class="w-full bg-white border border-gray-300 rounded px-2 py-1" 
                   value="${dateValue}" required>
        </td>

        <td class="py-3 px-4">
            <select name="rows[${rowIndex}][project]" class="w-full bg-white border border-gray-300 rounded px-2 py-1" required>
                <option value="">Select Project</option>
                <option>Project A</option><option>Project B</option><option>Project C</option>
            </select>
        </td>

        <td class="py-3 px-4">
            <input type="text" name="rows[${rowIndex}][task]" placeholder="Enter task"
                   class="w-full bg-white border border-gray-300 rounded px-2 py-1" required>
        </td>

        <td class="py-3 px-4">
            <input type="time" name="rows[${rowIndex}][start_time]" class="w-full bg-white border border-gray-300 rounded px-2 py-1" required>
        </td>

        <td class="py-3 px-4">
            <input type="time" name="rows[${rowIndex}][end_time]" class="w-full bg-white border border-gray-300 rounded px-2 py-1" required>
        </td>

        <td class="py-3 px-4">
            <button type="button" onclick="deleteRow(this)"
                style="background-color: #FFE5E5; border: none; padding: 8px 10px; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin: auto;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FF3B30" viewBox="0 0 24 24">
                    <path d="M9 3V4H4V6H5V20C5 21.1 5.9 22 7 22H17C18.1 22 19 21.1 19 20V6H20V4H15V3H9ZM7 6H17V20H7V6ZM9 8V18H11V8H9ZM13 8V18H15V8H13Z"/>
                </svg>
            </button>
        </td>
    `;

    tbody.insertBefore(row, addRowEl);
    rowIndex++;
}
</script>
</script>
@endsection
