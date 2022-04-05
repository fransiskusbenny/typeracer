<?php

namespace App\Http\Livewire;

use App\Events\ChatWasSent;
use App\Events\NicknameUpdated;
use App\Models\Lounge;
use Illuminate\Support\Collection;
use Livewire\Component;

class ChattingLounge extends Component
{
    use HasParticipants;

    public Lounge $lounge;
    public array $chats = [];
    public string $message = '';

    public function mount()
    {
        $this->participants = new Collection();
    }

    public function render()
    {
        return view('livewire.chatting-lounge');
    }

    public function sendMessage()
    {
        $this->validate(['message' => ['required', 'string', 'min:1', 'max:200']]);

        $this->chats[] = [
            'user' => [
                'id' => $this->user()->id,
                'name' => $this->user()->name
            ],
            'message' => $this->message
        ];

        ChatWasSent::broadcast($this->lounge, $this->message, $this->user())->toOthers();

        $this->reset('message');
    }

    public function updateChats($message)
    {
        array_push($this->chats, $message);
    }

    public function nicknameUpdated()
    {
        $this->updateParticipantNickname([
            'id' => $this->user()->id,
            'name' => $this->user()->name
        ]);

        NicknameUpdated::broadcast($this->lounge, $this->user())->toOthers();
    }

    protected function getListeners()
    {
        return [
            "echo-presence:lounge.{$this->lounge->id},here" => 'updateParticipants',
            "echo-presence:lounge.{$this->lounge->id},joining" => 'addParticipant',
            "echo-presence:lounge.{$this->lounge->id},leaving" => 'removeParticipant',
            "echo-private:lounge.{$this->lounge->id},NicknameUpdated" => 'updateParticipantNickname',
            "echo-private:lounge.{$this->lounge->id},ChatWasSent" => 'updateChats',
        ];
    }

    protected function participantAdded($participant)
    {
        ChatWasSent::broadcast($this->lounge, "{$participant['name']} has entered the lounge");
    }

     public function removeParticipant($participant)
    {
        $this->participantRemoved($participant);

        $this->participants = $this->participants->where('id', '<>', $participant['id'])->values();
    }

    protected function participantRemoved($participant)
    {
        ChatWasSent::broadcast($this->lounge, "{$participant['name']} has left the lounge");
    }

    public function updateParticipantNickname(array $updatedParticipant)
    {
        $this->participants = $this->participants->map(function ($participant) use($updatedParticipant){
            if($participant['id'] == $updatedParticipant['id']) {
                $participant['name'] = $updatedParticipant['name'];
            }
            return $participant;
        });
    }
}
