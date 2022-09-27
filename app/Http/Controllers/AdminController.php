<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('adm.painel');
    }

    public function denuncias()
    {
        return view('adm.denuncias');
    }

    public function create()
    {
        return view('adm.registerAdm');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
