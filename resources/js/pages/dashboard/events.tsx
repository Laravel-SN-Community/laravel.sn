import { Head, Link } from '@inertiajs/react';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { EVENTS } from '@/data/community';

export default function DashboardEvents() {
    const upcomingEvents = EVENTS.slice(0, 3);

    return (
        <>
            <Head title="Mes inscriptions" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="events" />

                    <main className="min-w-0 space-y-6">
                        <div>
                            <h1
                                className="mt-1 text-[32px] font-semibold tracking-[-0.02em]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                Mes inscriptions
                            </h1>
                        </div>

                        <div
                            className="rounded-xl p-6"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <div className="space-y-4">
                                {upcomingEvents.map((e) => (
                                    <div
                                        key={e.slug}
                                        className="flex flex-wrap items-center justify-between gap-4 border-b pb-4 last:border-0 last:pb-0"
                                        style={{
                                            borderColor: 'var(--sn-border)',
                                        }}
                                    >
                                        <div className="flex items-center gap-4">
                                            <div
                                                className="w-[52px] shrink-0 text-center"
                                                style={{
                                                    color: 'var(--sn-700)',
                                                }}
                                            >
                                                <div className="font-mono text-[10px] tracking-[0.15em] uppercase">
                                                    {e.month}
                                                </div>
                                                <div className="text-[28px] leading-none font-semibold tracking-[-0.03em]">
                                                    {e.day}
                                                </div>
                                            </div>
                                            <div className="min-w-0">
                                                <div
                                                    className="text-[15px] font-semibold tracking-tight"
                                                    style={{
                                                        color: 'var(--sn-fg)',
                                                    }}
                                                >
                                                    {e.title}
                                                </div>
                                                <div
                                                    className="mt-0.5 font-mono text-[11.5px]"
                                                    style={{
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    {e.where} · {e.time}
                                                </div>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3">
                                            <span
                                                className="font-mono text-[12px]"
                                                style={{
                                                    color: 'var(--sn-600)',
                                                }}
                                            >
                                                ● confirmé
                                            </span>
                                            <Link
                                                href={`/events/${e.slug}`}
                                                className="sn-btn sn-btn-ghost sn-btn-sm"
                                            >
                                                détails
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
