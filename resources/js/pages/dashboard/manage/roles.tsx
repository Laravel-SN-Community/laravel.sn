import { Head } from '@inertiajs/react';
import { Check, Info, Minus, ShieldCheck, UserCog, Users } from 'lucide-react';
import DashSidebar from '@/components/site/dashboard-sidebar';
import type { RoleMatrixRow } from '@/types/user';

type Props = {
    roles: RoleMatrixRow[];
    permissions: string[];
};

const ROLE_LABELS: Record<string, string> = {
    user: 'Membre',
    moderator: 'Modérateur',
    admin: 'Administrateur',
};

const PERMISSION_LABELS: Record<string, string> = {
    'articles:publish': 'Publier et refuser les articles',
    'articles:delete': 'Supprimer un article',
    'events:manage': 'Créer et modifier les évènements',
    'forum:moderate': 'Modérer le forum',
    'users:moderate': 'Suspendre et réactiver les comptes',
    'users:manage': 'Attribuer les rôles et supprimer les comptes',
};

function RoleIcon({ role }: { role: string }) {
    if (role === 'admin') {
        return <ShieldCheck size={14} style={{ color: 'var(--sn-accent)' }} />;
    }

    if (role === 'moderator') {
        return <UserCog size={14} style={{ color: '#b45309' }} />;
    }

    return <Users size={14} style={{ color: 'var(--sn-muted)' }} />;
}

export default function ManageRoles({ roles, permissions }: Props) {
    return (
        <>
            <Head title="Rôles et permissions — Laravel Sénégal" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="manage-roles" />

                    <main className="min-w-0 space-y-6">
                        <div>
                            <h1
                                className="mt-1 text-[24px] font-semibold tracking-[-0.02em] sm:text-[32px]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                Rôles et permissions
                            </h1>
                            <p
                                className="mt-1 text-[13px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Ce que chaque rôle peut faire sur la plateforme.
                            </p>
                        </div>

                        {/* Role summary */}
                        <div className="grid gap-3 sm:grid-cols-3">
                            {roles.map((role) => (
                                <div
                                    key={role.id}
                                    className="rounded-xl px-4 py-3"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                    }}
                                >
                                    <div className="flex items-center gap-1.5">
                                        <RoleIcon role={role.name} />
                                        <span
                                            className="text-[14px] font-semibold"
                                            style={{ color: 'var(--sn-fg)' }}
                                        >
                                            {ROLE_LABELS[role.name] ??
                                                role.name}
                                        </span>
                                    </div>
                                    <div
                                        className="mt-1 font-mono text-[11.5px]"
                                        style={{ color: 'var(--sn-muted)' }}
                                    >
                                        {role.users_count}{' '}
                                        {role.users_count === 1
                                            ? 'membre'
                                            : 'membres'}
                                        {' · '}
                                        {role.name === 'admin'
                                            ? 'toutes permissions'
                                            : `${role.permissions.length} permission${role.permissions.length === 1 ? '' : 's'}`}
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Matrix */}
                        <div
                            className="overflow-x-auto rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <table className="w-full min-w-[560px] border-collapse">
                                <thead>
                                    <tr
                                        style={{
                                            borderBottom:
                                                '1px solid var(--sn-border)',
                                        }}
                                    >
                                        <th
                                            className="px-6 py-3 text-left font-mono text-[10px] font-normal tracking-[0.18em] uppercase"
                                            style={{
                                                color: 'var(--sn-muted)',
                                            }}
                                        >
                                            Permission
                                        </th>
                                        {roles.map((role) => (
                                            <th
                                                key={role.id}
                                                className="px-4 py-3 text-center font-mono text-[10px] font-normal tracking-[0.18em] uppercase"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                            >
                                                {ROLE_LABELS[role.name] ??
                                                    role.name}
                                            </th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {permissions.map((permission, i) => (
                                        <tr
                                            key={permission}
                                            style={{
                                                borderBottom:
                                                    i === permissions.length - 1
                                                        ? 'none'
                                                        : '1px solid var(--sn-border)',
                                            }}
                                        >
                                            <td className="px-6 py-3.5">
                                                <div
                                                    className="text-[13.5px] font-medium"
                                                    style={{
                                                        color: 'var(--sn-fg)',
                                                    }}
                                                >
                                                    {PERMISSION_LABELS[
                                                        permission
                                                    ] ?? permission}
                                                </div>
                                                <div
                                                    className="mt-0.5 font-mono text-[11px]"
                                                    style={{
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    {permission}
                                                </div>
                                            </td>
                                            {roles.map((role) => {
                                                const granted =
                                                    role.permissions.includes(
                                                        permission,
                                                    );

                                                return (
                                                    <td
                                                        key={role.id}
                                                        className="px-4 py-3.5 text-center"
                                                    >
                                                        {granted ? (
                                                            <Check
                                                                size={16}
                                                                className="inline"
                                                                style={{
                                                                    color: 'var(--sn-accent)',
                                                                }}
                                                                aria-label="Autorisé"
                                                            />
                                                        ) : (
                                                            <Minus
                                                                size={16}
                                                                className="inline"
                                                                style={{
                                                                    color: 'var(--sn-border)',
                                                                }}
                                                                aria-label="Non autorisé"
                                                            />
                                                        )}
                                                    </td>
                                                );
                                            })}
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {/* Note */}
                        <div
                            className="flex gap-2.5 rounded-xl px-4 py-3 text-[12.5px]"
                            style={{
                                background: 'var(--sn-surface-2)',
                                color: 'var(--sn-muted)',
                            }}
                        >
                            <Info size={15} className="mt-0.5 shrink-0" />
                            <p>
                                Cette grille est en lecture seule. Elle est
                                définie dans{' '}
                                <code
                                    className="font-mono text-[11.5px]"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    RolesAndPermissionsSeeder
                                </code>{' '}
                                afin qu'elle reste identique sur tous les
                                environnements. Les administrateurs contournent
                                toutes les permissions. Le rôle d'un membre se
                                change depuis la page Utilisateurs.
                            </p>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
