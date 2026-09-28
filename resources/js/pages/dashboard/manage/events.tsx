import { Head, Link, router } from '@inertiajs/react';
import * as Dialog from '@radix-ui/react-dialog';
import { Eye, Pencil, Plus, Trash2 } from 'lucide-react';
import { X } from 'lucide-react';
import { useState } from 'react';
import EventController from '@/actions/App/Http/Controllers/EventController';
import DashSidebar from '@/components/site/dashboard-sidebar';
import EventCreateSheet from '@/components/site/event-create-sheet';
import { show as eventsShow } from '@/routes/events';

type Venue = { id: number; name: string; district: string };

type ManageEvent = {
    id: number;
    slug: string;
    title: string;
    format: string;
    description: string;
    status: string;
    starts_at: string;
    ends_at: string | null;
    registration_opens_at: string | null;
    registration_closes_at: string | null;
    is_featured: boolean;
    is_sponsored: boolean;
    is_online: boolean;
    online_url: string | null;
    venue_id: number | null;
    capacity: number | null;
    waitlist_capacity: number;
    agenda: Array<{ time: string; title: string }> | null;
    replay_url: string | null;
    cover_url: string | null;
    confirmed_registrations_count: number;
    venue: Venue | null;
};

type Stats = { total: number; upcoming: number; drafts: number; past: number };

