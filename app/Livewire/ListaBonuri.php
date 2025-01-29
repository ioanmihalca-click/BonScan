<?php

namespace App\Livewire;

use App\Models\Bon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
        $bon = Bon::where('user_id', Auth::id())
            ->findOrFail($this->selectedBonId);

        $bon->delete();
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
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10)
        ]);
    }
}
