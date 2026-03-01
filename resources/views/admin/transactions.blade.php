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
        <h2 class="text-2xl font-bold mb-6">All Transactions</h2>

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
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $transactions->links() }}</div>
        </div>
    </div>
</body>
</html>