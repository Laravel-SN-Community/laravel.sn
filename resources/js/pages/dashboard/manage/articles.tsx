import { Head, router } from '@inertiajs/react';
import { CheckCircle, Trash2, XCircle } from 'lucide-react';
import { useState } from 'react';
import ArticleController from '@/actions/App/Http/Controllers/ArticleController';
import { ConfirmModal } from '@/components/site/confirm-modal';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { fmtDate } from '@/lib/utils';
import type { ArticleTag } from '@/types/article';

type ManageArticle = {
    id: number;
    slug: string;
    title: string;
    locale: string;
    status: string;
    published_at: string | null;
    submitted_at: string | null;
    approved_at: string | null;
    reading_time_minutes: number;
    tags: ArticleTag[];
    author: { id: number; name: string; username: string };
};

type Props = {
    pendingArticles: ManageArticle[];
    approvedArticles: ManageArticle[];
    publishedArticles: ManageArticle[];
    canDelete: boolean;
};

type Tab = 'pending' | 'approved' | 'published';

export default function ManageArticles({
    pendingArticles,
    approvedArticles,
    publishedArticles,
    canDelete,
}: Props) {
    const [tab, setTab] = useState<Tab>('pending');
    const [approveTarget, setApproveTarget] = useState<ManageArticle | null>(
        null,
    );
    const [declineTarget, setDeclineTarget] = useState<ManageArticle | null>(
        null,
    );
    const [deleteTarget, setDeleteTarget] = useState<ManageArticle | null>(
        null,
    );

    function confirmApprove() {
        if (!approveTarget) {
            return;
        }

        router.post(
            ArticleController.publish.url({ article: approveTarget.slug }),
            {},
            { onFinish: () => setApproveTarget(null) },
        );
    }

    function confirmDecline() {
        if (!declineTarget) {
            return;
        }

        router.post(
            ArticleController.decline.url({ article: declineTarget.slug }),
            {},
            { onFinish: () => setDeclineTarget(null) },
        );
    }

    function confirmDelete() {
        if (!deleteTarget) {
            return;
        }

        router.delete(
            ArticleController.manageDestroy.url({
                article: deleteTarget.slug,
            }),
            { onFinish: () => setDeleteTarget(null) },
        );
    }

    const articles =
        tab === 'pending'
            ? pendingArticles
            : tab === 'approved'
              ? approvedArticles
              : publishedArticles;

    const tabs: { id: Tab; label: string; count: number }[] = [
        { id: 'pending', label: 'En attente', count: pendingArticles.length },
        { id: 'approved', label: 'Approuvés', count: approvedArticles.length },
        { id: 'published', label: 'Publiés', count: publishedArticles.length },
    ];

    return (
        <>
            <Head title="Gestion des articles" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="manage-articles" />

                    <main className="min-w-0 space-y-6">
                        <div>
                            <h1
                                className="mt-1 text-[32px] font-semibold tracking-[-0.02em]"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                Gestion des articles
                            </h1>
                        </div>

                        {/* Tabs */}
                        <div
                            className="flex gap-1 rounded-xl p-1"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {tabs.map((t) => (
                                <button
                                    key={t.id}
                                    onClick={() => setTab(t.id)}
                                    className="flex items-center gap-2 rounded-lg px-4 py-2 text-[13px] font-medium transition-colors"
                                    style={
                                        tab === t.id
                                            ? {
                                                  background: 'var(--sn-bg)',
                                                  color: 'var(--sn-fg)',
                                                  boxShadow:
                                                      '0 1px 3px rgba(0,0,0,0.08)',
                                              }
                                            : { color: 'var(--sn-muted)' }
                                    }
                                >
                                    {t.label}
                                    <span
                                        className="rounded-full px-1.5 py-0.5 text-[11px] leading-none font-semibold"
                                        style={
                                            tab === t.id
                                                ? {
                                                      background:
                                                          t.id === 'pending'
                                                              ? 'rgba(245,158,11,0.12)'
                                                              : 'color-mix(in oklch, var(--sn-accent) 12%, transparent)',
                                                      color:
                                                          t.id === 'pending'
                                                              ? '#b45309'
                                                              : 'var(--sn-700)',
                                                  }
                                                : {
                                                      background:
                                                          'var(--sn-surface-2)',
                                                      color: 'var(--sn-muted)',
                                                  }
                                        }
                                    >
                                        {t.count}
                                    </span>
                                </button>
                            ))}
                        </div>

                        {/* Article list */}
                        <div
                            className="overflow-hidden rounded-xl"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                            }}
                        >
                            {articles.length === 0 ? (
                                <div
                                    className="px-6 py-12 text-center text-[13px]"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {tab === 'pending'
                                        ? 'Aucun article en attente de validation.'
                                        : tab === 'approved'
                                          ? 'Aucun article approuvé en attente de publication.'
                                          : 'Aucun article publié.'}
                                </div>
                            ) : (
                                articles.map((a, i) => (
                                    <ArticleRow
                                        key={a.id}
                                        article={a}
                                        tab={tab}
                                        last={i === articles.length - 1}
                                        canDelete={canDelete}
                                        onApprove={() => setApproveTarget(a)}
                                        onDecline={() => setDeclineTarget(a)}
                                        onDelete={() => setDeleteTarget(a)}
                                    />
                                ))
                            )}
                        </div>
                    </main>
                </div>
            </div>

            {/* Approve confirm */}
            <ConfirmModal
                open={approveTarget !== null}
                onClose={() => setApproveTarget(null)}
                onConfirm={confirmApprove}
                icon={
                    <CheckCircle size={18} style={{ color: 'var(--sn-700)' }} />
                }
                iconBg="color-mix(in oklch, var(--sn-accent) 12%, transparent)"
                title="Approuver l'article"
                description={
                    <>
                        L'article{' '}
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            «&nbsp;{approveTarget?.title}&nbsp;»
                        </strong>{' '}
                        sera approuvé.{' '}
                        {approveTarget?.published_at &&
                        new Date(approveTarget.published_at) > new Date()
                            ? `Il sera publié le ${fmtDate(approveTarget.published_at)}.`
                            : 'Il sera publié immédiatement.'}
                    </>
                }
                confirmLabel="Approuver"
                confirmStyle={{
                    background: 'var(--sn-accent)',
                    color: 'var(--sn-accent-fg)',
                }}
            />

            {/* Decline confirm */}
            <ConfirmModal
                open={declineTarget !== null}
                onClose={() => setDeclineTarget(null)}
                onConfirm={confirmDecline}
                icon={
                    <XCircle
                        size={18}
                        style={{ color: 'var(--destructive)' }}
                    />
                }
                iconBg="color-mix(in oklch, var(--destructive) 10%, transparent)"
                title="Refuser l'article"
                description={
                    <>
                        L'article{' '}
                        <strong style={{ color: 'var(--sn-fg)' }}>
                            «&nbsp;{declineTarget?.title}&nbsp;»
                        </strong>{' '}
                        sera refusé et l'auteur en sera informé.
                    </>
                }
                confirmLabel="Refuser"
                confirmStyle={{
                    background: 'var(--destructive)',
                    color: '#fff',
                }}
            />

            {/* Delete confirm */}
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
        </>
    );
}

