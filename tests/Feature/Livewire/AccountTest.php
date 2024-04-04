<?php

use App\Livewire\Account;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Account::class)
        ->assertStatus(200);
});
