import { useForm } from '@inertiajs/react';
import * as Dialog from '@radix-ui/react-dialog';
import { Info, X } from 'lucide-react';
import { useEffect } from 'react';
import { LazyMarkdownEditor as MarkdownEditor } from '@/components/editor/lazy-markdown-editor';
import { ChannelsSelect } from '@/components/forum/channels-select';
import { toUrl } from '@/lib/utils';
import { store as threadsStore } from '@/routes/forum/threads';
import type { ForumChannel } from '@/types';

function Label({ text, required }: { text: string; required?: boolean }) {
    return (
        <div className="mb-1.5 flex items-center gap-1.5">
            <span
                className="text-[12.5px] font-medium"
                style={{ color: 'var(--sn-fg)' }}
            >
                {text}
            </span>
            {required && (
                <span
                    className="rounded px-1.5 py-0.5 font-mono text-[10px] font-medium"
                    style={{
                        background:
                            'color-mix(in oklch, var(--sn-accent) 15%, transparent)',
                        color: 'var(--sn-accent)',
                    }}
                >
                    Requis
                </span>
            )}
        </div>
    );
}

function FieldError({ message }: { message?: string | undefined }) {
    if (!message) {
        return null;
    }

    return (
        <p className="mt-1 text-[12px]" style={{ color: 'var(--destructive)' }}>
            {message}
        </p>
    );
}

type Props = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    channels: ForumChannel[];
    defaultChannelId?: number | null;
};

