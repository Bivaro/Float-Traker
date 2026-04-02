<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        // Get transactions newest first
        $transactions = Transaction::latest()->get();

        $balance = 0;

        // To calculate running balance correctly, loop oldest → newest first
        $ordered = $transactions->sortBy('created_at');

        foreach ($ordered as $t) {
            if ($t->type == 'float_Out') {
                $balance -= $t->amount;
            } else {
                $balance += $t->amount;
            }

            $t->running_balance = $balance;
        }

        // Finally, re-sort back to latest → oldest for display
        $transactions = $ordered->sortByDesc('created_at');

        return view('home', compact('transactions', 'balance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Transaction added successfully.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return redirect('/');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect('/');
    }

    public function downloadPdf()
    {
        $transactions = Transaction::orderBy('created_at')->get();

        $balance = 0;
        foreach ($transactions as $t) {
            $balance += $t->type == 'float_Out' ? -$t->amount : $t->amount;
            $t->running_balance = $balance;
        }

        $pdf = Pdf::loadView('transactions_pdf', compact('transactions', 'balance'));
        return $pdf->download('transactions.pdf');
    }
}
