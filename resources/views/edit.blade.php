<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaction</title>
</head>
<body>
    <h2>Edit Transaction</h2>

    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        <select name="type" required>
            <option value="float_In" {{ $transaction->type == 'float_In' ? 'selected' : '' }}>Float In</option>
            <option value="float_Out" {{ $transaction->type == 'float_Out' ? 'selected' : '' }}>Float Out</option>
        </select><br><br>

        <input type="number" name="amount" value="{{ $transaction->amount }}" required><br><br>

        <input type="text" name="description" value="{{ $transaction->description }}"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