function ArticleRow({
    article: a,
    tab,
    last,
    canDelete,
    onApprove,
    onDecline,
    onDelete,
}: {
    article: ManageArticle;
    tab: Tab;
    last: boolean;
    canDelete: boolean;
    onApprove: () => void;
    onDecline: () => void;
    onDelete: () => void;
}) {
    return (
        <div
            className="flex flex-wrap items-start justify-between gap-4 px-6 py-5"
            style={{
                borderBottom: last ? 'none' : '1px solid var(--sn-border)',
            }}
        >
            <div className="min-w-0 flex-1">
                <div className="flex flex-wrap items-center gap-2">
                    <span
                        className="text-[15px] font-semibold tracking-tight"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        {a.title}
                    </span>
                    <span
                        className="rounded px-1.5 py-0.5 text-[10px] font-medium uppercase"
                        style={{
                            background: 'var(--sn-surface-2)',
                            color: 'var(--sn-muted)',
                        }}
                    >
                        {a.locale}
                    </span>
                </div>

                <div
                    className="mt-1 text-[11.5px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    par {a.author.name} (@{a.author.username})
                    {tab === 'pending' && a.submitted_at && (
                        <> · soumis le {fmtDate(a.submitted_at)}</>
                    )}
                    {tab === 'approved' && a.published_at && (
                        <> · publication prévue le {fmtDate(a.published_at)}</>
                    )}
                    {tab === 'approved' && a.approved_at && (
                        <> · approuvé le {fmtDate(a.approved_at)}</>
                    )}
                    {tab === 'published' && a.published_at && (
                        <> · publié le {fmtDate(a.published_at)}</>
                    )}
                    {' · '}
                    {a.reading_time_minutes} min
                </div>

                {a.tags.length > 0 && (
                    <div className="mt-2 flex flex-wrap gap-1">
                        {a.tags.map((t) => (
                            <span
                                key={t.id}
                                className="rounded-full px-2 py-0.5 text-[10.5px]"
                                style={{
                                    background:
                                        'color-mix(in oklch, var(--sn-accent) 10%, transparent)',
                                    color: 'var(--sn-700)',
                                }}
                            >
                                {t.name}
                            </span>
                        ))}
                    </div>
                )}
            </div>

            <div className="flex shrink-0 items-center gap-1.5">
                {tab === 'pending' && (
                    <>
                        <button
                            onClick={onApprove}
                            className="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[12px] font-semibold transition-colors"
                            style={{
                                background:
                                    'color-mix(in oklch, var(--sn-accent) 12%, transparent)',
                                color: 'var(--sn-700)',
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.background =
                                    'color-mix(in oklch, var(--sn-accent) 20%, transparent)';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.background =
                                    'color-mix(in oklch, var(--sn-accent) 12%, transparent)';
                            }}
                        >
                            <CheckCircle size={13} />
                            Approuver
                        </button>
                        <button
                            onClick={onDecline}
                            className="flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-[12px] font-semibold transition-colors"
                            style={{
                                background:
                                    'color-mix(in oklch, var(--destructive) 8%, transparent)',
                                color: 'var(--destructive)',
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.background =
                                    'color-mix(in oklch, var(--destructive) 14%, transparent)';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.background =
                                    'color-mix(in oklch, var(--destructive) 8%, transparent)';
                            }}
                        >
                            <XCircle size={13} />
                            Refuser
                        </button>
                    </>
                )}
                {canDelete && (
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
