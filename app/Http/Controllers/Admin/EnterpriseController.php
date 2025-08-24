<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class EnterpriseController extends Controller
{
    public function index()
    {
        return Inertia::render('Enterprises/Index');
    }
}
