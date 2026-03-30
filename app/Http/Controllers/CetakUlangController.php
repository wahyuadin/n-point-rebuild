<?php

namespace App\Http\Controllers;

use App\Services\CetakulangService;
use Illuminate\Http\Request;

class CetakUlangController extends Controller
{
    protected $cetakUlang;

    public function __construct(CetakulangService $cetakUlang)
    {
        $this->cetakUlang = $cetakUlang;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function datatable(Request $request)
    {
        return datatables()->of($this->cetakUlang->datatable($request))
            ->addIndexColumn()
            ->editColumn('st_claim', function ($row) {
                return '<span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-200">' . $row->st_claim . '</span>';
            })
            ->editColumn('birth_date', function ($row) {
                return $row->birth_date ? \Carbon\Carbon::parse($row->birth_date)->format('Y-m-d') : '-';
            })
            ->editColumn('createddate', function ($row) {
                return $row->createddate ? \Carbon\Carbon::parse($row->createddate)->format('Y-m-d') : '-';
            })
            ->editColumn('ttl_paid', function ($row) {
                return 'Rp ' . number_format($row->ttl_paid, 0, ',', '.');
            })
            ->rawColumns(['st_claim', 'nm_plan', 'st_rujuk'])
            ->make(true);
    }
}
