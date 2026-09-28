import { Head, Link } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import { MEMBERS } from '@/data/community';

const CITIES = ['toutes', 'Dakar', 'Saint-Louis', 'Thiès'];

export default function Membres() {
    const [q, setQ] = useState('');
    const [city, setCity] = useState('toutes');

    const filtered = useMemo(() => {
        return MEMBERS.filter((m) => {
            if (city !== 'toutes' && m.city !== city) {
                return false;
            }

            if (q.trim()) {
                const s = q.toLowerCase();

                return (
                    m.name.toLowerCase().includes(s) ||
                    m.role.toLowerCase().includes(s) ||
                    m.company.toLowerCase().includes(s) ||
                    m.tags.some((t) => t.toLowerCase().includes(s))
                );
            }

            return true;
        });
    }, [q, city]);

    return (
        <>
            <Head title="Membres" />

            <section className="mx-auto max-w-[1400px] px-6 pt-10 pb-8 lg:px-10 lg:pt-16">
                <h1
                    className="mt-2 text-[34px] font-semibold tracking-tight"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    Communauté
                </h1>
                <p
                    className="mt-3 text-[16px] leading-relaxed lg:text-[17px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Les développeur·ses Laravel du Sénégal. De Wave à Volkeno,
                    de la junior à la CTO.
                </p>
            </section>

            <section className="mx-auto max-w-[1400px] px-6 pb-6 lg:px-10">
                <div className="sn-card p-4 md:p-5">
                    <div className="flex flex-wrap items-center gap-3">
                        <div
                            className="flex min-w-[240px] flex-1 items-center gap-2 rounded-md px-3"
                            style={{
                                background: 'var(--sn-surface-2)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <svg
                                width="14"
                                height="14"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                style={{
                                    color: 'var(--sn-muted)',
                                    flexShrink: 0,
                                }}
                            >
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.35-4.35" />
                            </svg>
                            <input
                                value={q}
                                onChange={(e) => setQ(e.target.value)}
                                placeholder="Chercher un membre…"
                                className="flex-1 bg-transparent py-2.5 text-[14px] outline-none"
                                style={{ color: 'var(--sn-fg)' }}
                            />
                        </div>
                    </div>
                    <div className="mt-4 flex flex-wrap gap-2 font-mono text-[12px]">
                        {CITIES.map((c) => (
                            <button
                                key={c}
                                onClick={() => setCity(c)}
                                className="rounded-md px-2.5 py-1 transition-colors"
                                style={
                                    city === c
                                        ? {
                                              background: 'var(--sn-accent)',
                                              color: 'var(--sn-accent-fg)',
                                          }
                                        : {
                                              background: 'var(--sn-surface-2)',
                                              color: 'var(--sn-muted)',
                                              border: '1px solid var(--sn-border)',
                                          }
                                }
                            >
                                {c}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            <section className="mx-auto max-w-[1400px] px-6 pb-20 lg:px-10">
                {filtered.length === 0 ? (
                    <div className="sn-card p-10 text-center">
                        <p
                            className="text-[15px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Essaie de modifier ta recherche.
                        </p>
                    </div>
                ) : (
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {filtered.map((m) => (
                            <Link
                                key={m.slug}
                                href={`/membres/${m.slug}`}
                                className="block rounded-xl p-5 transition-all hover:-translate-y-0.5"
                                style={{
                                    background: 'var(--sn-surface)',
                                    border: '1px solid var(--sn-border)',
                                }}
                            >
                                <div className="flex items-center gap-3">
                                    <div
                                        className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full font-mono text-[14px] font-semibold"
                                        style={{
                                            background: m.tint,
                                            color: '#fff',
                                        }}
                                    >
                                        {m.init}
                                    </div>
                                    <div className="min-w-0">
                                        <div
                                            className="truncate text-[15px] font-semibold"
                                            style={{ color: 'var(--sn-fg)' }}
                                        >
                                            {m.name}
                                        </div>
                                        <div
                                            className="truncate font-mono text-[12px]"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            {m.role}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    className="mt-2 font-mono text-[11.5px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {m.company} · {m.city}
                                </div>

                                <div className="mt-3 flex flex-wrap gap-1.5">
                                    {m.tags.map((tag) => (
                                        <span
                                            key={tag}
                                            className="rounded px-1.5 py-0.5 font-mono text-[10.5px]"
                                            style={{
                                                background:
                                                    'var(--sn-surface-2)',
                                                color: 'var(--sn-muted)',
                                                border: '1px solid var(--sn-border)',
                                            }}
                                        >
                                            {tag}
                                        </span>
                                    ))}
                                </div>

                                <div
                                    className="mt-4 flex items-center gap-4 border-t pt-3 font-mono text-[11.5px]"
                                    style={{
                                        borderColor: 'var(--sn-border)',
                                        color: 'var(--sn-muted)',
                                    }}
                                >
                                    <span>✎ {m.articles} articles</span>
                                    <span>☷ {m.events} évènements</span>
                                </div>
                            </Link>
                        ))}
                    </div>
                )}
            </section>
        </>
    );
}
