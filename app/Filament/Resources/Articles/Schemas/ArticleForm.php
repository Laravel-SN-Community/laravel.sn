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
use Illuminate\Support\Str;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\ValueObjects\ProviderTool;

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
                                    $prompt = "You are an expert SEO content writer specializing in Laravel development and web technologies.

                                                TASK: Generate a comprehensive, long-form blog article (1200+ words) based on the provided title.

                                                INPUT VARIABLES:
                                                - Title: \"{$state}\"
                                                - Audience: Laravel developers (beginner to advanced)
                                                - Language: Detect automatically from the title

                                                CONTENT STRUCTURE:

                                                1. Introduction (150-200 words)
                                                - Hook with compelling opening
                                                - Explain what the article covers and why it matters
                                                - Highlight key value propositions

                                                2. Main Content (800-1000 words)
                                                - 4-6 sections with descriptive H2 headings
                                                - 150-250 words per section
                                                - Use H3 subheadings for complex topics
                                                - Include real-world use cases and practical examples

                                                3. Code Examples
                                                - 3-5 production-ready Laravel code snippets with ```php blocks
                                                - Add explanatory comments
                                                - Follow Laravel conventions and best practices

                                                4. Key Takeaways (100-150 words)
                                                - Bullet points summarizing critical insights
                                                - Focus on actionable takeaways

                                                5. Conclusion (150-200 words)
                                                - Recap main points
                                                - Strong call-to-action
                                                - Suggest related topics

                                                FORMATTING (Strict Markdown, NO HTML):
                                                - # H1: Main title
                                                - ## H2: Major sections
                                                - ### H3: Subsections
                                                - **Bold** for key terms
                                                - Code blocks: ```php
                                                - Images: ![alt text](url) - include 2-3 relevant images
                                                - Links: [text](url)

                                                QUALITY REQUIREMENTS:
                                                - Clear, professional, accessible language
                                                - Active voice and strong verbs
                                                - Current best practices and accurate information
                                                - SEO-friendly without keyword stuffing
                                                - Include main keyword naturally 5-7 times
                                                - Answer common questions about the topic

                                                TONE: Professional, educational, practical, and authoritative.";

                                    $response = Prism::text()
                                        ->using(Provider::Anthropic, 'claude-3-5-sonnet-latest')
                                        ->withPrompt($prompt)
                                        ->withClientOptions([
                                            'timeout' => 120,
                                        ])
                                        ->withProviderTools([
                                            new ProviderTool(type: 'web_search_20250305', name: 'web_search'),
                                        ])
                                        ->asText();

                                    $content = $response->text;
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
                Select::make('technologies')
                    ->label('Technologies')
                    ->relationship('technologies', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->helperText('Select technologies for this article or create new ones'),

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
