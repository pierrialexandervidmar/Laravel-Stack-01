<?php

namespace App\Livewire\Forms\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;

/**
 * Class PostForm
 *
 * Classe responsável pelo gerenciamento do formulário de criação e edição de posts.
 * Contém regras de validação, atribuição de dados e persistência no banco de dados.
 */
class PostForm extends Form
{
    /**
     * @var Post|null Post associado ao formulário (utilizado na edição).
     */
    public ?Post $post;

    /**
     * @var string Título do post.
     */
    public $title = '';

    /**
     * @var mixed Imagem do post (arquivo enviado pelo usuário).
     */
    public $image;

    /**
     * @var string Conteúdo do post.
     */
    public $content = '';

    /**
     * Atribui um post existente ao formulário para edição.
     *
     * @param  Post  $post  Instância do post a ser editado.
     * @return void
     */
    public function setPost(Post $post)
    {
        // Define o post atual no formulário
        $this->post = $post;

        // Preenche o título do post no formulário
        $this->title = $post->title;

        // Preenche o conteúdo do post no formulário
        $this->content = $post->content;
    }

    /**
     * Define as regras de validação para o formulário.
     *
     * @return array Regras de validação.
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Processa o envio do formulário para criar um novo post.
     *
     * @return void
     */
    public function store()
    {
        // Valida os dados do formulário conforme as regras
        $this->validate();

        // Prepara os dados para criar o post
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            // Gera um slug baseado no título
            'slug' => str()->slug($this->title),
        ];

        // Se uma imagem foi enviada, armazena-a e adiciona ao array de dados
        if ($this->image) {
            $data['image'] = $this->image->store('posts', 'public');
        }

        // Cria um novo post associado ao usuário autenticado
        auth()->user()->posts()->create($data);

        // Reseta os campos do formulário após a criação
        $this->reset();
    }

    /**
     * Processa o envio do formulário para atualizar um post existente.
     *
     * @return void
     */
    public function update()
    {
        // Valida os dados do formulário conforme as regras
        $this->validate();

        // Prepara os dados atualizados para o post
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            // Gera um novo slug baseado no título
            'slug' => str()->slug($this->title),
        ];

        // Mantém a imagem atual do post
        $data['image'] = $this->post->image;

        // Se uma nova imagem foi enviada
        if ($this->image) {
            // Remove a imagem antiga do disco público
            Storage::disk('public')->delete($this->post->image);

            // Armazena a nova imagem e atualiza o campo de imagem
            $data['image'] = $this->image->store('posts', 'public');
        }

        // Atualiza o post associado ao usuário autenticado
        $this->post->update($data);

        // Reseta os campos do formulário após a atualização
        $this->reset();
    }
}
