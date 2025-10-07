<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->suffixAction(
                        Action::make('generate-post-content')
                            ->tooltip('Generate post content using AI')
                            ->icon('heroicon-m-sparkles')->defaultColor('primary')
                            ->action(function (?string $state, Set $set) {
                                if (empty($state)) {
                                    Notification::make()
                                        ->title('Please enter a title first.')
                                        ->body('You can\'t generate content without a title.')
                                        ->warning()
                                        ->send();

                                    return;
                                }
                                try {
                                    //                                    $prompt = "Write a detailed article about: " . $state;
                                    $prompt = "You are a Laravel expert SEO content writer.
Generate a comprehensive and detailed long-form blog article about the following title.
The language of the article must match the language of the title.

Title: \"$state\"

Guidelines:
- If the title is in English, write the article in English.
- If the title is in French, write the article in French.
- Minimum length: 1200 words.
- Format the output strictly in Markdown (not HTML).
- Use proper Markdown syntax:
  * # H1 for the main title
  * ## H2 and ### H3 for subheadings
  * Lists (- or 1.)
  * Code blocks with ```php for Laravel examples
  * Images with ![alt](url)
- Include introduction, detailed sections, and a strong conclusion.
- At the end, suggest a Meta description and 3–5 SEO keywords in Markdown list format.";
                                    $response = Gemini::generativeModel(model: 'gemini-2.0-flash')
                                        ->generateContent($prompt);
                                    $content = $response->text();
                                    if (empty($content)) {
                                        Notification::make()
                                            ->title('No content generated.')
                                            ->body('The AI did not return any content. Please try again.')
                                            ->warning()
                                            ->send();

                                        return;
                                    }
                                    $set('content', $content);
                                    Notification::make()
                                        ->title('Content generated successfully.')
                                        ->body('The AI has generated content for your article.')
                                        ->success()
                                        ->send();
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->title('Error generating content.')
                                        ->body($e->getMessage())
                                        ->danger()
                                        ->send();

                                    return;
                                }
                                //                                $set('content', 'AI generated content for: ' . $state);
                            })
                    )
                    ->required(),
                TextInput::make('slug')
                    ->scopedUnique()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('articles')
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
                //                DateTimePicker::make('published_at')
                //                    ->nullable()
                //                    ->after('status'),
            ]);
    }
}
