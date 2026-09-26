import { Head, Link, usePage } from '@inertiajs/react';
import { Check, Link2 } from 'lucide-react';
import { useEffect, useMemo, useRef, useState } from 'react';
import { Markdown } from '@/components/markdown/markdown';
import ArticleCard from '@/components/site/article-card';
import { useClipboard } from '@/hooks/use-clipboard';
import { useInitials } from '@/hooks/use-initials';
import { slugify } from '@/lib/slugify';
import type {
    ArticleCoverSrcset,
    ArticleFull,
    ArticleSummary,
} from '@/types/article';

function buildCoverSrcset(
    srcset: ArticleCoverSrcset | null,
): string | undefined {
    if (!srcset) {
        return undefined;
    }

    const parts: string[] = [];

    if (srcset.sm) {
        parts.push(`${srcset.sm} 640w`);
    }

    if (srcset.md) {
        parts.push(`${srcset.md} 1280w`);
    }

    return parts.length > 0 ? parts.join(', ') : undefined;
}

function extractToc(body: string): { id: string; label: string }[] {
    return [...body.matchAll(/^## (.+)$/gm)].map((m) => ({
        id: slugify(m[1]),
        label: m[1],
    }));
}

function fmtDate(iso: string): string {
    return new Date(iso).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}

function tagTint(slug: string): string {
    const palette = ['var(--sn-500)', 'var(--sn-600)', 'var(--sn-700)'];
    let h = 0;

    for (const c of slug) {
        h = (h * 31 + c.charCodeAt(0)) >>> 0;
    }

    return palette[h % palette.length];
}

const SHARE_TARGETS = [
    {
        label: 'X / Twitter',
        color: '#000',
        darkColor: '#e7e9ea',
        icon: (
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.629L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
            </svg>
        ),
        href: (title: string, url: string) =>
            `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`,
    },
    {
        label: 'LinkedIn',
        color: '#0A66C2',
        darkColor: '#0A66C2',
        icon: (
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
            </svg>
        ),
        href: (_: string, url: string) =>
            `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
    },
    {
        label: 'WhatsApp',
        color: '#25D366',
        darkColor: '#25D366',
        icon: (
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
        ),
        href: (title: string, url: string) =>
            `https://wa.me/?text=${encodeURIComponent(`${title} ${url}`)}`,
    },
];

function ShareCard({ title, slug }: { title: string; slug: string }) {
    const url = `${window.location.origin}/articles/${slug}`;
    const [, copy] = useClipboard();
    const [copied, setCopied] = useState(false);
    const timerRef = useRef<ReturnType<typeof setTimeout> | null>(null);

    const handleCopy = async () => {
        const ok = await copy(url);

        if (ok) {
            setCopied(true);

            if (timerRef.current) {
                clearTimeout(timerRef.current);
            }

            timerRef.current = setTimeout(() => setCopied(false), 2000);
        }
    };

    useEffect(
        () => () => {
            if (timerRef.current) {
                clearTimeout(timerRef.current);
            }
        },
        [],
    );

    return (
        <div className="mt-8">
            <p
                className="mb-2 text-[10px] font-semibold tracking-[0.18em] uppercase"
                style={{ color: 'var(--sn-muted)' }}
            >
                Partager
            </p>

            <div className="flex items-center gap-1">
                {SHARE_TARGETS.map(({ label, color, icon, href }) => (
                    <a
                        key={label}
                        href={href(title, url)}
                        target="_blank"
                        rel="noopener noreferrer"
                        title={label}
                        className="flex h-8 w-8 items-center justify-center rounded-lg transition-all duration-150"
                        style={{ color: 'var(--sn-muted)' }}
                        onMouseEnter={(e) => {
                            e.currentTarget.style.background = `color-mix(in oklch, ${color} 14%, transparent)`;
                            e.currentTarget.style.color = color;
                        }}
                        onMouseLeave={(e) => {
                            e.currentTarget.style.background = 'transparent';
                            e.currentTarget.style.color = 'var(--sn-muted)';
                        }}
                    >
                        {icon}
                    </a>
                ))}

                <div
                    className="mx-1.5 h-4 w-px shrink-0"
                    style={{ background: 'var(--sn-border)' }}
                />

                <button
                    onClick={handleCopy}
                    title="Copier le lien"
                    className="flex h-8 w-8 items-center justify-center rounded-lg transition-all duration-150"
                    style={{
                        color: copied ? 'var(--sn-accent)' : 'var(--sn-muted)',
                    }}
                    onMouseEnter={(e) => {
                        if (!copied) {
                            e.currentTarget.style.color = 'var(--sn-fg)';
                        }
                    }}
                    onMouseLeave={(e) => {
                        if (!copied) {
                            e.currentTarget.style.color = 'var(--sn-muted)';
                        }
                    }}
                >
                    {copied ? (
                        <Check size={13} strokeWidth={2.5} />
                    ) : (
                        <Link2 size={14} />
                    )}
                </button>
            </div>
        </div>
    );
}

