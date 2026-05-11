<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKlaimExport;
use App\Services\CetakulangService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $provider = DB::table('tbl_provider');
        if (Auth::user()->role !== 'admin') {
            $provider->where('provider_code', Auth::user()->provider_code);
        }
        $providerName = $provider->value('provider_name');
        $columns = $request->input('columns', []);

        return Excel::download(
            new LaporanKlaimExport($request->dari, $request->sampai, $columns),
            'Laporan_Klaim_' . $providerName . '_' . $request->dari . '_' . $request->sampai . '.xlsx'
        );
    }
}
