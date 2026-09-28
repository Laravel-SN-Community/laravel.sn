import { Head, Link, usePage } from '@inertiajs/react';
import {
    Bell,
    Briefcase,
    Check,
    CheckCircle,
    ChevronRight,
    Cloud,
    Database,
    Heart,
    HelpCircle,
    LayoutDashboard,
    LayoutGrid,
    List,
    MessageCircle,
    MessageSquare,
    Package,
    Plus,
    Server,
    Sparkles,
    User,
    X,
} from 'lucide-react';
import { useState } from 'react';
import { ThreadCreateSheet } from '@/components/site/thread-create-sheet';
import { toUrl } from '@/lib/utils';
import { index as forumIndex } from '@/routes/forum';
import {
    index as channelsIndex,
    show as channelShow,
} from '@/routes/forum/channels';
import type { Auth, ForumChannel } from '@/types';

const ICON_MAP: Record<string, React.ElementType> = {
    'message-circle': MessageCircle,
    'help-circle': HelpCircle,
    database: Database,
    layout: LayoutDashboard,
    server: Server,
    cloud: Cloud,
    'check-circle': CheckCircle,
    package: Package,
    briefcase: Briefcase,
    sparkles: Sparkles,
};

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

function ChannelIcon({ name, color }: { name: string | null; color: string }) {
    const Icon = (name && ICON_MAP[name]) || MessageCircle;

    return (
        <span
            className="grid h-11 w-11 shrink-0 place-items-center rounded-lg"
            style={{ background: `${color}22`, color }}
        >
            <Icon size={20} />
        </span>
    );
}

function NumStat({ n, label }: { n: number; label: string }) {
    return (
        <div className="min-w-[64px] text-center">
            <div
                className="text-[18px] leading-none font-semibold tracking-tight"
                style={{ color: 'var(--sn-fg)' }}
            >
                {n}
            </div>
            <div
                className="mt-1 font-mono text-[10.5px] tracking-[0.15em] uppercase"
                style={{ color: 'var(--sn-muted)' }}
            >
                {label}
            </div>
        </div>
    );
}

type Props = {
    channels: ForumChannel[];
    totals: { threads: number; replies: number };
};

export default function ForumChannels({ channels, totals }: Props) {
    const { auth } = usePage<{ auth: Auth }>().props;
    const [sheetOpen, setSheetOpen] = useState(false);

    return (
        <>
            <Head title="Channels — Forum" />
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
                        {/* Header */}
                        <header
                            className="mb-8 flex flex-wrap items-end justify-between gap-6 pb-6"
                            style={{
                                borderBottom: '1px solid var(--sn-border)',
                            }}
                        >
                            <div>
                                <h1
                                    className="text-[34px] leading-none font-semibold tracking-tight"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    Channels
                                </h1>
                                <p
                                    className="mt-3 max-w-[60ch] text-[14px] leading-relaxed"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Le forum est organisé en {channels.length}{' '}
                                    channels thématiques. Choisis-en un pour
                                    voir uniquement les discussions associées.
                                </p>
                            </div>
                            <dl className="flex items-center gap-7">
                                <NumStat n={totals.threads} label="sujets" />
                                <NumStat n={totals.replies} label="réponses" />
                            </dl>
                        </header>

                        {/* Channel rows */}
                        <div
                            className="overflow-hidden rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {channels.map((channel, idx) => {
                                const color =
                                    channel.color ?? 'var(--sn-accent)';

                                return (
                                    <Link
                                        key={channel.id}
                                        href={toUrl(channelShow(channel.slug))}
                                        className="group block px-5 py-5 transition-colors hover:bg-[color-mix(in_oklch,var(--sn-surface-2)_60%,transparent)]"
                                        style={{
                                            borderTop:
                                                idx === 0
                                                    ? 'none'
                                                    : '1px solid var(--sn-border)',
                                        }}
                                    >
                                        <div className="grid grid-cols-[auto_1fr_auto] items-center gap-5">
                                            {/* Icon + color stripe */}
                                            <div className="flex items-stretch gap-4">
                                                <span
                                                    className="w-1 shrink-0 rounded-full"
                                                    style={{
                                                        background: color,
                                                        opacity: 0.6,
                                                    }}
                                                />
                                                <ChannelIcon
                                                    name={channel.icon}
                                                    color={color}
                                                />
                                            </div>

                                            {/* Info */}
                                            <div className="min-w-0">
                                                <div className="flex flex-wrap items-center gap-2.5">
                                                    <h3
                                                        className="text-[16px] font-semibold tracking-tight"
                                                        style={{
                                                            color: 'var(--sn-fg)',
                                                        }}
                                                    >
                                                        {channel.name}
                                                    </h3>
                                                    <span
                                                        className="rounded px-1.5 py-0.5 font-mono text-[10.5px] tracking-[0.1em] uppercase"
                                                        style={{
                                                            background:
                                                                'var(--sn-surface-2)',
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                    >
                                                        #{channel.slug}
                                                    </span>
                                                </div>
                                                {channel.description && (
                                                    <p
                                                        className="mt-1 line-clamp-1 text-[12.5px] leading-relaxed"
                                                        style={{
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                    >
                                                        {channel.description}
                                                    </p>
                                                )}
                                                {channel.children.length >
                                                    0 && (
                                                    <div className="mt-2 flex flex-wrap gap-1.5">
                                                        {channel.children.map(
                                                            (child) => (
                                                                <span
                                                                    key={
                                                                        child.id
                                                                    }
                                                                    className="rounded px-1.5 py-0.5 font-mono text-[10px]"
                                                                    style={{
                                                                        background: `color-mix(in oklch, ${child.color ?? color} 12%, transparent)`,
                                                                        color:
                                                                            child.color ??
                                                                            color,
                                                                    }}
                                                                >
                                                                    {child.name}
                                                                </span>
                                                            ),
                                                        )}
                                                    </div>
                                                )}
                                            </div>

                                            {/* Stats */}
                                            <div
                                                className="hidden items-center gap-5 pl-5 sm:flex"
                                                style={{
                                                    borderLeft:
                                                        '1px solid var(--sn-border)',
                                                }}
                                            >
                                                <NumStat
                                                    n={channel.threads_count}
                                                    label="sujets"
                                                />
                                                <NumStat
                                                    n={channel.total_replies}
                                                    label="réponses"
                                                />
                                                <ChevronRight
                                                    size={14}
                                                    className="hidden text-[var(--sn-muted)] group-hover:text-[var(--sn-fg)] sm:block"
                                                />
                                            </div>

                                            <ChevronRight
                                                size={14}
                                                className="sm:hidden"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                            />
                                        </div>
                                    </Link>
                                );
                            })}
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
