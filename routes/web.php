<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchGrantController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\AcademicianController;

Route::get('/', function () {
    $totalGrants = \App\Models\ResearchGrant::count();
    $totalFunding = \App\Models\ResearchGrant::sum('grant_amount');
    $totalResearchers = \App\Models\Academician::count();
    $recentGrants = \App\Models\ResearchGrant::with('projectLeader')
        ->latest()
        ->take(5)
        ->get();

    return view('welcome', compact(
        'totalGrants',
        'totalFunding',
        'totalResearchers',
        'recentGrants'
    ));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Admin Executive and iRMC staff routes
    Route::middleware(['can:admin-executive,irmc-staff'])->group(function () {
        Route::resource('academicians', AcademicianController::class);
    });

    // Admin Executive only routes
    Route::middleware(['can:admin-executive'])->group(function () {
        Route::resource('grants', ResearchGrantController::class);
        Route::post('/grants/{grant}/members', [ResearchGrantController::class, 'updateMembers'])->name('grants.members.update');
    });

    // Routes accessible by all authenticated users (moved after resource routes)
    Route::get('/grants', [ResearchGrantController::class, 'index'])->name('grants.index');
    Route::get('/grants/{grant}', [ResearchGrantController::class, 'show'])->name('grants.show');

    // Project Leader routes
    Route::middleware(['can:project-leader'])->group(function () {
        Route::get('/my-grants', [ResearchGrantController::class, 'myGrants'])->name('grants.my');
        Route::post('/grants/{grant}/members', [ResearchGrantController::class, 'updateMembers'])
            ->middleware('can:manage-grant,grant')
            ->name('grants.members.update');
    });

    // Milestone routes with grant management authorization
    Route::middleware(['can:manage-grant,grant'])->group(function () {
        Route::post('/grants/{grant}/milestones', [MilestoneController::class, 'store'])->name('milestones.store');
        Route::put('/grants/{grant}/milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
        Route::delete('/grants/{grant}/milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');
    });
});
