<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
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
                    })->latest();
        if (isset($this->filter['active'])) {
            $lists = $lists->active($this->filter['active']);
        }
        $lists = $lists->get();

        return view('admin.pages.customers.export',compact('lists'));
    }
}
