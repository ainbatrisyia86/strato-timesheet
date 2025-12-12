<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage User Accounts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + Filter Form --}}
            <form method="GET" action="{{ route('manage.users') }}">
                <div class="flex flex-wrap items-end gap-4 mb-4">

                    <!-- Staff Search -->
                    <div class="relative flex-1 min-w-[250px]">
                        <input type="text" name="staff_name" placeholder="Search by Name"
                            value="{{ request('staff_name') }}"
                            class="border border-gray-300 rounded pl-3 pr-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-300"
                            style="background-color: #F3F3F3;">
                    </div>

                    <!-- Role Filter -->
                    <select name="role"
                        class="border border-gray-300 rounded px-3 py-2 w-72"
                        style="background-color: #F3F3F3;">
                        <option value="">-- Choose Role --</option>
                        <option value="Staff" {{ request('role') == 'Staff' ? 'selected' : '' }}>Staff</option>
                        <option value="HR" {{ request('role') == 'HR' ? 'selected' : '' }}>HR</option>
                        <option value="Super Admin" {{ request('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>

                    <!-- Apply Button -->
                    <button type="submit"
                        class="px-4 py-2 rounded-md text-white"
                        style="background-color: rgba(39, 173, 227, 0.73);">
                        Apply
                    </button>
                </div>
            </form>

            <!-- Users Table -->
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-300 border border-gray-400">
                    <thead style="background-color: #818181;">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border border-gray-400 text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #f3f3f3;" class="divide-y divide-gray-300">
                    @foreach ($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4 border border-gray-400">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 border border-gray-400">{{ $user->name }}</td>
                            <td class="px-6 py-4 border border-gray-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 border border-gray-400">{{ $user->role ?? 'Not Set' }}</td>

                            <!-- Default status -->
                            <td class="px-6 py-4 border border-gray-400">
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-xs">Active</span>
                            </td>

                            <!-- Action buttons -->
                            <td class="px-6 py-4 border border-gray-400">
                                <div class="flex gap-2">

                                    <!-- Edit button -->
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                    class="bg-orange-500 text-white text-xs px-2 py-1 rounded-md">
                                        Edit
                                    </a>

                                    <!-- Delete button -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white text-xs px-2 py-1 rounded-md">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <!-- New User Button -->
            <div class="flex justify-end mt-4">
                <button class="px-4 py-2 rounded-md text-white"
                    style="background-color: rgba(39, 173, 227, 0.73);">
                    + New User
                </button>
            </div>

        </div>
    </div>
</x-app-layout>
