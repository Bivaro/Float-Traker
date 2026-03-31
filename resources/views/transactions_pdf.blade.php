<!DOCTYPE html>
<html>
<head>
    <title>Transactions PDF</title>
</head>
<body>
    <h2>Float Balance: KES {{ number_format($balance, 2) }}</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Running Balance</th>
            <th>Date</th>
        </tr>
        @foreach($transactions as $t)
        <tr>
            <td>{{ $t->type }}</td>
            <td>KES {{ number_format($t->amount, 2) }}</td>
            <td>{{ $t->description }}</td>
            <td>KES {{ number_format($t->running_balance, 2) }}</td>
            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
