<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PlayersExport implements FromView
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
                        $q = $q->where('name', User::TYPE_PLAYER);
                    })->with('country')->latest();

        if (isset($this->filter['active'])) {
            $lists = $lists->active($this->filter['active']);
        }
        $lists = $lists->get();

        return view('admin.pages.players.export', compact('lists'));
    }

}
