<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Float Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Mobile scaling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Float Balance: KES {{ number_format($balance, 2) }}</h2>

    <h3>Add Transaction</h3>

    <form method="POST" action="/add" class="mb-4">
        @csrf
        <div class="mb-3">
            <select name="type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="float_In">Float In</option>
                <option value="float_Out">Float Out</option>
            </select>
        </div>

        <div class="mb-3">
            <input type="number" name="amount" class="form-control" placeholder="Amount" required>
        </div>

        <div class="mb-3">
            <input type="text" name="description" class="form-control" placeholder="Description">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <h3>Transactions</h3>
    <a href="{{ route('transactions.downloadPdf') }}" class="btn btn-secondary mb-3">Download PDF</a>

    <!-- Make table scrollable on small screens -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Trans. Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Running Balance</th>
                    <th>Actions</th>
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
                        <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
