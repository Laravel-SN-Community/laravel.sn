import { Head, Link, router, usePage } from '@inertiajs/react';
import {
    ArrowRight,
    Award,
    CalendarDays,
    Check,
    Link2,
    Loader2,
    MapPin,
    Presentation,
} from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { useInitials } from '@/hooks/use-initials';
import {
    register as registerRoute,
    show as eventsShow,
    unregister as unregisterRoute,
} from '@/routes/events';
import type { EventFull, EventRegistration, EventSummary } from '@/types/event';
import { formatEventDate } from '@/types/event';

type Props = {
    event: EventFull;
    userRegistration: EventRegistration | null;
    similarEvents: EventSummary[];
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

const TINTS = [
    '#0f7b4d',
    '#188a5c',
    '#0b6640',
    '#3ea777',
    '#126b44',
    '#1a9966',
];

function getTint(name: string): string {
    let hash = 0;

    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }

    return TINTS[Math.abs(hash) % TINTS.length];
}

export default function EventShow({
    event,
    userRegistration,
    similarEvents,
}: Props) {
    const { auth } = usePage().props as {
        auth: { user: { name: string } | null };
    };
    const getInitials = useInitials();
    const { day, month, year } = formatEventDate(event.starts_at);
    const isLoggedIn = !!auth?.user;
    const heroCtaRef = useRef<HTMLDivElement>(null);
    const [showBottomBar, setShowBottomBar] = useState(false);

    useEffect(() => {
        const el = heroCtaRef.current;

        if (!el) {
            return;
        }

        const observer = new IntersectionObserver(
            ([entry]) => setShowBottomBar(!entry.isIntersecting),
            { threshold: 0 },
        );
        observer.observe(el);

        return () => observer.disconnect();
    }, []);

    const endDate = event.ends_at ? formatEventDate(event.ends_at) : null;
    const dateLabel =
        endDate && endDate.day !== day
            ? `${day}–${endDate.day} ${month} ${year}`
            : `${day} ${month} ${year}`;

    const location = event.is_online
        ? 'En ligne'
        : [event.venue?.name, event.venue?.district].filter(Boolean).join(', ');

    return (
        <>
            <Head title={event.title} />

            {/* ── Hero ── */}
            <div className="relative overflow-hidden">
                {/* Grid — fades out at the bottom */}
                <div
                    className="pointer-events-none absolute inset-0"
                    style={{
                        backgroundImage:
                            'linear-gradient(rgba(15,123,77,.04) 1px, transparent 1px), linear-gradient(90deg, rgba(15,123,77,.04) 1px, transparent 1px)',
                        backgroundSize: '24px 24px',
                        WebkitMaskImage:
                            'linear-gradient(to bottom, black 0%, black 55%, transparent 95%)',
                        maskImage:
                            'linear-gradient(to bottom, black 0%, black 55%, transparent 95%)',
                    }}
                />
                {/* Green blur accent */}
                <div
                    className="pointer-events-none absolute -top-24 -right-24 h-105 w-105 rounded-full blur-3xl"
                    style={{ background: 'var(--sn-700)', opacity: 0.15 }}
                />

                <div className="relative mx-auto max-w-350 px-6 py-12 lg:px-10">
                    <div
                        className={
                            event.cover_url
                                ? 'grid items-center gap-10 lg:grid-cols-[1fr_420px]'
                                : undefined
                        }
                    >
                        {/* Left: text */}
                        <div>
                            {/* Breadcrumb */}
                            <div
                                className="mb-5 flex items-center gap-2 text-[11.5px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <Link
                                    href="/events"
                                    className="hover:underline"
                                >
                                    événements
                                </Link>
                                <span>/</span>
                                <span>
                                    {formatLabel(event.format).toLowerCase()}
                                </span>
                            </div>

                            {/* Badges */}
                            <div className="mb-4 flex flex-wrap items-center gap-2">
                                <span className="sn-badge sn-badge-primary">
                                    {formatLabel(event.format).toUpperCase()}
                                </span>
                                {event.ends_at &&
                                    endDate &&
                                    endDate.day !== day && (
                                        <span className="sn-badge sn-badge-neutral">
                                            · multi-jours
                                        </span>
                                    )}
                                {event.is_online && (
                                    <span className="sn-badge sn-badge-neutral">
                                        <Presentation
                                            size={13}
                                            style={{ color: 'var(--sn-muted)' }}
                                        />{' '}
                                        En ligne
                                    </span>
                                )}
                                {event.is_featured && (
                                    <span className="sn-badge sn-badge-neutral">
                                        <Award
                                            size={13}
                                            style={{ color: 'var(--sn-muted)' }}
                                        />{' '}
                                        à la une
                                    </span>
                                )}
                            </div>

                            {/* Title */}
                            <h1
                                className="text-[28px] leading-[1.1] font-semibold tracking-[-0.02em] lg:text-[38px]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                {event.title}
                            </h1>

                            {/* Description */}
                            <p
                                className="mt-4 max-w-[60ch] text-[16px] leading-relaxed italic lg:text-[18px]"
                                style={{
                                    color: 'var(--sn-muted)',
                                    fontFamily: 'Georgia, serif',
                                }}
                            >
                                {event.description}
                            </p>

                            {/* Meta row */}
                            <div
                                className="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-[13.5px]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                <span className="flex items-center gap-1.5">
                                    <CalendarDays
                                        size={15}
                                        style={{ color: 'var(--sn-accent)' }}
                                    />
                                    <b>{dateLabel}</b>
                                </span>
                                {location && (
                                    <>
                                        <span
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            ·
                                        </span>
                                        <span className="flex items-center gap-1.5">
                                            <MapPin
                                                size={15}
                                                style={{
                                                    color: 'var(--sn-accent)',
                                                }}
                                            />
                                            <b>
                                                {event.venue?.name ?? location}
                                            </b>
                                            {event.venue?.district && (
                                                <span
                                                    style={{
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    {event.venue.district}
                                                </span>
                                            )}
                                        </span>
                                    </>
                                )}
                            </div>

                            {/* CTAs */}
                            <div
                                ref={heroCtaRef}
                                className="mt-7 flex flex-wrap gap-3"
                            >
                                <HeroCta
                                    event={event}
                                    userRegistration={userRegistration}
                                    isLoggedIn={isLoggedIn}
                                />
                                {event.is_sponsored && (
                                    <button className="sn-btn sn-btn-secondary">
                                        Devenir sponsor
                                    </button>
                                )}
                            </div>
                        </div>

                        {/* Right: cover image */}
                        {event.cover_url && (
                            <div className="hidden lg:block">
                                <img
                                    src={event.cover_url}
                                    alt={event.title}
                                    className="w-full rounded-xl object-cover"
                                    style={{
                                        aspectRatio: '16/9',
                                        boxShadow:
                                            '0 8px 32px rgba(0,0,0,.22), 0 2px 8px rgba(0,0,0,.12)',
                                    }}
                                />
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* ── Speakers ── */}
            {event.speakers.length > 0 && (
                <section className="mx-auto max-w-350 px-6 py-10 lg:px-10">
                    <p
                        className="mb-5 text-[12px] tracking-[0.18em] uppercase"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {event.speakers.length} intervenant
                        {event.speakers.length > 1 ? 's' : ''}
                    </p>
                    <div className="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-3">
                        {event.speakers.map((s) => (
                            <div
                                key={s.id}
                                className="sn-card flex items-center gap-2.5 p-2.5"
                            >
                                <div
                                    className="grid h-9 w-9 shrink-0 place-items-center rounded-full text-[12px] font-semibold"
                                    style={{
                                        background: getTint(s.name),
                                        color: '#fff',
                                    }}
                                >
                                    {getInitials(s.name)}
                                </div>
                                <div className="min-w-0">
                                    <div
                                        className="truncate text-[13px] font-semibold"
                                        style={{ color: 'var(--sn-fg)' }}
                                    >
                                        {s.name}
                                    </div>
                                    {s.company && (
                                        <div
                                            className="truncate text-[11.5px]"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            {s.company}
                                        </div>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                </section>
            )}

            {/* ── Venue detail ── */}
            {event.venue && (
                <section
                    className="border-t"
                    style={{ borderColor: 'var(--sn-border)' }}
                >
                    <div className="mx-auto max-w-350 px-6 py-10 lg:px-10">
                        <p
                            className="mb-5 text-[12px] tracking-[0.18em] uppercase"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Lieu
                        </p>
                        <div className="flex items-start gap-4">
                            <div
                                className="grid h-10 w-10 shrink-0 place-items-center rounded-lg"
                                style={{ background: 'var(--sn-surface-2)' }}
                            >
                                <MapPin
                                    size={16}
                                    style={{ color: 'var(--sn-accent)' }}
                                />
                            </div>
                            <div>
                                <div
                                    className="text-[17px] font-semibold"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    {event.venue.name}
                                </div>
                                {event.venue.district && (
                                    <div
                                        className="mt-0.5 text-[13px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        {event.venue.district}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* ── Similar events ── */}
            {similarEvents.length > 0 && (
                <section
                    className="border-t"
                    style={{
                        borderColor: 'var(--sn-border)',
                        background: 'var(--sn-surface)',
                    }}
                >
                    <div className="mx-auto max-w-350 px-6 py-10 lg:px-10">
                        <p
                            className="mb-5 text-[12px] tracking-[0.18em] uppercase"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Événements similaires
                        </p>
                        <div className="grid gap-3 sm:grid-cols-3">
                            {similarEvents.map((e) => {
                                const d = formatEventDate(e.starts_at);
                                const loc = e.is_online
                                    ? 'En ligne'
                                    : (e.venue?.name ?? null);

                                return (
                                    <Link
                                        key={e.slug}
                                        href={eventsShow.url(e.slug)}
                                        className="sn-card sn-card-hover block p-4"
                                    >
                                        <div
                                            className="text-[11px] tracking-[0.15em] uppercase"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            {d.month} {d.year}
                                        </div>
                                        <div
                                            className="mt-1 text-[15px] font-semibold"
                                            style={{ color: 'var(--sn-fg)' }}
                                        >
                                            {e.title}
                                        </div>
                                        {loc && (
                                            <div
                                                className="mt-1 text-[11.5px]"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                            >
                                                {loc}
                                            </div>
                                        )}
                                        <div
                                            className="mt-3 flex items-center gap-1 text-[11px]"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        >
                                            Voir <ArrowRight size={11} />
                                        </div>
                                    </Link>
                                );
                            })}
                        </div>
                    </div>
                </section>
            )}

            {/* Spacer so fixed bottom bar doesn't overlap content on mobile */}
            <div className="pb-10 lg:pb-0" />
            <div className="h-16 lg:hidden" />

            {/* ── Registration bottom bar (mobile) ── */}
            <BottomBar
                event={event}
                userRegistration={userRegistration}
                isLoggedIn={isLoggedIn}
                visible={showBottomBar}
            />
        </>
    );
}

function HeroCta({
    event,
    userRegistration,
    isLoggedIn,
}: {
    event: EventFull;
    userRegistration: EventRegistration | null;
    isLoggedIn: boolean;
}) {
    const [loading, setLoading] = useState(false);

    function handleRegister() {
        setLoading(true);
        router.post(
            registerRoute.url(event.slug),
            {},
            {
                preserveScroll: true,
                onFinish: () => setLoading(false),
            },
        );
    }

    function handleCancel() {
        setLoading(true);
        router.delete(unregisterRoute.url(event.slug), {
            preserveScroll: true,
            onFinish: () => setLoading(false),
        });
    }

    if (userRegistration && userRegistration.status !== 'cancelled') {
        return (
            <>
                <div
                    className="flex items-center gap-2 rounded-lg px-4 py-2.5 text-[13.5px] font-medium"
                    style={{ background: 'var(--sn-700)', color: '#fff' }}
                >
                    <Check size={15} />
                    <span>Inscrit · {userRegistration.status_label}</span>
                </div>
                <button
                    onClick={handleCancel}
                    disabled={loading}
                    className="sn-btn sn-btn-ghost sn-btn-sm"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {loading ? (
                        <Loader2 size={13} className="animate-spin" />
                    ) : (
                        'Annuler'
                    )}
                </button>
            </>
        );
    }

    if (!isLoggedIn) {
        return (
            <Link
                href={`/login?redirect=/events/${event.slug}`}
                className="sn-btn sn-btn-primary"
            >
                Se connecter pour s'inscrire <ArrowRight size={14} />
            </Link>
        );
    }

    if (!event.registrations_open) {
        return (
            <div
                className="rounded-lg px-4 py-2.5 text-[12px]"
                style={{
                    background: 'var(--sn-surface)',
                    border: '1px solid var(--sn-border)',
                    color: 'var(--sn-muted)',
                }}
            >
                {event.is_full ? 'Complet' : 'Inscriptions fermées'}
            </div>
        );
    }

    return (
        <>
            <button
                onClick={handleRegister}
                disabled={loading}
                className="sn-btn sn-btn-primary"
            >
                {loading ? (
                    <Loader2 size={14} className="animate-spin" />
                ) : (
                    <>
                        {event.is_full ? "Liste d'attente" : "S'inscrire"}
                        <ArrowRight size={14} />
                    </>
                )}
            </button>
        </>
    );
}

function BottomBar({
    event,
    userRegistration,
    isLoggedIn,
    visible,
}: {
    event: EventFull;
    userRegistration: EventRegistration | null;
    isLoggedIn: boolean;
    visible: boolean;
}) {
    const [loading, setLoading] = useState(false);
    const { day, month } = formatEventDate(event.starts_at);

    function handleRegister() {
        setLoading(true);
        router.post(
            registerRoute.url(event.slug),
            {},
            {
                preserveScroll: true,
                onFinish: () => setLoading(false),
            },
        );
    }

    function handleCopy() {
        navigator.clipboard.writeText(window.location.href);
    }

    const alreadyRegistered =
        userRegistration && userRegistration.status !== 'cancelled';

    return (
        <div
            className="fixed inset-x-0 bottom-0 z-20 border-t lg:hidden"
            style={{
                background:
                    'color-mix(in oklch, var(--sn-bg) 85%, transparent)',
                backdropFilter: 'blur(14px)',
                WebkitBackdropFilter: 'blur(14px)',
                borderColor: 'var(--sn-border)',
                transform: visible ? 'translateY(0)' : 'translateY(100%)',
                transition: 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
            }}
        >
            <div className="flex items-center gap-3 px-4 py-3">
                <div className="min-w-0 flex-1">
                    <div
                        className="truncate text-[13px] font-semibold"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        {event.title}
                    </div>
                    <div
                        className="text-[11px]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {day} {month}
                        {event.venue?.name ? ` · ${event.venue.name}` : ''}
                    </div>
                </div>

                <button
                    onClick={handleCopy}
                    className="sn-btn sn-btn-ghost sn-btn-sm"
                    aria-label="Copier le lien"
                >
                    <Link2 size={13} />
                </button>

                {alreadyRegistered ? (
                    <div
                        className="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[13px] font-medium"
                        style={{ background: 'var(--sn-700)', color: '#fff' }}
                    >
                        <Check size={13} /> Inscrit
                    </div>
                ) : isLoggedIn && event.registrations_open ? (
                    <button
                        onClick={handleRegister}
                        disabled={loading}
                        className="sn-btn sn-btn-primary sn-btn-sm"
                    >
                        {loading ? (
                            <Loader2 size={13} className="animate-spin" />
                        ) : (
                            "S'inscrire"
                        )}
                    </button>
                ) : !isLoggedIn ? (
                    <Link
                        href="/login"
                        className="sn-btn sn-btn-primary sn-btn-sm"
                    >
                        Se connecter
                    </Link>
                ) : null}
            </div>
        </div>
    );
}
