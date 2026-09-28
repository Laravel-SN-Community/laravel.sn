import { Head, Link, usePage } from '@inertiajs/react';
import {
    AtSign,
    BookOpenText,
    Clock,
    CornerDownRight,
    Eye,
    Globe,
    MapPin,
    MessagesSquare,
    ShieldCheck,
    UserCog,
} from 'lucide-react';
import type { ReactNode } from 'react';
import { useState } from 'react';
import { GithubIcon } from '@/components/site/brand-icons';
import { useInitials } from '@/hooks/use-initials';
import type { ArticleSummary } from '@/types/article';

type UserProfile = {
    id: number;
    name: string;
    username: string;
    avatar: string | null;
    bio: string | null;
    location: string | null;
    github_handle: string | null;
    twitter_handle: string | null;
    website_url: string | null;
    created_at: string;
    role: string | null;
};

type ThreadSummary = {
    id: number;
    slug: string;
    title: string;
    replies_count: number;
    created_at: string;
    created_at_human: string;
    solution_reply_id: number | null;
    channels: Array<{
        id: number;
        name: string;
        slug: string;
        color: string | null;
    }>;
};

type ReplySummary = {
    id: number;
    thread_id: number;
    body: string;
    created_at: string;
    created_at_human: string;
    thread: { id: number; slug: string; title: string } | null;
};

type ActivityItem = {
    type: 'article' | 'thread' | 'reply';
    title: string;
    url: string;
    excerpt: string | null;
    date: string;
    date_human: string;
};

function memberTint(username: string): string {
    const palette = ['#0f7b4d', '#188a5c', '#0b6640', '#3ea777'];
    let h = 0;

    for (const c of username) {
        h = (h * 31 + c.charCodeAt(0)) >>> 0;
    }

    return palette[h % palette.length];
}

function fmtJoined(iso: string): string {
    return new Date(iso).toLocaleDateString('fr-FR', {
        month: 'long',
        year: 'numeric',
    });
}

function tagTint(slug: string): string {
    const palette = [
        '#0f7b4d',
        '#b45309',
        '#0369a1',
        '#7c3aed',
        '#dc2626',
        '#188a5c',
    ];
    let h = 0;

    for (const c of slug) {
        h = (h * 31 + c.charCodeAt(0)) >>> 0;
    }

    return palette[h % palette.length];
}

type ActivityMeta = {
    icon: ReactNode;
    label: string;
};

const ACTIVITY_META: Record<string, ActivityMeta> = {
    article: {
        icon: <BookOpenText size={18} />,
        label: 'a publié un article',
    },
    thread: {
        icon: <MessagesSquare size={18} />,
        label: 'a démarré un sujet',
    },
    reply: {
        icon: <CornerDownRight size={18} />,
        label: 'a répondu sur',
    },
};

type Tab = 'articles' | 'forum' | 'activite';
type ForumSubTab = 'threads' | 'replies' | 'solutions';

