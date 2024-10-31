<?php

namespace App\Livewire;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\On;

class DropdownSearch extends Component
{
    public $isOpen = false;
    public $searchTerm = '';
    public $items = [];
    public $model;
    public $displayName;
    public $filteredItems = [];
    public $selectedItem = null;



    public function mount($model, $displayName = 'name')
    {
        $this->model = $model;
        $this->displayName = $displayName;
        $this->loadItems();
    }

    public function loadItems(){
        try {
            $model = 'App\Models\\'.$this->model;
            $this->items = $model::whereNotIn('id',function ($query) {
                $query->select('container_id')->from('shipment_details');
            })->pluck($this->displayName, 'id')->toArray();

            $this->filteredItems = collect($this->items)->map(function ($item, $key) {
                return [
                    'key' => $key,
                    'value' => $item,
                ];
            })->all();
        }catch (\Throwable $th) {
            $this->items = [];
            Toaster::error(__('Model Not Found'));
        }
    }

    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
        $this->dispatch('dropdown-toggle', $this->isOpen);
    }

    public function updatedSearchTerm()
    {
        $this->filteredItems = collect($this->items)
            ->filter(function ($item) {
                return str_contains(strtolower($item), strtolower($this->searchTerm));
            })
            ->map(function ($item, $key) {
                return [
                    'key' => $key,
                    'value' => $item,
                ];
            })
            ->all();
    }

    #[On('dropdown-selected')]
    public function refreshSelectedItem($key, $value)
    {
        $this->selectedItem = $value;
        $this->isOpen = !$this->isOpen;
        $this->dispatch('dropdown-toggle', $this->isOpen);
    }

    #[On('refresh-dropdown-search')]
    public function resetSelectedItem()
    {
        $this->selectedItem = null;
    }

    public function render()
    {
        return view('livewire.dropdown-search');
    }

}
