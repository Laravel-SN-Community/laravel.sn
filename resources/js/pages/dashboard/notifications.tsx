import { Head } from '@inertiajs/react';
import DashSidebar from '@/components/site/dashboard-sidebar';

interface Notification {
    id: number;
    from: string;
    fromInit: string;
    fromTint: string;
    action: string;
    subject: string;
    when: string;
    unread: boolean;
}

const NOTIFICATIONS: Notification[] = [
    {
        id: 1,
        from: 'Khady Ndiaye',
        fromInit: 'KN',
        fromTint: '#3ea777',
        action: 'a aimé ton article',
        subject: 'Pest 4 + GitHub Actions',
        when: 'il y a 12 min',
        unread: true,
    },
    {
        id: 2,
        from: 'Omar Sy',
        fromInit: 'OS',
        fromTint: '#188a5c',
        action: 'a commenté',
        subject: 'Modèles sans N+1',
        when: 'il y a 2h',
        unread: true,
    },
    {
        id: 3,
        from: 'Système',
        fromInit: 'SY',
        fromTint: '#0f7b4d',
        action: 'Ton inscription au',
        subject: 'Meetup Dakar #09 confirmée',
        when: 'hier',
        unread: false,
    },
    {
        id: 4,
        from: 'Ibrahima Ba',
        fromInit: 'IB',
        fromTint: '#0b6640',
        action: 'a partagé ton article',
        subject: 'Filament v4',
        when: 'il y a 3 jours',
        unread: false,
    },
];

export default function DashboardNotifications() {
    return (
        <>
            <Head title="Notifications" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="notifications" />

                    <main className="min-w-0 space-y-6">
                        <div className="flex flex-wrap items-end justify-between gap-4">
                            <div>
                                <h1
                                    className="mt-1 text-[32px] font-semibold tracking-[-0.02em]"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    Notifications
                                </h1>
                            </div>
                            <button className="sn-btn sn-btn-ghost sn-btn-sm">
                                Tout marquer comme lu
                            </button>
                        </div>

                        <div
                            className="rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {NOTIFICATIONS.map((n, i) => (
                                <div
                                    key={n.id}
                                    className="flex items-start gap-4 px-5 py-4"
                                    style={{
                                        borderBottom:
                                            i < NOTIFICATIONS.length - 1
                                                ? '1px solid var(--sn-border)'
                                                : undefined,
                                    }}
                                >
                                    {n.unread ? (
                                        <div className="mt-2 shrink-0">
                                            <div
                                                className="h-1.5 w-1.5 rounded-full"
                                                style={{
                                                    background: 'var(--sn-600)',
                                                }}
                                            />
                                        </div>
                                    ) : (
                                        <div className="mt-2 shrink-0">
                                            <div className="h-1.5 w-1.5" />
                                        </div>
                                    )}

                                    <div
                                        className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full font-mono text-[11px] font-semibold"
                                        style={{
                                            background: n.fromTint,
                                            color: '#fff',
                                        }}
                                    >
                                        {n.fromInit}
                                    </div>

                                    <div className="min-w-0 flex-1">
                                        <div
                                            className="text-[13.5px]"
                                            style={{ color: 'var(--sn-fg)' }}
                                        >
                                            <span className="font-semibold">
                                                {n.from}
                                            </span>
                                            {' · '}
                                            {n.action}{' '}
                                            <span className="font-semibold">
                                                "{n.subject}"
                                            </span>
                                        </div>
                                        <div
                                            className="mt-0.5 font-mono text-[11.5px]"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            {n.when}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
