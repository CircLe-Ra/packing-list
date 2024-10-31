<?php

namespace App\Livewire;

use Livewire\Component;
use Masmerise\Toaster\Toaster;

class DropdownSearch extends Component
{
    public $isOpen = false;
    public $searchTerm = '';
    public $items = [];
    public $model;
    public $displayName;
    public $filteredItems = [];

    public function mount($model, $displayName = 'name')
    {
        $this->model = $model;
        $this->displayName = $displayName;
        $this->loadItems();
    }

    public function loadItems(){
        try {
            $modelClass = 'App\Models\\' . $this->model;
            $this->items = $modelClass::pluck($this->displayName, 'id')->toArray();
            $this->filteredItems = $this->items;
        }catch (\Throwable $th) {
            $this->items = [];
            Toaster::error(__('Model Not Found'));
        }
    }

    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function updatedSearchTerm()
    {
        $this->filteredItems = collect($this->items)->filter(function ($item) {
                            return str_contains(strtolower($item), strtolower($this->searchTerm));
                        });
    }

    public function render()
    {
        return view('livewire.dropdown-search');
    }

}
