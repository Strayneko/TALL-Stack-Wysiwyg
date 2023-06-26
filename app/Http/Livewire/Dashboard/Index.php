<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $file;
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
