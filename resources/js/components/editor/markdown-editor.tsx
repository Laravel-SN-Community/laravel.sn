import {
    BlockTypeSelect,
    BoldItalicUnderlineToggles,
    codeBlockPlugin,
    codeMirrorPlugin,
    CodeToggle,
    CreateLink,
    diffSourcePlugin,
    DiffSourceToggleWrapper,
    headingsPlugin,
    imagePlugin,
    InsertCodeBlock,
    InsertImage,
    linkDialogPlugin,
    linkPlugin,
    listsPlugin,
    ListsToggle,
    markdownShortcutPlugin,
    MDXEditor,
    quotePlugin,
    Separator,
    tablePlugin,
    thematicBreakPlugin,
    toolbarPlugin,
    UndoRedo,
} from '@mdxeditor/editor';
import type { MDXEditorMethods } from '@mdxeditor/editor';
import { forwardRef, useCallback, useEffect, useMemo, useRef } from 'react';
import { uploadEditorImage } from '@/lib/editor-upload';
import { cn } from '@/lib/utils';

import '@mdxeditor/editor/style.css';
import './markdown-editor.css';

export type EditorScope = 'full' | 'compact';

export interface MarkdownEditorProps {
    value: string;
    onChange: (markdown: string) => void;
    placeholder?: string;
    error?: string | undefined;
    scope?: EditorScope;
    disabled?: boolean;
    allowImages?: boolean;
    minHeight?: number;
    maxHeight?: number;
    className?: string;
    autoFocus?: boolean;
}

export const MarkdownEditor = forwardRef<MDXEditorMethods, MarkdownEditorProps>(
    function MarkdownEditor(
        {
            value,
            onChange,
            placeholder,
            error,
            scope = 'full',
            disabled = false,
            allowImages = true,
            minHeight = 240,
            maxHeight,
            className,
            autoFocus = false,
        },
        ref,
    ) {
        const wrapperRef = useRef<HTMLDivElement>(null);
        const overlayRef = useRef<HTMLDivElement>(null);

        const imageUploadHandler = useCallback(async (file: File) => {
            return uploadEditorImage(file);
        }, []);

        const handleChange = useCallback(
            (markdown: string) => {
                onChange(markdown);
            },
            [onChange],
        );

        useEffect(() => {
            if (!wrapperRef.current) {
                return;
            }

            const shell = wrapperRef.current.querySelector(
                '.mdxeditor-popup-container',
            );

            if (shell instanceof HTMLElement) {
                shell.style.zIndex = '99999';
            }
        }, []);

        const plugins = useMemo(() => {
            const base = [
                headingsPlugin({
                    allowedHeadingLevels:
                        scope === 'full' ? [1, 2, 3, 4] : [2, 3],
                }),
                listsPlugin(),
                quotePlugin(),
                thematicBreakPlugin(),
                linkPlugin(),
                linkDialogPlugin(),
                tablePlugin(),
                codeBlockPlugin({ defaultCodeBlockLanguage: 'php' }),
                codeMirrorPlugin({
                    codeBlockLanguages: {
                        php: 'PHP',
                        js: 'JavaScript',
                        ts: 'TypeScript',
                        tsx: 'TSX',
                        jsx: 'JSX',
                        bash: 'Bash',
                        json: 'JSON',
                        sql: 'SQL',
                        html: 'HTML',
                        css: 'CSS',
                        yaml: 'YAML',
                        blade: 'Blade',
                        '': 'Texte',
                    },
                }),
                markdownShortcutPlugin(),
                diffSourcePlugin({ viewMode: 'rich-text' }),
            ];

            if (allowImages) {
                base.push(
                    imagePlugin({
                        imageUploadHandler,
                        disableImageResize: true,
                    }),
                );
            }

            base.push(
                toolbarPlugin({
                    toolbarContents: () => (
                        <DiffSourceToggleWrapper
                            options={['rich-text', 'source']}
                        >
                            <Toolbar scope={scope} allowImages={allowImages} />
                        </DiffSourceToggleWrapper>
                    ),
                }),
            );

            return base;
        }, [scope, allowImages, imageUploadHandler]);

        return (
            <div className={cn('sn-mdx-wrapper', className)} ref={wrapperRef}>
                <div
                    className={cn(
                        'sn-mdx-shell',
                        error && 'sn-mdx-shell--error',
                        disabled && 'sn-mdx-shell--disabled',
                    )}
                    style={
                        {
                            '--sn-mdx-min-h': `${minHeight}px`,
                            ...(maxHeight
                                ? { '--sn-mdx-max-h': `${maxHeight}px` }
                                : {}),
                        } as React.CSSProperties
                    }
                >
                    <div ref={overlayRef} className="sn-mdx-overlay-anchor" />
                    <MDXEditor
                        ref={ref}
                        markdown={value}
                        onChange={handleChange}
                        placeholder={placeholder ?? 'Écris en markdown…'}
                        readOnly={disabled}
                        autoFocus={autoFocus}
                        plugins={plugins}
                        contentEditableClassName="sn-mdx-content"
                        spellCheck
                        suppressHtmlProcessing
                    />
                </div>
                {error && (
                    <p className="sn-mdx-error" role="alert">
                        {error}
                    </p>
                )}
            </div>
        );
    },
);

function Toolbar({
    scope,
    allowImages,
}: {
    scope: EditorScope;
    allowImages: boolean;
}) {
    return (
        <>
            <UndoRedo />
            <Separator />
            <BoldItalicUnderlineToggles />
            <CodeToggle />
            <Separator />
            {scope === 'full' && (
                <>
                    <BlockTypeSelect />
                    <Separator />
                </>
            )}
            <ListsToggle />
            <Separator />
            <CreateLink />
            {allowImages && <InsertImage />}
            <Separator />
            <InsertCodeBlock />
        </>
    );
}
