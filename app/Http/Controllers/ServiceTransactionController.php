<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ServiceTransaction;
use App\Models\TransactionLog;

class ServiceTransactionController extends Controller
{
    public function index()
    {
        $transactions = ServiceTransaction::with(['transactionLogs'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($tx) {
                $items = collect($tx->transactionLogs); // ✅ plural version

                return [
                    'date' => $tx->created_at->format('Y-m-d'),
                    'or_number' => $tx->or_number,
                    'ss_number' => $tx->ss_number,
                    'services' => $items->pluck('item_name')->implode(', '),
                    'staff_list' => $items->pluck('staff_name')->filter()->unique()->implode(', '),
                    'amount' => $tx->total_amount,
                    'staff_services' => $items->map(fn ($item) => [
                        'staff' => $item->staff_name,
                        'service' => $item->item_name
                    ])->filter(fn ($entry) => $entry['staff'])->values()
                ];
            });

        return view('services.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        // Simulated save — no database storage for now
        return redirect()->back()->with('success', 'Simulated save: form data received.');
    }

    public function pos()
    {
        // Fetch dynamic services from external API
        $services = Http::get('https://rhc-portal.org/service-pricelists')->json();
    
        // Group by category + service name + length type
        $groupedServices = collect($services)
            ->groupBy(fn($item) => $item['category'] . ' - ' . $item['service_name'] . ' - ' . $item['length_type']);
    
        // Static staff list for now
        $staff = ['Anna', 'Ben', 'Carla'];
    
        return view('services.pos', compact('groupedServices', 'staff'));
    }
}
