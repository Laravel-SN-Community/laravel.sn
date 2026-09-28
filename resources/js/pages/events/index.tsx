import { Head, Link, router } from '@inertiajs/react';
import { ArrowRight, Award, MapPin } from 'lucide-react';
import { index as eventsIndex, show as eventsShow } from '@/routes/events';
import type { EventSummary, PaginatedEvents } from '@/types/event';
import { formatEventDate } from '@/types/event';

type Filters = { tab: string };

type Props = {
    events: PaginatedEvents;
    filters: Filters;
};

function formatLabel(format: string): string {
    const map: Record<string, string> = {
        meetup: 'Meetup',
        workshop: 'Workshop',
        conference: 'Conférence',
        hackathon: 'Hackathon',
        webinar: 'Webinaire',
    };

    return map[format] ?? format;
}

export default function EventsIndex({ events, filters }: Props) {
    const tab = filters.tab ?? 'upcoming';

    function go(newTab: string) {
        router.get(
            eventsIndex.url(),
            { tab: newTab },
            { preserveState: true, replace: true },
        );
    }

    const featured = events.data.find((e) => e.is_featured) ?? events.data[0];
    const rest = featured ? events.data.filter((e) => e !== featured) : [];

    return (
        <>
            <Head title="Événements" />

            {/* Page header */}
            <section className="mx-auto max-w-[1400px] px-6 pt-10 pb-6 lg:px-10 lg:pt-16">
                <div className="flex flex-wrap items-end justify-between gap-6">
                    <div>
                        <h1
                            className="mt-2 text-[34px] font-semibold tracking-tight"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Événements
                        </h1>
                        <p
                            className="mt-4 text-[16px] leading-relaxed lg:text-[17px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Rencontres, workshops et conférences.
                        </p>
                    </div>
                </div>
            </section>

            {/* Tabs */}
            <section className="mx-auto max-w-[1400px] px-6 pb-8 lg:px-10">
                <div className="flex items-center gap-4 text-[12px]">
                    {(['upcoming', 'past'] as const).map((t) => (
                        <button
                            key={t}
                            onClick={() => go(t)}
                            className="rounded-md px-3 py-1 transition-colors"
                            style={{
                                background:
                                    tab === t ? 'var(--sn-fg)' : 'transparent',
                                color:
                                    tab === t
                                        ? 'var(--sn-bg)'
                                        : 'var(--sn-muted)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {t === 'upcoming' ? 'À venir' : 'Passés'}
                        </button>
                    ))}
                    <span
                        className="ml-auto"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {events.total} événement{events.total !== 1 ? 's' : ''}
                    </span>
                </div>
            </section>

            {/* Featured event */}
            {featured && (
                <section className="mx-auto max-w-[1400px] px-6 pb-10 lg:px-10">
                    <Link
                        href={eventsShow.url(featured.slug)}
                        className="group block"
                    >
                        <FeaturedCard event={featured} />
                    </Link>
                </section>
            )}

            {/* Rest of events */}
            {rest.length > 0 && (
                <section className="mx-auto max-w-[1400px] px-6 pb-20 lg:px-10">
                    <h3
                        className="mb-4 text-[13px] font-semibold tracking-wide uppercase"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {tab === 'upcoming'
                            ? 'Prochains rendez-vous'
                            : 'Archives'}
                    </h3>
                    <div className="grid gap-4 md:grid-cols-2">
                        {rest.map((e) => (
                            <Link
                                key={e.slug}
                                href={eventsShow.url(e.slug)}
                                className="block rounded-xl p-5 transition-all hover:-translate-y-0.5"
                                style={{
                                    background: 'var(--sn-surface)',
                                    border: '1px solid var(--sn-border)',
                                }}
                            >
                                <EventCard event={e} />
                            </Link>
                        ))}
                    </div>
                </section>
            )}

            {/* Pagination */}
            {events.last_page > 1 && (
                <section className="mx-auto max-w-[1400px] px-6 pb-10 lg:px-10">
                    <div className="flex justify-center gap-2 text-[12px]">
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
                </section>
            )}

            {events.data.length === 0 && (
                <section className="mx-auto max-w-[1400px] px-6 pb-20 lg:px-10">
                    <div
                        className="rounded-xl p-12 text-center"
                        style={{
                            background: 'var(--sn-surface)',
                            border: '1px solid var(--sn-border)',
                        }}
                    >
                        <p
                            className="text-[15px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            {tab === 'upcoming'
                                ? 'Aucun événement à venir pour le moment.'
                                : 'Aucun événement passé.'}
                        </p>
                    </div>
                </section>
            )}

            <div className="pb-10" />
        </>
    );
}

function FeaturedCard({ event }: { event: EventSummary }) {
    const { day, month, year } = formatEventDate(event.starts_at);
    const location = event.is_online
        ? 'En ligne'
        : [event.venue?.name, event.venue?.district]
              .filter(Boolean)
              .join(' · ');

    return (
        <div
            className="grid overflow-hidden rounded-2xl lg:grid-cols-[300px_1fr]"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            {/* Date block */}
            <div
                className="flex flex-col items-center justify-center p-8 text-center lg:p-10"
                style={{ background: 'var(--sn-700)', color: '#fff' }}
            >
                <div className="text-[12px] tracking-[0.2em] uppercase opacity-80">
                    {month}
                </div>
                <div className="my-1 text-[88px] leading-[0.9] font-semibold tracking-[-0.04em]">
                    {day}
                </div>
                <div className="text-[12px] opacity-80">{year}</div>
                <div
                    className="mt-4 rounded-full px-3 py-1 text-[10.5px] tracking-[0.15em] uppercase"
                    style={{ background: 'rgba(255,255,255,0.15)' }}
                >
                    {formatLabel(event.format)}
                </div>
            </div>

            {/* Details */}
            <div className="p-8 lg:p-10">
                <div
                    className="flex items-center gap-2 text-[11.5px] tracking-[0.18em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {event.is_featured && (
                        <>
                            <span className="flex items-center gap-1">
                                <Award size={15} />à la une
                            </span>
                            <span>·</span>
                        </>
                    )}
                    <span>{formatLabel(event.format)}</span>
                </div>
                <h2 className="mt-3 text-[28px] leading-[1.05] font-semibold tracking-[-0.02em] group-hover:underline lg:text-[34px]">
                    {event.title}
                </h2>
                <p
                    className="mt-3 max-w-[60ch] text-[15px] leading-relaxed"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {event.description}
                </p>
                <div
                    className="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-[12.5px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {location && (
                        <span className="flex items-center gap-1.5">
                            <MapPin size={15} />
                            {location}
                        </span>
                    )}
                </div>
                <div className="mt-6 flex items-center gap-3">
                    <span className="sn-btn sn-btn-primary">
                        Voir les détails <ArrowRight size={14} />
                    </span>
                </div>
            </div>
        </div>
    );
}

