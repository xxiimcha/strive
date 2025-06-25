<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionLog;
use App\Models\ServiceTransaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'customer_name' => 'nullable|string',
            'contact' => 'nullable|string',
            'cash' => 'required|numeric',
            'change' => 'required|numeric',
        ]);

        $transactionNumber = 'TXN-' . strtoupper(Str::random(8));
        $branchId = 1;

        $total = 0;
        DB::beginTransaction();
        try {
            foreach ($data['items'] as $item) {
                $total += $item['item_rate'] * $item['quantity'];

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

            ServiceTransaction::create([
                'customer_name' => $data['customer_name'],
                'contact' => $data['contact'],
                'transaction_log_id' => TransactionLog::where('transaction_number', $transactionNumber)->first()->id,
                'total_amount' => $total,
                'cash' => $data['cash'],
                'change' => $data['change'],
                'ss_number' => $data['ss_number'],
                'or_number' => $data['or_number'],
                'status' => 'completed',
                'reason' => null,
                'branch_id' => $branchId,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Transaction saved successfully',
                'transaction_number' => $transactionNumber
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed', 'error' => $e->getMessage()], 500);
        }
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
        $count = TransactionLog::where('transaction_number', $txn)
            ->where('status', 'completed')
            ->update(['status' => 'refund', 'refund_reason' => $reason]);

        ServiceTransaction::whereHas('transactionLog', function ($q) use ($txn) {
            $q->where('transaction_number', $txn);
        })->update([
            'status' => 'refund',
            'reason' => $reason,
        ]);

        return response()->json(['message' => "Refunded $count item(s) in transaction $txn."]);
    }

    public function refundSelectedItems(Request $request)
    {
        $ids = $request->input('ids', []);
        $reason = $request->input('reason');

        $count = TransactionLog::whereIn('id', $ids)
            ->where('status', 'completed')
            ->update(['status' => 'refund', 'refund_reason' => $reason]);

        return response()->json(['message' => "Refunded $count selected item(s)."]);
    }
}
