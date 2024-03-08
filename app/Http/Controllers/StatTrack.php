<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class StatTrack extends Controller
{
    public function index()
    {
        // Retrieve statistics from cache if available
        $statistics = Cache::remember('sales_statistics', now()->addHours(1), function () {
            return $this->calculateStatistics();
        });

        return view('index');
    }

    private function calculateStatistics()
    {
        $statistics = [];

        // Calculate statistics for each day
        $dates = Sale::selectRaw('DATE(datetime) as date')->distinct()->pluck('date');
        foreach ($dates as $date) {
            $statistics[$date] = [
                'sales_agents' => Sale::whereDate('datetime', $date)->groupBy('sales_agent_id')->selectRaw('sales_agent_id, COUNT(*) as total_sales, SUM(price) as total_price')->with('salesAgent')->get(),
                'products' => Sale::whereDate('datetime', $date)->groupBy('product_id')->selectRaw('product_id, COUNT(*) as total_sales, SUM(price) as total_price')->with('product')->get(),
                'customers' => Sale::whereDate('datetime', $date)->groupBy('customer_id')->selectRaw('customer_id, COUNT(*) as total_sales, SUM(price) as total_price')->with('customer')->get(),
            ];
        }

        return $statistics;
    }
}
