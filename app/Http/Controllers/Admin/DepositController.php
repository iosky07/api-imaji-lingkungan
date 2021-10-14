<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function show($id)
    {
        return view('pages.deposit.show', compact('id'));
    }
}