export default function MembreShow() {
    const { user, articles, threads, replies, solutions, activity } = usePage()
        .props as unknown as {
        user: UserProfile;
        articles: ArticleSummary[];
        threads: ThreadSummary[];
        replies: ReplySummary[];
        solutions: ReplySummary[];
        activity: ActivityItem[];
    };
    const getInitials = useInitials();
    const [tab, setTab] = useState<Tab>('articles');
    const [forumSub, setForumSub] = useState<ForumSubTab>('threads');

    const tint = memberTint(user.username ?? user.name);
    const initials = getInitials(user.name);
    const hasSocials =
        user.github_handle || user.twitter_handle || user.website_url;

    const tabs: Array<{ id: Tab; label: string }> = [
        { id: 'articles', label: 'Articles' },
        { id: 'forum', label: 'Forum' },
        { id: 'activite', label: 'Activité' },
    ];

    return (
        <>
            <Head title={`@${user.username}`} />

            <header
                className="relative overflow-hidden"
                style={{
                    background: 'var(--sn-bg)',
                    color: 'var(--sn-fg)',
                }}
            >
                <div
                    aria-hidden
                    className="pointer-events-none absolute -top-40 -right-32 hidden h-[560px] w-[560px] rounded-full sm:block lg:-top-48 lg:-right-40 lg:h-[720px] lg:w-[720px]"
                    style={{
                        background: `radial-gradient(circle, ${tint}55 0%, transparent 58%)`,
                        filter: 'blur(70px)',
                    }}
                />
                <div
                    aria-hidden
                    className="absolute inset-x-0 bottom-0 h-px"
                    style={{ background: 'var(--sn-border)' }}
                />

                <div className="relative mx-auto max-w-[1200px] px-4 pt-8 pb-10 sm:px-6 sm:pt-10 sm:pb-12 lg:px-10 lg:pt-14 lg:pb-16">
                    <div className="flex flex-col gap-6 sm:gap-8 lg:flex-row lg:items-start lg:gap-14">
                        {/* Avatar */}
                        <div className="relative shrink-0">
                            <div
                                aria-hidden
                                className="absolute -inset-4 hidden rounded-full sm:block"
                                style={{
                                    background: `radial-gradient(circle, ${tint}20 0%, transparent 70%)`,
                                }}
                            />
                            {user.avatar ? (
                                <img
                                    src={user.avatar}
                                    alt={user.name}
                                    className="relative h-24 w-24 rounded-full object-cover sm:h-28 sm:w-28 lg:h-36 lg:w-36"
                                    style={{
                                        boxShadow: `0 0 0 3px var(--sn-bg), 0 0 0 4px ${tint}40, 0 24px 48px -16px rgba(0,0,0,0.35)`,
                                    }}
                                />
                            ) : (
                                <div
                                    className="relative flex h-24 w-24 items-center justify-center rounded-full text-[32px] font-semibold tracking-tight text-white sm:h-28 sm:w-28 sm:text-[36px] lg:h-36 lg:w-36 lg:text-[42px]"
                                    style={{
                                        background: `linear-gradient(145deg, ${tint}, ${tint}cc)`,
                                        boxShadow: `0 0 0 3px var(--sn-bg), 0 0 0 4px ${tint}40, 0 24px 48px -16px rgba(0,0,0,0.35)`,
                                    }}
                                >
                                    {initials}
                                </div>
                            )}
                        </div>

                        {/* Identity */}
                        <div className="min-w-0 flex-1">
                            <h1 className="text-[28px] leading-[1.05] font-semibold tracking-[-0.03em] sm:text-[36px] lg:text-[56px]">
                                {user.name}
                                {user.role === 'admin' && (
                                    <sup className="ml-1 inline-flex items-center gap-1 align-middle sm:ml-1.5">
                                        <ShieldCheck
                                            size={14}
                                            className="sm:!h-4 sm:!w-4"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        />
                                        <span
                                            className="text-[10px] font-medium tracking-[0.04em] sm:text-[11px]"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        >
                                            Admin
                                        </span>
                                    </sup>
                                )}
                                {user.role === 'moderator' && (
                                    <sup className="ml-1 inline-flex items-center gap-1 align-middle sm:ml-1.5">
                                        <UserCog
                                            size={14}
                                            className="sm:!h-4 sm:!w-4"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        />
                                        <span
                                            className="text-[10px] font-medium tracking-[0.04em] sm:text-[11px]"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        >
                                            Modérateur
                                        </span>
                                    </sup>
                                )}
                            </h1>

                            <span
                                className="mt-1.5 inline-flex items-center gap-0.5 text-[12px] tracking-normal lowercase sm:mt-2 sm:text-[13px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <AtSign size={12} className="shrink-0" />
                                {user.username}
                            </span>

                            {user.bio && (
                                <p
                                    className="mt-4 max-w-[58ch] text-[14px] leading-[1.6] sm:mt-5 sm:text-[15.5px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {user.bio}
                                </p>
                            )}

                            {hasSocials && (
                                <div className="mt-3.5 flex items-center gap-3 sm:mt-4">
                                    {user.github_handle && (
                                        <a
                                            href={`https://github.com/${user.github_handle}`}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title={user.github_handle}
                                            className="transition-colors hover:!text-[var(--sn-fg)]"
                                            style={{
                                                color: 'var(--sn-muted)',
                                            }}
                                        >
                                            <GithubIcon size={18} />
                                        </a>
                                    )}
                                    {user.twitter_handle && (
                                        <a
                                            href={`https://x.com/${user.twitter_handle}`}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title={`@${user.twitter_handle}`}
                                            className="transition-colors hover:!text-[var(--sn-fg)]"
                                            style={{
                                                color: 'var(--sn-muted)',
                                            }}
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                className="h-[18px] w-[18px]"
                                                fill="currentColor"
                                            >
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.629L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
                                            </svg>
                                        </a>
                                    )}
                                    {user.website_url && (
                                        <a
                                            href={user.website_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title={user.website_url}
                                            className="transition-colors hover:!text-[var(--sn-fg)]"
                                            style={{
                                                color: 'var(--sn-muted)',
                                            }}
                                        >
                                            <Globe size={18} />
                                        </a>
                                    )}
                                </div>
                            )}

                            <div
                                className="mt-4 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-[10.5px] tracking-[0.14em] uppercase sm:mt-5 sm:gap-x-5 sm:text-[11.5px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                {user.location && (
                                    <span className="inline-flex items-center gap-1">
                                        <MapPin
                                            size={12}
                                            style={{ opacity: 0.6 }}
                                        />
                                        {user.location}
                                    </span>
                                )}
                                <span>
                                    Inscrit·e {fmtJoined(user.created_at)}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <nav
                className="sticky top-16 z-30"
                style={{
                    background: 'var(--sn-bg)',
                    borderBottom: '1px solid var(--sn-border)',
                }}
            >
                <div className="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-10">
                    <div className="no-scrollbar flex items-center gap-0.5 overflow-x-auto sm:gap-1">
                        {tabs.map((t) => (
                            <button
                                key={t.id}
                                onClick={() => setTab(t.id)}
                                className="relative cursor-pointer px-2.5 py-3.5 text-[13px] whitespace-nowrap transition-colors sm:px-3 sm:py-4 sm:text-[13.5px]"
                                style={{
                                    color:
                                        tab === t.id
                                            ? 'var(--sn-fg)'
                                            : 'var(--sn-muted)',
                                    fontWeight: tab === t.id ? 600 : 500,
                                }}
                            >
                                {t.label}
                                {tab === t.id && (
                                    <span
                                        aria-hidden
                                        className="absolute right-2.5 bottom-0 left-2.5 h-[2px] rounded-full sm:right-3 sm:left-3"
                                        style={{
                                            background: 'var(--sn-accent)',
                                        }}
                                    />
                                )}
                            </button>
                        ))}
                    </div>
                </div>
            </nav>

            <main className="mx-auto max-w-[1200px] px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                {tab === 'articles' && <TabArticles articles={articles} />}
                {tab === 'forum' && (
                    <TabForum
                        threads={threads}
                        replies={replies}
                        solutions={solutions}
                        sub={forumSub}
                        setSub={setForumSub}
                    />
                )}
                {tab === 'activite' && <TabActivity activity={activity} />}
            </main>
        </>
    );
}

