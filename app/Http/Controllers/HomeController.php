<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Origin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $db_backendpillar = Destination::where('destination', 'LIKE', '%' . $request->search . '%')
                ->get();
        } else {
            $db_backendpillar = Destination::with('origin')
                ->get();
        }

        return view('home', ['db_backendpillar' => $db_backendpillar]);
    }
}
