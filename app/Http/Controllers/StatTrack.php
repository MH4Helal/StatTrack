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
        // Retrieve statistics for the current day or from cache if available
        $currentDate = now()->toDateString();
        $statistics = Cache::remember('sales_statistics_' . $currentDate, now()->addMinutes(10)), function () use ($currentDate) {
            return $this->calculateStatisticsForDate($currentDate);
        });

        // Retrieve historical statistics for previous days from the separate database
        $historicalStatistics = $this->getHistoricalStatistics();

        // Merge current statistics with historical statistics
        $statistics = $historicalStatistics->merge($statistics);

        return view('index');
    }

    private function calculateStatisticsForDate($date)
    {
        return [
            $date => [
                'sales_agents' => Sale::whereDate('datetime', $date)->groupBy('sales_agent')->selectRaw('sales_agent, COUNT(*) as total_sales, SUM(price) as total_price')->get(),
                'products' => Sale::whereDate('datetime', $date)->groupBy('product')->selectRaw('product, COUNT(*) as total_sales, SUM(price) as total_price')->get(),
                'customers' => Sale::whereDate('datetime', $date)->groupBy('customer')->selectRaw('customer, COUNT(*) as total_sales, SUM(price) as total_price')->get(),
            ]
        ];
    }

    private function getHistoricalStatistics()
    {
        // Retrieve historical statistics from the separate database for previous days
     
        return collect();
    }
}
