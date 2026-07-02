{{-- resources/views/students/create.blade.php --}}
<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Add New Student</h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to register a new student</p>
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

        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ===== PROFILE IMAGE CARD ===== --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0">
                        <img id="preview"
                             src="https://ui-avatars.com/api/?name=Student&background=e0e7ff&color=4f46e5&size=128"
                             class="h-24 w-24 rounded-full object-cover ring-4 ring-indigo-50">
                        <label for="profile_image"
                               class="absolute -bottom-1 -right-1 bg-indigo-600 text-white rounded-full h-8 w-8 flex items-center justify-center text-sm cursor-pointer hover:bg-indigo-700 shadow">
                            📷
                        </label>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">Profile Photo</p>
                        <p class="text-sm text-gray-400 mb-2">JPG or PNG, up to 2MB</p>
                        <input type="file" name="profile_image" id="profile_image" accept="image/*"
                               onchange="previewImage(event)" class="hidden">
                        <label for="profile_image"
                               class="inline-block text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 cursor-pointer">
                            Choose Image
                        </label>
                    </div>
                </div>
            </div>

            {{-- ===== BASIC DETAILS =====
                 Yaha naye field add karna ho toh isi <div class="grid ..."> ke andar
                 ek naya <div> block copy-paste karke naam/name change kar dena --}}
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">1</span>
                    <h3 class="text-base font-semibold text-gray-800">Basic Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Student ID *</label>
                        <input type="text" name="student_id" value="{{ old('student_id') }}"
                               placeholder="e.g. STU-2026-001"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                               placeholder="e.g. Suraj"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                               placeholder="e.g. Verma"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                {{-- full_name auto-generate hoke yaha chupke se save hoga --}}
                <input type="hidden" name="full_name" id="full_name">
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
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="student@example.com"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Mobile *</label>
                        <input type="text" name="mobile" maxlength="15" value="{{ old('mobile') }}"
                               placeholder="9876543210"
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
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Gender *</label>
                        <div class="flex gap-2">
                            @foreach(['Male','Female','Other'] as $g)
                                <label class="flex-1">
                                    <input type="radio" name="gender" value="{{ $g }}" class="peer hidden"
                                           @checked(old('gender') == $g) required>
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
                        <input type="text" name="course" value="{{ old('course') }}" placeholder="e.g. B.Tech CSE"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Department</label>
                        <input type="text" name="department" value="{{ old('department') }}" placeholder="e.g. Computer Science"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Semester</label>
                        <input type="text" name="semester" value="{{ old('semester') }}" placeholder="e.g. 5th"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Roll Number *</label>
                        <input type="text" name="roll_number" value="{{ old('roll_number') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Admission Date *</label>
                        <input type="date" name="admission_date" value="{{ old('admission_date') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Fees (₹)</label>
                        <input type="number" step="0.01" name="fees" value="{{ old('fees', 0) }}"
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
                    <textarea name="address" rows="2" placeholder="House no, street, area..."
                              class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', 'India') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Pincode</label>
                        <input type="text" name="pincode" maxlength="10" value="{{ old('pincode') }}"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            {{-- ===== STATUS + SUBMIT (sticky bottom bar) ===== --}}
            <div class="sticky bottom-4 bg-white shadow-lg border border-gray-100 rounded-2xl p-4 flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="status" value="1" checked
                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Mark as Active Student
                </label>
                <div class="flex gap-3">
                    <a href="{{ route('students.index') }}"
                       class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">Cancel</a>
                    <button type="submit"
                            class="px-6 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                        Save Student
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