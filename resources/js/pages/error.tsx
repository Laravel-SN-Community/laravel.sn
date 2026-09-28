import { Head, Link } from '@inertiajs/react';
import type { ReactNode } from 'react';
import {
    ErrorCode,
    ErrorTerminal,
    TerminalCaret,
    TerminalLine,
    TypedCommand,
} from '@/components/site/error-terminal';
import type { ZeroKind } from '@/components/site/error-terminal';

interface ErrorProps {
    status: number;
    path?: string;
}

interface Variant {
    kind: ZeroKind;
    glow: string;
    title: string;
    description: string;
    terminal: ReactNode;
    actions: ReactNode;
}

function notFoundVariant(path?: string): Variant {
    const shown =
        path && path !== '/'
            ? `/${path.replace(/^\//, '')}`.slice(0, 26)
            : '/cette-page';

    return {
        kind: 'search',
        glow: 'var(--sn-accent)',
        title: "Cette route n'existe pas.",
        description:
            'Le lien est peut-être cassé, ou la page a déménagé sans laisser d’adresse. Tout le reste fonctionne, promis.',
        terminal: (
            <ErrorTerminal
                file="routes/web.php"
                footerLeft="php artisan route:list"
                footerRight="exit 1"
            >
                <TypedCommand text={`php artisan route:list --path=${shown}`} />
                <TerminalLine delay={1.7} color="var(--sn-laravel)">
                    0 route trouvée.
                </TerminalLine>
                <TerminalLine delay={2.1} color="var(--sn-code-comment)">
                    → essayez plutôt :{' '}
                    <span style={{ color: 'var(--sn-accent)' }}>/articles</span>{' '}
                    · <span style={{ color: 'var(--sn-accent)' }}>/forum</span>{' '}
                    · <span style={{ color: 'var(--sn-accent)' }}>/events</span>
                </TerminalLine>
                <TerminalLine delay={2.5}>
                    <span style={{ color: 'var(--sn-code-comment)' }}>$ </span>
                    <TerminalCaret />
                </TerminalLine>
            </ErrorTerminal>
        ),
        actions: (
            <>
                <Link href="/" className="sn-btn sn-btn-primary">
                    ← Accueil
                </Link>
                <Link href="/articles" className="sn-btn sn-btn-secondary">
                    Articles
                </Link>
                <Link href="/forum" className="sn-btn sn-btn-secondary">
                    Forum
                </Link>
            </>
        ),
    };
}

function forbiddenVariant(): Variant {
    return {
        kind: 'lock',
        glow: 'var(--sn-accent)',
        title: 'Zone réservée.',
        description:
            "Vous n'avez pas la permission de voir cette page. Connectez-vous, ou demandez l'accès à un modérateur sur le forum.",
        terminal: (
            <ErrorTerminal
                file="app/Policies/PagePolicy.php"
                footerLeft="psysh › tinker"
                footerRight="Gate::denies"
            >
                <TypedCommand
                    prompt=">>> "
                    text="Gate::allows('voir-cette-page')"
                />
                <TerminalLine delay={1.7}>
                    <span style={{ color: 'var(--sn-code-comment)' }}>
                        =&gt;{' '}
                    </span>
                    <span style={{ color: 'var(--sn-laravel)' }}>false</span>
                </TerminalLine>
                <TerminalLine delay={2.1}>
                    <span style={{ color: 'var(--sn-code-keyword)' }}>
                        abort
                    </span>
                    (403,{' '}
                    <span style={{ color: 'var(--sn-code-string)' }}>
                        "La teranga a ses limites."
                    </span>
                    );
                    <TerminalCaret />
                </TerminalLine>
            </ErrorTerminal>
        ),
        actions: (
            <>
                <Link href="/login" className="sn-btn sn-btn-primary">
                    Se connecter
                </Link>
                <Link href="/" className="sn-btn sn-btn-secondary">
                    Accueil
                </Link>
            </>
        ),
    };
}

