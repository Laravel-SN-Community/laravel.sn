import { Head, Link, usePage } from '@inertiajs/react';
import {
    Bell,
    Check,
    Eye,
    Heart,
    LayoutGrid,
    List,
    Lock,
    MessageSquare,
    Pin,
    Plus,
    User,
    X,
} from 'lucide-react';
import { useState } from 'react';
import { ThreadCreateSheet } from '@/components/site/thread-create-sheet';
import { useInitials } from '@/hooks/use-initials';
import { useReloadOnHistoryNavigation } from '@/hooks/use-reload-on-history-navigation';
import { authorTint } from '@/lib/forum';
import { stripMarkdown } from '@/lib/strip-markdown';
import { toUrl } from '@/lib/utils';
import { index as forumIndex } from '@/routes/forum';
import {
    index as channelsIndex,
    show as channelShow,
} from '@/routes/forum/channels';
import { show as threadShow } from '@/routes/forum/threads';
import type {
    Auth,
    ForumChannel,
    ForumChannelMin,
    ForumThreadSummary,
    PaginatedThreads,
} from '@/types';

const NAV_FILTERS: {
    slug: string | null;
    label: string;
    Icon: React.ElementType;
}[] = [
    { slug: null, label: 'Tous les sujets', Icon: List },
    { slug: 'mine', label: 'Mes questions', Icon: User },
    { slug: 'subscribed', label: 'Suivi', Icon: Bell },
    { slug: 'popular', label: 'Populaire', Icon: Heart },
    { slug: 'resolved', label: 'Résolu', Icon: Check },
    { slug: 'unresolved', label: 'Non résolu', Icon: X },
    { slug: 'unanswered', label: 'Aucune réponse', Icon: MessageSquare },
];

function ChannelTag({ channel }: { channel: ForumChannelMin }) {
    const color = channel.color ?? 'var(--sn-accent)';

    return (
        <span
            className="inline-flex items-center gap-1.5 rounded px-2 py-0.5 font-mono text-[10.5px] tracking-[0.1em] uppercase"
            style={{
                background: `color-mix(in oklch, ${color} 14%, transparent)`,
                color,
            }}
        >
            <span
                className="h-1.5 w-1.5 rounded-full"
                style={{ background: color }}
            />
            {channel.name}
        </span>
    );
}

function ThreadCard({ thread }: { thread: ForumThreadSummary }) {
    const getInitials = useInitials();
    const isResolved = thread.solution_reply_id !== null;

    return (
        <Link
            href={toUrl(threadShow(thread.slug))}
            className="block rounded-xl p-5 transition-colors hover:border-[var(--sn-accent)]/30"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            <div className="mb-2.5 flex flex-wrap items-center gap-2">
                {thread.channels.map((c) => (
                    <ChannelTag key={c.id} channel={c} />
                ))}
                {isResolved && (
                    <span
                        className="inline-flex items-center gap-1 rounded px-2 py-0.5 font-mono text-[10.5px] tracking-[0.1em] uppercase"
                        style={{
                            background:
                                'color-mix(in oklch, var(--sn-accent) 14%, transparent)',
                            color: 'var(--sn-accent)',
                        }}
                    >
                        <Check size={10} /> résolu
                    </span>
                )}
                {thread.is_pinned && (
                    <Pin size={12} style={{ color: 'var(--sn-muted)' }} />
                )}
                {thread.is_locked && (
                    <Lock size={12} style={{ color: 'var(--sn-muted)' }} />
                )}
            </div>

            <div
                className="text-[16.5px] leading-snug font-semibold tracking-tight"
                style={{ color: 'var(--sn-fg)' }}
            >
                {thread.title}
            </div>

            <p
                className="mt-2 line-clamp-2 text-[13.5px] leading-relaxed"
                style={{ color: 'var(--sn-muted)' }}
            >
                {stripMarkdown(thread.body)}
            </p>

            <div className="mt-3 flex flex-wrap items-center justify-between gap-3">
                <div
                    className="flex items-center gap-2.5 text-[12.5px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    <span
                        className="grid h-6 w-6 place-items-center rounded-full font-mono text-[10px]"
                        style={{
                            background: authorTint(thread.author.id),
                            color: '#fff',
                        }}
                    >
                        {getInitials(thread.author.name)}
                    </span>
                    <span>
                        <span style={{ color: 'var(--sn-fg)' }}>
                            @{thread.author.username}
                        </span>
                        {' · '}
                        <span className="font-mono">
                            {thread.created_at_human}
                        </span>
                    </span>
                </div>
                <div
                    className="flex items-center gap-4 font-mono text-[12px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    <span className="flex items-center gap-1.5">
                        <MessageSquare size={13} /> {thread.replies_count}
                    </span>
                    <span className="flex items-center gap-1.5">
                        <Eye size={13} /> {thread.views_count}
                    </span>
                </div>
            </div>
        </Link>
    );
}

