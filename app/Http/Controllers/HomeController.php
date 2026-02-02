<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $quotas = Registration::all();
        return view('home', compact('quotas'));
    }

    public function about()
    {
        return view('about');
    }

    public function vision()
    {
        return view('vision');
    }

    public function contact()
    {
        return view('contact');
    }
}