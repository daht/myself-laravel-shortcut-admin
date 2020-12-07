<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function roles(Request $request)
    {

        $result = $this->roles->newQuery()->paginate();
        return view_prefix('app_index', compact('result', 'request'));
    }
}