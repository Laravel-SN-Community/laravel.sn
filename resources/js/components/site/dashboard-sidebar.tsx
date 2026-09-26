import { Link, router, usePage } from '@inertiajs/react';
import {
    // Bell, // TODO: réactiver avec la section Notifications
    CalendarDays,
    FileText,
    LayoutDashboard,
    LogOut,
    Settings,
    ShieldCheck,
    UserCircle,
    UserCog,
    UsersRound,
} from 'lucide-react';
import { useEffect, useRef } from 'react';
import { useInitials } from '@/hooks/use-initials';
import { logout } from '@/routes';
import type { Auth } from '@/types/auth';

const USER_SECTIONS = [
    {
        id: 'overview',
        label: "Vue d'ensemble",
        Icon: LayoutDashboard,
        href: '/dashboard',
    },
    {
        id: 'profile',
        label: 'Mon profil',
        Icon: UserCircle,
        href: '/dashboard/profile',
    },
    {
        id: 'articles',
        label: 'Mes articles',
        Icon: FileText,
        href: '/dashboard/articles',
    },
    // TODO: réactiver quand ces fonctionnalités seront implémentées
    // {
    //     id: 'events',
    //     label: 'Mes inscriptions',
    //     Icon: CalendarDays,
    //     href: '/dashboard/events',
    // },
    // {
    //     id: 'notifications',
    //     label: 'Notifications',
    //     Icon: Bell,
    //     href: '/dashboard/notifications',
    // },
    {
        id: 'settings',
        label: 'Paramètres',
        Icon: Settings,
        href: '/dashboard/settings',
    },
] as const;

const MANAGE_SECTIONS = [
    {
        id: 'manage-articles',
        label: 'Articles',
        Icon: FileText,
        href: '/dashboard/manage/articles',
    },
    {
        id: 'manage-events',
        label: 'Évènements',
        Icon: CalendarDays,
        href: '/dashboard/manage/events',
    },
    {
        id: 'manage-users',
        label: 'Utilisateurs',
        Icon: UsersRound,
        href: '/dashboard/manage/users',
    },
] as const;

// Réservé aux administrateurs (permission users:manage).
const ADMIN_SECTIONS = [
    {
        id: 'manage-roles',
        label: 'Rôles',
        Icon: ShieldCheck,
        href: '/dashboard/manage/roles',
    },
] as const;

type SectionId =
    | (typeof USER_SECTIONS)[number]['id']
    | (typeof MANAGE_SECTIONS)[number]['id']
    | (typeof ADMIN_SECTIONS)[number]['id']
    // Sections temporairement masquées (voir USER_SECTIONS) — à réimplémenter
    | 'events'
    | 'notifications';

let navHasInitialized = false;

const TINTS = ['#0f7b4d', '#188a5c', '#0b6640', '#3ea777'];

function getTint(name: string): string {
    let hash = 0;

    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }

    return TINTS[Math.abs(hash) % TINTS.length];
}

function NavLink({
    href,
    icon: Icon,
    label,
    active,
}: {
    href: string;
    icon: React.ElementType;
    label: string;
    active: boolean;
}) {
    return (
        <Link
            href={href}
            className="flex items-center gap-2.5 rounded-md px-3 py-2 text-[13.5px] font-medium transition-colors"
            style={{
                background: active ? 'var(--sn-surface-2)' : 'transparent',
                color: active ? 'var(--sn-fg)' : 'var(--sn-muted)',
            }}
        >
            <Icon
                size={15}
                strokeWidth={active ? 2 : 1.5}
                style={{
                    color: active ? 'var(--sn-600)' : 'inherit',
                    flexShrink: 0,
                }}
            />
            {label}
        </Link>
    );
}

