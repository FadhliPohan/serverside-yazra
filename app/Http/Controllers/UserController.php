<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();
            // Pencarian berdasarkan nama atau email
            if ($request->has('search') && !empty($request->search['value'])) {
                $query->where('name', 'like', '%' . $request->search['value'] . '%');
                $query->orWhere('email', 'like', '%' . $request->search['value'] . '%');
            }

            // $data = $query->get();
            $data = $query->limit(10);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Lihat</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users');
    }


    public function call(Request $request)
    {
        $data = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
