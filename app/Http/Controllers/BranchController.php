<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BranchController extends Controller
{
    public function index()
    {
        // Fetch branch data from external API
        $response = Http::get('https://rhc-portal.org/franchises');

        // Check if response is successful
        if ($response->successful()) {
            $branches = $response->json(); // Decode JSON response
        } else {
            $branches = []; // Fallback if API fails
        }

        // Pass data to the view
        return view('branches.index', compact('branches'));
    }
}
