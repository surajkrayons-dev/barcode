<x-app-layout>

    <div class="max-w-7xl mx-auto py-8 px-4">

        <div class="bg-white rounded-xl shadow">

            {{-- Header --}}
            <div class="border-b px-8 py-6">

                <h2 class="text-3xl font-bold text-gray-800">
                    Visitor Registration
                </h2>

                <p class="text-gray-500 mt-2">
                    Please fill all required details carefully.
                </p>

            </div>

            {{-- Validation --}}
            @if ($errors->any())

                <div class="m-6 rounded-lg bg-red-50 border border-red-200 p-4">

                    <ul class="list-disc list-inside text-red-600 text-sm">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('registration.store') }}" method="POST">

                @csrf

                <div class="p-8">

                    {{-- ========================= --}}
                    {{-- Visitor Details --}}
                    {{-- ========================= --}}

                    <div class="mb-8">

                        <h3 class="text-xl font-semibold text-gray-800 mb-5 border-b pb-2">
                            Visitor Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Email --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Email <span class="text-red-500">*</span>
                                </label>

                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                            {{-- Phone --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                        </div>

                        {{-- Name Row --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                            {{-- Title --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Title
                                </label>

                                <select name="title" class="w-full rounded-lg border-gray-300">

                                    <option value="">Select</option>

                                    <option value="Mr">Mr</option>

                                    <option value="Mrs">Mrs</option>

                                    <option value="Ms">Ms</option>

                                    <option value="Dr">Dr</option>

                                </select>

                            </div>

                            {{-- First Name --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    First Name <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                            {{-- Last Name --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Last Name
                                </label>

                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                        </div>

                        {{-- Job Details --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            <div>

                                <label class="block mb-2 font-medium">
                                    Job Title <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="job_title" value="{{ old('job_title') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                            <div>

                                <label class="block mb-2 font-medium">
                                    Job Function <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="job_function" value="{{ old('job_function') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                        </div>

                    </div>



                    {{-- ========================= --}}
                    {{-- Company Details --}}
                    {{-- ========================= --}}

                    <div class="mb-8">

                        <h3 class="text-xl font-semibold text-gray-800 mb-5 border-b pb-2">
                            Company Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label class="block mb-2 font-medium">
                                    Company Name <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="company_name" value="{{ old('company_name') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                            <div>

                                <label class="block mb-2 font-medium">
                                    Website
                                </label>

                                <input type="text" name="website" value="{{ old('website') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                        </div>

                        <div class="mt-6">

                            <label class="block mb-2 font-medium">
                                Address <span class="text-red-500">*</span>
                            </label>

                            <textarea rows="4" name="address" class="w-full rounded-lg border-gray-300">{{ old('address') }}</textarea>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            <div>

                                <label class="block mb-2 font-medium">
                                    Country <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="country" value="{{ old('country') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                            <div>

                                <label class="block mb-2 font-medium">
                                    State <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="state" value="{{ old('state') }}"
                                    class="w-full rounded-lg border-gray-300">

                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            {{-- City --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    City <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                            {{-- Pincode --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Pincode <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="pincode" value="{{ old('pincode') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                        </div>

                    </div>



                    {{-- ========================= --}}
                    {{-- Business Details --}}
                    {{-- ========================= --}}

                    <div class="mb-8">

                        <h3 class="text-xl font-semibold text-gray-800 mb-5 border-b pb-2">
                            Business Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Industry Segment --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Industry Segment <span class="text-red-500">*</span>
                                </label>

                                <select name="industry_segment"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                                    <option value="">Select Industry</option>

                                    <option value="Manufacturer">Manufacturer</option>

                                    <option value="Importer">Importer</option>

                                    <option value="Exporter">Exporter</option>

                                    <option value="Wholesaler">Wholesaler</option>

                                    <option value="Retailer">Retailer</option>

                                    <option value="Distributor">Distributor</option>

                                </select>

                            </div>

                            {{-- Business Nature --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Business Nature <span class="text-red-500">*</span>
                                </label>

                                <select name="business_nature"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                                    <option value="">Select Business Nature</option>

                                    <option value="Proprietorship">Proprietorship</option>

                                    <option value="Partnership">Partnership</option>

                                    <option value="Private Limited">Private Limited</option>

                                    <option value="Public Limited">Public Limited</option>

                                    <option value="LLP">LLP</option>

                                </select>

                            </div>

                        </div>



                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            {{-- Primary Product --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Primary Product Group <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="primary_product_group"
                                    value="{{ old('primary_product_group') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                            {{-- Additional Product --}}
                            <div>

                                <label class="block mb-2 font-medium">
                                    Additional Product Group
                                </label>

                                <input type="text" name="additional_product_group"
                                    value="{{ old('additional_product_group') }}"
                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                        </div>

                    </div>



                    {{-- ========================= --}}
                    {{-- Declaration --}}
                    {{-- ========================= --}}

                    <div class="border rounded-xl p-5 bg-gray-50">

                        <label class="flex items-start gap-3">

                            <input type="checkbox" name="terms" value="1"
                                class="mt-1 rounded border-gray-300">

                            <span class="text-sm text-gray-600 leading-6">

                                I hereby declare that all information provided by me is true and correct.
                                I agree to the Terms & Conditions and Privacy Policy.

                            </span>

                        </label>

                    </div>



                    {{-- Buttons --}}

                    <div class="flex justify-end gap-3 mt-8">

                        <a href="{{ route('registrations.index') }}"
                            class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">

                            Cancel

                        </a>

                        <button type="submit"
                            class="px-8 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700">

                            Submit Registration

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
