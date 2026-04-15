@extends('layouts.app')

@section('content')

<div class="p-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-5 rounded-xl mb-6">
        <h2 class="text-lg font-semibold">👥 User Management</h2>
        <p class="text-sm text-blue-100">Manage staff accounts</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('password'))
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">
            Password: <strong>{{ session('password') }}</strong>
        </div>
    @endif

    <!-- SEARCH -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Search users..."
                   class="border p-2 rounded w-1/3">

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Search
            </button>
        </form>
    </div>

    <!-- CREATE STAFF -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="font-semibold mb-4">➕ Add New Staff</h3>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input type="text" name="name"
                       placeholder="Full Name"
                       class="border p-2 rounded"
                       required>

                <input type="email" name="email"
                       placeholder="Email Address"
                       class="border p-2 rounded"
                       required>

                <select name="role"
                        class="border p-2 rounded"
                        required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="mt-4">
                <button class="bg-blue-600 text-white px-5 py-2 rounded">
                    Create Staff
                </button>
            </div>
        </form>
    </div>

    <!-- USERS TABLE -->
    <div class="bg-white p-6 rounded shadow">

        <h3 class="font-semibold mb-4">📋 Users</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Name</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Role</th>
                        <th class="p-2 border">Edit Role</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($users as $index => $user)
                    <tr>

                        <td class="p-2 border">
                            {{ method_exists($users, 'firstItem') ? $users->firstItem() + $index : $index + 1 }}
                        </td>

                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->email }}</td>

                        <td class="p-2 border">
                            @foreach($user->roles as $role)
                                <span class="bg-blue-100 px-2 py-1 text-xs rounded">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>

                        <!-- EDIT ROLE BUTTON -->
                        <td class="p-2 border text-center">
                            <button onclick="openRoleModal({{ $user->id }}, '{{ $user->roles->pluck('name')->first() }}')"
                                    class="bg-indigo-500 text-white px-3 py-1 rounded text-xs">
                                Edit Role
                            </button>
                        </td>

                        <!-- DELETE -->
                        <td class="p-2 border text-center">
                            @if(auth()->id() !== $user->id)
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Delete user?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">You</span>
                            @endif
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">
                            No users found
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        @if(method_exists($users, 'links'))
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</div>

<!-- ROLE MODAL -->
<div id="roleModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96">

        <h3 class="font-semibold mb-4">Update User Role</h3>

        <form method="POST" id="roleForm">
            @csrf

            <select name="role" id="roleSelect" class="border p-2 rounded w-full mb-4">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRoleModal()"
                        class="bg-gray-400 text-white px-4 py-2 rounded">
                    Cancel
                </button>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openRoleModal(userId, currentRole) {
    let modal = document.getElementById('roleModal');
    let form = document.getElementById('roleForm');
    let select = document.getElementById('roleSelect');

    form.action = `/admin/users/${userId}/role`;
    select.value = currentRole;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRoleModal() {
    document.getElementById('roleModal').classList.add('hidden');
}
</script>

@endsection