export default function ArticleShow() {
    const { article, relatedArticles } = usePage().props as unknown as {
        article: ArticleFull;
        relatedArticles: ArticleSummary[];
    };

    const getInitials = useInitials();
    const toc = useMemo(() => extractToc(article.body), [article.body]);
    const firstTag = article.tags[0];
    const tint = firstTag ? tagTint(firstTag.slug) : 'var(--sn-600)';

    // Temporarily disabled until reactions, saves, and copy-link actions are implemented.
    // const [reactions, setReactions] = useState({
    //     up: article.likes_count,
    //     heart: 0,
    //     fire: 0,
    // });
    // const [saved, setSaved] = useState(false);
    const [activeSection, setActiveSection] = useState('');

    useEffect(() => {
        if (toc.length === 0) {
            return;
        }

        const handler = () => {
            let current = toc[0]?.id ?? '';

            for (const { id } of toc) {
                const el = document.getElementById(id);

                if (el && el.getBoundingClientRect().top < 140) {
                    current = id;
                }
            }

            setActiveSection(current);
        };
        window.addEventListener('scroll', handler, { passive: true });
        handler();

        return () => window.removeEventListener('scroll', handler);
    }, [toc]);

    return (
        <>
            <Head title={`${article.title} — Laravel Sénégal`}>
                <meta name="description" content={article.excerpt} />
                <meta property="og:title" content={article.title} />
                <meta property="og:description" content={article.excerpt} />
                <meta property="og:type" content="article" />
                {article.cover_url && (
                    <meta property="og:image" content={article.cover_url} />
                )}
                <meta name="twitter:card" content="summary_large_image" />
            </Head>

            {/* Breadcrumb */}
            <div
                className="mx-auto flex max-w-[1400px] flex-wrap items-center gap-2 px-6 pt-6 text-[12px] lg:px-10"
                style={{ color: 'var(--sn-muted)' }}
            >
                <Link href="/articles" className="hover:underline">
                    Articles
                </Link>
                <span>/</span>
                <span style={{ color: 'var(--sn-fg)' }}>{article.title}</span>
            </div>

            {/* Content */}
            <article className="mx-auto grid max-w-[1400px] gap-10 px-6 pt-6 pb-16 lg:grid-cols-12 lg:px-10">
                {/* Main column */}
                <div className="min-w-0 lg:col-span-8">
                    {/* Tags + meta */}
                    <div className="mb-4 flex flex-wrap gap-2">
                        {article.tags.map((tag) => (
                            <span
                                key={tag.id}
                                className="sn-badge sn-badge-primary"
                            >
                                #{tag.name}
                            </span>
                        ))}
                        <span className="sn-badge sn-badge-neutral">
                            {article.locale.toUpperCase()}
                        </span>
                        <span className="sn-badge sn-badge-neutral">
                            {article.reading_time_minutes} min de lecture
                        </span>
                    </div>

                    <h1
                        className="text-[28px] leading-[1.1] font-semibold tracking-tight lg:text-[34px]"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        {article.title}
                    </h1>

                    {/* Desktop: excerpt */}
                    <p
                        className="mt-5 hidden max-w-[60ch] text-[18px] leading-[1.6] sm:block"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        {article.excerpt}
                    </p>

                    {/* Mobile: cover image if available */}
                    {article.cover_url && (
                        <div className="mt-5 overflow-hidden rounded-xl sm:hidden">
                            <img
                                src={
                                    article.cover_srcset?.sm ??
                                    article.cover_url
                                }
                                srcSet={buildCoverSrcset(article.cover_srcset)}
                                sizes="(max-width: 640px) 100vw, 640px"
                                alt={article.title}
                                width={640}
                                height={360}
                                fetchPriority="high"
                                decoding="async"
                                className="w-full object-cover"
                            />
                        </div>
                    )}

                    {/* Author strip */}
                    <div
                        className="mt-8 flex items-center gap-4 pb-4 lg:border-b lg:pb-8"
                        style={{ borderColor: 'var(--sn-border)' }}
                    >
                        <Link
                            href={`/@${article.author.username}`}
                            className="flex items-center gap-3"
                        >
                            {article.author.avatar ? (
                                <img
                                    src={article.author.avatar}
                                    alt={article.author.name}
                                    className="h-8 w-8 rounded-full object-cover"
                                />
                            ) : (
                                <span
                                    className="grid h-8 w-8 place-items-center rounded-full font-mono text-[11px]"
                                    style={{ background: tint, color: '#fff' }}
                                >
                                    {getInitials(article.author.name)}
                                </span>
                            )}
                            <div
                                className="text-[14px] font-medium"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                {article.author.name}
                            </div>
                        </Link>
                        {article.published_at && (
                            <div
                                className="ml-auto text-right text-[12px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <div>{fmtDate(article.published_at)}</div>
                                {article.was_revised &&
                                    article.content_updated_at && (
                                        <div
                                            className="mt-0.5"
                                            style={{
                                                color: 'var(--sn-accent)',
                                            }}
                                        >
                                            Mis à jour le{' '}
                                            {fmtDate(
                                                article.content_updated_at,
                                            )}
                                        </div>
                                    )}
                            </div>
                        )}
                    </div>

                    {/* Hero */}
                    {article.cover_url && (
                        <div
                            className="relative mt-8 hidden overflow-hidden rounded-xl sm:block"
                            style={{ aspectRatio: '16/8' }}
                        >
                            {article.cover_url ? (
                                <img
                                    src={
                                        article.cover_srcset?.md ??
                                        article.cover_url
                                    }
                                    srcSet={buildCoverSrcset(
                                        article.cover_srcset,
                                    )}
                                    sizes="(min-width: 1024px) 760px, (min-width: 640px) 100vw, 0px"
                                    alt={article.title}
                                    width={1280}
                                    height={640}
                                    fetchPriority="high"
                                    decoding="async"
                                    className="absolute inset-0 h-full w-full object-cover"
                                />
                            ) : (
                                <>
                                    <div className="bg-sn-grid absolute inset-0 opacity-30" />
                                    {firstTag && (
                                        <div
                                            className="absolute bottom-6 left-6 font-mono text-[13px]"
                                            style={{
                                                color: 'rgba(255,255,255,.85)',
                                            }}
                                        >
                                            #{firstTag.name}
                                            {article.published_at && (
                                                <>
                                                    {' '}
                                                    ·{' '}
                                                    {article.published_at.slice(
                                                        0,
                                                        10,
                                                    )}
                                                </>
                                            )}
                                        </div>
                                    )}
                                </>
                            )}
                        </div>
                    )}

                    {/* Mobile TOC + share */}
                    {toc.length > 0 && (
                        <details
                            className="group rounded-xl border lg:hidden"
                            style={{
                                borderColor: 'var(--sn-border)',
                            }}
                        >
                            <summary
                                className="flex cursor-pointer items-center justify-between px-4 py-3 text-[12px] font-semibold tracking-wide uppercase select-none"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                <span>Sommaire</span>
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="transition-transform duration-200 group-open:rotate-180"
                                >
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </summary>
                            <nav
                                className="flex flex-col gap-0.5 border-t px-4 pt-2 pb-3"
                                style={{ borderColor: 'var(--sn-border)' }}
                            >
                                {toc.map((t) => (
                                    <a
                                        key={t.id}
                                        href={`#${t.id}`}
                                        onClick={(e) => {
                                            e.preventDefault();
                                            document
                                                .getElementById(t.id)
                                                ?.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start',
                                                });
                                        }}
                                        className="rounded-md px-2 py-1.5 text-[13.5px] transition-colors"
                                        style={{
                                            color:
                                                activeSection === t.id
                                                    ? 'var(--sn-accent)'
                                                    : 'var(--sn-muted)',
                                            fontWeight:
                                                activeSection === t.id
                                                    ? 500
                                                    : 400,
                                            background:
                                                activeSection === t.id
                                                    ? 'color-mix(in oklch, var(--sn-accent) 8%, transparent)'
                                                    : 'transparent',
                                        }}
                                    >
                                        {t.label}
                                    </a>
                                ))}
                            </nav>
                        </details>
                    )}

                    {/* Article body */}
                    <Markdown variant="article" headingIds className="mt-10">
                        {article.body}
                    </Markdown>

                    {/*
                    Temporarily disabled until reactions, saves, and copy-link actions are implemented.
                    <div
                        className="mt-10 flex flex-wrap items-center gap-3 border-b pb-8"
                        style={{ borderColor: 'var(--sn-border)' }}
                    >
                        <button
                            onClick={() =>
                                setReactions((r) => ({ ...r, up: r.up + 1 }))
                            }
                            className="sn-btn sn-btn-secondary sn-btn-sm"
                        >
                            👍 {reactions.up}
                        </button>
                        <button
                            onClick={() =>
                                setReactions((r) => ({
                                    ...r,
                                    heart: r.heart + 1,
                                }))
                            }
                            className="sn-btn sn-btn-secondary sn-btn-sm"
                        >
                            ❤️ {reactions.heart}
                        </button>
                        <button
                            onClick={() =>
                                setReactions((r) => ({
                                    ...r,
                                    fire: r.fire + 1,
                                }))
                            }
                            className="sn-btn sn-btn-secondary sn-btn-sm"
                        >
                            🔥 {reactions.fire}
                        </button>
                        <div className="ml-auto flex items-center gap-2">
                            <button
                                onClick={() => setSaved((s) => !s)}
                                className="sn-btn sn-btn-secondary sn-btn-sm"
                            >
                                {saved ? '★ Sauvegardé' : '☆ Sauvegarder'}
                            </button>
                            <button className="sn-btn sn-btn-secondary sn-btn-sm">
                                <Link2 size={13} /> Copier le lien
                            </button>
                        </div>
                    </div>
                    */}

                    {/* Related */}
                    {relatedArticles.length > 0 && (
                        <div className="mt-12">
                            <h3
                                className="mb-4 text-[20px] font-semibold tracking-tight"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                Articles liés
                            </h3>
                            <div className="grid gap-4 md:grid-cols-2">
                                {relatedArticles.map((a) => (
                                    <ArticleCard key={a.slug} {...a} />
                                ))}
                            </div>
                        </div>
                    )}
                </div>

                {/* TOC sidebar */}
                <aside className="hidden lg:col-span-4 lg:block">
                    <div className="lg:sticky lg:top-24">
                        {toc.length > 0 && (
                            <>
                                <div
                                    className="mb-3 text-[11px] font-semibold tracking-wide uppercase"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Sommaire
                                </div>
                                <nav
                                    className="flex flex-col gap-1 border-l pl-4"
                                    style={{ borderColor: 'var(--sn-border)' }}
                                >
                                    {toc.map((t) => (
                                        <a
                                            key={t.id}
                                            href={`#${t.id}`}
                                            onClick={(e) => {
                                                e.preventDefault();
                                                document
                                                    .getElementById(t.id)
                                                    ?.scrollIntoView({
                                                        behavior: 'smooth',
                                                        block: 'start',
                                                    });
                                            }}
                                            className="py-1.5 text-[13.5px] transition-colors"
                                            style={{
                                                color:
                                                    activeSection === t.id
                                                        ? 'var(--sn-accent)'
                                                        : 'var(--sn-muted)',
                                                fontWeight:
                                                    activeSection === t.id
                                                        ? 500
                                                        : 400,
                                                borderLeft:
                                                    activeSection === t.id
                                                        ? '2px solid var(--sn-accent)'
                                                        : '2px solid transparent',
                                                marginLeft: -17,
                                                paddingLeft: 15,
                                            }}
                                        >
                                            {t.label}
                                        </a>
                                    ))}
                                </nav>
                            </>
                        )}

                        <ShareCard title={article.title} slug={article.slug} />
                    </div>
                </aside>
            </article>
        </>
    );
}
