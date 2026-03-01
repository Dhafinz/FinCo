<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions - FinCo Admin</title>
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
        <div class="flex justify-between mb-6">
            <h2 class="text-2xl font-bold">All Transactions</h2>
            <a href="/admin/transactions/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Transaction</a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Type</th>
                        <th class="p-3 text-left">Amount</th>
                        <th class="p-3 text-left">XP</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                    <tr class="border-t">
                        <td class="p-3">{{ $t->id }}</td>
                        <td class="p-3">{{ $t->user->name ?? '-' }}</td>
                        <td class="p-3">{{ $t->category->name ?? '-' }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-sm {{ $t->type == 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $t->type }}
                            </span>
                        </td>
                        <td class="p-3">Rp {{ number_format($t->amount) }}</td>
                        <td class="p-3 text-yellow-600 font-bold">+{{ $t->xp_earned }} XP</td>
                        <td class="p-3">{{ $t->transaction_date }}</td>
                        <td class="p-3 space-x-2">
                            <a href="/admin/transactions/{{ $t->id }}/edit" class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500">Edit</a>
                            <form action="/admin/transactions/{{ $t->id }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus transaksi ini?')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $transactions->links() }}</div>
        </div>
    </div>
</body>
</html>