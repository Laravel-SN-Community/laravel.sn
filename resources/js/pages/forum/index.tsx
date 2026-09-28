import { Head, InfiniteScroll, Link, router, usePage } from '@inertiajs/react';
import {
    Bell,
    Check,
    Eye,
    Heart,
    LayoutGrid,
    List,
    Loader2,
    Lock,
    MessageSquare,
    Pin,
    Plus,
    Search,
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
import { index as channelsIndex } from '@/routes/forum/channels';
import { show as threadShow } from '@/routes/forum/threads';
import type {
    Auth,
    ForumChannel,
    ForumChannelMin,
    ForumThreadSummary,
    PaginatedThreads,
} from '@/types';

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
            className="block rounded-xl p-5 transition-colors"
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
                    <Pin size={11} style={{ color: 'var(--sn-muted)' }} />
                )}
                {thread.is_locked && (
                    <Lock size={11} style={{ color: 'var(--sn-muted)' }} />
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
                    <div
                        className="relative h-6 w-6 shrink-0 overflow-hidden rounded-full"
                        style={{
                            background: thread.author.avatar
                                ? 'transparent'
                                : authorTint(thread.author.id),
                        }}
                    >
                        {thread.author.avatar ? (
                            <img
                                src={thread.author.avatar}
                                alt={thread.author.name}
                                className="h-full w-full object-cover"
                            />
                        ) : (
                            <span className="absolute inset-0 flex items-center justify-center font-mono text-[10px] text-white">
                                {getInitials(thread.author.name)}
                            </span>
                        )}
                    </div>
                    <span>
                        <span style={{ color: 'var(--sn-fg)' }}>
                            @{thread.author.username}
                        </span>
                        {' · '}
                        <span>{thread.created_at_human}</span>
                    </span>
                </div>
                <div
                    className="flex items-center gap-4 text-[12px]"
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

type FilterSlug =
    | 'mine'
    | 'subscribed'
    | 'popular'
    | 'resolved'
    | 'unresolved'
    | 'unanswered'
    | null;

const NAV_FILTERS: {
    slug: FilterSlug;
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

type Props = {
    channels: ForumChannel[];
    threads: PaginatedThreads;
    filter: FilterSlug;
    locale: 'fr' | 'en';
};

export default function Forum({ channels, threads, filter, locale }: Props) {
    const { auth } = usePage<{ auth: Auth }>().props;
    const [sheetOpen, setSheetOpen] = useState(false);
    const [q, setQ] = useState('');

    useReloadOnHistoryNavigation(['threads']);

    const displayed = q
        ? threads.data.filter((t) =>
              t.title.toLowerCase().includes(q.toLowerCase()),
          )
        : threads.data;

    function applyFilter(slug: FilterSlug) {
        router.get(
            toUrl(forumIndex()),
            {
                ...(slug ? { filter: slug } : {}),
                ...(locale !== 'fr' ? { locale } : {}),
            },
            { replace: true },
        );
    }

    function applyLocale(l: 'fr' | 'en') {
        router.get(
            toUrl(forumIndex()),
            {
                ...(filter ? { filter } : {}),
                ...(l !== 'fr' ? { locale: l } : {}),
            },
            { replace: true },
        );
    }

    return (
        <>
            <Head title="Forum" />
            <ThreadCreateSheet
                open={sheetOpen}
                onOpenChange={setSheetOpen}
                channels={channels}
            />

            <div className="mx-auto max-w-[1400px] px-6 pt-10 pb-16 lg:px-10">
                <div className="mb-8">
                    <h1
                        className="mt-2 text-[34px] font-semibold tracking-tight"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        Discussions de la communauté
                    </h1>
                    <p
                        className="mt-2 max-w-[60ch] text-[16px] leading-relaxed"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        Pose ta question, partage un retour d'expérience, ou
                        aide quelqu'un.
                    </p>
                </div>

                <div className="grid items-start gap-8 lg:grid-cols-[260px_1fr]">
                    {/* Sidebar */}
                    <aside className="order-last space-y-1 lg:sticky lg:top-20 lg:order-first">
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

                        {/* First filter: Tous les sujets */}
                        {(() => {
                            const { slug, label, Icon } = NAV_FILTERS[0];
                            const isActive = slug === filter;

                            return (
                                <button
                                    key={label}
                                    onClick={() => applyFilter(slug)}
                                    className="flex w-full cursor-pointer items-center gap-3 rounded-md px-3 py-2 text-[13.5px] transition-colors"
                                    style={{
                                        background: isActive
                                            ? 'var(--sn-surface-2)'
                                            : 'transparent',
                                        color: isActive
                                            ? 'var(--sn-fg)'
                                            : 'var(--sn-muted)',
                                        fontWeight: isActive ? 600 : 500,
                                    }}
                                >
                                    <Icon size={15} />
                                    <span>{label}</span>
                                </button>
                            );
                        })()}

                        {/* Channels link */}
                        <Link
                            href={toUrl(channelsIndex())}
                            className="flex w-full cursor-pointer items-center gap-3 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            <LayoutGrid size={15} />
                            <span>Channels</span>
                        </Link>

                        {NAV_FILTERS.slice(1).map(({ slug, label, Icon }) => {
                            const isActive = slug === filter;

                            return (
                                <button
                                    key={label}
                                    onClick={() => applyFilter(slug)}
                                    className="flex w-full cursor-pointer items-center gap-3 rounded-md px-3 py-2 text-[13.5px] transition-colors"
                                    style={{
                                        background: isActive
                                            ? 'var(--sn-surface-2)'
                                            : 'transparent',
                                        color: isActive
                                            ? 'var(--sn-fg)'
                                            : 'var(--sn-muted)',
                                        fontWeight: isActive ? 600 : 500,
                                    }}
                                >
                                    <Icon size={15} />
                                    <span>{label}</span>
                                </button>
                            );
                        })}
                    </aside>

                    {/* Main */}
                    <div>
                        <div className="mb-5 flex items-center gap-3">
                            <div
                                className="flex gap-0.5 rounded-lg p-0.5"
                                style={{
                                    background: 'var(--sn-surface)',
                                    border: '1px solid var(--sn-border)',
                                }}
                            >
                                {(['fr', 'en'] as const).map((l) => (
                                    <button
                                        key={l}
                                        onClick={() => applyLocale(l)}
                                        className="rounded-md px-3 py-1.5 text-[12px] font-semibold transition-all"
                                        style={{
                                            background:
                                                locale === l
                                                    ? 'var(--sn-accent)'
                                                    : 'transparent',
                                            color:
                                                locale === l
                                                    ? 'var(--sn-accent-fg)'
                                                    : 'var(--sn-muted)',
                                        }}
                                    >
                                        {l.toUpperCase()}
                                    </button>
                                ))}
                            </div>

                            <div className="relative ml-auto flex-1 lg:max-w-[280px]">
                                <span
                                    className="absolute top-1/2 left-3 -translate-y-1/2"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    <Search size={14} />
                                </span>
                                <input
                                    value={q}
                                    onChange={(e) => setQ(e.target.value)}
                                    placeholder="Rechercher un sujet"
                                    className="w-full rounded-md py-2 pr-3 pl-9 text-[13.5px]"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                        color: 'var(--sn-fg)',
                                    }}
                                />
                            </div>
                        </div>

                        <div>
                            {displayed.length > 0 ? (
                                <InfiniteScroll
                                    data="threads"
                                    manual
                                    preserveUrl
                                    itemsElement="#thread-list"
                                    next={({ loading, fetch, hasMore }) =>
                                        hasMore && (
                                            <div className="mt-6 flex justify-center">
                                                <button
                                                    onClick={fetch}
                                                    disabled={loading}
                                                    className="sn-btn sn-btn-secondary"
                                                >
                                                    {loading ? (
                                                        <>
                                                            <Loader2
                                                                size={14}
                                                                className="animate-spin"
                                                            />
                                                            Chargement…
                                                        </>
                                                    ) : (
                                                        'Voir plus de sujets'
                                                    )}
                                                </button>
                                            </div>
                                        )
                                    }
                                >
                                    <div id="thread-list" className="space-y-3">
                                        {displayed.map((t) => (
                                            <ThreadCard key={t.id} thread={t} />
                                        ))}
                                    </div>
                                </InfiniteScroll>
                            ) : (
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
                                        Aucun sujet ne correspond.
                                    </p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
