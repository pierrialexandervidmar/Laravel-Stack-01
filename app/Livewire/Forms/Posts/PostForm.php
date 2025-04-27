<?php

namespace App\Livewire\Forms\Posts;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public $title = '';
    public $image;
    public $content = '';

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    // Método para processar o envio do formulário
    public function store()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => str()->slug($this->title),
        ];

        if ($this->image)
        {
            $data['image'] = $this->image->store('posts', 'public');
        }

        // Cria o post associado ao usuário autenticado
        auth()->user()->posts()->create($data);

        // Reseta os campos do formulário após o sucesso
        $this->reset();
    }
}