function serverErrorVariant(): Variant {
    return {
        kind: 'crash',
        glow: 'var(--sn-laravel)',
        title: 'Quelque chose a cassé. De notre côté.',
        description:
            "L'équipe est prévenue et lit déjà les logs. Réessayez dans un instant.",
        terminal: (
            <ErrorTerminal
                file="storage/logs/laravel.log"
                footerLeft="HTTP 500"
                footerRight="incident signalé ●"
            >
                <TypedCommand
                    prompt=""
                    text="[2026-06-10 14:02:11] prod.ERROR:"
                />
                <TerminalLine delay={1.6}>
                    <span style={{ color: 'var(--sn-laravel)' }}>
                        ErrorException
                    </span>{' '}
                    — Undefined variable{' '}
                    <span style={{ color: 'var(--sn-code-class)' }}>
                        $patience
                    </span>
                </TerminalLine>
                <TerminalLine delay={2.0} color="var(--sn-code-comment)">
                    {'  app/Http/Controllers/PageController.php:42'}
                </TerminalLine>
                <TerminalLine delay={2.3} color="var(--sn-code-comment)">
                    {'  #0 vendor/laravel/framework/.../Router.php:721'}
                </TerminalLine>
                <TerminalLine delay={2.6} color="var(--sn-code-comment)">
                    {'  #1 {main}'}
                    <TerminalCaret color="var(--sn-laravel)" />
                </TerminalLine>
            </ErrorTerminal>
        ),
        actions: (
            <>
                <button
                    type="button"
                    onClick={() => window.location.reload()}
                    className="sn-btn sn-btn-primary"
                >
                    Réessayer
                </button>
                <Link href="/" className="sn-btn sn-btn-secondary">
                    Accueil
                </Link>
                <Link href="/forum" className="sn-btn sn-btn-secondary">
                    Signaler sur le forum
                </Link>
            </>
        ),
    };
}

function variantFor(status: number, path?: string): Variant {
    if (status === 403) {
        return forbiddenVariant();
    }

    if (status === 404) {
        return notFoundVariant(path);
    }

    return serverErrorVariant();
}

export default function Error({ status, path }: ErrorProps) {
    const { kind, glow, title, description, terminal, actions } = variantFor(
        status,
        path,
    );

    return (
        <>
            <Head title={`${status}`} />

            <section className="relative overflow-hidden">
                {/* Soft radial glow tinted by the error kind */}
                <div
                    aria-hidden
                    className="pointer-events-none absolute -top-32 left-1/2 h-[420px] w-[640px] -translate-x-1/2 opacity-[.07]"
                    style={{
                        background: `radial-gradient(closest-side, ${glow}, transparent 70%)`,
                    }}
                />

                <div className="relative mx-auto max-w-[720px] px-6 pt-20 pb-24 text-center lg:pt-24 lg:pb-32">
                    <div className="sn-fade-up">
                        <ErrorCode code={String(status)} kind={kind} />
                    </div>

                    <h1
                        className="sn-fade-up mt-6 text-[26px] font-semibold tracking-[-0.02em] sm:text-[32px]"
                        style={{
                            animationDelay: '.12s',
                            color: 'var(--sn-fg)',
                        }}
                    >
                        {title}
                    </h1>
                    <p
                        className="sn-fade-up mx-auto mt-3 max-w-[46ch] text-[15.5px] leading-[1.6]"
                        style={{
                            animationDelay: '.16s',
                            color: 'var(--sn-muted)',
                        }}
                    >
                        {description}
                    </p>

                    <div
                        className="sn-fade-up mx-auto mt-10 max-w-[560px]"
                        style={{ animationDelay: '.22s' }}
                    >
                        {terminal}
                    </div>

                    <div
                        className="sn-fade-up mt-8 flex flex-wrap justify-center gap-2"
                        style={{ animationDelay: '.3s' }}
                    >
                        {actions}
                    </div>
                </div>
            </section>
        </>
    );
}
