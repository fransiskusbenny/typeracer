<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait HasParticipants
{
    public Collection $participants;

    public function updateParticipants($participants)
    {
        $this->participants = collect($participants)
            ->sortByDesc(fn($participant) => $participant['id'] == $this->user()->id)
            ->values();
    }

    public function addParticipant($participant)
    {
        $this->participants = $this->participants->push($participant);

        $this->participantAdded($participant);;
    }

    public function removeParticipant($participant)
    {
        $this->participants = $this->participants->where('id', '<>', $participant['id'])->values();

        $this->participantRemoved($participant);
    }

    protected function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::guard('broadcast')->user();
    }

    protected function participantAdded($participant)
    {

    }

    protected function participantRemoved($participant)
    {

    }
}