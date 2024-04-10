<?php

namespace App\Livewire;

use Livewire\Component;

class Account extends Component
{
    public function render()
    {
        $accounts_sum = \App\Models\Account::where('user_id', auth()->user()->id)->selectRaw('type, sum(balance) as balance_sum')->groupBy('type')->get();

        return view('livewire.account',[
            'accounts_sum' => $accounts_sum
        ]);
    }
}
