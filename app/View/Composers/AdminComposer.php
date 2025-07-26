<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\User;

class AdminComposer
{
    public function compose(View $view)
    {
        $user = null;
        if (session('logged_id')) {
            $user = User::find(session('logged_id'));
        }

        $view->with('currentAdmin', $user);
    }
}
