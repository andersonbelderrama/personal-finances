<?php

use App\Livewire\Debt;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Debt::class)
        ->assertStatus(200);
});
