<?php

namespace App\Http\Controllers;

use App\Helpers\EncryptionHelper;
use App\Services\LoggerChainService\Logger;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $goTo = request()->goTo ?? session('goTo') ?? [];
        try {
            $goTo = $goTo ? EncryptionHelper::decodeRequestAttribute($goTo) : [];

        } catch (\Throwable $e) {
            $log = new Logger($e);
            $log->log();
        }
        session()->forget('goTo');

        return view('index', [
            'currentUser' => auth()->user()->only('id', 'name', 'email'),
            'goTo' => $goTo
        ]);
    }


}