function EmptyState({ title, hint }: { title: string; hint?: string }) {
    return (
        <div
            className="rounded-xl p-8 text-center sm:p-12"
            style={{
                background: 'var(--sn-surface)',
                border: '1px dashed var(--sn-border)',
            }}
        >
            <div className="text-[14px] font-medium sm:text-[15px]">
                {title}
            </div>
            {hint && (
                <div
                    className="mt-1 text-[11.5px] sm:text-[12px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {hint}
                </div>
            )}
        </div>
    );
}

function TabArticles({ articles }: { articles: ArticleSummary[] }) {
    if (articles.length === 0) {
        return (
            <EmptyState
                title="Pas encore d'article publié"
                hint="Reviens plus tard."
            />
        );
    }

    return (
        <div className="grid gap-4 sm:gap-5 md:grid-cols-2">
            {articles.map((a) => {
                const firstTag = a.tags[0];
                const tint = firstTag
                    ? tagTint(firstTag.slug)
                    : 'var(--sn-500)';

                return (
                    <Link
                        key={a.slug}
                        href={`/articles/${a.slug}`}
                        className="sn-card group block overflow-hidden transition-all duration-300 hover:-translate-y-1"
                        onMouseEnter={(e) => {
                            e.currentTarget.style.boxShadow =
                                'var(--sn-shadow-md)';
                        }}
                        onMouseLeave={(e) => {
                            e.currentTarget.style.boxShadow =
                                'var(--sn-shadow-xs)';
                        }}
                    >
                        <div className="flex h-full flex-col p-4 sm:p-6">
                            <div className="flex flex-wrap items-center gap-2 text-[10.5px] tracking-[0.12em] uppercase sm:gap-2.5 sm:text-[11px]">
                                {firstTag && (
                                    <span
                                        className="rounded-md px-2 py-0.5 text-[10px] font-semibold sm:text-[10.5px]"
                                        style={{
                                            background: `color-mix(in oklch, ${tint} 12%, transparent)`,
                                            color: tint,
                                        }}
                                    >
                                        #{firstTag.name}
                                    </span>
                                )}
                                <span
                                    className="flex items-center gap-1.5"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {a.published_at &&
                                        new Date(
                                            a.published_at,
                                        ).toLocaleDateString('fr-FR', {
                                            day: 'numeric',
                                            month: 'short',
                                            year: 'numeric',
                                        })}
                                </span>
                                <span
                                    className="inline-flex items-center gap-1"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    <Clock size={11} />
                                    {a.reading_time_minutes} min
                                </span>
                            </div>

                            <h4 className="mt-3 text-[15.5px] leading-snug font-semibold tracking-[-0.01em] transition-colors group-hover:text-[color:var(--sn-accent)] sm:mt-3.5 sm:text-[17px]">
                                {a.title}
                            </h4>

                            <p
                                className="mt-2 flex-1 text-[13px] leading-[1.65] sm:mt-2.5 sm:text-[13.5px]"
                                style={{
                                    color: 'var(--sn-muted)',
                                    display: '-webkit-box',
                                    WebkitLineClamp: 2,
                                    WebkitBoxOrient: 'vertical',
                                    overflow: 'hidden',
                                }}
                            >
                                {a.excerpt}
                            </p>

                            <div
                                className="mt-4 flex items-center gap-5 border-t pt-3.5 text-[11px] sm:mt-5 sm:pt-4 sm:text-[11.5px]"
                                style={{
                                    borderColor: 'var(--sn-border)',
                                    color: 'var(--sn-muted)',
                                }}
                            >
                                <span className="inline-flex items-center gap-1.5">
                                    <Eye size={13} style={{ opacity: 0.5 }} />
                                    {a.views_count.toLocaleString('fr-FR')} vues
                                </span>
                            </div>
                        </div>
                    </Link>
                );
            })}
        </div>
    );
}

