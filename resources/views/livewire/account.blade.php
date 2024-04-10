<div>


    <div class="container px-6 mx-auto">
        <div class="flex flex-col md:flex-row my-6 space-y-4 md:space-y-0 md:space-x-6">
            @foreach ($accounts_sum as $account_sum)
                <x-card class="relative z-20 overflow-hidden rounded-xl" shadow="md">
                    <x-icon name="currency-dollar" class="w-48 h-48 absolute z-10 opacity-10 -top-11 right-4 -rotate-6" outline />
                    <div class="text-xl font-semibold">{{ $account_sum->type->label() }} </div>
                    <div class="text-3xl font-bold">R$ {{ number_format($account_sum->balance_sum, 2, ',', '.') }}</div>
                </x-card>
            @endforeach
        </div>
        <livewire:account-table />
    </div>
</div>
