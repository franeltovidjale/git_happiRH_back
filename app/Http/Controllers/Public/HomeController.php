<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class HomeController extends Controller
{
    public function welcome()
    {
        $plans = Plan::active()->with('features')->get();

        return view('welcome', [
            'plans' => $plans,
        ]);
    }

    public function features()
    {
        return view('public.features');
    }

    public function tarifs()
    {
        return view('public.tarifs');
    }

    public function demo()
    {
        return view('public.demo');
    }

    public function resources()
    {
        return view('public.resources');
    }

    public function company()
    {
        return view('public.company');
    }

    public function getStarted()
    {
        return view('auth.register');
    }
}