export function ThreadCreateSheet({
    open,
    onOpenChange,
    channels,
    defaultChannelId = null,
}: Props) {
    const { data, setData, post, processing, errors, reset } = useForm<{
        title: string;
        body: string;
        channel_ids: number[];
        locale: 'fr' | 'en';
    }>({
        title: '',
        body: '',
        channel_ids: defaultChannelId ? [defaultChannelId] : [],
        locale: 'fr',
    });

    useEffect(() => {
        if (open) {
            reset();
            setData('channel_ids', defaultChannelId ? [defaultChannelId] : []);
        }
    }, [open]); // eslint-disable-line react-hooks/exhaustive-deps

    function handleClose(next: boolean) {
        if (!next) {
            reset();
        }

        onOpenChange(next);
    }

    function submit(e: React.SyntheticEvent) {
        e.preventDefault();
        post(toUrl(threadsStore()), { onSuccess: () => handleClose(false) });
    }

    return (
        <Dialog.Root open={open} onOpenChange={handleClose}>
            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 z-50 bg-black/40 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:animate-in data-[state=open]:fade-in-0" />
                <Dialog.Content
                    className="fixed inset-2 z-50 flex flex-col rounded-2xl shadow-2xl transition ease-in-out outline-none data-[state=closed]:animate-out data-[state=closed]:duration-300 data-[state=closed]:slide-out-to-right data-[state=open]:animate-in data-[state=open]:duration-500 data-[state=open]:slide-in-from-right sm:top-4 sm:right-4 sm:bottom-4 sm:left-auto sm:w-[760px] sm:max-w-[calc(100vw-32px)]"
                    style={{
                        background: 'var(--sn-bg)',
                        border: '1px solid var(--sn-border)',
                    }}
                    onPointerDownOutside={(e) => e.preventDefault()}
                    onInteractOutside={(e) => e.preventDefault()}
                >
                    {/* Header */}
                    <div
                        className="flex shrink-0 items-center justify-between px-6 py-4"
                        style={{
                            borderBottom: '1px solid var(--sn-border)',
                            background: 'var(--sn-surface)',
                            borderRadius: '16px 16px 0 0',
                        }}
                    >
                        <h2
                            className="text-[18px] font-semibold tracking-tight"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Nouveau sujet
                        </h2>
                        <div className="flex items-center gap-2">
                            <span
                                className="rounded px-1.5 py-0.5 font-mono text-[10px] font-medium"
                                style={{
                                    background: 'var(--sn-n200)',
                                    color: 'var(--sn-n500)',
                                }}
                            >
                                ESC
                            </span>
                            <Dialog.Close
                                className="flex h-8 w-8 items-center justify-center rounded-lg transition-colors focus:outline-none"
                                style={{ color: 'var(--sn-muted)' }}
                                onMouseEnter={(e) => {
                                    e.currentTarget.style.background =
                                        'var(--sn-surface-2)';
                                }}
                                onMouseLeave={(e) => {
                                    e.currentTarget.style.background =
                                        'transparent';
                                }}
                            >
                                <X size={16} />
                                <span className="sr-only">Fermer</span>
                            </Dialog.Close>
                        </div>
                    </div>

                    <form
                        id="thread-form"
                        onSubmit={submit}
                        className="flex flex-1 flex-col overflow-hidden"
                    >
                        <div className="flex-1 space-y-5 overflow-y-auto px-6 py-5">
                            {/* Info box */}
                            <div
                                className="flex items-start gap-3 rounded-xl px-4 py-3"
                                style={{
                                    background: 'rgba(2,132,199,0.07)',
                                    border: '1px solid rgba(2,132,199,0.2)',
                                }}
                            >
                                <Info
                                    size={14}
                                    className="mt-0.5 shrink-0"
                                    style={{ color: '#0284c7' }}
                                />
                                <div
                                    className="text-[12.5px] leading-relaxed"
                                    style={{ color: '#0369a1' }}
                                >
                                    <span className="font-semibold">
                                        Bon à savoir —{' '}
                                    </span>
                                    Décris clairement ton problème avec le
                                    contexte et ce que tu as déjà essayé. Un
                                    titre précis et une description complète
                                    obtiennent plus de réponses.
                                </div>
                            </div>

                            {/* Title */}
                            <div>
                                <Label text="Titre" required />
                                <input
                                    value={data.title}
                                    onChange={(e) =>
                                        setData('title', e.target.value)
                                    }
                                    placeholder="Ex. : Comment éviter les requêtes N+1 sur des relations imbriquées ?"
                                    className="w-full rounded-lg px-3 py-2.5 text-[14px] font-medium transition-colors focus:outline-none"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: `1px solid ${errors.title ? 'var(--destructive)' : 'var(--sn-border)'}`,
                                        color: 'var(--sn-fg)',
                                    }}
                                    onFocus={(e) => {
                                        e.currentTarget.style.borderColor =
                                            'var(--sn-accent)';
                                    }}
                                    onBlur={(e) => {
                                        e.currentTarget.style.borderColor =
                                            errors.title
                                                ? 'var(--destructive)'
                                                : 'var(--sn-border)';
                                    }}
                                />
                                <p
                                    className="mt-1 text-[11.5px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Minimum de 10 caractères.
                                </p>
                                <FieldError message={errors.title} />
                            </div>

                            {/* Channels + Langue */}
                            <div className="grid grid-cols-1 gap-5 sm:grid-cols-[1fr_auto]">
                                <div>
                                    <Label text="Channels" required />
                                    <ChannelsSelect
                                        channels={channels}
                                        selected={data.channel_ids}
                                        onChange={(ids) =>
                                            setData('channel_ids', ids)
                                        }
                                        error={
                                            errors.channel_ids as
                                                string | undefined
                                        }
                                    />
                                </div>

                                <div>
                                    <div
                                        className="mb-1.5 text-[12.5px] font-medium"
                                        style={{ color: 'var(--sn-fg)' }}
                                    >
                                        Langue
                                    </div>
                                    <div
                                        className="flex gap-0.5 rounded-lg p-0.5"
                                        style={{
                                            background: 'var(--sn-surface-2)',
                                        }}
                                    >
                                        {(['fr', 'en'] as const).map((loc) => (
                                            <button
                                                key={loc}
                                                type="button"
                                                onClick={() =>
                                                    setData('locale', loc)
                                                }
                                                className="rounded-md px-4 py-2 text-[12.5px] font-semibold transition-all"
                                                style={{
                                                    background:
                                                        data.locale === loc
                                                            ? 'var(--sn-bg)'
                                                            : 'transparent',
                                                    color:
                                                        data.locale === loc
                                                            ? 'var(--sn-fg)'
                                                            : 'var(--sn-muted)',
                                                    boxShadow:
                                                        data.locale === loc
                                                            ? '0 1px 4px rgba(0,0,0,0.12)'
                                                            : 'none',
                                                }}
                                            >
                                                {loc.toUpperCase()}
                                            </button>
                                        ))}
                                    </div>
                                    <p
                                        className="mt-1 text-[11.5px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        Langue du sujet
                                    </p>
                                </div>
                            </div>

                            {/* Markdown editor */}
                            <MarkdownEditor
                                value={data.body}
                                onChange={(v) => setData('body', v)}
                                error={errors.body}
                                scope="full"
                                allowImages
                                placeholder="Mon code actuel :&#10;&#10;```php&#10;$users = User::all();&#10;```&#10;&#10;Ce que j'ai essayé :&#10;- ..."
                                minHeight={260}
                                maxHeight={360}
                                disabled={processing}
                            />
                        </div>

                        {/* Footer */}
                        <div
                            className="flex shrink-0 items-center justify-end gap-3 px-6 py-4"
                            style={{
                                borderTop: '1px solid var(--sn-border)',
                                background: 'var(--sn-surface)',
                                borderRadius: '0 0 16px 16px',
                            }}
                        >
                            <Dialog.Close asChild>
                                <button
                                    type="button"
                                    className="sn-btn sn-btn-secondary"
                                    disabled={processing}
                                >
                                    Annuler
                                </button>
                            </Dialog.Close>
                            <button
                                type="submit"
                                form="thread-form"
                                className="sn-btn sn-btn-primary"
                                disabled={processing}
                            >
                                {processing
                                    ? 'Publication…'
                                    : 'Publier le sujet'}
                            </button>
                        </div>
                    </form>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}
