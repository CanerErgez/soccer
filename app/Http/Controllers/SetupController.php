<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SetupService;

class SetupController extends Controller
{
    public function __construct(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function setup()
    {
        if ($this->setupService->generateNewLeague())
        {
            return redirect('/');
        }

        throw new \Exception('Could not create league. Review your settings.');
    }
}
