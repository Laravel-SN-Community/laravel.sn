import { router } from '@inertiajs/react';
import {
    ArrowDown,
    ArrowLeft,
    ArrowUp,
    BookOpen,
    CalendarDays,
    CornerDownLeft,
    MessageSquare,
    Moon,
    Search,
    Sun,
    User,
} from 'lucide-react';
import { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import type { ElementType } from 'react';
import { GithubIcon } from '@/components/site/brand-icons';
import { useAppearance } from '@/hooks/use-appearance';

// ─── Types ────────────────────────────────────────────────────────────────────

type Scope = 'articles' | 'threads' | 'members' | null;

type PaletteItemType =
    'scope-selector' | 'nav' | 'action' | 'command' | 'result';

interface PaletteItem {
    type: PaletteItemType;
    group?: string;
    label: string;
    description?: string;
    hint?: string;
    Icon: ElementType;
    href?: string;
    scopeTarget?: NonNullable<Scope>;
    newTab?: boolean;
    avatar?: string | null;
    onAction?: () => void;
}

interface SearchResult {
    id: number;
    title?: string;
    name?: string;
    username?: string;
    author?: string | null;
    avatar?: string | null;
    url: string;
}

interface SearchResults {
    articles: SearchResult[];
    threads: SearchResult[];
    members: SearchResult[];
}

interface CommandPaletteProps {
    open: boolean;
    onClose: () => void;
}

// ─── Config ───────────────────────────────────────────────────────────────────

const SCOPE_CONFIG: Record<
    NonNullable<Scope>,
    { label: string; Icon: ElementType; placeholder: string }
> = {
    articles: {
        label: 'Articles',
        Icon: BookOpen,
        placeholder: 'Rechercher un article…',
    },
    threads: {
        label: 'Forum',
        Icon: MessageSquare,
        placeholder: 'Rechercher un fil de discussion…',
    },
    members: {
        label: 'Membres',
        Icon: User,
        placeholder: 'Rechercher un membre…',
    },
};

const SLASH_COMMANDS: Record<string, NonNullable<Scope>> = {
    '/articles': 'articles',
    '/forum': 'threads',
    '/membres': 'members',
};

const SCOPE_SELECTORS: PaletteItem[] = [
    {
        type: 'scope-selector',
        group: 'Rechercher dans',
        label: 'Articles',
        Icon: BookOpen,
        scopeTarget: 'articles',
    },
    {
        type: 'scope-selector',
        group: 'Rechercher dans',
        label: 'Forum',
        Icon: MessageSquare,
        scopeTarget: 'threads',
    },
    {
        type: 'scope-selector',
        group: 'Rechercher dans',
        label: 'Membres',
        Icon: User,
        scopeTarget: 'members',
    },
];

const NAV_ITEMS: PaletteItem[] = [
    {
        type: 'nav',
        group: 'Navigation',
        label: 'Articles',
        description: 'Actualités et tutoriels.',
        Icon: BookOpen,
        href: '/articles',
    },
    {
        type: 'nav',
        group: 'Navigation',
        label: 'Forum',
        description: 'Apprenez, découvrez, partagez.',
        Icon: MessageSquare,
        href: '/forum',
    },
    {
        type: 'nav',
        group: 'Navigation',
        label: 'Événements',
        description: 'Meetups et rencontres.',
        Icon: CalendarDays,
        href: '/events',
    },
];

const ACTION_ITEMS: PaletteItem[] = [
    {
        type: 'action',
        group: 'Actions',
        label: 'GitHub — Laravel SN Community',
        description: 'github.com/Laravel-SN-Community',
        Icon: GithubIcon,
        href: 'https://github.com/Laravel-SN-Community/laravel.sn',
        newTab: true,
    },
];

// ─── Helpers ──────────────────────────────────────────────────────────────────

function searchResultsToItems(
    results: SearchResults,
    scope: Scope,
): PaletteItem[] {
    const items: PaletteItem[] = [];

    if (!scope || scope === 'articles') {
        results.articles.forEach((a) =>
            items.push({
                type: 'result',
                group: 'Articles',
                label: a.title ?? '',
                hint: a.author ? `par ${a.author}` : '',
                Icon: BookOpen,
                href: a.url,
            }),
        );
    }

    if (!scope || scope === 'threads') {
        results.threads.forEach((t) =>
            items.push({
                type: 'result',
                group: 'Forum',
                label: t.title ?? '',
                hint: t.author ? `par ${t.author}` : '',
                Icon: MessageSquare,
                href: t.url,
            }),
        );
    }

    if (!scope || scope === 'members') {
        results.members.forEach((m) =>
            items.push({
                type: 'result',
                group: 'Membres',
                label: m.name ?? '',
                hint: `@${m.username}`,
                Icon: User,
                href: m.url,
                avatar: m.avatar ?? null,
            }),
        );
    }

    return items;
}

function navigate(item: PaletteItem, onClose: () => void) {
    if (!item.href) {
        return;
    }

    onClose();

    if (item.newTab) {
        window.open(item.href, '_blank', 'noopener,noreferrer');
    } else {
        router.visit(item.href);
    }
}

// ─── Component ────────────────────────────────────────────────────────────────

export default function CommandPalette({ open, onClose }: CommandPaletteProps) {
    const inputRef = useRef<HTMLInputElement>(null);
    const listRef = useRef<HTMLDivElement>(null);
    const [q, setQ] = useState('');
    const [cursor, setCursor] = useState(0);
    const [scope, setScope] = useState<Scope>(null);
    const [searchResults, setSearchResults] = useState<SearchResults | null>(
        null,
    );
    const [loading, setLoading] = useState(false);
    const { resolvedAppearance, updateAppearance } = useAppearance();
    const [prevOpen, setPrevOpen] = useState(open);
    const [rendered, setRendered] = useState(open);
    const [closing, setClosing] = useState(false);

    if (prevOpen !== open) {
        setPrevOpen(open);

        if (open) {
            setRendered(true);
            setClosing(false);
        } else if (rendered) {
            setClosing(true);
            setQ('');
            setScope(null);
            setSearchResults(null);
            setCursor(0);
        }
    }

    const isSearching = q.trim().length >= 2;

    const commandItems: PaletteItem[] = useMemo(
        () => [
            {
                type: 'command' as const,
                group: 'Commandes',
                label: 'Changer de thème',
                Icon: resolvedAppearance === 'dark' ? Sun : Moon,
                onAction: () =>
                    updateAppearance(
                        resolvedAppearance === 'dark' ? 'light' : 'dark',
                    ),
            },
        ],
        [resolvedAppearance, updateAppearance],
    );

    // Build the flat list of all keyboard-navigable items
    const items: PaletteItem[] = useMemo(() => {
        if (scope && isSearching && searchResults) {
            return searchResultsToItems(searchResults, scope);
        }

        if (scope) {
            return [];
        }

        if (isSearching && searchResults) {
            return searchResultsToItems(searchResults, null);
        }

        return [
            ...SCOPE_SELECTORS,
            ...NAV_ITEMS,
            ...ACTION_ITEMS,
            ...commandItems,
        ];
    }, [scope, isSearching, searchResults, commandItems]);

    // Build groups map from flat items list
    const groups = useMemo(() => {
        const ungrouped: (PaletteItem & { idx: number })[] = [];
        const grouped = new Map<string, (PaletteItem & { idx: number })[]>();

        items.forEach((item, idx) => {
            if (!item.group) {
                ungrouped.push({ ...item, idx });
            } else {
                if (!grouped.has(item.group)) {
                    grouped.set(item.group, []);
                }

                grouped.get(item.group)!.push({ ...item, idx });
            }
        });

        const result: Array<
            | { type: 'ungrouped'; items: (PaletteItem & { idx: number })[] }
            | {
                  type: 'group';
                  label: string;
                  items: (PaletteItem & { idx: number })[];
              }
        > = [];

        if (ungrouped.length) {
            result.push({ type: 'ungrouped', items: ungrouped });
        }

        grouped.forEach((groupItems, label) =>
            result.push({ type: 'group', label, items: groupItems }),
        );

        return result;
    }, [items]);

    // Focus input on open / scope change
    useEffect(() => {
        if (!open) {
            return;
        }

        const id = setTimeout(() => inputRef.current?.focus(), 0);

        return () => clearTimeout(id);
    }, [open, scope]);

    // Unmount after close animation
    useEffect(() => {
        if (!closing) {
            return;
        }

        const t = setTimeout(() => {
            setRendered(false);
            setClosing(false);
        }, 130);

        return () => clearTimeout(t);
    }, [closing]);

    // Scroll active item into view
    useEffect(() => {
        const el = listRef.current?.querySelector(
            `[data-idx="${cursor}"]`,
        ) as HTMLElement | null;
        el?.scrollIntoView({ block: 'nearest' });
    }, [cursor]);

    // Debounced search
    useEffect(() => {
        if (!isSearching) {
            return;
        }

        const controller = new AbortController();

        const id = setTimeout(() => {
            const params = new URLSearchParams({ q: q.trim() });

            if (scope) {
                params.set('scope', scope);
            }

            fetch(`/search?${params}`, {
                signal: controller.signal,
                headers: { Accept: 'application/json' },
            })
                .then((r) => r.json())
                .then((data: SearchResults) => {
                    setSearchResults(data);
                    setCursor(0);
                })
                .catch(() => {})
                .finally(() => setLoading(false));
        }, 300);

        return () => {
            clearTimeout(id);
            controller.abort();
        };
    }, [q, scope, isSearching]);

    const activateScope = useCallback((s: NonNullable<Scope>) => {
        setScope(s);
        setQ('');
        setSearchResults(null);
        setCursor(0);
    }, []);

    const handleBack = useCallback(() => {
        setScope(null);
        setQ('');
        setSearchResults(null);
        setCursor(0);
    }, []);

    const handleSelect = useCallback(
        (item: PaletteItem) => {
            if (item.type === 'scope-selector' && item.scopeTarget) {
                activateScope(item.scopeTarget);
            } else if (item.onAction) {
                item.onAction();
                onClose();
            } else {
                navigate(item, onClose);
            }
        },
        [activateScope, onClose],
    );

    const handleChange = useCallback((val: string) => {
        for (const [cmd, scopeTarget] of Object.entries(SLASH_COMMANDS)) {
            if (val === cmd || val.startsWith(cmd + ' ')) {
                const rest = val.slice(cmd.length).trimStart();
                setScope(scopeTarget);
                setQ(rest);
                setSearchResults(null);
                setCursor(0);

                return;
            }
        }

        setQ(val);
        setCursor(0);

        if (val.trim().length < 2) {
            setSearchResults(null);
            setLoading(false);
        } else {
            setLoading(true);
        }
    }, []);

    const onKey = useCallback(
        (e: React.KeyboardEvent) => {
            switch (e.key) {
                case 'Escape':
                    e.preventDefault();

                    if (scope) {
                        handleBack();
                    } else {
                        onClose();
                    }

                    break;
                case 'Backspace':
                    if (scope && q === '') {
                        e.preventDefault();
                        handleBack();
                    }

                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    setCursor((c) =>
                        items.length ? (c + 1) % items.length : 0,
                    );
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    setCursor((c) =>
                        items.length
                            ? (c - 1 + items.length) % items.length
                            : 0,
                    );
                    break;
                case 'Enter': {
                    e.preventDefault();
                    const hovered = listRef.current?.querySelector(
                        '.palette-item:hover',
                    ) as HTMLElement | null;
                    const hoveredIdx = hovered
                        ? parseInt(hovered.getAttribute('data-idx') ?? '')
                        : NaN;
                    const target = !isNaN(hoveredIdx)
                        ? items[hoveredIdx]
                        : items[cursor];

                    if (target) {
                        handleSelect(target);
                    }

                    break;
                }
            }
        },
        [items, cursor, scope, q, onClose, handleBack, handleSelect],
    );

    if (!rendered) {
        return null;
    }

    const scopeConfig = scope ? SCOPE_CONFIG[scope] : null;

    return (
        <>
            <style>{`
                @keyframes palette-in {
                    from { transform: translateX(-50%) translateY(-16px); opacity: 0; }
                    to   { transform: translateX(-50%) translateY(0);     opacity: 1; }
                }
                @keyframes palette-out {
                    from { transform: translateX(-50%) translateY(0);     opacity: 1; }
                    to   { transform: translateX(-50%) translateY(-12px); opacity: 0; }
                }
                .palette-overlay {
                    position: fixed; inset: 0; z-index: 50;
                    background: rgba(12,20,18,.48);
                    backdrop-filter: blur(2px);
                }
                .palette-overlay-in  { animation: sn-overlay-in  .12s var(--sn-ease) both; }
                .palette-overlay-out { animation: sn-overlay-out .12s var(--sn-ease) both; }
                .palette-dialog {
                    position: fixed;
                    top: 72px; left: 50%;
                    transform: translateX(-50%);
                    z-index: 51;
                    width: calc(100vw - 2rem);
                    max-width: 640px;
                }
                .palette-dialog-in  { animation: palette-in  .15s var(--sn-ease) both; }
                .palette-dialog-out { animation: palette-out .12s var(--sn-ease) both; }
                /* On mobile (touch, no keyboard): sit near the top like the
                   menu sheet, and drop keyboard affordances (footer hints +
                   the active-row highlight). */
                @media (max-width: 767px) {
                    .palette-dialog { top: 16px; }
                    .palette-footer { display: none; }
                    .palette-item[data-active="true"] { background: transparent; }
                }
                .palette-box {
                    background: var(--sn-surface);
                    border: 1px solid var(--sn-border);
                    border-radius: 14px;
                    box-shadow: 0 24px 64px -16px rgba(12,20,18,.22), 0 0 0 1px rgba(12,20,18,.04);
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                }
                .palette-input-row {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    height: 52px;
                    padding: 0 16px;
                    border-bottom: 1px solid var(--sn-border);
                    flex-shrink: 0;
                }
                .palette-input {
                    flex: 1;
                    background: transparent;
                    border: none;
                    outline: none;
                    font-size: 15px;
                    color: var(--sn-fg);
                    line-height: 1;
                }
                .palette-input::placeholder { color: var(--sn-muted); }
                .palette-list {
                    flex: 1;
                    overflow-y: auto;
                    overscroll-behavior: contain;
                    padding: 6px 0;
                    max-height: 56vh;
                }
                .palette-list::-webkit-scrollbar { width: 4px; }
                .palette-list::-webkit-scrollbar-track { background: transparent; }
                .palette-list::-webkit-scrollbar-thumb {
                    background: var(--sn-border);
                    border-radius: 2px;
                }
                .palette-section-label {
                    padding: 10px 16px 4px;
                    font-size: 11px;
                    font-weight: 600;
                    letter-spacing: .06em;
                    text-transform: uppercase;
                    color: var(--sn-muted);
                }
                .palette-item {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 0 8px;
                    margin: 0 4px;
                    height: 44px;
                    cursor: pointer;
                    border-radius: 8px;
                    position: relative;
                    text-align: left;
                    width: calc(100% - 8px);
                    border: none;
                    background: transparent;
                    color: var(--sn-fg);
                    transition: none;
                }
                .palette-item:hover {
                    background: var(--sn-surface-2);
                }
                .palette-item[data-active="true"] {
                    background: color-mix(in srgb, var(--sn-accent) 9%, var(--sn-surface-2));
                }
                .palette-item-icon {
                    width: 30px;
                    height: 30px;
                    border-radius: 7px;
                    display: grid;
                    place-items: center;
                    flex-shrink: 0;
                    background: var(--sn-surface-2);
                    color: var(--sn-muted);
                }
                .palette-item-body {
                    flex: 1;
                    min-width: 0;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .palette-item-label {
                    font-size: 14px;
                    font-weight: 450;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    flex: 1;
                    min-width: 0;
                }
                .palette-item-description {
                    font-size: 12.5px;
                    color: var(--sn-muted);
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    flex-shrink: 0;
                    max-width: 220px;
                }
                .palette-item-hint {
                    font-size: 12px;
                    color: var(--sn-muted);
                    flex-shrink: 0;
                }
                .palette-avatar {
                    width: 30px;
                    height: 30px;
                    border-radius: 50%;
                    object-fit: cover;
                    flex-shrink: 0;
                }
                .palette-scope-arrow {
                    color: var(--sn-muted);
                    flex-shrink: 0;
                    font-size: 12px;
                }
                .palette-footer {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    height: 38px;
                    padding: 0 14px;
                    border-top: 1px solid var(--sn-border);
                    flex-shrink: 0;
                }
                .palette-footer-group {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    font-size: 12px;
                    color: var(--sn-muted);
                }
                .palette-kbd {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    height: 22px;
                    min-width: 22px;
                    padding: 0;
                    border-radius: 6px;
                    font-size: 11.5px;
                    font-weight: 500;
                    background: var(--sn-surface-2);
                    color: var(--sn-fg);
                    border: 1px solid var(--sn-border);
                    box-shadow: 0 1px 0 var(--sn-border);
                    line-height: 1;
                }
                .palette-kbd svg { display: block; }
                .palette-kbd-text {
                    padding: 0 7px;
                    font-size: 10.5px;
                    font-weight: 600;
                    letter-spacing: .03em;
                    text-transform: uppercase;
                }
                .palette-back-btn {
                    display: grid;
                    place-items: center;
                    width: 28px;
                    height: 28px;
                    border-radius: 7px;
                    background: var(--sn-surface-2);
                    border: 1px solid var(--sn-border);
                    color: var(--sn-muted);
                    cursor: pointer;
                    flex-shrink: 0;
                    transition: background 120ms, color 120ms;
                }
                .palette-back-btn:hover {
                    background: var(--sn-n200);
                    color: var(--sn-fg);
                }
                .palette-scope-label {
                    font-size: 14px;
                    font-weight: 550;
                    color: var(--sn-fg);
                }
                .palette-scope-sep {
                    font-size: 14px;
                    color: var(--sn-border);
                    margin: 0 2px;
                    user-select: none;
                }
                .palette-empty {
                    padding: 40px 16px;
                    text-align: center;
                    font-size: 14px;
                    color: var(--sn-muted);
                }
                .palette-empty strong {
                    color: var(--sn-fg);
                    font-weight: 500;
                }
                .palette-skeleton {
                    padding: 8px 12px;
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                }
                .palette-skeleton-row {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 7px 8px;
                    margin: 0 4px;
                    border-radius: 8px;
                }
                .palette-skel-icon {
                    width: 30px; height: 30px; border-radius: 7px;
                    background: var(--sn-surface-2);
                    animation: skel-pulse 1.4s ease infinite;
                    flex-shrink: 0;
                }
                .palette-skel-lines {
                    flex: 1; display: flex; flex-direction: column; gap: 6px;
                }
                .palette-skel-line {
                    height: 11px; border-radius: 4px;
                    background: var(--sn-surface-2);
                    animation: skel-pulse 1.4s ease infinite;
                }
                @keyframes skel-pulse {
                    0%,100% { opacity: 1; }
                    50%      { opacity: .45; }
                }
            `}</style>

            {/* Backdrop */}
            <div
                className={`palette-overlay ${closing ? 'palette-overlay-out' : 'palette-overlay-in'}`}
                onClick={onClose}
            />

            {/* Modal */}
            <div
                className={`palette-dialog ${closing ? 'palette-dialog-out' : 'palette-dialog-in'}`}
                role="dialog"
                aria-modal="true"
                aria-label="Recherche"
            >
                <div className="palette-box">
                    {/* ── Input bar ─────────────────────────────────────── */}
                    <div className="palette-input-row">
                        {scopeConfig ? (
                            <>
                                <button
                                    className="palette-back-btn"
                                    onClick={handleBack}
                                    aria-label="Retour"
                                >
                                    <ArrowLeft size={13} />
                                </button>
                                <span className="palette-scope-label">
                                    {scopeConfig.label}
                                </span>
                                <span className="palette-scope-sep">/</span>
                            </>
                        ) : (
                            <Search
                                size={16}
                                style={{
                                    color: 'var(--sn-muted)',
                                    flexShrink: 0,
                                }}
                            />
                        )}
                        <input
                            ref={inputRef}
                            value={q}
                            onChange={(e) => handleChange(e.target.value)}
                            onKeyDown={onKey}
                            placeholder={
                                scopeConfig
                                    ? scopeConfig.placeholder
                                    : 'Recherche…'
                            }
                            className="palette-input"
                            autoComplete="off"
                            spellCheck={false}
                        />
                    </div>

                    {/* ── List body ──────────────────────────────────────── */}
                    <div className="palette-list" ref={listRef}>
                        {/* Loading skeleton */}
                        {loading && (
                            <div className="palette-skeleton">
                                {[1, 2, 3, 4].map((i) => (
                                    <div
                                        key={i}
                                        className="palette-skeleton-row"
                                    >
                                        <div
                                            className="palette-skel-icon"
                                            style={{
                                                animationDelay: `${i * 80}ms`,
                                            }}
                                        />
                                        <div className="palette-skel-lines">
                                            <div
                                                className="palette-skel-line"
                                                style={{
                                                    width: `${55 + (i % 3) * 15}%`,
                                                    animationDelay: `${i * 80}ms`,
                                                }}
                                            />
                                            <div
                                                className="palette-skel-line"
                                                style={{
                                                    width: `${30 + (i % 2) * 10}%`,
                                                    animationDelay: `${i * 80 + 60}ms`,
                                                }}
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}

                        {/* Empty state */}
                        {!loading && isSearching && items.length === 0 && (
                            <div className="palette-empty">
                                Aucun résultat pour{' '}
                                <strong>«&nbsp;{q}&nbsp;»</strong>
                            </div>
                        )}

                        {/* Scoped idle state */}
                        {!loading && scope && !isSearching && (
                            <div className="palette-empty">
                                Tapez pour rechercher dans{' '}
                                <strong>{SCOPE_CONFIG[scope].label}</strong>
                            </div>
                        )}

                        {/* Items */}
                        {!loading &&
                            groups.map((section, si) => (
                                <div key={si}>
                                    {section.type === 'group' && (
                                        <div className="palette-section-label">
                                            {section.label}
                                        </div>
                                    )}
                                    {section.items.map((item) => {
                                        const active = cursor === item.idx;

                                        return (
                                            <button
                                                key={item.idx}
                                                data-idx={item.idx}
                                                data-active={active}
                                                className="palette-item"
                                                onClick={() =>
                                                    handleSelect(item)
                                                }
                                            >
                                                {item.avatar ? (
                                                    <img
                                                        src={item.avatar}
                                                        alt={item.label}
                                                        className="palette-avatar"
                                                    />
                                                ) : (
                                                    <span className="palette-item-icon">
                                                        <item.Icon size={15} />
                                                    </span>
                                                )}
                                                <span className="palette-item-body">
                                                    <span className="palette-item-label">
                                                        {item.label}
                                                    </span>
                                                    {item.description && (
                                                        <span className="palette-item-description">
                                                            {item.description}
                                                        </span>
                                                    )}
                                                    {item.hint && (
                                                        <span className="palette-item-hint">
                                                            {item.hint}
                                                        </span>
                                                    )}
                                                    {item.type ===
                                                        'scope-selector' && (
                                                        <span className="palette-scope-arrow">
                                                            →
                                                        </span>
                                                    )}
                                                </span>
                                            </button>
                                        );
                                    })}
                                </div>
                            ))}
                    </div>

                    {/* ── Footer ────────────────────────────────────────── */}
                    <div className="palette-footer">
                        <div className="palette-footer-group">
                            <kbd className="palette-kbd palette-kbd-text">
                                esc
                            </kbd>
                            <span>{scope ? 'Retour' : 'Fermer'}</span>
                        </div>
                        <div className="palette-footer-group">
                            <div className="palette-footer-group">
                                <kbd className="palette-kbd">
                                    <ArrowUp size={13} strokeWidth={2.25} />
                                </kbd>
                                <kbd className="palette-kbd">
                                    <ArrowDown size={13} strokeWidth={2.25} />
                                </kbd>
                                <span>Naviguer</span>
                            </div>
                            <span
                                style={{
                                    color: 'var(--sn-border)',
                                    margin: '0 4px',
                                }}
                            >
                                ·
                            </span>
                            <div className="palette-footer-group">
                                <kbd className="palette-kbd">
                                    <CornerDownLeft
                                        size={13}
                                        strokeWidth={2.25}
                                    />
                                </kbd>
                                <span>Sélectionner</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
