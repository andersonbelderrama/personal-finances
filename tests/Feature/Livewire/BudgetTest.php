<?php

use App\Livewire\Budget;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Budget::class)
        ->assertStatus(200);
});