function TabForum({
    threads,
    replies,
    solutions,
    sub,
    setSub,
}: {
    threads: ThreadSummary[];
    replies: ReplySummary[];
    solutions: ReplySummary[];
    sub: ForumSubTab;
    setSub: (s: ForumSubTab) => void;
}) {
    const subs: Array<{ id: ForumSubTab; label: string; n: number }> = [
        { id: 'threads', label: 'Sujets', n: threads.length },
        { id: 'replies', label: 'Réponses', n: replies.length },
        { id: 'solutions', label: 'Solutions', n: solutions.length },
    ];

    return (
        <div>
            <div
                className="no-scrollbar mb-5 inline-flex w-fit items-center gap-0.5 overflow-x-auto rounded-lg p-1 sm:mb-6 sm:gap-1"
                style={{
                    background: 'var(--sn-surface-2)',
                    border: '1px solid var(--sn-border)',
                }}
            >
                {subs.map((s) => (
                    <button
                        key={s.id}
                        onClick={() => setSub(s.id)}
                        className="flex cursor-pointer items-center gap-1.5 rounded-md px-2.5 py-1.5 text-[11.5px] whitespace-nowrap transition-colors sm:gap-2 sm:px-3 sm:text-[12px]"
                        style={{
                            background:
                                sub === s.id
                                    ? 'var(--sn-surface)'
                                    : 'transparent',
                            color:
                                sub === s.id
                                    ? 'var(--sn-fg)'
                                    : 'var(--sn-muted)',
                        }}
                    >
                        {s.label}
                        <span
                            className="rounded px-1.5 text-[10px] sm:text-[10.5px]"
                            style={{ background: 'var(--sn-bg)' }}
                        >
                            {s.n}
                        </span>
                    </button>
                ))}
            </div>

            {sub === 'threads' &&
                (threads.length === 0 ? (
                    <EmptyState title="Aucun sujet démarré" />
                ) : (
                    <div className="space-y-2.5 sm:space-y-3">
                        {threads.map((t) => (
                            <ThreadRow key={t.id} thread={t} />
                        ))}
                    </div>
                ))}

            {sub === 'replies' &&
                (replies.length === 0 ? (
                    <EmptyState title="Aucune réponse postée" />
                ) : (
                    <div className="space-y-2.5 sm:space-y-3">
                        {replies.map((r) => (
                            <ReplyRow key={r.id} reply={r} />
                        ))}
                    </div>
                ))}

            {sub === 'solutions' &&
                (solutions.length === 0 ? (
                    <EmptyState title="Pas encore de solution acceptée" />
                ) : (
                    <div className="space-y-2.5 sm:space-y-3">
                        {solutions.map((r) => (
                            <ReplyRow key={r.id} reply={r} isSolution />
                        ))}
                    </div>
                ))}
        </div>
    );
}

