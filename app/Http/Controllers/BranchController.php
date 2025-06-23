<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BranchStatus;
use App\Models\User;

class BranchController extends Controller
{
    public function index()
    {
        $response = Http::get('https://rhc-portal.org/franchises');
        $branches = $response->successful() ? $response->json() : [];

        // Attach local DB status to each branch
        foreach ($branches as &$branch) {
            $status = BranchStatus::where('branch_id', $branch['id'])->first();
            $branch['status'] = $status?->status ?? null;
        }

        return view('branches.index', compact('branches'));
    }

    public function activate(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|integer|unique:branch_statuses,branch_id',
        ]);
    
        // Step 1: Store branch status in local DB
        BranchStatus::create([
            'branch_id' => $request->branch_id,
            'status' => 'Active',
        ]);
    
        // Step 2: Fetch full branch info from API
        $apiResponse = Http::get('https://rhc-portal.org/franchises');
        if ($apiResponse->failed()) {
            return redirect()->back()->with('error', 'Unable to fetch branch data from API.');
        }
    
        $branches = $apiResponse->json();
        $branch = collect($branches)->firstWhere('id', $request->branch_id);
    
        if (!$branch) {
            return redirect()->back()->with('error', 'Branch data not found.');
        }
    
        // Step 3: Find or create user
        $user = User::firstOrCreate(
            ['email' => $branch['email_address']],
            [
                'name' => $branch['franchisee_name'],
                'password' => bcrypt('defaultpassword123'), // Temporary password
                'role' => 'branch', // Only if you have a 'role' column
            ]
        );
    
        // Step 4: Link branch to user using pivot table
        $user->branches()->syncWithoutDetaching([$branch['id']]);
    
        return redirect()->back()->with('success', 'Branch activated and user account updated.');
    }
    
}
