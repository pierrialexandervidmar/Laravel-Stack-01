<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PostIndex extends Component
{
    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);
        Storage::disk('public')->delete($post->image);
        $post->delete();
        session()->flash('success', 'Post deletado com sucesso.');
    }

    public function render()
    {
        return view('livewire.posts.post-index', [
            'posts' => auth()->user()->posts()->latest()->get(),
        ]);
    }
}
