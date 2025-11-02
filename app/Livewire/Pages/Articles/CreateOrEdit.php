<?php

namespace App\Livewire\Pages\Articles;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Category;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class CreateOrEdit extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?Article $article = null;
    public ?array $data = [];
    public bool $isEditing = false;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->article = Article::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $this->isEditing = true;

            $this->form->fill([
                'title' => $this->article->title,
                'slug' => $this->article->slug,
                'content' => $this->article->content,
                'excerpt' => $this->article->excerpt,
                'status' => $this->article->status,
                'category_id' => $this->article->category_id,
            ]);
        } else {
            $this->form->fill([
                'status' => 'draft',
            ]);
        }
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('slug')
                    ->scopedUnique()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('articles')
                    ->directory('articles/covers')
                    ->disk('public')
                    ->image()
                    ->imageEditor()

                    ->maxSize(5120)
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->maxLength(255),
                        TextInput::make('description')
                            ->maxLength(500),
                    ])
                    ->helperText('Select a category for this article or create a new one'),

                Select::make('status')
                    ->options(ArticleStatus::class)
                    ->required(),
                MarkdownEditor::make('content')
                    ->fileAttachmentsDirectory('articles')
                    ->fileAttachmentsDisk('public')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->model($this->article ?? Article::class);


    }

    public function save(): void
    {
        $data = $this->form->getState();

        $data['user_id'] = Auth::id();

        if ($data['status'] === 'published' && !$this->article?->published_at) {
            $data['published_at'] = now();
        }

        // Extraire l'image avant de sauvegarder
        $coverImage = $data['cover_image'] ?? null;
        unset($data['cover_image']);

        if ($this->isEditing) {
            $this->article->update($data);
            $message = 'Article mis à jour avec succès.';
        } else {
            $this->article = Article::create($data);
            $message = 'Article créé avec succès.';
        }

        // Gérer l'upload de l'image si elle existe
        if ($coverImage) {
            $this->article->clearMediaCollection('articles');
            $this->article->addMedia(storage_path('app/public/' . $coverImage))
                ->toMediaCollection('articles');
        }

        Notification::make()
            ->title($message)
            ->success()
            ->send();

        $this->redirectRoute('articles.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.articles.create-or-edit');
    }
}
