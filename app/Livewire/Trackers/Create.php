<?php

namespace App\Livewire\Trackers;

use App\Repositories\Trackers;
use Livewire\Component;

class Create extends Component
{
    protected Trackers $trackers;

    public string $apiUrl;
    public string $type;
    public string $token;

    public array $types = [
        'everhour' => 'Everhour',
        'clockify' => 'Clockify',
        'mayven' => 'Mayven',
        'placeholder' => 'Placeholder',
    ];

    public function __construct()
    {
        $this->trackers = app(Trackers::class);
    }

    public function render()
    {
        return view('livewire.trackers.create');
    }

}
