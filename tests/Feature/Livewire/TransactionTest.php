<?php

use App\Livewire\Transaction;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Transaction::class)
        ->assertStatus(200);
});
