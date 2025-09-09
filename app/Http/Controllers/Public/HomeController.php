<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

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

    public function getStarted(Request $request)
    {
        $plan = null;
        if ($request->has('plan')) {
            $plan = Plan::active()->where('slug', $request->get('plan'))->first();
        }

        if (! $plan) {
            return redirect()->route('tarifs');
        }

        return view('auth.register', [
            'plan' => $plan,
        ]);
    }
}
