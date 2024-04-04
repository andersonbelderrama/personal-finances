<?php

use App\Livewire\RecurrentExpense;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(RecurrentExpense::class)
        ->assertStatus(200);
});
