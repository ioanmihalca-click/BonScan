<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use Livewire\WithPagination;

class ListaBonuri extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $selectedBonId;
    public $showEditModal = false;

    protected $listeners = ['rezultatUpdated' => '$refresh'];

    public function confirmDelete($bonId)
    {
        $this->selectedBonId = $bonId;
        $this->showDeleteModal = true;
    }

    public function deleteBon()
    {
        $bon = Bon::find($this->selectedBonId);
        if ($bon) {
            $bon->delete();
        }
        $this->showDeleteModal = false;
        session()->flash('message', 'Bonul a fost șters cu succes.');
    }

    public function editBon($bonId)
    {
        $this->selectedBonId = $bonId;
        $this->showEditModal = true;
    }

    public function render()
    {
        return view('livewire.lista-bonuri', [
            'bonuri' => Bon::with('rezultatOcr')
                          ->latest()
                          ->paginate(10)
        ]);
    }
}