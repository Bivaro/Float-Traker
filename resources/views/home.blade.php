<!DOCTYPE html>
<html>
<head>
    <title>Float Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Float Balance: KES {{ number_format($balance, 2) }}</h2>

    <h3>Add Transaction</h3>

    <form method="POST" action="/add">
        @csrf
        <div class="mb-3">
        <select name="type" required>
            <option value="">Select Type</option>
            <option value="float_In">Float In</option>
            <option value="float_Out">Float Out</option>
        </select><br>
</div>

<div class="mb-3">
        <input type="number" name="amount" placeholder="Amount" required><br>
</div>

<div class="mb-3">
        <input type="text" name="description" placeholder="Description"><br>
</div>
        <button type="submit">Save</button>
    </form>

    <h3>Transactions</h3>
    
    <a href="{{ route('transactions.downloadPdf') }}"><button>Download PDF</button></a>
    <table border="1" cellpadding="10" class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Trans. Date</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Running Balance</th> 
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $t)
        <tr>
            <td>{{ $t->created_at->format('d M Y H:i') }}</td>    
            <td>{{ $t->type }}</td>
            <td>KES {{ number_format($t->amount, 2) }}</td>
            <td>{{ $t->description }}</td>
            <td>KES {{ number_format($t->running_balance, 2) }}</td>
            <td>
                <!-- Edit button -->
                <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <!-- Delete button -->
            <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            </td>
        </tr>

    @endforeach
    </tbody>
    </table>
</div>
</body>
</html>