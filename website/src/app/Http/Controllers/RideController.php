<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class RideController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function __invoke($id)
    {
        return 'hello';
    }
}
