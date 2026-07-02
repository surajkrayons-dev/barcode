<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Students</h2>
                <a href="{{ route('student.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + Add Student
                </a>
            </div>

            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('students.index') }}" class="flex flex-col md:flex-row gap-3 mb-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name, email, roll no..."
                    class="flex-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                <select name="status" class="rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    <option value="1" @selected(request('status') === '1')>Active</option>
                    <option value="0" @selected(request('status') === '0')>Inactive</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Filter
                </button>

                @if (request('search') || request('status') !== null)
                    <a href="{{ route('students.index') }}"
                        class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm self-center">Clear</a>
                @endif
            </form>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Photo</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Student ID</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Course</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Roll No.</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Mobile</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <img src="{{ $student->profile_image ? asset('storage/' . $student->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($student->full_name) . '&background=e5e7eb&color=555' }}"
                                        class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $student->student_id }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $student->full_name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $student->course }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $student->roll_number }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $student->mobile }}</td>
                                <td class="px-4 py-3">
                                    @if ($student->status)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('student.view', $student->id) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:bg-gray-100" title="View">
                                            👁️
                                        </a>
                                        <a href="{{ route('student.edit', $student->id) }}"
                                            class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50" title="Edit">
                                            ✏️
                                        </a>
                                        <a href="{{ route('student.delete', $student->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this student?');"
                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50" title="Delete">
                                            🗑️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                    No students found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $students->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
