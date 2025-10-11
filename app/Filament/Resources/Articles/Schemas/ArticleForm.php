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
                                    $prompt = "You are an expert SEO content writer specializing in Laravel development, web technologies, and best practices.

                                                Your task: Generate a comprehensive, well-researched, long-form blog article based on the provided title.

                                                INPUT INFORMATION:
                                                - Title: \"$state\"
                                                - Target audience: Laravel developers (beginner to advanced)
                                                - Language: Auto-detect from title (English → English, French → Français)

                                                CONTENT REQUIREMENTS:

                                                Structure:
                                                1. **Eye-catching Introduction** (150-200 words)
                                                - Hook the reader with a compelling opening
                                                - Briefly explain what the article covers
                                                - Highlight key value propositions
                                                - Include a clear context of why this topic matters

                                                2. **Detailed Main Sections** (800-1000 words)
                                                - Create 4-6 well-organized sections with descriptive H2 headings
                                                - Each section should have 150-250 words minimum
                                                - Use H3 subheadings to break up complex topics
                                                - Include practical examples relevant to Laravel developers
                                                - Provide real-world use cases and scenarios

                                                3. **Code Examples**
                                                - Include 3-5 practical Laravel code snippets (```php blocks)
                                                - Add comments explaining complex logic
                                                - Show both incorrect and correct approaches when relevant
                                                - Ensure all code is production-ready and follows Laravel conventions

                                                4. **Key Takeaways Section** (100-150 words)
                                                - Summarize critical points in a memorable way
                                                - Use bullet points for clarity
                                                - Focus on actionable insights

                                                5. **Compelling Conclusion** (150-200 words)
                                                - Recap the main points
                                                - Reinforce the article's value
                                                - Include a strong call-to-action
                                                - Suggest related topics the reader might explore

                                                FORMATTING REQUIREMENTS:
                                                - Use strict Markdown syntax (NO HTML tags)
                                                - # H1: Main title (use the provided title)
                                                - ## H2: Major sections
                                                - ### H3: Subsections (use when needed for clarity)
                                                - **Bold** for emphasis on key terms
                                                - Use unordered lists (-) or ordered lists (1.) appropriately
                                                - Code blocks with ```php language identifier
                                                - Include images with descriptive alt text: ![descriptive alt text](url)
                                                - Add 2-3 relevant images throughout the article
                                                - Use proper Markdown formatting for links: [anchor text](url)

                                                QUALITY STANDARDS:
                                                - Minimum word count: 1200 words
                                                - Write in clear, professional but accessible language
                                                - Avoid redundancy and fluff
                                                - Use active voice and strong verbs
                                                - Include current best practices and industry standards
                                                - Ensure SEO-friendly content without keyword stuffing
                                                - Every section should provide genuine value

                                                SEO OPTIMIZATION:
                                                - Include the main keyword naturally 5-7 times throughout the article
                                                - Use LSI (Latent Semantic Indexing) keywords related to the topic
                                                - Write descriptive headings that include relevant keywords
                                                - Ensure the article answers common questions about the topic

                                                OUTPUT FORMAT - End the article with a dedicated SEO section:

                                                ---
                                                

                                                TONE AND STYLE:
                                                - Professional yet approachable
                                                - Educational and informative
                                                - Practical and actionable
                                                - Confident and authoritative
                                                - Avoid overly technical jargon; explain when necessary
                                                - Include tips and warnings where appropriate

                                                IMPORTANT NOTES:
                                                - Ensure content is original and well-researched
                                                - Follow Laravel naming conventions and best practices
                                                - Include Laravel version-specific information if relevant
                                                - Be factually accurate; double-check code examples
                                                - Write for long-form engagement (people should stay to read the full article)
                                                - Make the article shareable and reference-worthy";

                                    $response = Prism::text()
                                        ->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
                                        ->withPrompt($prompt)
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
