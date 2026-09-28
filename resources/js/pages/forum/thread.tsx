import { Head, InfiniteScroll, Link, router, usePage } from '@inertiajs/react';
import {
    Bell,
    Check,
    Eye,
    Heart,
    LayoutGrid,
    List,
    Lock,
    MessageSquare,
    User,
    X,
} from 'lucide-react';
import React, { useEffect } from 'react';
import { OpCard } from '@/components/forum/op-card';
import { ReplyCard } from '@/components/forum/reply-card';
import { ReplyForm } from '@/components/forum/reply-form';
import { useInitials } from '@/hooks/use-initials';
import { authorTint } from '@/lib/forum';
import { toUrl } from '@/lib/utils';
import { index as forumIndex } from '@/routes/forum';
import { index as channelsIndex } from '@/routes/forum/channels';
import { toggle as reactionToggle } from '@/routes/forum/reactions';
import {
    pin as threadPin,
    subscribe as threadSubscribe,
    unlock as threadUnlock,
    unpin as threadUnpin,
    unsubscribe as threadUnsubscribe,
} from '@/routes/forum/threads';
import type { Auth, ForumThreadFull, PaginatedReplies } from '@/types';

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

function Avatar({
    id,
    name,
    avatar,
}: {
    id: number;
    name: string;
    avatar: string | null;
}) {
    const getInitials = useInitials();

    return (
        <div
            className="relative h-10 w-10 shrink-0 overflow-hidden rounded-full"
            style={{
                background: avatar ? 'transparent' : authorTint(id),
                boxShadow: '0 0 0 4px var(--sn-bg)',
            }}
        >
            {avatar ? (
                <img
                    src={avatar}
                    alt={name}
                    className="h-full w-full object-cover"
                />
            ) : (
                <span className="absolute inset-0 flex items-center justify-center font-mono text-[11px] text-white">
                    {getInitials(name)}
                </span>
            )}
        </div>
    );
}

function TimelineStat({
    icon,
    value,
}: {
    icon: React.ReactNode;
    value: number;
}) {
    return (
        <div className="flex flex-col items-center gap-1">
            <span style={{ color: 'var(--sn-muted)' }}>{icon}</span>
            <span
                className="font-mono text-[11px] leading-none"
                style={{ color: 'var(--sn-muted)' }}
            >
                {value}
            </span>
        </div>
    );
}

type Props = {
    thread: ForumThreadFull;
    replies: PaginatedReplies;
    isSubscribed: boolean;
};

