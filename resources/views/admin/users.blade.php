<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users - FinCo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">FinCo Admin</h1>
            <div class="space-x-4">
                <a href="/admin" class="hover:underline">Dashboard</a>
                <a href="/admin/transactions" class="hover:underline">Transactions</a>
                <a href="/admin/users" class="hover:underline">Users</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">All Users</h2>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role</th>
                        <th class="p-3 text-left">Level</th>
                        <th class="p-3 text-left">Total XP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-t">
                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-sm {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-3">{{ $user->gamificationProfile->level ?? 1 }}</td>
                        <td class="p-3 text-yellow-600 font-bold">{{ $user->gamificationProfile->total_xp ?? 0 }} XP</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $users->links() }}</div>
        </div>
    </div>
</body>
</html>