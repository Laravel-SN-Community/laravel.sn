import { Head, Link, router } from '@inertiajs/react';
import { Send, Trash2 } from 'lucide-react';
import { useState } from 'react';
import ArticleController from '@/actions/App/Http/Controllers/ArticleController';
import ArticleCreateSheet from '@/components/site/article-create-sheet';
import { ConfirmModal } from '@/components/site/confirm-modal';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { fmtDate } from '@/lib/utils';
import type { ArticleTag } from '@/types/article';

type DashboardArticle = {
    id: number;
    slug: string;
    title: string;
    excerpt: string;
    body: string;
    locale: string;
    status: string;
    published_at: string | null;
    submitted_at: string | null;
    declined_at: string | null;
    cover_url: string | null;
    reading_time_minutes: number;
    views_count: number;
    content_updated_at: string | null;
    created_at: string;
    updated_at: string;
    tags: ArticleTag[];
};

type Props = {
    tags: ArticleTag[];
    publishedArticles: DashboardArticle[];
    draftArticles: DashboardArticle[];
    canPublish: boolean;
};

const SUBMIT_CHECKLIST = [
    'Votre titre est clair, spécifique et accrocheur',
    'Le contenu est complet (minimum 500 mots avec des exemples)',
    'Une image de couverture a été ajoutée',
    'Les tags choisis sont pertinents (1 à 3 tags)',
];

