<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Illuminate\Http\Request;

class lendingController extends Controller
{
    public function index(Request $request){
        $data = [
          'logged' => UserHelper::CheckAuth($request)
        ];

        return view('pages.main')->with($data);
    }
}
