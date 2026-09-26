import { Head, Link, router } from '@inertiajs/react';
import {
    Ban,
    Search,
    ShieldCheck,
    ShieldOff,
    Trash2,
    UserCog,
    X,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import UserController from '@/actions/App/Http/Controllers/UserController';
import { ConfirmModal } from '@/components/site/confirm-modal';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { useInitials } from '@/hooks/use-initials';
import { fmtDate } from '@/lib/utils';
import type { ManageUser, ManageUserStats, UserRole } from '@/types/user';

type PaginatedUsers = {
    data: ManageUser[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
};

type Props = {
    users: PaginatedUsers;
    stats: ManageUserStats;
    filters: { q: string | null; role: UserRole | null; tab: string };
    roles: UserRole[];
    canManage: boolean;
};

const TABS = [
    { id: 'all', label: 'Tous', statKey: 'total' },
    { id: 'moderators', label: 'Équipe', statKey: 'moderators' },
    { id: 'suspended', label: 'Suspendus', statKey: 'suspended' },
] as const;

const ROLE_LABELS: Record<UserRole, string> = {
    user: 'Membre',
    moderator: 'Modérateur',
    admin: 'Administrateur',
};

const DURATIONS = [
    { value: '3', label: '3 jours' },
    { value: '7', label: '7 jours' },
    { value: '30', label: '30 jours' },
    { value: '90', label: '90 jours' },
    { value: '', label: 'Définitive' },
] as const;

const TINTS = ['#0f7b4d', '#188a5c', '#0b6640', '#3ea777'];

function getTint(name: string): string {
    let hash = 0;

    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }

    return TINTS[Math.abs(hash) % TINTS.length];
}

type Query = { q: string | null; role: UserRole | null; tab: string };

// Module-level so the debounced effect below depends only on its inputs.
function visit(query: Query) {
    router.get(
        UserController.manageIndex.url(),
        {
            q: query.q || undefined,
            role: query.role ?? undefined,
            tab: query.tab,
        },
        { preserveState: true, preserveScroll: true, replace: true },
    );
}

function roleStyle(role: UserRole): { bg: string; color: string } {
    if (role === 'admin') {
        return {
            bg: 'color-mix(in oklch, var(--sn-600) 14%, transparent)',
            color: 'var(--sn-700)',
        };
    }

    if (role === 'moderator') {
        return {
            bg: 'color-mix(in oklch, #f59e0b 14%, transparent)',
            color: '#b45309',
        };
    }

    return { bg: 'var(--sn-surface-2)', color: 'var(--sn-muted)' };
}

export default function ManageUsers({
    users,
    stats,
    filters,
    roles,
    canManage,
}: Props) {
    const tab = filters.tab ?? 'all';
    const [search, setSearch] = useState(filters.q ?? '');
    const [suspendTarget, setSuspendTarget] = useState<ManageUser | null>(null);
    const [liftTarget, setLiftTarget] = useState<ManageUser | null>(null);
    const [deleteTarget, setDeleteTarget] = useState<ManageUser | null>(null);
    const [roleTarget, setRoleTarget] = useState<{
        user: ManageUser;
        role: UserRole;
    } | null>(null);
    const [reason, setReason] = useState('');
    const [duration, setDuration] = useState<string>('7');

    // Debounce the search box so typing doesn't fire a visit per keystroke.
    // The guard compares against the server-rendered value rather than
    // tracking "first render": a visit here drops the page param, and under
    // StrictMode's double-invoked effects a render-count guard would fire on
    // mount and bounce every paginated page back to page 1.
    useEffect(() => {
        if (search === (filters.q ?? '')) {
            return;
        }

        const timeout = setTimeout(() => {
            visit({ q: search || null, role: filters.role, tab });
        }, 350);

        return () => clearTimeout(timeout);
    }, [search, filters.q, filters.role, tab]);

    function go(next: Partial<Query>) {
        visit({ q: search || null, role: filters.role, tab, ...next });
    }

    function openSuspend(user: ManageUser) {
        setReason('');
        setDuration('7');
        setSuspendTarget(user);
    }

    function confirmSuspend() {
        if (!suspendTarget || reason.trim() === '') {
            return;
        }

        router.post(
            UserController.suspend.url({ user: suspendTarget.id }),
            {
                reason: reason.trim(),
                duration_days: duration === '' ? null : Number(duration),
            },
            {
                preserveScroll: true,
                onSuccess: () => setSuspendTarget(null),
            },
        );
    }

    function confirmLift() {
        if (!liftTarget) {
            return;
        }

        router.delete(UserController.unsuspend.url({ user: liftTarget.id }), {
            preserveScroll: true,
            onFinish: () => setLiftTarget(null),
        });
    }

    function confirmRole() {
        if (!roleTarget) {
            return;
        }

        router.patch(
            UserController.updateRole.url({ user: roleTarget.user.id }),
            { role: roleTarget.role },
            { preserveScroll: true, onFinish: () => setRoleTarget(null) },
        );
    }

    function confirmDelete() {
        if (!deleteTarget) {
            return;
        }

        router.delete(
            UserController.manageDestroy.url({ user: deleteTarget.id }),
            { onFinish: () => setDeleteTarget(null) },
        );
    }

    return (
        <>
            <Head title="Gestion des utilisateurs — Laravel Sénégal" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="manage-users" />

                    <main className="min-w-0 space-y-6">
                        <div>
                            <h1
                                className="mt-1 text-[24px] font-semibold tracking-[-0.02em] sm:text-[32px]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                Gestion des utilisateurs
                            </h1>
                            <p
                                className="mt-1 text-[13px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                {canManage
                                    ? 'Attribuez les rôles, suspendez ou réactivez les comptes de la communauté.'
                                    : 'Suspendez ou réactivez les comptes de la communauté.'}
                            </p>
                        </div>

                        {/* Stats */}
                        <div className="grid grid-cols-2 gap-3 lg:grid-cols-4">
                            <StatTile label="Membres" value={stats.total} />
                            <StatTile
                                label="Équipe"
                                value={stats.moderators}
                                accent="var(--sn-700)"
                            />
                            <StatTile
                                label="Suspendus"
                                value={stats.suspended}
                                accent={
                                    stats.suspended > 0
                                        ? 'var(--destructive)'
                                        : undefined
                                }
                            />
                            <StatTile
                                label="30 derniers jours"
                                value={stats.recent}
                            />
                        </div>

                        {/* Search + role filter */}
                        <div className="flex flex-wrap items-center gap-2">
                            <div className="relative min-w-[220px] flex-1">
                                <Search
                                    size={14}
                                    className="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2"
                                    style={{ color: 'var(--sn-muted)' }}
                                />
                                <input
                                    type="search"
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    placeholder="Rechercher par nom, identifiant ou e-mail…"
                                    className="w-full rounded-md py-2 pr-9 pl-9 font-mono text-[13px] outline-none"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                        color: 'var(--sn-fg)',
                                    }}
                                />
                                {search !== '' && (
                                    <button
                                        onClick={() => setSearch('')}
                                        className="absolute top-1/2 right-2.5 -translate-y-1/2"
                                        aria-label="Effacer la recherche"
                                    >
                                        <X
                                            size={14}
                                            style={{ color: 'var(--sn-muted)' }}
                                        />
                                    </button>
                                )}
                            </div>

                            <select
                                value={filters.role ?? ''}
                                onChange={(e) =>
                                    go({
                                        role:
                                            (e.target.value as UserRole) ||
                                            null,
                                    })
                                }
                                className="max-w-[180px] rounded-md px-3 py-2 font-mono text-[13px]"
                                style={{
                                    background: 'var(--sn-surface)',
                                    border: '1px solid var(--sn-border)',
                                    color: 'var(--sn-fg)',
                                }}
                            >
                                <option value="">Tous les rôles</option>
                                {roles.map((r) => (
                                    <option key={r} value={r}>
                                        {ROLE_LABELS[r]}
                                    </option>
                                ))}
                            </select>
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
                                const count = stats[t.statKey];

                                return (
                                    <button
                                        key={t.id}
                                        onClick={() => go({ tab: t.id })}
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

                        {/* User list */}
                        <div
                            className="overflow-hidden rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {users.data.length === 0 ? (
                                <div
                                    className="px-6 py-12 text-center font-mono text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {filters.q
                                        ? `Aucun utilisateur ne correspond à « ${filters.q} ».`
                                        : 'Aucun utilisateur dans cette catégorie.'}
                                </div>
                            ) : (
                                users.data.map((u, i) => (
                                    <UserRow
                                        key={u.id}
                                        user={u}
                                        last={i === users.data.length - 1}
                                        canManage={canManage}
                                        roles={roles}
                                        onRoleChange={(role) =>
                                            setRoleTarget({ user: u, role })
                                        }
                                        onSuspend={() => openSuspend(u)}
                                        onLift={() => setLiftTarget(u)}
                                        onDelete={() => setDeleteTarget(u)}
                                    />
                                ))
                            )}
                        </div>

                        {/* Pagination */}
                        {users.last_page > 1 && (
                            <div className="flex justify-center gap-2 font-mono text-[12px]">
                                {users.prev_page_url && (
                                    <Link
                                        href={users.prev_page_url}
                                        className="sn-btn sn-btn-ghost sn-btn-sm"
                                    >
                                        ← Précédent
                                    </Link>
                                )}
                                <span
                                    className="flex items-center px-3"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {users.current_page} / {users.last_page}
                                </span>
                                {users.next_page_url && (
                                    <Link
                                        href={users.next_page_url}
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

            {/* Suspend */}
            <ConfirmModal
                open={suspendTarget !== null}
                onClose={() => setSuspendTarget(null)}
                onConfirm={confirmSuspend}
                icon={<Ban size={18} style={{ color: 'var(--destructive)' }} />}
                iconBg="color-mix(in oklch, var(--destructive) 10%, transparent)"
                title="Suspendre le compte"
                description={
                    <>
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            {suspendTarget?.name}
                        </strong>{' '}
                        ne pourra plus se connecter ni publier tant que la
                        suspension est active.
                    </>
                }
                extra={
                    <div className="space-y-3">
                        <div>
                            <div
                                className="mb-1.5 font-mono text-[10.5px] tracking-[0.18em] uppercase"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Motif
                            </div>
                            <textarea
                                value={reason}
                                onChange={(e) => setReason(e.target.value)}
                                rows={3}
                                maxLength={255}
                                placeholder="Visible par le membre sur l'écran de connexion."
                                className="w-full resize-none rounded-md px-3 py-2 text-[13px] outline-none"
                                style={{
                                    background: 'var(--sn-bg)',
                                    border: '1px solid var(--sn-border)',
                                    color: 'var(--sn-fg)',
                                }}
                            />
                        </div>
                        <div>
                            <div
                                className="mb-1.5 font-mono text-[10.5px] tracking-[0.18em] uppercase"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Durée
                            </div>
                            <select
                                value={duration}
                                onChange={(e) => setDuration(e.target.value)}
                                className="w-full rounded-md px-3 py-2 font-mono text-[13px]"
                                style={{
                                    background: 'var(--sn-bg)',
                                    border: '1px solid var(--sn-border)',
                                    color: 'var(--sn-fg)',
                                }}
                            >
                                {DURATIONS.map((d) => (
                                    <option key={d.label} value={d.value}>
                                        {d.label}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>
                }
                confirmLabel="Suspendre"
                confirmStyle={{
                    background: 'var(--destructive)',
                    color: '#fff',
                    opacity: reason.trim() === '' ? 0.5 : 1,
                }}
            />

            {/* Lift suspension */}
            <ConfirmModal
                open={liftTarget !== null}
                onClose={() => setLiftTarget(null)}
                onConfirm={confirmLift}
                icon={
                    <ShieldOff size={18} style={{ color: 'var(--sn-700)' }} />
                }
                iconBg="color-mix(in oklch, var(--sn-accent) 12%, transparent)"
                title="Lever la suspension"
                description={
                    <>
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            {liftTarget?.name}
                        </strong>{' '}
                        retrouvera immédiatement l'accès à son compte.
                    </>
                }
                confirmLabel="Lever la suspension"
                confirmStyle={{
                    background: 'var(--sn-accent)',
                    color: 'var(--sn-accent-fg)',
                }}
            />

            {/* Role change */}
            <ConfirmModal
                open={roleTarget !== null}
                onClose={() => setRoleTarget(null)}
                onConfirm={confirmRole}
                icon={<UserCog size={18} style={{ color: 'var(--sn-700)' }} />}
                iconBg="color-mix(in oklch, var(--sn-accent) 12%, transparent)"
                title="Changer le rôle"
                description={
                    <>
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            {roleTarget?.user.name}
                        </strong>{' '}
                        deviendra{' '}
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            {roleTarget ? ROLE_LABELS[roleTarget.role] : ''}
                        </strong>
                        {roleTarget?.role === 'admin' &&
                            ' — un administrateur contourne toutes les permissions.'}
                    </>
                }
                confirmLabel="Confirmer"
                confirmStyle={{
                    background: 'var(--sn-accent)',
                    color: 'var(--sn-accent-fg)',
                }}
            />

            {/* Delete */}
            <ConfirmModal
                open={deleteTarget !== null}
                onClose={() => setDeleteTarget(null)}
                onConfirm={confirmDelete}
                icon={
                    <Trash2 size={18} style={{ color: 'var(--destructive)' }} />
                }
                iconBg="color-mix(in oklch, var(--destructive) 10%, transparent)"
                title="Supprimer le compte"
                description={
                    <>
                        Le compte de{' '}
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            {deleteTarget?.name}
                        </strong>{' '}
                        sera supprimé définitivement. Cette action est
                        irréversible.
                    </>
                }
                confirmLabel="Supprimer"
                confirmStyle={{
                    background: 'var(--destructive)',
                    color: '#fff',
                }}
            />
        </>
    );
}

function StatTile({
    label,
    value,
    accent,
}: {
    label: string;
    value: number;
    accent?: string | undefined;
}) {
    return (
        <div
            className="rounded-xl px-4 py-3"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            <div
                className="font-mono text-[10px] tracking-[0.18em] uppercase"
                style={{ color: 'var(--sn-muted)' }}
            >
                {label}
            </div>
            <div
                className="mt-1 text-[22px] font-semibold tracking-[-0.02em] tabular-nums"
                style={{ color: accent ?? 'var(--sn-fg)' }}
            >
                {value}
            </div>
        </div>
    );
}

function UserRow({
    user: u,
    last,
    canManage,
    roles,
    onRoleChange,
    onSuspend,
    onLift,
    onDelete,
}: {
    user: ManageUser;
    last: boolean;
    canManage: boolean;
    roles: UserRole[];
    onRoleChange: (role: UserRole) => void;
    onSuspend: () => void;
    onLift: () => void;
    onDelete: () => void;
}) {
    const getInitials = useInitials();
    const badge = roleStyle(u.role);
    const tint = getTint(u.name);

    // Mirrors SuspendUser/LiftUserSuspension: admins are untouchable, and
    // only an admin (canManage) may act on a fellow moderator. Hiding the
    // control beats showing one that only ever returns a validation error.
    const canModerateTarget =
        u.role !== 'admin' && (canManage || u.role !== 'moderator');

    return (
        <div
            className="flex flex-wrap items-start justify-between gap-4 px-6 py-5"
            style={{
                borderBottom: last ? 'none' : '1px solid var(--sn-border)',
            }}
        >
            <div className="flex min-w-0 flex-1 items-start gap-3">
                <div
                    className="relative h-10 w-10 shrink-0 overflow-hidden rounded-full"
                    style={{
                        background: u.avatar ? 'transparent' : tint,
                        opacity: u.is_suspended ? 0.45 : 1,
                    }}
                >
                    {u.avatar ? (
                        <img
                            src={u.avatar}
                            alt={u.name}
                            className="h-full w-full object-cover"
                        />
                    ) : (
                        <span className="absolute inset-0 flex items-center justify-center text-[13px] font-bold tracking-wide text-white">
                            {getInitials(u.name)}
                        </span>
                    )}
                </div>

                <div className="min-w-0">
                    <div className="flex flex-wrap items-center gap-2">
                        <Link
                            href={`/@${u.username}`}
                            className="text-[15px] font-semibold tracking-tight hover:underline"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            {u.name}
                        </Link>
                        <span
                            className="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10.5px] font-medium"
                            style={{
                                background: badge.bg,
                                color: badge.color,
                            }}
                        >
                            {u.role === 'admin' && <ShieldCheck size={10} />}
                            {u.role === 'moderator' && <UserCog size={10} />}
                            {ROLE_LABELS[u.role]}
                        </span>
                        {u.is_suspended && (
                            <span
                                className="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10.5px] font-medium"
                                style={{
                                    background:
                                        'color-mix(in oklch, var(--destructive) 12%, transparent)',
                                    color: 'var(--destructive)',
                                }}
                            >
                                <Ban size={10} />
                                Suspendu
                            </span>
                        )}
                        {u.email_verified_at === null && (
                            <span
                                className="rounded px-1.5 py-0.5 text-[10px] font-medium uppercase"
                                style={{
                                    background: 'var(--sn-surface-2)',
                                    color: 'var(--sn-muted)',
                                }}
                            >
                                Non vérifié
                            </span>
                        )}
                    </div>

                    <div
                        className="mt-1 text-[11.5px]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        @{u.username} · {u.email}
                        {u.created_at && (
                            <> · inscrit le {fmtDate(u.created_at)}</>
                        )}
                        {u.last_active_at && (
                            <> · vu le {fmtDate(u.last_active_at)}</>
                        )}
                    </div>

                    {u.is_suspended && (
                        <div
                            className="mt-2 rounded-lg px-3 py-2 text-[11.5px]"
                            style={{
                                background:
                                    'color-mix(in oklch, var(--destructive) 6%, transparent)',
                                color: 'var(--sn-muted)',
                            }}
                        >
                            <span style={{ color: 'var(--destructive)' }}>
                                {u.suspended_until
                                    ? `Suspendu jusqu'au ${fmtDate(u.suspended_until)}`
                                    : 'Suspension définitive'}
                            </span>
                            {u.suspension_reason && (
                                <> — {u.suspension_reason}</>
                            )}
                            {u.suspended_by && (
                                <> · par {u.suspended_by.name}</>
                            )}
                        </div>
                    )}
                </div>
            </div>

            <div className="flex shrink-0 flex-wrap items-center gap-1.5">
                {canManage && (
                    <select
                        value={u.role}
                        onChange={(e) =>
                            onRoleChange(e.target.value as UserRole)
                        }
                        aria-label={`Rôle de ${u.name}`}
                        className="rounded-lg px-2.5 py-1.5 font-mono text-[12px]"
                        style={{
                            background: 'var(--sn-surface-2)',
                            border: '1px solid var(--sn-border)',
                            color: 'var(--sn-fg)',
                        }}
                    >
                        {roles.map((r) => (
                            <option key={r} value={r}>
                                {ROLE_LABELS[r]}
                            </option>
                        ))}
                    </select>
                )}

                {canModerateTarget &&
                    (u.is_suspended ? (
                        <button
                            onClick={onLift}
                            className="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[12px] font-semibold transition-colors"
                            style={{
                                background:
                                    'color-mix(in oklch, var(--sn-accent) 12%, transparent)',
                                color: 'var(--sn-700)',
                            }}
                        >
                            <ShieldOff size={13} />
                            Réactiver
                        </button>
                    ) : (
                        <button
                            onClick={onSuspend}
                            className="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[12px] font-semibold transition-colors"
                            style={{
                                background:
                                    'color-mix(in oklch, var(--destructive) 8%, transparent)',
                                color: 'var(--destructive)',
                            }}
                        >
                            <Ban size={13} />
                            Suspendre
                        </button>
                    ))}

                {canManage && u.role !== 'admin' && (
                    <button
                        onClick={onDelete}
                        className="flex h-8 w-8 items-center justify-center rounded-lg transition-colors"
                        style={{ color: 'var(--sn-muted)' }}
                        title="Supprimer"
                        onMouseEnter={(e) => {
                            e.currentTarget.style.background =
                                'color-mix(in oklch, var(--destructive) 10%, transparent)';
                            e.currentTarget.style.color = 'var(--destructive)';
                        }}
                        onMouseLeave={(e) => {
                            e.currentTarget.style.background = 'transparent';
                            e.currentTarget.style.color = 'var(--sn-muted)';
                        }}
                    >
                        <Trash2 size={14} />
                    </button>
                )}
            </div>
        </div>
    );
}
