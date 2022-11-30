<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

Route::get('/', /* [HomeController::class, 'index'], */ function () {
    if (auth()->user()) {
        return redirect()->to('/admin/dashboard');
    } else {
        return redirect()->to('/login');
    }
})
    ->name('index');
// ->breadcrumbs(function (Trail $trail) {
//     $trail->push(__('Home'), route('frontend.index'));
// });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });
