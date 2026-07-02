<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Student</h2>
                <p class="text-sm text-gray-500 mt-1">Update {{ $student->full_name }}'s details</p>
            </div>
            <a href="{{ route('students.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                ← Back to list
            </a>
        </div>

        {{-- ===== ERROR MESSAGES ===== --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
                <p class="font-medium text-sm mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Route students.update POST hai (web.php me), isliye @method spoof ki zaroorat nahi --}}
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ===== PROFILE IMAGE CARD ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0">
                        <img id="preview"
                             src="{{ $student->profile_image ? asset('storage/'.$student->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($student->full_name).'&background=e0e7ff&color=4f46e5&size=128' }}"
                             class="h-24 w-24 rounded-full object-cover ring-4 ring-indigo-50">
                        <label for="profile_image"
                               class="absolute -bottom-1 -right-1 bg-indigo-600 text-white rounded-full h-8 w-8 flex items-center justify-center text-sm cursor-pointer hover:bg-indigo-700 shadow">
                            📷
                        </label>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Profile Photo</p>
                        <p class="text-sm text-gray-400 mb-2">Leave empty to keep current photo</p>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                               onchange="previewImage(event)" class="hidden">
                        <label for="profile_image"
                               class="inline-block text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 cursor-pointer">
                            Change Image
                        </label>
                    </div>
                </div>
            </div>

            {{-- ===== BASIC DETAILS ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">1</span>
                    <h3 class="text-base font-semibold text-gray-800">Basic Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Student ID *</label>
                        <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <input type="hidden" name="full_name" id="full_name" value="{{ $student->full_name }}">
            </div>

            {{-- ===== CONTACT DETAILS ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">2</span>
                    <h3 class="text-base font-semibold text-gray-800">Contact Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Mobile *</label>
                        <input type="text" name="mobile" maxlength="15" value="{{ old('mobile', $student->mobile) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                </div>
            </div>

            {{-- ===== PERSONAL DETAILS ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">3</span>
                    <h3 class="text-base font-semibold text-gray-800">Personal Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Date of Birth *</label>
                        <input type="date" name="date_of_birth"
                               value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Gender *</label>
                        <div class="flex gap-2">
                            @foreach(['Male','Female','Other'] as $g)
                                <label class="flex-1">
                                    <input type="radio" name="gender" value="{{ $g }}" class="peer hidden"
                                           @checked(old('gender', $student->gender) == $g) required>
                                    <div class="text-center text-sm py-2 rounded-lg border border-gray-300 text-gray-600 cursor-pointer
                                                peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition">
                                        {{ $g }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== ACADEMIC DETAILS ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">4</span>
                    <h3 class="text-base font-semibold text-gray-800">Academic Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Course *</label>
                        <input type="text" name="course" value="{{ old('course', $student->course) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Department</label>
                        <input type="text" name="department" value="{{ old('department', $student->department) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Semester</label>
                        <input type="text" name="semester" value="{{ old('semester', $student->semester) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Roll Number *</label>
                        <input type="text" name="roll_number" value="{{ old('roll_number', $student->roll_number) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Admission Date *</label>
                        <input type="date" name="admission_date"
                               value="{{ old('admission_date', $student->admission_date?->format('Y-m-d')) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Fees (₹)</label>
                        <input type="number" step="0.01" name="fees" value="{{ old('fees', $student->fees) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            {{-- ===== ADDRESS ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">5</span>
                    <h3 class="text-base font-semibold text-gray-800">Address</h3>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                    <textarea name="address" rows="2"
                              class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $student->address) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', $student->city) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state', $student->state) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', $student->country) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Pincode</label>
                        <input type="text" name="pincode" maxlength="10" value="{{ old('pincode', $student->pincode) }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            {{-- ===== STATUS + SUBMIT (sticky bottom bar) ===== --}}
            <div class="sticky bottom-4 bg-white shadow-lg border border-gray-100 rounded-2xl p-4 flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="status" value="1" @checked(old('status', $student->status))
                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Mark as Active Student
                </label>
                <div class="flex gap-3">
                    <a href="{{ route('students.index') }}"
                       class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Cancel</a>
                    <button type="submit"
                            class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                        Update Student
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            if (file) preview.src = URL.createObjectURL(file);
        }

        function updateFullName() {
            const first = document.getElementById('first_name').value.trim();
            const last = document.getElementById('last_name').value.trim();
            document.getElementById('full_name').value = (first + ' ' + last).trim();
        }
        document.getElementById('first_name').addEventListener('input', updateFullName);
        document.getElementById('last_name').addEventListener('input', updateFullName);
    </script>
</x-app-layout>