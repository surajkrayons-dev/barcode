<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Student Profile</h2>
                <p class="text-sm text-gray-500 mt-1">Complete details of the student</p>
            </div>
            <a href="{{ route('students.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                ← Back to list
            </a>
        </div>

        {{-- ===== SUCCESS MESSAGE ===== --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ===== PROFILE CARD ===== --}}
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-24"></div>
            <div class="px-6 pb-6">
                <div class="flex flex-col md:flex-row md:items-end gap-4 -mt-12">
                    <img src="{{ $student->profile_image ? asset('storage/'.$student->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($student->full_name).'&background=e0e7ff&color=4f46e5&size=128' }}"
                         class="h-24 w-24 rounded-full object-cover ring-4 ring-white shadow">
                    <div class="flex-1 flex flex-col md:flex-row md:items-center md:justify-between gap-3 pb-1">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $student->student_id }} &middot; {{ $student->course }}</p>
                        </div>
                        <div>
                            @if($student->status)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== BASIC & CONTACT DETAILS ===== --}}
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-2 mb-5">
                <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">1</span>
                <h3 class="text-base font-semibold text-gray-800">Basic & Contact Details</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-sm">
                <div>
                    <p class="text-gray-400 mb-1">Student ID</p>
                    <p class="text-gray-800 font-medium">{{ $student->student_id }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Full Name</p>
                    <p class="text-gray-800 font-medium">{{ $student->full_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Gender</p>
                    <p class="text-gray-800 font-medium">{{ $student->gender }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Email</p>
                    <p class="text-gray-800 font-medium break-all">{{ $student->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Mobile</p>
                    <p class="text-gray-800 font-medium">{{ $student->mobile }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Date of Birth</p>
                    <p class="text-gray-800 font-medium">{{ $student->date_of_birth?->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== ACADEMIC DETAILS ===== --}}
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-2 mb-5">
                <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">2</span>
                <h3 class="text-base font-semibold text-gray-800">Academic Details</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-sm">
                <div>
                    <p class="text-gray-400 mb-1">Course</p>
                    <p class="text-gray-800 font-medium">{{ $student->course }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Department</p>
                    <p class="text-gray-800 font-medium">{{ $student->department ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Semester</p>
                    <p class="text-gray-800 font-medium">{{ $student->semester ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Roll Number</p>
                    <p class="text-gray-800 font-medium">{{ $student->roll_number }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Admission Date</p>
                    <p class="text-gray-800 font-medium">{{ $student->admission_date?->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Fees</p>
                    <p class="text-gray-800 font-medium">₹{{ number_format($student->fees, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- ===== ADDRESS ===== --}}
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-2 mb-5">
                <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">3</span>
                <h3 class="text-base font-semibold text-gray-800">Address</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">
                <div class="md:col-span-2">
                    <p class="text-gray-400 mb-1">Address</p>
                    <p class="text-gray-800 font-medium">{{ $student->address ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">City</p>
                    <p class="text-gray-800 font-medium">{{ $student->city ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">State</p>
                    <p class="text-gray-800 font-medium">{{ $student->state ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Country</p>
                    <p class="text-gray-800 font-medium">{{ $student->country ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Pincode</p>
                    <p class="text-gray-800 font-medium">{{ $student->pincode ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- ===== META INFO ===== --}}
        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">
                <div>
                    <p class="text-gray-400 mb-1">Registered On</p>
                    <p class="text-gray-800 font-medium">{{ $student->created_at?->format('d M Y, h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 mb-1">Last Updated</p>
                    <p class="text-gray-800 font-medium">{{ $student->updated_at?->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- ===== ACTIONS ===== --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('student.delete', $student->id) }}"
            onclick="return confirm('Are you sure you want to delete this student?');"
            class="px-5 py-2 rounded-lg border border-red-200 text-red-600 text-sm hover:bg-red-50">
                Delete
            </a>
            <a href="{{ route('student.edit', $student->id) }}"
               class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                Edit Student
            </a>
        </div>

    </div>
</x-app-layout>