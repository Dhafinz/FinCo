<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaction - FinCo Admin</title>
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

    <div class="container mx-auto p-6 max-w-lg">
        <h2 class="text-2xl font-bold mb-6">Edit Transaction</h2>

        @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <form action="/admin/transactions/{{ $transaction->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">User</label>
                    <select name="user_id" class="w-full border rounded p-2">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $transaction->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Category</label>
                    <select name="category_id" class="w-full border rounded p-2">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full border rounded p-2">
                        <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Amount</label>
                    <input type="number" name="amount" value="{{ $transaction->amount }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" value="{{ $transaction->description }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Date</label>
                    <input type="date" name="transaction_date" value="{{ $transaction->transaction_date }}" class="w-full border rounded p-2">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                    <a href="/admin/transactions" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>