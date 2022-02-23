<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Porpagar extends Component
{
    public function render()
    {
        

        return view('livewire.porpagar')
            ->extends('layouts.livewire-layout')
            ->section('content');
    }
    }

