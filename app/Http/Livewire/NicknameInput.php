<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NicknameInput extends Component
{
    public string $name;

    public function mount()
    {
         $this->name = $this->user()?->name ?? '';
    }

    public function render()
    {
        return view('livewire.nickname-input');
    }

    public function updated($property)
    {
        $guest = json_encode([
            'id' => $this->user()->id,
            'name' => $this->name ?: 'Guest-'. $this->user()->id,
        ]);

        cookie()->queue('guest', $guest, 60 * 24, null, null, false);

        $this->dispatchBrowserEvent('nickname-updated');
    }

    protected function user()
    {
        return Auth::guard('broadcast')->user();
    }
}
