<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersReportExport implements FromView
{
    private $filter = [];
    
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function view(): View
    {
        $lists = User::search($this->filter)
                    ->whereHas('roles', function($q) {
                        $q = $q->where('name', 'Customer');
                    })
                    ->select('id', 'name', 'email', 'phone', 'created_at', 'active')
                    ->withCount('favourites')
                    ->orderBy('favourites_count', 'desc')
                    ->get();
                    
        return view('admin.pages.customers.export',compact('lists'));
        return view('admin.pages.reports.customers.export', compact('lists'));
    }
}
