<section>

    <form wire:submit="updatePost" class="max-w-md mx-auto flex flex-col gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        
        {{-- Title --}}
        <flux:input wire:model="form.title" label="title" type="text" autofocus autocomplete="email"
            placeholder="Title here" />

        {{-- Image --}}
        <flux:input wire:model="form.image" label="Image" type="file" />

        {{-- Content --}}
        <flux:textarea wire:model="form.content" label="Content" type="text" placeholder="Content here" />

        {{-- Category --}}

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">Salvar Edição</flux:button>
        </div>
    </form>

</section>