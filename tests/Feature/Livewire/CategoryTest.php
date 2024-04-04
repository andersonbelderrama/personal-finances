<?php

use App\Livewire\Category;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Category::class)
        ->assertStatus(200);
});
