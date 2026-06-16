<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function data(Request $request)
    {
        $period     = strtoupper($request->get('period', 'ANNUAL'));
        $city       = $request->get('city', 'all');
        $monthRange = $this->monthRange($period);

        return response()->json([
            'kpis'  => $this->kpis($monthRange, $city),
            'q1'    => $this->q1($monthRange, $city),
            'q2'    => $this->q2($monthRange),
            'q3'    => $this->q3($monthRange),
            'q4'    => $this->q4($monthRange),
            'q5'    => $this->q5($monthRange),
            'trend' => $this->trend($monthRange, $city),
        ]);
    }

    private function monthRange(string $period): ?array
    {
        return match ($period) {
            'Q1'    => [1, 3],
            'Q2'    => [4, 6],
            'Q3'    => [7, 9],
            'Q4'    => [10, 12],
            'H1'    => [1, 6],
            'H2'    => [7, 12],
            default => null,
        };
    }

    private function periodFilter($query, ?array $mr, string $dateCol = 'od.orderDate')
    {
        if ($mr) {
            $query->whereBetween(DB::raw("MONTH($dateCol)"), $mr)
                  ->where(DB::raw("YEAR($dateCol)"), 2025);
        }
        return $query;
    }

    private function kpis(?array $mr, string $city): array
    {
        $base = function () use ($mr, $city) {
            return DB::table('fact_q1 as f')
                ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
                ->join('customer_dim as cd', 'f.customer_dim_id', '=', 'cd.customer_dim_id')
                ->when($city !== 'all', fn($q) => $q->where('cd.city', $city))
                ->when($mr, fn($q) => $q
                    ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                    ->where(DB::raw('YEAR(od.orderDate)'), 2025));
        };

        return [
            'revenue'   => (float) $base()->sum(DB::raw('f.quantityOrdered * f.priceEach')),
            'orders'    => (int)   $base()->distinct()->count('f.orderNumber'),
            'customers' => (int)   DB::table('customer_dim')
                ->when($city !== 'all', fn($q) => $q->where('city', $city))
                ->count(),
            'products'  => (int)   DB::table('product_dim')->count(),
        ];
    }

    private function q1(?array $mr, string $city): array
    {
        $rows = DB::table('fact_q1 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('customer_dim as cd', 'f.customer_dim_id', '=', 'cd.customer_dim_id')
            ->selectRaw('cd.city, SUM(f.quantityOrdered * f.priceEach) as total_sales')
            ->when($city !== 'all', fn($q) => $q->where('cd.city', $city))
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy('cd.city')
            ->orderByDesc('total_sales')
            ->get();

        return [
            'labels' => $rows->pluck('city')->values(),
            'values' => $rows->pluck('total_sales')->map(fn($v) => (float) $v)->values(),
        ];
    }

    private function q2(?array $mr): array
    {
        $rows = DB::table('fact_q2 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('product_dim as pd', 'f.product_dim_id', '=', 'pd.product_dim_id')
            ->selectRaw('pd.productName as product_name, SUM(f.quantityOrdered * f.priceEach) as total_sales')
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy('pd.productName')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        return [
            'labels' => $rows->pluck('product_name')->values(),
            'values' => $rows->pluck('total_sales')->map(fn($v) => (float) $v)->values(),
        ];
    }

    private function q3(?array $mr): array
    {
        $rows = DB::table('fact_q3 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('employee_dim as ed', 'f.employee_dim_id', '=', 'ed.employee_dim_id')
            ->join('shopping_service.offices as off', 'ed.officeCode', '=', 'off.officeCode')
            ->selectRaw('off.city as office_city, COUNT(DISTINCT f.orderNumber) as total_orders')
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy('off.city')
            ->orderByDesc('total_orders')
            ->get();

        return [
            'labels' => $rows->pluck('office_city')->values(),
            'values' => $rows->pluck('total_orders')->map(fn($v) => (int) $v)->values(),
        ];
    }

    private function q4(?array $mr): array
    {
        $rows = DB::table('fact_q4 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('productline_dim as pl', 'f.productline_dim_id', '=', 'pl.productline_dim_id')
            ->selectRaw('pl.productLine as product_line, SUM(f.quantityOrdered * f.priceEach) as total_revenue')
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy('pl.productLine')
            ->orderByDesc('total_revenue')
            ->get();

        return [
            'labels' => $rows->pluck('product_line')->values(),
            'values' => $rows->pluck('total_revenue')->map(fn($v) => (float) $v)->values(),
        ];
    }

    private function q5(?array $mr): array
    {
        $rows = DB::table('fact_q5 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('employee_dim as ed', 'f.employee_dim_id', '=', 'ed.employee_dim_id')
            ->selectRaw('CONCAT(ed.firstName, " ", ed.lastName) as sales_rep,
                         COUNT(DISTINCT f.orderNumber) as total_orders,
                         SUM(f.quantityOrdered * f.priceEach) as total_revenue')
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy('ed.employeeNumber', 'ed.firstName', 'ed.lastName')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        return [
            'labels'  => $rows->pluck('sales_rep')->values(),
            'orders'  => $rows->pluck('total_orders')->map(fn($v) => (int) $v)->values(),
            'revenue' => $rows->pluck('total_revenue')->map(fn($v) => (float) $v)->values(),
        ];
    }

    private function trend(?array $mr, string $city): array
    {
        $names = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                       'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $rows = DB::table('fact_q1 as f')
            ->join('order_dim as od', 'f.order_dim_id', '=', 'od.order_dim_id')
            ->join('customer_dim as cd', 'f.customer_dim_id', '=', 'cd.customer_dim_id')
            ->selectRaw('MONTH(od.orderDate) as month_num,
                         SUM(f.quantityOrdered * f.priceEach) as total_sales')
            ->when($city !== 'all', fn($q) => $q->where('cd.city', $city))
            ->when($mr, fn($q) => $q
                ->whereBetween(DB::raw('MONTH(od.orderDate)'), $mr)
                ->where(DB::raw('YEAR(od.orderDate)'), 2025))
            ->groupBy(DB::raw('MONTH(od.orderDate)'))
            ->orderBy('month_num')
            ->get();

        return [
            'labels' => $rows->pluck('month_num')->map(fn($m) => $names[(int) $m] ?? "M{$m}")->values(),
            'values' => $rows->pluck('total_sales')->map(fn($v) => (float) $v)->values(),
        ];
    }
}
