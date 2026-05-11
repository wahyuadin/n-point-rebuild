<?php

namespace App\Http\Controllers;

use App\Services\CetakulangService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $cetakUlang;

    public function __construct(CetakulangService $cetakUlang)
    {
        $this->cetakUlang = $cetakUlang;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function exportExcel(Request $request)
    {
        // return $request->all();

        return $this->cetakUlang->exportExcel($request);
    }
}
