import { Head, Link, usePage } from '@inertiajs/react';
import { Check, Eye, MessageSquare, Zap } from 'lucide-react';
import { useState } from 'react';
import {
    FORUM_CHANNELS,
    FORUM_TAG_COLORS,
    FORUM_THREADS,
    MEMBERS,
} from '@/data/community';
import { useInitials } from '@/hooks/use-initials';

function ChannelIcon({ k }: { k: string }) {
    const props = {
        width: 14,
        height: 14,
        viewBox: '0 0 24 24',
        fill: 'none' as const,
        stroke: 'currentColor' as const,
        strokeWidth: 1.75,
        strokeLinecap: 'round' as const,
        strokeLinejoin: 'round' as const,
    };

    if (k === 'list') {
        return (
            <svg {...props}>
                <line x1="8" y1="6" x2="21" y2="6" />
                <line x1="8" y1="12" x2="21" y2="12" />
                <line x1="8" y1="18" x2="21" y2="18" />
                <line x1="3" y1="6" x2="3.01" y2="6" />
                <line x1="3" y1="12" x2="3.01" y2="12" />
                <line x1="3" y1="18" x2="3.01" y2="18" />
            </svg>
        );
    }

    if (k === 'check') {
        return (
            <svg {...props}>
                <polyline points="20 6 9 17 4 12" />
            </svg>
        );
    }

    if (k === 'x') {
        return (
            <svg {...props}>
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        );
    }

    if (k === 'msg') {
        return (
            <svg {...props}>
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
        );
    }

    if (k === 'heart') {
        return (
            <svg {...props}>
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
        );
    }

    return null;
}

const FAKE_REPLIES = [
    {
        author: 'stevymarlino',
        init: 'SM',
        tint: '#b45309',
        xp: 438,
        when: 'il y a 2 semaines',
        body: "Salut, c'est comme indiqué dans le message : tu dois faire pointer ton .htaccess vers ton index.php. Si tu as déployé tes fichiers dans le public_html, il faut créer un .htaccess qui va rediriger tes requêtes vers ton dossier public de ton projet qui contient ton index.php.",
    },
    {
        author: 'omarsy',
        init: 'OS',
        tint: '#188a5c',
        xp: 912,
        when: 'il y a 10 jours',
        body: "Pour compléter la réponse ci-dessus : assure-toi aussi que `APP_ENV=production` et que tu as bien exécuté `php artisan config:cache` après le déploiement. Beaucoup d'erreurs 403/500 en prod viennent d'un cache de config stale.",
    },
];

