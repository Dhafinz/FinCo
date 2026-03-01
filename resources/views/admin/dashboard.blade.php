<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FinCo</title>
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
                <a href="/gamification" class="hover:underline">Gamification</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-gray-500">Total Transactions</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['total_transactions'] }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-gray-500">Total Income</p>
                <p class="text-3xl font-bold text-green-500">Rp {{ number_format($stats['total_income']) }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-gray-500">Total Expense</p>
                <p class="text-3xl font-bold text-red-500">Rp {{ number_format($stats['total_expense']) }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p>Selamat datang di Admin Panel FinCo!</p>
        </div>
    </div>
</body>
</html>