function ThreadRow({ thread }: { thread: ThreadSummary }) {
    return (
        <Link
            href={`/forum/threads/${thread.slug}`}
            className="block rounded-xl p-4 transition-colors sm:p-5"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
            onMouseEnter={(e) => {
                e.currentTarget.style.background = 'var(--sn-surface-2)';
            }}
            onMouseLeave={(e) => {
                e.currentTarget.style.background = 'var(--sn-surface)';
            }}
        >
            <div
                className="flex flex-wrap items-center gap-1.5 text-[10px] tracking-[0.15em] uppercase sm:gap-2 sm:text-[10.5px]"
                style={{ color: 'var(--sn-muted)' }}
            >
                {thread.channels.map((ch) => (
                    <span
                        key={ch.id}
                        className="inline-flex items-center gap-1"
                        style={{
                            color: ch.color ?? 'var(--sn-accent)',
                        }}
                    >
                        <span
                            className="inline-block h-1.5 w-1.5 rounded-full"
                            style={{
                                background: ch.color ?? 'var(--sn-accent)',
                            }}
                        />
                        {ch.name}
                    </span>
                ))}
                {thread.channels.length > 0 && (
                    <span style={{ opacity: 0.4 }}>&middot;</span>
                )}
                <span>{thread.created_at_human}</span>
                <span style={{ opacity: 0.4 }}>&middot;</span>
                <span>
                    {thread.replies_count} réponse
                    {thread.replies_count > 1 ? 's' : ''}
                </span>
                {thread.solution_reply_id && (
                    <>
                        <span style={{ opacity: 0.4 }}>&middot;</span>
                        <span style={{ color: 'var(--sn-accent)' }}>
                            ● résolu
                        </span>
                    </>
                )}
            </div>
            <div className="mt-1.5 text-[14px] font-semibold tracking-[-0.005em] sm:mt-2 sm:text-[15px]">
                {thread.title}
            </div>
        </Link>
    );
}

