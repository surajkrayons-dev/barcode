<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <h2 class="text-2xl font-bold text-gray-800">
                    Visitor Registrations
                </h2>

                <a href="{{ route('registration.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    + New Registration
                </a>

            </div>

            {{-- Search --}}
            <form method="GET"
                action="{{ route('registrations.index') }}"
                class="flex flex-col md:flex-row gap-3 mb-6">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search Registration No, Name, Company, Email..."
                    class="flex-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                <select
                    name="status"
                    class="rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">

                    <option value="">All Status</option>

                    <option value="1"
                        @selected(request('status')==='1')>
                        Active
                    </option>

                    <option value="0"
                        @selected(request('status')==='0')>
                        Inactive
                    </option>

                </select>

                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Filter
                </button>

                @if(request('search') || request('status') !== null)

                    <a href="{{ route('registrations.index') }}"
                        class="px-4 py-2 text-gray-500 hover:text-gray-700">
                        Clear
                    </a>

                @endif

            </form>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">

                <table class="min-w-full divide-y divide-gray-200 text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Registration No
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Visitor Name
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Company
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Job Title
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Phone
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Email
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Country
                            </th>

                            <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-4 py-3 text-right font-semibold text-gray-600">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($registrations as $registration)

                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3 font-medium">
                                    {{ $registration->registration_no }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->full_name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->company_name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->job_title }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->phone }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->email }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $registration->country }}
                                </td>

                                <td class="px-4 py-3">

                                    @if($registration->status)

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Active
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td class="px-4 py-3 text-right">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ route('registration.view',$registration->id) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100"
                                            title="View">

                                            👁️

                                        </a>

                                        <a href="{{ route('registration.edit',$registration->id) }}"
                                            class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50"
                                            title="Edit">

                                            ✏️

                                        </a>

                                        <a href="{{ route('registration.delete',$registration->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this registration?');"
                                            class="p-2 rounded-lg text-red-600 hover:bg-red-50"
                                            title="Delete">

                                            🗑️

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="px-4 py-10 text-center text-gray-400">

                                    No registrations found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="mt-6">

                {{ $registrations->links() }}

            </div>

        </div>

    </div>
</x-app-layout>