type Props = {
    channel: ForumChannel;
    channels: ForumChannel[];
    threads: PaginatedThreads;
};

export default function Channel({ channel, channels, threads }: Props) {
    const { auth } = usePage<{ auth: Auth }>().props;
    const [sheetOpen, setSheetOpen] = useState(false);
    const color = channel.color ?? 'var(--sn-accent)';

    useReloadOnHistoryNavigation(['threads']);

    return (
        <>
            <Head title={`${channel.name} — Forum`} />
            <ThreadCreateSheet
                open={sheetOpen}
                onOpenChange={setSheetOpen}
                channels={channels}
            />

            <div className="mx-auto max-w-[1400px] px-6 pt-10 pb-16 lg:px-10">
                <div className="grid items-start gap-8 lg:grid-cols-[260px_1fr]">
                    {/* Sidebar */}
                    <aside className="order-last space-y-1 lg:sticky lg:top-18 lg:order-first">
                        <button
                            onClick={() => {
                                if (auth?.user) {
                                    setSheetOpen(true);
                                } else {
                                    window.location.href = '/login';
                                }
                            }}
                            className="sn-btn sn-btn-primary mb-4 w-full justify-center"
                        >
                            <Plus size={13} className="mr-1" /> Nouveau sujet
                        </button>

                        {/* "Tous les sujets" first */}
                        {(() => {
                            const { label, Icon } = NAV_FILTERS[0];

                            return (
                                <Link
                                    href={toUrl(forumIndex())}
                                    className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    <Icon size={15} />
                                    <span>{label}</span>
                                </Link>
                            );
                        })()}

                        {/* Channels — active */}
                        <Link
                            href={toUrl(channelsIndex())}
                            className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-[13.5px] transition-colors"
                            style={{
                                background: 'var(--sn-surface-2)',
                                color: 'var(--sn-fg)',
                                fontWeight: 600,
                            }}
                        >
                            <LayoutGrid size={15} />
                            <span>Channels</span>
                        </Link>

                        {/* Remaining filters */}
                        {NAV_FILTERS.slice(1).map(({ slug, label, Icon }) => (
                            <Link
                                key={label}
                                href={toUrl(forumIndex()) + `?filter=${slug}`}
                                className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <Icon size={15} />
                                <span>{label}</span>
                            </Link>
                        ))}
                    </aside>

                    {/* Main */}
                    <main className="min-w-0">
                        {/* Channel header */}
                        <div className="mb-8">
                            <div className="flex items-center gap-3">
                                {channel.color && (
                                    <span
                                        className="h-4 w-4 rounded-full"
                                        style={{ background: color }}
                                    />
                                )}
                                <h1
                                    className="text-[28px] font-semibold tracking-tight"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    {channel.name}
                                </h1>
                            </div>
                            {channel.description && (
                                <p
                                    className="mt-2 max-w-[60ch] text-[15px] leading-relaxed"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {channel.description}
                                </p>
                            )}
                            {channel.children.length > 0 && (
                                <div className="mt-3 flex flex-wrap gap-2">
                                    {channel.children.map((child) => (
                                        <Link
                                            key={child.id}
                                            href={toUrl(
                                                channelShow(child.slug),
                                            )}
                                            className="rounded-md px-3 py-1.5 text-[12.5px] font-medium transition-colors"
                                            style={{
                                                background: 'var(--sn-surface)',
                                                border: '1px solid var(--sn-border)',
                                                color: 'var(--sn-fg)',
                                            }}
                                        >
                                            {child.name}
                                        </Link>
                                    ))}
                                </div>
                            )}
                        </div>

                        {/* Threads */}
                        <div className="space-y-3">
                            {threads.data.map((thread) => (
                                <ThreadCard key={thread.id} thread={thread} />
                            ))}
                            {threads.data.length === 0 && (
                                <div
                                    className="rounded-xl p-12 text-center"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                    }}
                                >
                                    <p
                                        className="text-[14px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        Aucune discussion dans ce canal.
                                    </p>
                                </div>
                            )}
                        </div>

                        {/* Pagination */}
                        {threads.last_page > 1 && (
                            <div className="mt-8 flex items-center justify-center gap-3">
                                {threads.prev_page_url && (
                                    <Link
                                        href={threads.prev_page_url}
                                        className="sn-btn sn-btn-secondary sn-btn-sm"
                                    >
                                        ← Précédent
                                    </Link>
                                )}
                                <span
                                    className="font-mono text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {threads.current_page} / {threads.last_page}
                                </span>
                                {threads.next_page_url && (
                                    <Link
                                        href={threads.next_page_url}
                                        className="sn-btn sn-btn-secondary sn-btn-sm"
                                    >
                                        Suivant →
                                    </Link>
                                )}
                            </div>
                        )}
                    </main>
                </div>
            </div>
        </>
    );
}
