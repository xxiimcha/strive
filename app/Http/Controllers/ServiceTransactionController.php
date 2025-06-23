<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceTransactionController extends Controller
{
    public function index()
    {
        // Simulated transaction data
        $transactions = [
            [
                'date' => '2025-06-23',
                'or_number' => '001245',
                'ss_number' => 'SS876',
                'services' => 'Haircut, Hair Color',
                'staff_list' => 'Anna, Belle',
                'amount' => 1200.00,
                'individual_staff' => ['Anna', 'Belle', '', '', '', '', '', ''],
            ],
        ];

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

        // Group by service category and service name, filter only non-quoted services
        $groupedServices = collect($services)
            ->where('is_quoted', 0)
            ->groupBy(fn($item) => $item['category'] . ' - ' . $item['service_name']);

        // Static staff list for now
        $staff = ['Anna', 'Ben', 'Carla'];

        return view('services.pos', compact('groupedServices', 'staff'));
    }
}
