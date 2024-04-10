<?php

namespace App\Livewire;

use App\Enums\AccountType;
use App\Helpers\PowerGridThemes\TailwindStriped;
use App\Models\Account;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
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
use PowerComponents\LivewirePowerGrid\Responsive;

final class AccountTable extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = false;

    public function setUp(): array
    {
        $this->showCheckBox();

        $this->persist(['columns', 'filters']);

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Responsive::make()
                ->fixedColumns('name','balance',Responsive::ACTIONS_COLUMN_NAME),
        ];
    }

    public function template(): ?string
    {
        return TailwindStriped::class;
    }

    public function datasource(): ?Builder
    {
        return Account::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

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

        $this->skipRender();
    }

    #[On('openModal')]
    public function openModal(string $component, array $arguments)
    {
        if ($component === 'edit') {
            // Por exemplo, você pode emitir um evento para abrir o modal de edição com os argumentos passados
            $this->emit('editModalOpened', $arguments);
        } elseif ($component === 'delete') {
            // Ou você pode abrir o modal de exclusão com os argumentos passados
            $this->emit('deleteModalOpened', $arguments);
        }
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
                return $account->type->label();
            })
            ->add('balance_formatted', function (Account $account) {
                return 'R$ ' . number_format($account->balance, 2, ',', '.');
            })
            //->add('user_id')
            ->add('created_at')
            ->add('created_at_formatted', fn ($account) => Carbon::parse($account->created_at)->format('d/m/Y H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),
            Column::make('Banco', 'name')
                ->sortable()
                ->fixedOnResponsive()
                ->searchable(),

            Column::make(__('Agência'), 'branch')
                ->sortable()
                ->hidden( true, false )
                ->searchable(),

            Column::make('Conta', 'account_number')
                ->sortable()
                ->hidden( true, false )
                ->searchable(),

            Column::make('Ativo', 'active')
                ->sortable()
                ->toggleable()
                ->searchable(),

            Column::make('Tipo', 'type_label', 'accounts.type')
                // ->contentClasses(                    [
                //     AccountType::ContaCorrente->labels() => 'flex items-center justify-center p-2 rounded-full text-md bg-indigo-600',
                // ])
                ->sortable()
                ->searchable(),

            Column::make('Saldo', 'balance_formatted', 'balance')
                ->sortable()
                ->searchable(),

            //Column::make('User id', 'user_id'),

            Column::make('Criado em', 'created_at_formatted', 'created_at')
                ->sortable()
                ->hidden( true, false )
                ->searchable(),

            Column::action('Ações')
                ->fixedOnResponsive(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name', 'Name')
                ->operators(['contains', 'is', 'is_not']),

            Filter::enumSelect('type_label', 'type')
                ->dataSource(AccountType::cases())
                ->optionLabel('type_label'),

            Filter::number('balance_formatted', 'balance')
                ->thousands('.')
                ->decimal(','),


        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->emit('edit', $rowId);
    }

    public function actions(Account $row): array
    {
        return [
            Button::add('edit')
                ->slot('Editar')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->openModal('edit', ['account' => $row->id])
                //->dispatch('edit', ['rowId' => $row->id])
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


}
