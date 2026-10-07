<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'pageTitle' => 'Dashboard',
            'stats' => [
                [
                    'label' => 'Portfolio Views',
                    'value' => '12.4K',
                    'change' => '+18%',
                ],
                [
                    'label' => 'Messages',
                    'value' => '28',
                    'change' => '+7',
                ],
                [
                    'label' => 'Projects',
                    'value' => '16',
                    'change' => '4 active',
                ],
                [
                    'label' => 'Services',
                    'value' => '6',
                    'change' => 'Live',
                ],
            ],
        ]);
    }
}
