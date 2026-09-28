import { Head } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import { RESOURCES } from '@/data/community';

const TYPE_ICONS: Record<string, string> = {
    guide: '📚',
    cheatsheet: '📄',
    template: '🗂️',
    vidéo: '🎬',
};

const TYPES = ['tous', 'guide', 'cheatsheet', 'template', 'vidéo'];
const LEVELS = ['tous', 'débutant', 'intermédiaire', 'avancé'];

export default function Ressources() {
    const [q, setQ] = useState('');
    const [typeFilter, setTypeFilter] = useState('tous');
    const [levelFilter, setLevelFilter] = useState('tous');

    const filtered = useMemo(() => {
        return RESOURCES.filter((r) => {
            if (typeFilter !== 'tous' && r.type !== typeFilter) {
                return false;
            }

            if (levelFilter !== 'tous' && r.level !== levelFilter) {
                return false;
            }

            if (q.trim()) {
                const s = q.toLowerCase();

                return (
                    r.title.toLowerCase().includes(s) ||
                    r.desc.toLowerCase().includes(s) ||
                    r.author.toLowerCase().includes(s)
                );
            }

            return true;
        });
    }, [q, typeFilter, levelFilter]);

    return (
        <>
            <Head title="Ressources" />

            <section className="mx-auto max-w-[1400px] px-6 pt-10 pb-8 lg:px-10 lg:pt-16">
                <h1
                    className="mt-2 text-[34px] font-semibold tracking-tight"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    Ressources
                </h1>
                <p
                    className="mt-3 text-[16px] leading-relaxed lg:text-[17px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Guides, antisèches, templates, vidéos.
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
                                placeholder="Chercher une ressource…"
                                className="flex-1 bg-transparent py-2.5 text-[14px] outline-none"
                                style={{ color: 'var(--sn-fg)' }}
                            />
                        </div>
                    </div>

                    <div className="mt-4 flex flex-wrap gap-2 font-mono text-[12px]">
                        <span
                            className="self-center pr-1"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            type :
                        </span>
                        {TYPES.map((t) => (
                            <button
                                key={t}
                                onClick={() => setTypeFilter(t)}
                                className="rounded-md px-2.5 py-1 transition-colors"
                                style={
                                    typeFilter === t
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
                                {t}
                            </button>
                        ))}
                    </div>

                    <div className="mt-3 flex flex-wrap gap-2 font-mono text-[12px]">
                        <span
                            className="self-center pr-1"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            niveau :
                        </span>
                        {LEVELS.map((l) => (
                            <button
                                key={l}
                                onClick={() => setLevelFilter(l)}
                                className="rounded-md px-2.5 py-1 transition-colors"
                                style={
                                    levelFilter === l
                                        ? {
                                              background: 'var(--sn-fg)',
                                              color: 'var(--sn-bg)',
                                          }
                                        : {
                                              background: 'var(--sn-surface-2)',
                                              color: 'var(--sn-muted)',
                                              border: '1px solid var(--sn-border)',
                                          }
                                }
                            >
                                {l}
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
                            Essaie de modifier tes filtres.
                        </p>
                    </div>
                ) : (
                    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        {filtered.map((r) => (
                            <div
                                key={r.slug}
                                className="relative flex flex-col rounded-xl p-5"
                                style={{
                                    background: 'var(--sn-surface)',
                                    border: '1px solid var(--sn-border)',
                                }}
                            >
                                <div className="absolute top-4 right-4">
                                    <span
                                        className="rounded px-1.5 py-0.5 font-mono text-[10.5px] tracking-[0.1em] uppercase"
                                        style={{
                                            background: 'var(--sn-surface-2)',
                                            color: 'var(--sn-muted)',
                                            border: '1px solid var(--sn-border)',
                                        }}
                                    >
                                        {r.type}
                                    </span>
                                </div>

                                <div className="text-[28px]">
                                    {TYPE_ICONS[r.type] ?? '📌'}
                                </div>

                                <div
                                    className="mt-3 pr-16 text-[16px] font-semibold tracking-tight"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    {r.title}
                                </div>

                                <p
                                    className="mt-2 flex-1 text-[13.5px] leading-relaxed"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {r.desc}
                                </p>

                                <div
                                    className="mt-4 flex items-center justify-between border-t pt-3 font-mono text-[11.5px]"
                                    style={{
                                        borderColor: 'var(--sn-border)',
                                        color: 'var(--sn-muted)',
                                    }}
                                >
                                    <div className="flex items-center gap-2">
                                        <span>{r.meta}</span>
                                        <span>·</span>
                                        <span>{r.level}</span>
                                    </div>
                                    <span>{r.author}</span>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </section>
        </>
    );
}
