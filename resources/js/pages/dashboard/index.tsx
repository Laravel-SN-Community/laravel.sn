import { Head, Link, usePage } from '@inertiajs/react';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { formatEventDate } from '@/types/event';

interface AuthUser {
    name: string;
    email: string;
}

interface DashboardStats {
    articlesPublished: number;
    articlesThisMonth: number;
    totalViews: number;
    eventsRegistered: number;
    upcomingEvents: number;
    reputation: number;
}

interface NextEvent {
    title: string;
    slug: string;
    starts_at: string;
    is_online: boolean;
    registrations_open: boolean;
    is_full: boolean;
    venue: { name: string; district: string | null } | null;
}

interface DashboardProps {
    stats: DashboardStats;
    nextEvent: NextEvent | null;
}

function StatCard({
    label,
    value,
    delta,
    trend = false,
}: {
    label: string;
    value: string;
    delta?: string;
    trend?: boolean;
}) {
    return (
        <div
            className="rounded-xl p-4"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            <div
                className="font-mono text-[10.5px] tracking-[0.18em] uppercase"
                style={{ color: 'var(--sn-muted)' }}
            >
                {label}
            </div>
            <div
                className="mt-1.5 text-[28px] font-semibold tracking-[-0.02em]"
                style={{ color: 'var(--sn-fg)' }}
            >
                {value}
            </div>
            {delta && (
                <div
                    className="mt-1 font-mono text-[11px]"
                    style={{ color: 'var(--sn-600)' }}
                >
                    {trend ? '↗ ' : ''}
                    {delta}
                </div>
            )}
        </div>
    );
}

function DashCard({
    eyebrow,
    title,
    actions,
    children,
}: {
    eyebrow?: string;
    title?: string;
    actions?: React.ReactNode;
    children: React.ReactNode;
}) {
    return (
        <div
            className="rounded-xl p-6"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            {eyebrow && (
                <div
                    className="font-mono text-[10.5px] tracking-[0.18em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {eyebrow}
                </div>
            )}
            <div className="flex items-center justify-between gap-3">
                {title && (
                    <h3
                        className="mt-1 text-[18px] font-semibold tracking-[-0.01em]"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        {title}
                    </h3>
                )}
                {actions}
            </div>
            <div className="mt-4">{children}</div>
        </div>
    );
}

function NextEventCard({ event }: { event: NextEvent }) {
    const { day, month, year, time } = formatEventDate(event.starts_at);

    const location = event.is_online
        ? 'En ligne'
        : event.venue
          ? [event.venue.name, event.venue.district].filter(Boolean).join(' · ')
          : 'Lieu à confirmer';

    const registration = event.is_full
        ? { label: '● Complet', open: false }
        : event.registrations_open
          ? { label: '● Inscription ouverte', open: true }
          : { label: '● Inscriptions fermées', open: false };

    return (
        <DashCard
            eyebrow="Prochain évènement"
            title={event.title}
            actions={
                <Link
                    href={`/events/${event.slug}`}
                    className="sn-btn sn-btn-ghost sn-btn-sm"
                >
                    détails →
                </Link>
            }
        >
            <div className="grid gap-4 font-mono text-[12.5px] sm:grid-cols-3">
                <div>
                    <span style={{ color: 'var(--sn-muted)' }}>📅 </span>
                    {day} {month} {year} · {time}
                </div>
                <div>
                    <span style={{ color: 'var(--sn-muted)' }}>📍 </span>
                    {location}
                </div>
                <div
                    style={{
                        color: registration.open
                            ? 'var(--sn-600)'
                            : 'var(--sn-muted)',
                    }}
                >
                    {registration.label}
                </div>
            </div>
        </DashCard>
    );
}

function DashOverview({
    user,
    stats,
    nextEvent,
}: {
    user: AuthUser;
    stats: DashboardStats;
    nextEvent: NextEvent | null;
}) {
    const firstName = user.name.split(' ')[0];

    return (
        <div className="space-y-6">
            {/* Greeting */}
            <div>
                <h1
                    className="mt-1 text-[32px] font-semibold tracking-[-0.02em]"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    Salaam, {firstName} 👋
                </h1>
                <p
                    className="mt-1 font-mono text-[13px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Voici ce qui se passe dans ton coin de la communauté.
                </p>
            </div>

            {/* Stats */}
            <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard
                    label="Articles publiés"
                    value={stats.articlesPublished.toLocaleString('fr-FR')}
                    delta={
                        stats.articlesThisMonth > 0
                            ? `+${stats.articlesThisMonth} ce mois`
                            : 'aucun ce mois'
                    }
                    trend={stats.articlesThisMonth > 0}
                />
                <StatCard
                    label="Vues totales"
                    value={stats.totalViews.toLocaleString('fr-FR')}
                    delta={`sur ${stats.articlesPublished} article${stats.articlesPublished > 1 ? 's' : ''}`}
                />
                <StatCard
                    label="Évènements"
                    value={stats.eventsRegistered.toLocaleString('fr-FR')}
                    delta={`${stats.upcomingEvents} à venir`}
                />
                <StatCard
                    label="Réputation"
                    value={stats.reputation.toLocaleString('fr-FR')}
                    delta="j'aime reçus"
                />
            </div>

            {/* Next event */}
            {nextEvent ? (
                <NextEventCard event={nextEvent} />
            ) : (
                <DashCard
                    eyebrow="Prochain évènement"
                    title="Aucun évènement à venir"
                >
                    <p
                        className="font-mono text-[12.5px]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        Reviens bientôt — de nouveaux évènements arrivent.
                    </p>
                </DashCard>
            )}
        </div>
    );
}

export default function Dashboard({ stats, nextEvent }: DashboardProps) {
    const { auth } = usePage().props as { auth: { user: AuthUser | null } };
    const user = auth?.user;

    if (!user) {
        return null;
    }

    return (
        <>
            <Head title="Dashboard" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="overview" />
                    <main className="min-w-0">
                        <DashOverview
                            user={user}
                            stats={stats}
                            nextEvent={nextEvent}
                        />
                    </main>
                </div>
            </div>
        </>
    );
}
