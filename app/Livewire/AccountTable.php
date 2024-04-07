<?php

namespace App\Livewire;

use App\Enums\AccountType;
use App\Models\Account;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AccountTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Account::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('branch')
            ->add('account_number')
            ->add('active')
            ->add('type_label', function (Account $account) {
                return $account->type->labels();
            })
            ->add('balance_formatted', function (Account $account) {
                return 'R$ ' . number_format($account->balance, 2, ',', '.');
            })
            ->add('user_id')
            ->add('created_at_formatted', function (Account $account) {
                return Carbon::parse($account->created_at)->format('d/m/Y H:i');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id'),
            Column::make('Banco', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Agência', 'branch')
                ->sortable()
                ->searchable(),

            Column::make('Conta', 'account_number')
                ->sortable()
                ->searchable(),

            Column::make('Ativo', 'active')
                ->sortable()
                ->toggleable()
                ->searchable(),

            Column::make('Tipo', 'type_label')
                ->sortable()
                ->searchable(),

            Column::make('Saldo', 'balance_formatted')
                ->sortable()
                ->searchable(),

            //Column::make('User id', 'user_id'),

            Column::make('Criado em', 'created_at_formatted')
                ->sortable()
                ->searchable(),

            Column::action('Ações')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name', 'Name')
                ->operators(['contains', 'is', 'is_not']),



        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Account $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        Account::query()->find($id)->update([
            $field => $value
        ]);
    }

    public function onUpdatedToggleable(string $id, string $field, string $value): void
    {
        Account::query()->find($id)->update([
            $field => $value
        ]);
    }

}
