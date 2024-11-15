<?php

namespace App\Http\Controllers;

use App\Services\ItemServices\WolfService;

class ItemController extends Controller
{
    private WolfService $wolfService;

    public function __construct(WolfService $wolfService)
    {
        parent::__construct();
        $this->wolfService = $wolfService;
    }
}
