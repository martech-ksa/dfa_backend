<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <table class="w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border text-left">Name</th>
                            <th class="p-3 border text-left">Email</th>
                            <th class="p-3 border text-left">Current Role</th>
                            <th class="p-3 border text-left">Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border">{{ $user->name }}</td>
                                <td class="p-3 border">{{ $user->email }}</td>
                                <td class="p-3 border font-semibold">
                                    {{ $user->roles->pluck('name')->first() ?? 'No Role' }}
                                </td>
                                <td class="p-3 border">
                                    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                        @csrf

                                        <select name="role_id" class="border rounded p-2">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    @if($user->roles->pluck('id')->first() == $role->id)
                                                        selected
                                                    @endif
                                                >
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded ml-2">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</x-app-layout>