type PaginatedEvents = {
    data: ManageEvent[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
};

type Props = {
    events: PaginatedEvents;
    stats: Stats;
    venues: Venue[];
    filters: { tab: string };
};

const FORMAT_LABELS: Record<string, string> = {
    meetup: 'Meetup',
    workshop: 'Workshop',
    conference: 'Conférence',
    hackathon: 'Hackathon',
    webinar: 'Webinaire',
};

const TABS = [
    { id: 'all', label: 'Tous' },
    { id: 'upcoming', label: 'À venir' },
    { id: 'drafts', label: 'Brouillons' },
    { id: 'past', label: 'Passés' },
] as const;

function statusStyle(status: string): {
    label: string;
    bg: string;
    color: string;
} {
    if (status === 'published') {
        return {
            label: 'Publié',
            bg: 'color-mix(in oklch, var(--sn-600) 12%, transparent)',
            color: 'var(--sn-700)',
        };
    }

    if (status === 'draft') {
        return {
            label: 'Brouillon',
            bg: 'color-mix(in oklch, #f59e0b 12%, transparent)',
            color: '#b45309',
        };
    }

    return {
        label: status,
        bg: 'var(--sn-surface-2)',
        color: 'var(--sn-muted)',
    };
}

export default function ManageEvents({
    events,
    stats,
    venues,
    filters,
}: Props) {
    const tab = filters.tab ?? 'all';
    const [sheetOpen, setSheetOpen] = useState(false);
    const [editTarget, setEditTarget] = useState<ManageEvent | null>(null);
    const [deleteTarget, setDeleteTarget] = useState<ManageEvent | null>(null);

    function openCreate() {
        setEditTarget(null);
        setSheetOpen(true);
    }

    function openEdit(e: ManageEvent) {
        setEditTarget(e);
        setSheetOpen(true);
    }

    function handleSheetChange(next: boolean) {
        if (!next) {
            setEditTarget(null);
        }

        setSheetOpen(next);
    }

    function go(newTab: string) {
        router.get(
            EventController.manageIndex.url(),
            { tab: newTab },
            { preserveState: true, replace: true },
        );
    }

    function tabCount(id: string): number {
        if (id === 'all') {
            return stats.total;
        }

        if (id === 'upcoming') {
            return stats.upcoming;
        }

        if (id === 'drafts') {
            return stats.drafts;
        }

        if (id === 'past') {
            return stats.past;
        }

        return 0;
    }

    function confirmDelete() {
        if (!deleteTarget) {
            return;
        }

        router.delete(
            EventController.destroy.url({ event: deleteTarget.slug }),
            {
                onFinish: () => setDeleteTarget(null),
            },
        );
    }

    return (
        <>
            <Head title="Gestion des évènements" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="manage-events" />

                    <main className="min-w-0 space-y-6">
                        {/* Header */}
                        <div className="flex flex-wrap items-end justify-between gap-3">
                            <div>
                                <h1
                                    className="mt-1 text-[24px] font-semibold tracking-[-0.02em] sm:text-[32px]"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    Gestion des évènements
                                </h1>
                            </div>
                            <button
                                onClick={openCreate}
                                className="sn-btn sn-btn-primary shrink-0"
                            >
                                <Plus size={15} />
                                Nouvel évènement
                            </button>
                        </div>

                        {/* Tabs */}
                        <div
                            className="flex w-full items-center gap-0.5 rounded-xl p-1 font-mono text-[12px] sm:inline-flex sm:w-auto"
                            style={{
                                background: 'var(--sn-surface-2)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {TABS.map((t) => {
                                const active = t.id === tab;
                                const count = tabCount(t.id);

                                return (
                                    <button
                                        key={t.id}
                                        onClick={() => go(t.id)}
                                        className="flex flex-1 items-center justify-center gap-1 rounded-lg px-2 py-1.5 whitespace-nowrap transition-all sm:flex-none sm:gap-1.5 sm:px-3"
                                        style={{
                                            background: active
                                                ? 'var(--sn-700)'
                                                : 'transparent',
                                            color: active
                                                ? '#fff'
                                                : 'var(--sn-muted)',
                                            fontWeight: active ? 600 : 400,
                                        }}
                                    >
                                        {t.label}
                                        {count > 0 && (
                                            <span
                                                className="rounded px-1 py-0.5 text-[10px]"
                                                style={{
                                                    background: active
                                                        ? 'rgba(255,255,255,0.2)'
                                                        : 'transparent',
                                                    color: active
                                                        ? '#fff'
                                                        : 'var(--sn-muted)',
                                                }}
                                            >
                                                {count}
                                            </span>
                                        )}
                                    </button>
                                );
                            })}
                        </div>

                        {/* Events list */}
                        <div
                            className="overflow-hidden rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {events.data.length === 0 ? (
                                <div
                                    className="px-6 py-12 text-center font-mono text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Aucun évènement dans cette catégorie.
                                </div>
                            ) : (
                                events.data.map((e, i) => (
                                    <EventRow
                                        key={e.id}
                                        event={e}
                                        last={i === events.data.length - 1}
                                        onEdit={() => openEdit(e)}
                                        onDelete={() => setDeleteTarget(e)}
                                    />
                                ))
                            )}
                        </div>

                        {/* Pagination */}
                        {events.last_page > 1 && (
                            <div className="flex justify-center gap-2 font-mono text-[12px]">
                                {events.prev_page_url && (
                                    <Link
                                        href={events.prev_page_url}
                                        className="sn-btn sn-btn-ghost sn-btn-sm"
                                    >
                                        ← Précédent
                                    </Link>
                                )}
                                <span
                                    className="flex items-center px-3"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {events.current_page} / {events.last_page}
                                </span>
                                {events.next_page_url && (
                                    <Link
                                        href={events.next_page_url}
                                        className="sn-btn sn-btn-ghost sn-btn-sm"
                                    >
                                        Suivant →
                                    </Link>
                                )}
                            </div>
                        )}
                    </main>
                </div>
            </div>

            {/* Delete confirm */}
            <Dialog.Root
                open={deleteTarget !== null}
                onOpenChange={(open) => {
                    if (!open) {
                        setDeleteTarget(null);
                    }
                }}
            >
                <Dialog.Portal>
                    <Dialog.Overlay className="fixed inset-0 z-50 bg-black/40 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:animate-in data-[state=open]:fade-in-0" />
                    <Dialog.Content
                        className="fixed top-1/2 left-1/2 z-50 w-full max-w-[420px] -translate-x-1/2 -translate-y-1/2 rounded-2xl p-6 shadow-2xl outline-none data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
                        style={{
                            background: 'var(--sn-bg)',
                            border: '1px solid var(--sn-border)',
                        }}
                    >
                        <div className="flex items-start justify-between gap-4">
                            <div
                                className="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl"
                                style={{
                                    background:
                                        'color-mix(in oklch, var(--destructive) 10%, transparent)',
                                }}
                            >
                                <Trash2
                                    size={18}
                                    style={{ color: 'var(--destructive)' }}
                                />
                            </div>
                            <Dialog.Close
                                className="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg transition-colors focus:outline-none"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <X size={14} />
                            </Dialog.Close>
                        </div>
                        <Dialog.Title
                            className="mt-4 text-[17px] font-semibold tracking-tight"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Supprimer l'évènement
                        </Dialog.Title>
                        <Dialog.Description
                            className="mt-1.5 text-[13.5px] leading-relaxed"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            <span
                                className="font-medium"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                «&nbsp;{deleteTarget?.title}&nbsp;»
                            </span>{' '}
                            sera supprimé définitivement. Cette action est
                            irréversible.
                        </Dialog.Description>
                        <div className="mt-6 flex justify-end gap-3">
                            <Dialog.Close className="sn-btn sn-btn-secondary sn-btn-sm">
                                Annuler
                            </Dialog.Close>
                            <button
                                onClick={confirmDelete}
                                className="sn-btn sn-btn-sm rounded-lg px-4 py-2 text-[13px] font-semibold"
                                style={{
                                    background: 'var(--destructive)',
                                    color: '#fff',
                                }}
                            >
                                Supprimer
                            </button>
                        </div>
                    </Dialog.Content>
                </Dialog.Portal>
            </Dialog.Root>

            <EventCreateSheet
                open={sheetOpen}
                onOpenChange={handleSheetChange}
                venues={venues}
                {...(editTarget ? { event: editTarget } : {})}
            />
        </>
    );
}

