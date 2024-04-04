<?php

use App\Livewire\Account;
use App\Livewire\Budget;
use App\Livewire\Category;
use App\Livewire\Debt;
use App\Livewire\RecurrentExpense;
use App\Livewire\Transaction;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => 'auth'], function () {
    Route::get('accounts', Account::class)->name('accounts');
    Route::get('budgets', Budget::class)->name('budgets');
    Route::get('categories', Category::class)->name('categories');
    Route::get('debts', Debt::class)->name('debts');
    Route::get('recurrent-expenses', RecurrentExpense::class)->name('recurrent-expenses');
    Route::get('transactions', Transaction::class)->name('transactions');
});

require __DIR__.'/auth.php';