export default function DashboardArticles({
    tags = [],
    publishedArticles = [],
    draftArticles = [],
    canPublish = false,
}: Props) {
    const [sheetOpen, setSheetOpen] = useState(false);
    const [editArticle, setEditArticle] = useState<DashboardArticle | null>(
        null,
    );
    const [deleteTarget, setDeleteTarget] = useState<DashboardArticle | null>(
        null,
    );
    const [submitConfirmTarget, setSubmitConfirmTarget] =
        useState<DashboardArticle | null>(null);
    const [submitting, setSubmitting] = useState(false);

    function openCreate() {
        setEditArticle(null);
        setSheetOpen(true);
    }

    function openEdit(a: DashboardArticle) {
        setEditArticle(a);
        setSheetOpen(true);
    }

    function handleSheetChange(next: boolean) {
        if (!next) {
            setEditArticle(null);
        }

        setSheetOpen(next);
    }

    function handlePublish(article: DashboardArticle) {
        if (canPublish) {
            router.post(
                ArticleController.publish.url({ article: article.slug }),
            );
        } else {
            setSubmitConfirmTarget(article);
        }
    }

    function confirmSubmit() {
        if (!submitConfirmTarget) {
            return;
        }

        setSubmitting(true);
        router.post(
            `/articles/${submitConfirmTarget.slug}/submit`,
            {},
            {
                onFinish: () => {
                    setSubmitting(false);
                    setSubmitConfirmTarget(null);
                },
            },
        );
    }

    function confirmDelete() {
        if (!deleteTarget) {
            return;
        }

        router.delete(
            ArticleController.destroy.url({ article: deleteTarget.slug }),
            { onFinish: () => setDeleteTarget(null) },
        );
    }

    const publishedCount = publishedArticles.filter(
        (a) => a.status === 'published',
    ).length;
    const pendingCount = publishedArticles.filter(
        (a) => a.status === 'pending',
    ).length;
    const approvedCount = publishedArticles.filter(
        (a) => a.status === 'approved',
    ).length;

    return (
        <>
            <Head title="Mes articles" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="articles" />

                    <main className="min-w-0 space-y-6">
                        <div className="flex flex-wrap items-end justify-between gap-4">
                            <div>
                                <h1
                                    className="mt-1 text-[32px] font-semibold tracking-[-0.02em]"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    Mes articles
                                </h1>
                                <p
                                    className="mt-1 text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {publishedCount} publié
                                    {publishedCount !== 1 ? 's' : ''}
                                    {pendingCount > 0 &&
                                        ` · ${pendingCount} en attente`}
                                    {approvedCount > 0 &&
                                        ` · ${approvedCount} approuvé${approvedCount !== 1 ? 's' : ''}`}
                                    {' · '}
                                    {draftArticles.length} brouillon
                                    {draftArticles.length !== 1 ? 's' : ''}
                                </p>
                            </div>
                            <button
                                onClick={openCreate}
                                className="sn-btn sn-btn-primary"
                            >
                                Nouvel article
                            </button>
                        </div>

                        {/* Published */}
                        <div
                            className="rounded-xl p-6"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <h3
                                className="mb-4 text-[13px] font-semibold tracking-wide uppercase"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Publiés
                            </h3>
                            {publishedArticles.length === 0 ? (
                                <p
                                    className="text-[12.5px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Aucun article publié pour l'instant.
                                </p>
                            ) : (
                                <div className="space-y-4">
                                    {publishedArticles.map((a) => {
                                        const isPending =
                                            a.status === 'pending';
                                        const isApproved =
                                            a.status === 'approved';
                                        const isReadOnly =
                                            isPending || isApproved;

                                        return (
                                            <div
                                                key={a.slug}
                                                className="flex flex-wrap items-start justify-between gap-3 border-b pb-4 last:border-0 last:pb-0"
                                                style={{
                                                    borderColor:
                                                        'var(--sn-border)',
                                                }}
                                            >
                                                <div className="min-w-0">
                                                    <div className="flex flex-wrap items-center gap-2">
                                                        <span
                                                            className="text-[15px] font-semibold tracking-tight"
                                                            style={{
                                                                color: 'var(--sn-fg)',
                                                            }}
                                                        >
                                                            {a.title}
                                                        </span>
                                                        {isPending && (
                                                            <span
                                                                className="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold tracking-wide"
                                                                style={{
                                                                    background:
                                                                        'rgba(245,158,11,0.1)',
                                                                    color: '#b45309',
                                                                    border: '1px solid rgba(245,158,11,0.28)',
                                                                }}
                                                            >
                                                                <span
                                                                    className="h-1.5 w-1.5 rounded-full"
                                                                    style={{
                                                                        background:
                                                                            '#f59e0b',
                                                                    }}
                                                                />
                                                                En attente de
                                                                validation
                                                            </span>
                                                        )}
                                                        {isApproved && (
                                                            <span
                                                                className="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold tracking-wide"
                                                                style={{
                                                                    background:
                                                                        'color-mix(in oklch, var(--sn-accent) 10%, transparent)',
                                                                    color: 'var(--sn-700)',
                                                                    border: '1px solid color-mix(in oklch, var(--sn-accent) 25%, transparent)',
                                                                }}
                                                            >
                                                                <span
                                                                    className="h-1.5 w-1.5 rounded-full"
                                                                    style={{
                                                                        background:
                                                                            'var(--sn-accent)',
                                                                    }}
                                                                />
                                                                Approuvé
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div
                                                        className="mt-0.5 text-[11.5px]"
                                                        style={{
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                    >
                                                        {isPending ? (
                                                            <>
                                                                Soumis le{' '}
                                                                {a.submitted_at
                                                                    ? fmtDate(
                                                                          a.submitted_at,
                                                                      )
                                                                    : '—'}{' '}
                                                                · en cours de
                                                                révision
                                                            </>
                                                        ) : isApproved ? (
                                                            <>
                                                                Publication
                                                                prévue le{' '}
                                                                {a.published_at
                                                                    ? fmtDate(
                                                                          a.published_at,
                                                                      )
                                                                    : '—'}
                                                            </>
                                                        ) : (
                                                            <>
                                                                {a.published_at
                                                                    ? fmtDate(
                                                                          a.published_at,
                                                                      )
                                                                    : '—'}{' '}
                                                                ·{' '}
                                                                {
                                                                    a.reading_time_minutes
                                                                }{' '}
                                                                min ·{' '}
                                                                {a.views_count.toLocaleString(
                                                                    'fr-FR',
                                                                )}{' '}
                                                                vues
                                                            </>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="flex gap-2">
                                                    {isReadOnly ? (
                                                        <button
                                                            onClick={() =>
                                                                setDeleteTarget(
                                                                    a,
                                                                )
                                                            }
                                                            className="flex h-8 w-8 items-center justify-center rounded-lg transition-colors"
                                                            style={{
                                                                color: 'var(--sn-muted)',
                                                            }}
                                                            title="Supprimer"
                                                            onMouseEnter={(
                                                                e,
                                                            ) => {
                                                                e.currentTarget.style.background =
                                                                    'color-mix(in oklch, var(--destructive) 10%, transparent)';
                                                                e.currentTarget.style.color =
                                                                    'var(--destructive)';
                                                            }}
                                                            onMouseLeave={(
                                                                e,
                                                            ) => {
                                                                e.currentTarget.style.background =
                                                                    'transparent';
                                                                e.currentTarget.style.color =
                                                                    'var(--sn-muted)';
                                                            }}
                                                        >
                                                            <Trash2 size={14} />
                                                        </button>
                                                    ) : (
                                                        <>
                                                            <Link
                                                                href={`/articles/${a.slug}`}
                                                                className="sn-btn sn-btn-ghost sn-btn-sm"
                                                            >
                                                                Voir
                                                            </Link>
                                                            <button
                                                                onClick={() =>
                                                                    openEdit(a)
                                                                }
                                                                className="sn-btn sn-btn-ghost sn-btn-sm"
                                                            >
                                                                Modifier
                                                            </button>
                                                        </>
                                                    )}
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            )}
                        </div>

                        {/* Drafts */}
                        <div
                            className="rounded-xl p-6"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            <h3
                                className="mb-4 text-[13px] font-semibold tracking-wide uppercase"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Brouillons
                            </h3>
                            {draftArticles.length === 0 ? (
                                <p
                                    className="text-[12.5px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    Aucun brouillon. Commence à écrire !
                                </p>
                            ) : (
                                <div className="space-y-4">
                                    {draftArticles.map((d) => {
                                        const isDeclined =
                                            d.status === 'declined';

                                        return (
                                            <div
                                                key={d.slug}
                                                className="flex flex-wrap items-start justify-between gap-3 border-b pb-4 last:border-0 last:pb-0"
                                                style={{
                                                    borderColor:
                                                        'var(--sn-border)',
                                                }}
                                            >
                                                <div className="min-w-0">
                                                    <div className="flex flex-wrap items-center gap-2">
                                                        <span
                                                            className="text-[15px] font-semibold tracking-tight"
                                                            style={{
                                                                color: 'var(--sn-fg)',
                                                            }}
                                                        >
                                                            {d.title}
                                                        </span>
                                                        {isDeclined && (
                                                            <span
                                                                className="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold tracking-wide"
                                                                style={{
                                                                    background:
                                                                        'color-mix(in oklch, var(--destructive) 10%, transparent)',
                                                                    color: 'var(--destructive)',
                                                                    border: '1px solid color-mix(in oklch, var(--destructive) 25%, transparent)',
                                                                }}
                                                            >
                                                                <span
                                                                    className="h-1.5 w-1.5 rounded-full"
                                                                    style={{
                                                                        background:
                                                                            'var(--destructive)',
                                                                    }}
                                                                />
                                                                Refusé
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div
                                                        className="mt-0.5 text-[11.5px]"
                                                        style={{
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                    >
                                                        {isDeclined &&
                                                        d.declined_at
                                                            ? `Refusé le ${fmtDate(d.declined_at)} · modifiez et soumettez à nouveau`
                                                            : `Modifié ${fmtDate(d.content_updated_at ?? d.created_at)}`}
                                                    </div>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    <button
                                                        onClick={() =>
                                                            openEdit(d)
                                                        }
                                                        className="sn-btn sn-btn-ghost sn-btn-sm"
                                                    >
                                                        Reprendre
                                                    </button>
                                                    <button
                                                        onClick={() =>
                                                            handlePublish(d)
                                                        }
                                                        className="sn-btn sn-btn-ghost sn-btn-sm"
                                                    >
                                                        Publier
                                                    </button>
                                                    <button
                                                        onClick={() =>
                                                            setDeleteTarget(d)
                                                        }
                                                        className="flex h-8 w-8 items-center justify-center rounded-lg transition-colors"
                                                        style={{
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                        title="Supprimer"
                                                        onMouseEnter={(e) => {
                                                            e.currentTarget.style.background =
                                                                'color-mix(in oklch, var(--destructive) 10%, transparent)';
                                                            e.currentTarget.style.color =
                                                                'var(--destructive)';
                                                        }}
                                                        onMouseLeave={(e) => {
                                                            e.currentTarget.style.background =
                                                                'transparent';
                                                            e.currentTarget.style.color =
                                                                'var(--sn-muted)';
                                                        }}
                                                    >
                                                        <Trash2 size={14} />
                                                    </button>
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            )}
                        </div>
                    </main>
                </div>
            </div>

            {/* Submit for review confirm modal */}
            <ConfirmModal
                open={submitConfirmTarget !== null}
                onClose={() => setSubmitConfirmTarget(null)}
                onConfirm={confirmSubmit}
                loading={submitting}
                icon={<Send size={18} style={{ color: '#d97706' }} />}
                iconBg="rgba(245,158,11,0.1)"
                title="Soumettre pour validation"
                description={
                    <>
                        Votre article{' '}
                        <span
                            className="font-medium"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            «&nbsp;{submitConfirmTarget?.title}&nbsp;»
                        </span>{' '}
                        sera soumis à l'équipe de modération.
                    </>
                }
                extra={
                    <>
                        <div
                            className="mt-4 rounded-xl px-4 py-3.5"
                            style={{
                                background: 'rgba(245,158,11,0.06)',
                                border: '1px solid rgba(245,158,11,0.2)',
                            }}
                        >
                            <p
                                className="mb-3 text-[12px] font-semibold tracking-wide uppercase"
                                style={{ color: '#b45309' }}
                            >
                                Avant de continuer, vérifiez que&nbsp;:
                            </p>
                            <ul className="space-y-2.5">
                                {SUBMIT_CHECKLIST.map((item, i) => (
                                    <li
                                        key={i}
                                        className="flex items-start gap-2.5 text-[13px]"
                                        style={{ color: '#92400e' }}
                                    >
                                        <span
                                            className="mt-[3px] flex h-4 w-4 shrink-0 items-center justify-center rounded border-[1.5px]"
                                            style={{
                                                borderColor:
                                                    'rgba(245,158,11,0.45)',
                                            }}
                                        />
                                        {item}
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <p
                            className="mt-4 text-[13px] leading-relaxed"
                            style={{ color: 'var(--sn-muted)' }}
                        >
                            Une fois soumis, l'article ne pourra plus être
                            modifié jusqu'à la décision des modérateurs.
                        </p>
                    </>
                }
                confirmLabel="Soumettre pour validation"
                confirmLabelLoading="Envoi…"
                confirmStyle={{
                    background: 'var(--sn-accent)',
                    color: 'var(--sn-accent-fg)',
                }}
            />

            {/* Delete confirm modal */}
            <ConfirmModal
                open={deleteTarget !== null}
                onClose={() => setDeleteTarget(null)}
                onConfirm={confirmDelete}
                icon={
                    <Trash2 size={18} style={{ color: 'var(--destructive)' }} />
                }
                iconBg="color-mix(in oklch, var(--destructive) 10%, transparent)"
                title="Supprimer l'article"
                description={
                    <>
                        L'article{' '}
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            «&nbsp;{deleteTarget?.title}&nbsp;»
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

            <ArticleCreateSheet
                tags={tags}
                open={sheetOpen}
                onOpenChange={handleSheetChange}
                article={editArticle ?? undefined}
                canPublish={canPublish}
            />
        </>
    );
}
