<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use Livewire\WithFileUploads;

class PostEdit extends Component
{
    use WithFileUploads;
    
    public function render()
    {
        return view('livewire.posts.post-edit');
    }
}