export default function ForumThread() {
    const getInitials = useInitials();
    const { slug } = usePage().props as unknown as { slug: string };
    const thread =
        FORUM_THREADS.find((x) => x.slug === slug) ?? FORUM_THREADS[0];
    const authorMember = MEMBERS.find((m) => m.slug === thread.authorSlug);
    const author = authorMember ?? {
        name: thread.author,
        init: getInitials(thread.author),
        tint: '#0f7b4d',
        role: 'Membre',
        company: '—',
    };
    const xp = authorMember
        ? authorMember.articles * 120 + authorMember.events * 80
        : 55;

    const replies = FAKE_REPLIES.slice(
        0,
        Math.min(thread.replies, FAKE_REPLIES.length),
    );

    const [replyText, setReplyText] = useState('');

    return (
        <>
            <Head title={`${thread.title} — Forum`} />

            <div className="mx-auto max-w-[1400px] px-6 pt-10 pb-16 lg:px-10">
                {/* Breadcrumb */}
                <div
                    className="mb-6 flex items-center gap-2 font-mono text-[11.5px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    <Link href="/forum" className="hover:underline">
                        forum
                    </Link>
                    <span>/</span>
                    <span>{thread.tags[0]}</span>
                </div>

                <div className="grid items-start gap-6 lg:grid-cols-[220px_56px_1fr]">
                    {/* Left sidebar (sticky) */}
                    <aside className="order-last space-y-2 lg:sticky lg:top-20 lg:order-first">
                        <button className="sn-btn sn-btn-primary w-full justify-center">
                            Répondre
                        </button>
                        <button className="sn-btn sn-btn-secondary w-full justify-center">
                            S'abonner
                        </button>
                        <div
                            className="mt-4 space-y-1 border-t pt-4"
                            style={{ borderColor: 'var(--sn-border)' }}
                        >
                            {FORUM_CHANNELS.map((c) => (
                                <Link
                                    key={c.slug}
                                    href="/forum"
                                    className="flex w-full items-center gap-2.5 rounded-md px-2 py-1.5 text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    <ChannelIcon k={c.icon} />
                                    <span>{c.label}</span>
                                </Link>
                            ))}
                        </div>
                    </aside>

                    {/* Author rail (desktop only) */}
                    <div className="order-2 hidden flex-col items-center gap-4 lg:sticky lg:top-20 lg:flex">
                        <span
                            className="grid h-11 w-11 place-items-center rounded-full font-mono text-[12px]"
                            style={{ background: author.tint, color: '#fff' }}
                        >
                            {author.init}
                        </span>
                        <div
                            className="flex flex-col items-center gap-3 font-mono text-[11px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            <span className="flex flex-col items-center gap-1">
                                <Zap size={14} />
                                <span>{xp}</span>
                            </span>
                            <span className="flex flex-col items-center gap-1">
                                <MessageSquare size={14} />
                                <span>{thread.replies}</span>
                            </span>
                            <span className="flex flex-col items-center gap-1">
                                <Eye size={14} />
                                <span>{thread.views}</span>
                            </span>
                        </div>
                    </div>

                    {/* Main */}
                    <main className="order-3 min-w-0">
                        {/* Author + tags header */}
                        <div className="mb-4 flex flex-wrap items-center justify-between gap-4">
                            <div className="flex items-center gap-3">
                                <span
                                    className="grid h-10 w-10 place-items-center rounded-full font-mono text-[12px] lg:hidden"
                                    style={{
                                        background: author.tint,
                                        color: '#fff',
                                    }}
                                >
                                    {author.init}
                                </span>
                                <div>
                                    <div className="flex items-center gap-2">
                                        <span className="text-[15px] font-semibold">
                                            {thread.author}
                                        </span>
                                        <span
                                            className="rounded px-1.5 py-0.5 font-mono text-[10.5px]"
                                            style={{
                                                background:
                                                    'var(--sn-surface-2)',
                                                color: 'var(--sn-muted)',
                                            }}
                                        >
                                            {xp} XP
                                        </span>
                                    </div>
                                    <div
                                        className="font-mono text-[11.5px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        a posé <span>{thread.when}</span>
                                    </div>
                                </div>
                            </div>

                            <div className="flex flex-wrap items-center gap-2">
                                {thread.tags.map((tag) => {
                                    const cfg =
                                        FORUM_TAG_COLORS[tag] ??
                                        FORUM_TAG_COLORS['divers'];

                                    return (
                                        <span
                                            key={tag}
                                            className="inline-flex items-center gap-1.5 rounded px-2 py-0.5 font-mono text-[10.5px] tracking-[0.1em] uppercase"
                                            style={{
                                                background: `color-mix(in oklch, ${cfg.color} 14%, transparent)`,
                                                color: cfg.color,
                                            }}
                                        >
                                            <span
                                                className="h-1.5 w-1.5 rounded-full"
                                                style={{
                                                    background: cfg.color,
                                                }}
                                            />
                                            {tag}
                                        </span>
                                    );
                                })}
                                {thread.resolved && (
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
                            </div>
                        </div>

                        {/* Title card */}
                        <div
                            className="mb-4 rounded-lg p-4"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <h1 className="text-[20px] leading-snug font-semibold tracking-tight">
                                {thread.title}
                            </h1>
                        </div>

                        {/* Body */}
                        <div className="space-y-4 text-[14.5px] leading-[1.75]">
                            <p>{thread.excerpt}</p>
                            <p style={{ color: 'var(--sn-muted)' }}>
                                Si quelqu'un a déjà rencontré ce problème ou a
                                une piste, je suis preneur. Merci d'avance à la
                                communauté 🙏
                            </p>
                        </div>

                        {/* Replies */}
                        <div
                            className="mt-10 border-t pt-8"
                            style={{ borderColor: 'var(--sn-border)' }}
                        >
                            <div className="space-y-6">
                                {replies.map((r, i) => (
                                    <div
                                        key={i}
                                        className="grid grid-cols-[44px_1fr] gap-4"
                                    >
                                        <span
                                            className="grid h-11 w-11 place-items-center rounded-full font-mono text-[12px]"
                                            style={{
                                                background: r.tint,
                                                color: '#fff',
                                            }}
                                        >
                                            {r.init}
                                        </span>
                                        <div>
                                            <div className="mb-2 flex items-center gap-2">
                                                <span className="text-[14.5px] font-semibold">
                                                    {r.author}
                                                </span>
                                                <span
                                                    className="rounded px-1.5 py-0.5 font-mono text-[10.5px]"
                                                    style={{
                                                        background:
                                                            'var(--sn-surface-2)',
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    {r.xp} XP
                                                </span>
                                                <span
                                                    className="font-mono text-[11.5px]"
                                                    style={{
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    · a répondu {r.when}
                                                </span>
                                            </div>
                                            <div className="text-[14.5px] leading-[1.75]">
                                                {r.body}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                                {replies.length === 0 && (
                                    <p
                                        className="font-mono text-[13px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        Aucune réponse pour l'instant. Sois le
                                        premier à aider !
                                    </p>
                                )}
                            </div>
                        </div>

                        {/* Reply box */}
                        <div
                            className="mt-10 rounded-xl p-5"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <div
                                className="mb-3 font-mono text-[11px] tracking-[0.18em] uppercase"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Ta réponse
                            </div>
                            <textarea
                                rows={4}
                                value={replyText}
                                onChange={(e) => setReplyText(e.target.value)}
                                placeholder="Tape ta réponse en markdown…"
                                className="w-full resize-none rounded-md px-3 py-2.5 text-[14px]"
                                style={{
                                    background: 'var(--sn-bg)',
                                    border: '1px solid var(--sn-border)',
                                    color: 'var(--sn-fg)',
                                }}
                            />
                            <div className="mt-3 flex items-center justify-between">
                                <span
                                    className="font-mono text-[11px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    markdown supporté · sois sympa
                                </span>
                                <button className="sn-btn sn-btn-primary sn-btn-sm">
                                    Publier la réponse
                                </button>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
