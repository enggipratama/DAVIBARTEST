<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\RincianOrder;

class RincianOrderTable extends Component
{
    public $rincianOrders;

    public function mount()
    {
        // Logika pengambilan data rincian order
        $this->rincianOrders = RincianOrder::all();
    }

    public function render()
    {
        return view('components.rincian-order-table');
    }
}