function EventCard({ event }: { event: EventSummary }) {
    const { day, month, time } = formatEventDate(event.starts_at);
    const location = event.is_online
        ? 'En ligne'
        : [event.venue?.name, event.venue?.district]
              .filter(Boolean)
              .join(' · ');

    return (
        <div className="flex items-start gap-5">
            <div className="w-[64px] flex-shrink-0 text-center">
                <div
                    className="text-[10px] tracking-[0.18em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {month}
                </div>
                <div
                    className="mt-0.5 text-[36px] leading-none font-semibold tracking-[-0.03em]"
                    style={{ color: 'var(--sn-700)' }}
                >
                    {day}
                </div>
                <div
                    className="mt-0.5 text-[10px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {time}
                </div>
            </div>
            <div className="min-w-0 flex-1">
                <div
                    className="flex items-center gap-2 text-[10.5px] tracking-[0.15em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    <span
                        className="rounded px-1.5 py-0.5"
                        style={{
                            background: 'var(--sn-surface-2)',
                            color: 'var(--sn-fg)',
                        }}
                    >
                        {formatLabel(event.format)}
                    </span>
                    {location && (
                        <>
                            <span>·</span>
                            <span>{location}</span>
                        </>
                    )}
                </div>
                <h4 className="mt-2 text-[17px] leading-[1.25] font-semibold tracking-[-0.01em]">
                    {event.title}
                </h4>
            </div>
        </div>
    );
}