export default function DashSidebar({ section }: { section: SectionId }) {
    const { auth } = usePage().props as unknown as { auth: Auth };
    const user = auth?.user ?? null;
    const role = auth?.role ?? null;
    const getInitials = useInitials();
    const activeItemRef = useRef<HTMLSpanElement>(null);

    useEffect(() => {
        const behavior = navHasInitialized ? 'instant' : 'smooth';
        navHasInitialized = true;

        activeItemRef.current?.scrollIntoView({
            behavior,
            inline: 'center',
            block: 'nearest',
        });
    }, [section]);

    if (!user) {
        return null;
    }

    const init = getInitials(user.name);
    const tint = getTint(user.name);
    const isAdmin = role === 'admin';
    const isMod = role === 'moderator' || isAdmin;

    function handleLogout() {
        router.post(logout());
    }

    const manageItems = [
        ...(isMod ? MANAGE_SECTIONS : []),
        ...(isAdmin ? ADMIN_SECTIONS : []),
    ];

    const allMobileItems = [...USER_SECTIONS, ...manageItems];

    return (
        <aside className="min-w-0 lg:sticky lg:top-24 lg:self-start">
            {/* ── Mobile: horizontal scrollable tab bar ── */}
            <div
                className="mb-5 overflow-x-auto lg:hidden"
                style={{ borderBottom: '1px solid var(--sn-border)' }}
            >
                <div className="flex min-w-max items-center gap-0.5 pt-1 pb-2">
                    {allMobileItems.map((s) => {
                        const active = s.id === section;

                        return (
                            <span
                                key={s.id}
                                ref={active ? activeItemRef : undefined}
                            >
                                <Link
                                    href={s.href}
                                    className="flex shrink-0 items-center gap-1.5 rounded-lg px-3 py-2 text-[13px] font-medium whitespace-nowrap transition-colors"
                                    style={{
                                        background: active
                                            ? 'color-mix(in srgb, var(--sn-600) 12%, transparent)'
                                            : 'transparent',
                                        color: active
                                            ? 'var(--sn-600)'
                                            : 'var(--sn-muted)',
                                    }}
                                >
                                    <s.Icon
                                        size={14}
                                        strokeWidth={active ? 2 : 1.5}
                                        style={{ flexShrink: 0 }}
                                    />
                                    {s.label}
                                </Link>
                            </span>
                        );
                    })}
                </div>
            </div>

            {/* ── Desktop: vertical sidebar ── */}
            <div className="hidden lg:block">
                {/* User card */}
                <div
                    className="mb-3 rounded-xl p-4"
                    style={{
                        background: 'var(--sn-surface)',
                        border: '1px solid var(--sn-border)',
                    }}
                >
                    <div className="flex items-center gap-3">
                        <div
                            className="relative h-10 w-10 shrink-0 overflow-hidden rounded-full"
                            style={{
                                background: user.avatar ? 'transparent' : tint,
                            }}
                        >
                            {user.avatar ? (
                                <img
                                    src={user.avatar}
                                    alt={user.name}
                                    className="h-full w-full object-cover"
                                />
                            ) : (
                                <span className="absolute inset-0 flex items-center justify-center text-[13px] font-bold tracking-wide text-white">
                                    {init}
                                </span>
                            )}
                        </div>
                        <div className="min-w-0">
                            <div
                                className="flex items-center gap-1.5 text-[14px] font-semibold"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                <span className="truncate">{user.name}</span>
                                {role === 'admin' && (
                                    <span
                                        title="Administrateur"
                                        className="inline-flex shrink-0"
                                    >
                                        <ShieldCheck
                                            size={13}
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        />
                                    </span>
                                )}
                                {role === 'moderator' && (
                                    <span
                                        title="Modérateur"
                                        className="inline-flex shrink-0"
                                    >
                                        <UserCog
                                            size={13}
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        />
                                    </span>
                                )}
                            </div>
                            <div
                                className="truncate text-[11.5px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                {user.email}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Mon espace */}
                <div
                    className="mb-0.5 px-3 pt-3 pb-1 font-mono text-[10px] tracking-[0.18em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Mon espace
                </div>
                <nav className="space-y-0.5">
                    {USER_SECTIONS.map((s) => (
                        <NavLink
                            key={s.id}
                            href={s.href}
                            icon={s.Icon}
                            label={s.label}
                            active={s.id === section}
                        />
                    ))}
                </nav>

                {/* Modération section — mods and admins only */}
                {isMod && (
                    <>
                        <div
                            className="mb-0.5 px-3 pt-5 pb-1 font-mono text-[10px] tracking-[0.18em] uppercase"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Modération
                        </div>
                        <nav className="space-y-0.5">
                            {manageItems.map((s) => (
                                <NavLink
                                    key={s.id}
                                    href={s.href}
                                    icon={s.Icon}
                                    label={s.label}
                                    active={s.id === section}
                                />
                            ))}
                        </nav>
                    </>
                )}

                <button
                    onClick={handleLogout}
                    className="mt-4 flex w-full items-center gap-2.5 rounded-md px-3 py-2 text-[13.5px] font-medium transition-opacity hover:opacity-70"
                    style={{ color: 'var(--destructive)' }}
                >
                    <LogOut
                        size={15}
                        strokeWidth={1.5}
                        style={{ flexShrink: 0 }}
                    />
                    Se déconnecter
                </button>
            </div>
        </aside>
    );
}