function ReplyRow({
    reply,
    isSolution = false,
}: {
    reply: ReplySummary;
    isSolution?: boolean;
}) {
    const t = reply.thread;

    return (
        <Link
            href={t ? `/forum/threads/${t.slug}#reply-${reply.id}` : '#'}
            className="block rounded-xl p-4 transition-colors sm:p-5"
            style={
                isSolution
                    ? {
                          background:
                              'color-mix(in oklch, var(--sn-accent) 8%, transparent)',
                          border: '1.5px solid color-mix(in oklch, var(--sn-accent) 40%, transparent)',
                      }
                    : {
                          background: 'var(--sn-surface)',
                          border: '1px solid var(--sn-border)',
                      }
            }
        >
            <div
                className="flex flex-wrap items-center gap-1.5 text-[10px] tracking-[0.15em] uppercase sm:gap-2 sm:text-[10.5px]"
                style={{ color: 'var(--sn-muted)' }}
            >
                <span>a répondu {reply.created_at_human}</span>
                {isSolution && (
                    <span
                        className="ml-auto inline-flex items-center gap-1 rounded px-1.5 text-[9.5px] sm:text-[10px]"
                        style={{
                            background: 'var(--sn-accent)',
                            color: 'var(--sn-accent-fg)',
                        }}
                    >
                        ✓ solution acceptée
                    </span>
                )}
            </div>
            {t && (
                <div
                    className="mt-1.5 text-[13px] font-semibold tracking-[-0.005em] sm:mt-2 sm:text-[14px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    sur &middot;{' '}
                    <span style={{ color: 'var(--sn-fg)' }}>{t.title}</span>
                </div>
            )}
            {reply.body && (
                <p
                    className="mt-1.5 text-[12.5px] leading-relaxed sm:mt-2 sm:text-[13.5px]"
                    style={{
                        color: 'var(--sn-muted)',
                        display: '-webkit-box',
                        WebkitLineClamp: 2,
                        WebkitBoxOrient: 'vertical',
                        overflow: 'hidden',
                    }}
                >
                    {reply.body}
                </p>
            )}
        </Link>
    );
}

function TabActivity({ activity }: { activity: ActivityItem[] }) {
    if (activity.length === 0) {
        return <EmptyState title="Pas encore d'activité" />;
    }

    return (
        <div className="relative max-w-[820px]">
            <div
                aria-hidden
                className="absolute top-0 bottom-0 left-[17px] w-px"
                style={{ background: 'var(--sn-border)' }}
            />

            <ul className="space-y-3 sm:space-y-4">
                {activity.map((item, i) => {
                    const meta = ACTIVITY_META[item.type];

                    return (
                        <li
                            key={`${item.type}-${i}`}
                            className="relative flex gap-3.5 sm:gap-4"
                        >
                            <div
                                className="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-full"
                                style={{
                                    background: 'var(--sn-bg)',
                                    color: 'var(--sn-muted)',
                                }}
                            >
                                {meta.icon}
                            </div>

                            <div className="min-w-0 flex-1 pt-1 sm:pt-1.5">
                                <div className="flex flex-wrap items-baseline gap-x-2 gap-y-0.5">
                                    <span
                                        className="text-[10px] tracking-[0.14em] uppercase sm:text-[10.5px]"
                                        style={{
                                            color: 'var(--sn-muted)',
                                        }}
                                    >
                                        {meta.label}
                                    </span>
                                    <span
                                        className="text-[10px] sm:text-[10.5px]"
                                        style={{
                                            color: 'var(--sn-muted)',
                                            opacity: 0.6,
                                        }}
                                    >
                                        {item.date_human}
                                    </span>
                                </div>

                                <Link
                                    href={item.url}
                                    className="mt-0.5 block text-[13.5px] leading-snug font-semibold tracking-[-0.005em] hover:underline sm:text-[14.5px]"
                                >
                                    <span className="line-clamp-2 sm:line-clamp-1">
                                        {item.title}
                                    </span>
                                </Link>

                                {item.type === 'reply' && item.excerpt && (
                                    <p
                                        className="mt-1 text-[12px] leading-relaxed sm:text-[12.5px]"
                                        style={{
                                            color: 'var(--sn-muted)',
                                            display: '-webkit-box',
                                            WebkitLineClamp: 2,
                                            WebkitBoxOrient: 'vertical',
                                            overflow: 'hidden',
                                        }}
                                    >
                                        {item.excerpt}
                                    </p>
                                )}
                            </div>
                        </li>
                    );
                })}
            </ul>
        </div>
    );
}
