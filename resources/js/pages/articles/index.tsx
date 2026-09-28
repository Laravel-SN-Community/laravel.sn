import { Head, router } from '@inertiajs/react';
import { ChevronDown, ChevronUp, X } from 'lucide-react';
import { useRef, useState } from 'react';
import ArticleCard from '@/components/site/article-card';
import type { ArticleTag, PaginatedArticles } from '@/types/article';

type Filters = {
    tag: string | null;
    locale: string;
    q: string | null;
    sort: string;
};
type Props = {
    articles: PaginatedArticles;
    tags: ArticleTag[];
    filters: Filters;
};

export default function Articles({ articles, tags, filters }: Props) {
    const [q, setQ] = useState(filters.q ?? '');
    const [showAllTags, setShowAllTags] = useState(false);
    const qTimer = useRef<ReturnType<typeof setTimeout>>(undefined);

    const VISIBLE_TAGS = 10;

    function go(overrides: Partial<Filters & { page: number }>) {
        const params: Record<string, string | number> = {};
        const merged = { ...filters, q: q || null, ...overrides };

        if (merged.tag) {
            params.tag = merged.tag;
        }

        if (merged.q) {
            params.q = merged.q;
        }

        if (merged.sort && merged.sort !== 'recent') {
            params.sort = merged.sort;
        }

        if (merged.locale && merged.locale !== 'fr') {
            params.locale = merged.locale;
        }

        if ('page' in overrides && overrides.page && overrides.page > 1) {
            params.page = overrides.page;
        }

        router.get('/articles', params, { preserveState: true, replace: true });
    }

    function handleQ(value: string) {
        setQ(value);
        clearTimeout(qTimer.current);
        qTimer.current = setTimeout(() => go({ q: value || null }), 400);
    }

    const activeTag = filters.tag ?? null;

    return (
        <>
            <Head title="Articles" />

            {/* Page header */}
            <section className="mx-auto max-w-[1400px] px-6 pt-10 pb-10 lg:px-10 lg:pt-16">
                <div className="flex flex-wrap items-end justify-between gap-6">
                    <div className="max-w-[60ch]">
                        <h1
                            className="mt-2 text-[34px] font-semibold tracking-tight"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Écrits par la communauté.
                        </h1>
                        <p
                            className="mt-4 text-[16px] leading-relaxed lg:text-[17px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Guides, retours d'expérience et bonnes pratiques.
                        </p>
                    </div>
                    <div
                        className="flex gap-0.5 rounded-lg p-0.5"
                        style={{
                            background: 'var(--sn-surface)',
                            border: '1px solid var(--sn-border)',
                        }}
                    >
                        {(['fr', 'en'] as const).map((loc) => (
                            <button
                                key={loc}
                                onClick={() => go({ locale: loc })}
                                className="rounded-md px-3 py-1.5 text-[12px] font-semibold transition-all"
                                style={{
                                    background:
                                        filters.locale === loc
                                            ? 'var(--sn-accent)'
                                            : 'transparent',
                                    color:
                                        filters.locale === loc
                                            ? 'var(--sn-accent-fg)'
                                            : 'var(--sn-muted)',
                                }}
                            >
                                {loc.toUpperCase()}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            {/* Filters */}
            <section className="mx-auto max-w-[1400px] px-6 lg:px-10">
                <div className="sn-card p-4 md:p-5">
                    <div className="flex flex-wrap items-center gap-3">
                        {/* Search */}
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
                                onChange={(e) => handleQ(e.target.value)}
                                placeholder="Chercher un article…"
                                className="flex-1 bg-transparent py-2.5 text-[14px] outline-none"
                                style={{ color: 'var(--sn-fg)' }}
                            />
                            {q && (
                                <button
                                    onClick={() => handleQ('')}
                                    aria-label="Effacer"
                                >
                                    <X
                                        size={14}
                                        style={{ color: 'var(--sn-muted)' }}
                                    />
                                </button>
                            )}
                        </div>

                        {/* Sort */}
                        <select
                            value={filters.sort}
                            onChange={(e) => go({ sort: e.target.value })}
                            className="max-w-[180px] rounded-md px-3 py-2 font-mono text-[13px]"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                                color: 'var(--sn-fg)',
                            }}
                        >
                            <option value="recent">Plus récents</option>
                            <option value="popular">Plus populaires</option>
                            <option value="long">Lecture longue</option>
                            <option value="short">Lecture rapide</option>
                        </select>
                    </div>

                    {/* Tag chips */}
                    <div className="mt-4 flex flex-wrap items-center gap-2">
                        <button
                            onClick={() => go({ tag: null })}
                            className="rounded-md px-2.5 py-1 font-mono text-[12px] transition-colors"
                            style={
                                activeTag === null
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
                            #Tous
                        </button>
                        {(showAllTags ? tags : tags.slice(0, VISIBLE_TAGS)).map(
                            (tag) => (
                                <button
                                    key={tag.id}
                                    onClick={() => go({ tag: tag.slug })}
                                    className="rounded-md px-2.5 py-1 font-mono text-[12px] transition-colors"
                                    style={
                                        activeTag === tag.slug
                                            ? {
                                                  background:
                                                      'var(--sn-accent)',
                                                  color: 'var(--sn-accent-fg)',
                                              }
                                            : {
                                                  background:
                                                      'var(--sn-surface-2)',
                                                  color: 'var(--sn-muted)',
                                                  border: '1px solid var(--sn-border)',
                                              }
                                    }
                                >
                                    #{tag.name}
                                </button>
                            ),
                        )}
                        {tags.length > VISIBLE_TAGS && (
                            <button
                                onClick={() => setShowAllTags((v) => !v)}
                                className="flex items-center gap-1 rounded-md px-2.5 py-1 font-mono text-[12px] transition-colors"
                                style={{
                                    background: 'var(--sn-surface-2)',
                                    color: 'var(--sn-muted)',
                                    border: '1px solid var(--sn-border)',
                                }}
                            >
                                {showAllTags ? (
                                    <>
                                        <ChevronUp size={11} />
                                        Masquer
                                    </>
                                ) : (
                                    <>
                                        <ChevronDown size={11} />+
                                        {tags.length - VISIBLE_TAGS} tags
                                    </>
                                )}
                            </button>
                        )}
                    </div>
                </div>

                {/* Count */}
                <div className="mt-6 mb-4 flex items-center justify-between">
                    <div
                        className="flex items-center gap-3 font-mono text-[12px]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        <span
                            className="h-1 w-1 rounded-full"
                            style={{ background: 'var(--sn-accent)' }}
                        />
                        <span>
                            <span style={{ color: 'var(--sn-fg)' }}>
                                {articles.total}
                            </span>{' '}
                            {articles.total === 1 ? 'article' : 'articles'}
                        </span>
                    </div>
                    {articles.last_page > 1 && (
                        <div
                            className="font-mono text-[11.5px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            page {articles.current_page} / {articles.last_page}
                        </div>
                    )}
                </div>
            </section>

            {/* Grid */}
            <section className="mx-auto max-w-[1400px] px-6 lg:px-10">
                {articles.data.length === 0 ? (
                    <div className="sn-card p-10 text-center">
                        <p
                            className="text-[15px]"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Essaie d'enlever un filtre ou de changer ta
                            recherche.
                        </p>
                    </div>
                ) : (
                    <div className="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                        {articles.data.map((a) => (
                            <ArticleCard key={a.slug} {...a} />
                        ))}
                    </div>
                )}

                {/* Pagination */}
                {articles.last_page > 1 && (
                    <div className="mt-10 flex items-center justify-center gap-2">
                        <button
                            onClick={() =>
                                go({ page: articles.current_page - 1 })
                            }
                            disabled={articles.current_page === 1}
                            className="sn-btn sn-btn-secondary sn-btn-sm"
                            style={
                                articles.current_page === 1
                                    ? { opacity: 0.4 }
                                    : {}
                            }
                        >
                            ← Préc.
                        </button>
                        {Array.from(
                            { length: articles.last_page },
                            (_, i) => i + 1,
                        ).map((p) => (
                            <button
                                key={p}
                                onClick={() => go({ page: p })}
                                className="h-9 w-9 rounded-md font-mono text-[13px]"
                                style={
                                    p === articles.current_page
                                        ? {
                                              background: 'var(--sn-fg)',
                                              color: 'var(--sn-bg)',
                                          }
                                        : {
                                              background: 'var(--sn-surface)',
                                              color: 'var(--sn-fg)',
                                              border: '1px solid var(--sn-border)',
                                          }
                                }
                            >
                                {p}
                            </button>
                        ))}
                        <button
                            onClick={() =>
                                go({ page: articles.current_page + 1 })
                            }
                            disabled={
                                articles.current_page === articles.last_page
                            }
                            className="sn-btn sn-btn-secondary sn-btn-sm"
                            style={
                                articles.current_page === articles.last_page
                                    ? { opacity: 0.4 }
                                    : {}
                            }
                        >
                            Suiv. →
                        </button>
                    </div>
                )}
            </section>

            <div className="pb-20" />
        </>
    );
}