export default function Thread({ thread, replies, isSubscribed }: Props) {
    const { auth } = usePage<{ auth: Auth }>().props;

    useEffect(() => {
        const hash = window.location.hash;

        if (hash) {
            history.replaceState(
                null,
                '',
                window.location.pathname + window.location.search,
            );
            window.scrollTo(0, 0);

            setTimeout(() => {
                const el = document.querySelector(hash);

                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                    const card = el.querySelector(':scope > *');

                    if (card) {
                        setTimeout(() => {
                            card.classList.add('reply-highlight');
                            setTimeout(
                                () => card.classList.remove('reply-highlight'),
                                2700,
                            );
                        }, 600);
                    }
                }
            }, 300);
        }
    }, []);

    return (
        <>
            <Head title={`${thread.title} — Forum`} />

            <div className="mx-auto max-w-[1400px] px-6 pt-10 pb-16 lg:px-10">
                <div className="grid items-start gap-8 lg:grid-cols-[260px_1fr]">
                    {/* Sidebar */}
                    <aside className="order-last space-y-1 lg:sticky lg:top-18 lg:order-first">
                        {auth?.user && (
                            <Link
                                href={toUrl(
                                    isSubscribed
                                        ? threadUnsubscribe(thread.slug)
                                        : threadSubscribe(thread.slug),
                                )}
                                method={isSubscribed ? 'delete' : 'post'}
                                as="button"
                                className="sn-btn sn-btn-secondary mt-2 mb-4 w-full justify-center"
                            >
                                {isSubscribed ? 'Se désabonner' : "S'abonner"}
                            </Link>
                        )}

                        {!auth?.user && <div className="mb-4" />}

                        <Link
                            href={toUrl(channelsIndex())}
                            className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            <LayoutGrid size={15} />
                            <span>Channels</span>
                        </Link>

                        {NAV_FILTERS.map(({ slug, label, Icon }) => (
                            <Link
                                key={label}
                                href={
                                    toUrl(forumIndex()) +
                                    (slug ? `?filter=${slug}` : '')
                                }
                                className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <Icon size={15} />
                                <span>{label}</span>
                            </Link>
                        ))}
                    </aside>

                    {/* Main content */}
                    <main className="min-w-0">
                        {/* OP row */}
                        <div className="grid gap-x-4 pb-6 lg:grid-cols-[52px_1fr]">
                            <div className="hidden flex-col items-center pt-1 lg:flex">
                                <div
                                    className="sticky top-18 flex flex-col items-center gap-3.5 rounded-full px-3.5 py-4"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                    }}
                                >
                                    {auth?.user ? (
                                        <button
                                            onClick={() =>
                                                router.post(
                                                    toUrl(
                                                        reactionToggle(
                                                            thread.slug,
                                                        ),
                                                    ),
                                                    { type: 'like' },
                                                    { preserveScroll: true },
                                                )
                                            }
                                            className="flex cursor-pointer flex-col items-center gap-1 transition-opacity hover:opacity-70"
                                        >
                                            <Heart
                                                size={18}
                                                style={{
                                                    color: thread.user_liked
                                                        ? '#ef4444'
                                                        : 'var(--sn-muted)',
                                                    fill: thread.user_liked
                                                        ? '#ef4444'
                                                        : 'none',
                                                }}
                                            />
                                            <span
                                                className="font-mono text-[11px] leading-none"
                                                style={{
                                                    color: thread.user_liked
                                                        ? '#ef4444'
                                                        : 'var(--sn-muted)',
                                                }}
                                            >
                                                {thread.likes_count}
                                            </span>
                                        </button>
                                    ) : (
                                        <TimelineStat
                                            icon={<Heart size={18} />}
                                            value={thread.likes_count}
                                        />
                                    )}
                                    <TimelineStat
                                        icon={<MessageSquare size={18} />}
                                        value={thread.replies_count}
                                    />
                                    <TimelineStat
                                        icon={<Eye size={18} />}
                                        value={thread.views_count}
                                    />
                                </div>
                            </div>
                            <div className="min-w-0">
                                <OpCard thread={thread} />
                            </div>
                        </div>

                        {/* Replies */}
                        {replies.data.length === 0 ? (
                            <div className="grid gap-x-4 lg:grid-cols-[52px_1fr]">
                                <div className="hidden lg:block" />
                                <div
                                    className="rounded-lg p-5 text-center"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px dashed var(--sn-border)',
                                    }}
                                >
                                    <p
                                        className="text-[14px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        Pas encore de réponse. Sois le premier à
                                        aider !
                                    </p>
                                </div>
                            </div>
                        ) : (
                            <InfiniteScroll
                                data="replies"
                                buffer={300}
                                className="mb-10"
                            >
                                {replies.data.map((reply, index) => {
                                    const isLast =
                                        index === replies.data.length - 1;

                                    return (
                                        <div
                                            key={reply.id}
                                            className="mb-8 grid gap-x-4 lg:grid-cols-[52px_1fr]"
                                        >
                                            <div className="relative z-10 hidden lg:block">
                                                <div
                                                    aria-hidden
                                                    className="pointer-events-none absolute w-px"
                                                    style={{
                                                        left: '50%',
                                                        top: 0,
                                                        ...(isLast
                                                            ? { height: 22 }
                                                            : {
                                                                  bottom: '-2rem',
                                                              }),
                                                        background:
                                                            'var(--sn-border)',
                                                    }}
                                                />
                                                <div className="sticky top-18 flex flex-col items-center pt-0.5">
                                                    <Avatar
                                                        id={reply.author.id}
                                                        name={reply.author.name}
                                                        avatar={
                                                            reply.author.avatar
                                                        }
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                id={`reply-${reply.id}`}
                                                className="min-w-0 scroll-mt-24"
                                            >
                                                <ReplyCard
                                                    reply={reply}
                                                    isSolution={
                                                        reply.id ===
                                                        thread.solution?.id
                                                    }
                                                    thread={thread}
                                                    auth={auth}
                                                />
                                            </div>
                                        </div>
                                    );
                                })}
                            </InfiniteScroll>
                        )}

                        {/* Reply form / locked notice */}
                        <div className="mb-16 grid gap-x-4 lg:grid-cols-[52px_1fr]">
                            <div className="hidden lg:block" />
                            <div className="min-w-0">
                                {thread.is_locked ? (
                                    <div
                                        className="flex items-start gap-4 rounded-xl px-5 py-4"
                                        style={{
                                            background: 'var(--sn-surface)',
                                            border: '1.5px dashed var(--sn-border)',
                                        }}
                                    >
                                        <Lock
                                            size={16}
                                            className="mt-0.5 shrink-0"
                                            style={{ color: 'var(--sn-muted)' }}
                                        />
                                        <div className="min-w-0 flex-1">
                                            <p
                                                className="text-[13.5px] font-semibold"
                                                style={{
                                                    color: 'var(--sn-fg)',
                                                }}
                                            >
                                                Conversation Fermée
                                            </p>
                                            <p
                                                className="mt-0.5 text-[13px] leading-relaxed"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                            >
                                                Cette discussion est fermée aux
                                                nouvelles réponses. Pensez à
                                                ouvrir un nouveau sujet si vous
                                                avez une question similaire.
                                            </p>
                                        </div>
                                        {(auth?.role === 'admin' ||
                                            auth?.role === 'moderator') && (
                                            <div className="flex shrink-0 items-center gap-2">
                                                <Link
                                                    href={toUrl(
                                                        thread.is_pinned
                                                            ? threadUnpin(
                                                                  thread.slug,
                                                              )
                                                            : threadPin(
                                                                  thread.slug,
                                                              ),
                                                    )}
                                                    method={
                                                        thread.is_pinned
                                                            ? 'delete'
                                                            : 'post'
                                                    }
                                                    as="button"
                                                    preserveScroll
                                                    className="sn-btn sn-btn-secondary sn-btn-sm"
                                                >
                                                    {thread.is_pinned
                                                        ? 'Désépingler'
                                                        : 'Épingler'}
                                                </Link>
                                                <Link
                                                    href={toUrl(
                                                        threadUnlock(
                                                            thread.slug,
                                                        ),
                                                    )}
                                                    method="delete"
                                                    as="button"
                                                    preserveScroll
                                                    className="sn-btn sn-btn-secondary sn-btn-sm"
                                                >
                                                    Rouvrir
                                                </Link>
                                            </div>
                                        )}
                                    </div>
                                ) : auth?.user ? (
                                    <ReplyForm thread={thread} auth={auth} />
                                ) : (
                                    <div
                                        className="rounded-xl p-5 text-center"
                                        style={{
                                            background: 'var(--sn-surface)',
                                            border: '1px solid var(--sn-border)',
                                        }}
                                    >
                                        <Link
                                            href="/login"
                                            className="sn-btn sn-btn-primary sn-btn-sm"
                                        >
                                            Se connecter pour répondre
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
