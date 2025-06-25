<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionLog;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function storeTransaction(Request $request)
    {
        $data = $request->validate([
            'or_number' => 'nullable|string',
            'ss_number' => 'required|string',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.item_rate' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.staff_name' => 'nullable|string',
        ]);

        $transactionNumber = 'TXN-' . strtoupper(Str::random(8));
        $branchId = 1; // default branch ID

        foreach ($data['items'] as $item) {
            TransactionLog::create([
                'transaction_number' => $transactionNumber,
                'or_number' => $data['or_number'],
                'ss_number' => $data['ss_number'],
                'branch_id' => $branchId,
                'status' => 'completed',
                'item_name' => $item['item_name'],
                'item_rate' => $item['item_rate'],
                'quantity' => $item['quantity'],
                'staff_name' => $item['staff_name'],
            ]);
        }

        return response()->json([
            'message' => 'Transaction saved successfully',
            'transaction_number' => $transactionNumber
        ], 201);
    }

    public function getRefundableTransactions($ssNumber)
    {
        return TransactionLog::where('ss_number', $ssNumber)
            ->where('status', 'completed')
            ->orderByDesc('transaction_number')
            ->get();
    }
    
    public function refundWholeTransaction(Request $request, $txn)
    {
        $reason = $request->input('reason');
        // Log or store $reason if needed
        $count = TransactionLog::where('transaction_number', $txn)
            ->where('status', 'completed')
            ->update(['status' => 'refund', 'refund_reason' => $reason]);
    
        return response()->json(['message' => "Refunded $count item(s) in transaction $txn."]);
    }
    
    public function refundSelectedItems(Request $request)
    {
        $ids = $request->input('ids', []);
        $reason = $request->input('reason');
        // Log or store $reason if needed
        $count = TransactionLog::whereIn('id', $ids)
            ->where('status', 'completed')
            ->update(['status' => 'refund', 'refund_reason' => $reason]);
    
        return response()->json(['message' => "Refunded $count selected item(s)."]);
    }    
}
