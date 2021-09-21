<?php

namespace App\Http\Controllers;

use App\JenisPKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Home/home');
    }
    public function GetJenisPKM()
    {
        $result = JenisPKM::all();
        return response()->json(["jenispkm" => $result]);
    }
    public function DownloadTemplate($jenis_pkm)
    {
        try {
            return Storage::download("public/dokumen/template/" . $jenis_pkm . ".pdf");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
