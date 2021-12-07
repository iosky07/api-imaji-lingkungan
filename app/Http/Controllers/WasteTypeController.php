<?php

namespace App\Http\Controllers;

use App\Models\WasteType;
use Illuminate\Http\Request;

class WasteTypeController extends Controller
{
    public function index(){
        return view('pages.commodity.index', [
            'wasteType'=>WasteType::class
        ]);
    }
    public function create(){
        return view('pages.commodity.create');
    }
    public function edit($id){
        return view('pages.commodity.edit',compact('id'));
    }
}
