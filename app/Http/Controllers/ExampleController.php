<?php

namespace App\Http\Controllers;

use App\Jobs\TestQueue;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test() {
        $arr = ['time' => time()];
        $this->dispatch(new TestQueue($arr));
        return resp(200, 'ok');
    }
}
