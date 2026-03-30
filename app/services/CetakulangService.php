<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CetakulangService
{
    public function tambah($request)
    {
        DB::beginTransaction();
        try {
            // Logic simpan data Anda di sini...

            DB::commit();
            toastify()->success('Data Berhasil Ditambahkan.');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback(); // Rollback HARUS sebelum return
            toastify()->error('Error: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id, $request)
    {
        DB::beginTransaction();
        try {
            // Logic update data Anda di sini...

            DB::commit();
            toastify()->success('Data Berhasil diedit.');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            toastify()->error('Error: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function hapus($id)
    {
        DB::beginTransaction();
        try {
            // Logic hapus data Anda di sini...

            DB::commit();
            toastify()->success('Data Berhasil Dihapus.');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            toastify()->error('Error: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function datatable($request)
    {
        $query = DB::table('tbl_claim AS c')
            ->join('tbl_claim_detail AS cd', 'c.claim_no', '=', 'cd.claim_no')
            ->join('tbl_membership AS m', 'c.member_no', '=', 'm.member_no')
            ->join('tbl_plan AS p', 'p.kd_plan', '=', 'c.kd_plan')
            ->join('tbl_customer AS cust', 'cust.kd_cus', '=', 'c.kd_cus');

        if (Auth::user()->role !== 'admin') {
            $query->where('c.provider_code', Auth::user()->provider_code);
        }

        if ($request->dari && $request->sampai) {
            $query->whereBetween('c.createddate', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        }

        return $query->select(
            'c.claim_no',
            'c.rs',
            'c.st_claim',
            'p.nm_plan',
            'c.st_rujuk',
            'cust.nm_cus',
            'm.member_no',
            'c.createddate',
            'm.birth_date',
            'm.member_name',
            DB::raw('SUM(cd.ttl_paid) AS ttl_paid')
        )
            ->groupBy(
                'c.claim_no',
                'c.rs',
                'c.st_claim',
                'p.nm_plan',
                'c.st_rujuk',
                'cust.nm_cus',
                'm.member_no',
                'c.createddate',
                'm.birth_date',
                'm.member_name'
            );
    }
}