function EventRow({
    event: e,
    last,
    onEdit,
    onDelete,
}: {
    event: ManageEvent;
    last: boolean;
    onEdit: () => void;
    onDelete: () => void;
}) {
    const date = new Date(e.starts_at);
    const day = date.toLocaleDateString('fr-FR', { day: '2-digit' });
    const monthShort = date
        .toLocaleDateString('fr-FR', { month: 'short' })
        .replace('.', '');
    const monthUp = monthShort.toUpperCase();
    const time = date.toLocaleTimeString('fr-FR', {
        hour: '2-digit',
        minute: '2-digit',
    });
    const status = statusStyle(e.status);
    const isDraft = e.status === 'draft';

    const meta = (
        <div
            className="flex flex-wrap items-center gap-1 font-mono text-[10px] tracking-[0.15em] uppercase"
            style={{ color: 'var(--sn-muted)' }}
        >
            <span>{FORMAT_LABELS[e.format] ?? e.format}</span>
            {e.venue && (
                <>
                    <span>·</span>
                    <span>{e.venue.district}</span>
                </>
            )}
            {e.is_online && (
                <>
                    <span>·</span>
                    <span>En ligne</span>
                </>
            )}
            {e.is_featured && (
                <>
                    <span>·</span>
                    <span style={{ color: 'var(--sn-600)' }}>★ Une</span>
                </>
            )}
        </div>
    );

    const draftBadge = isDraft ? (
        <span
            className="shrink-0 rounded-md px-2 py-0.5 font-mono text-[10px] font-semibold tracking-[0.08em] uppercase"
            style={{ background: status.bg, color: status.color }}
        >
            {status.label}
        </span>
    ) : null;

    const actions = (
        <div className="flex items-center gap-1.5">
            <Link
                href={eventsShow.url(e.slug)}
                className="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-[12px] font-medium transition-colors"
                style={{
                    background: 'var(--sn-surface-2)',
                    color: 'var(--sn-muted)',
                }}
            >
                <Eye size={13} />
                Voir
            </Link>
            <button
                onClick={onEdit}
                className="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-[12px] font-medium transition-colors"
                style={{
                    background: 'var(--sn-surface-2)',
                    color: 'var(--sn-muted)',
                }}
            >
                <Pencil size={13} />
                Modifier
            </button>
            <button
                onClick={onDelete}
                className="flex h-8 w-8 items-center justify-center rounded-lg transition-colors"
                style={{
                    background:
                        'color-mix(in oklch, var(--destructive) 8%, transparent)',
                    color: 'var(--destructive)',
                }}
            >
                <Trash2 size={13} />
            </button>
        </div>
    );

    return (
        <div
            style={{
                borderBottom: last ? 'none' : '1px solid var(--sn-border)',
            }}
        >
            {/* ── Mobile layout ── */}
            <div className="space-y-2 px-4 py-4 sm:hidden">
                <div className="flex items-start justify-between gap-2">
                    {meta}
                    {draftBadge}
                </div>
                <div
                    className="text-[15px] leading-snug font-semibold tracking-tight"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    {e.title}
                </div>
                <div
                    className="flex items-center gap-2 font-mono text-[11px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {e.venue && <span>{e.venue.name}</span>}
                    <span style={{ color: 'var(--sn-600)' }}>
                        {day} {monthShort} · {time}
                    </span>
                </div>
                <div className="pt-1">{actions}</div>
            </div>

            {/* ── Desktop layout ── */}
            <div className="hidden items-start gap-5 px-6 py-5 sm:flex">
                {/* Date column */}
                <div className="w-12 shrink-0 text-center">
                    <div
                        className="font-mono text-[10px] tracking-[0.18em] uppercase"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {monthUp}
                    </div>
                    <div
                        className="mt-0.5 text-[30px] leading-none font-semibold tracking-tight"
                        style={{ color: 'var(--sn-700)' }}
                    >
                        {day}
                    </div>
                    <div
                        className="mt-0.5 font-mono text-[10px]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {time}
                    </div>
                </div>

                {/* Content */}
                <div className="min-w-0 flex-1">
                    <div
                        className="flex items-center gap-2 font-mono text-[10.5px] tracking-[0.15em] uppercase"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        <span>{FORMAT_LABELS[e.format] ?? e.format}</span>
                        {e.venue && (
                            <>
                                <span>·</span>
                                <span>{e.venue.district}</span>
                            </>
                        )}
                        {e.is_online && (
                            <>
                                <span>·</span>
                                <span>En ligne</span>
                            </>
                        )}
                        {e.is_featured && (
                            <>
                                <span>·</span>
                                <span style={{ color: 'var(--sn-600)' }}>
                                    ★ À la une
                                </span>
                            </>
                        )}
                    </div>
                    <div
                        className="mt-1 text-[15px] leading-snug font-semibold tracking-tight"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        {e.title}
                    </div>
                    {e.venue && (
                        <div
                            className="mt-0.5 text-[12.5px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            {e.venue.name} · {e.venue.district}
                        </div>
                    )}
                </div>

                {/* Draft badge + actions */}
                <div className="flex shrink-0 flex-col items-end gap-3">
                    {draftBadge}
                    {actions}
                </div>
            </div>
        </div>
    );
}
