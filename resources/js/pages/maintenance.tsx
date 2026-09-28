import { Head } from '@inertiajs/react';
import {
    ErrorCode,
    ErrorTerminal,
    TerminalCaret,
    TerminalLine,
    TypedCommand,
} from '@/components/site/error-terminal';
import SiteWordmark from '@/components/site/site-wordmark';

/**
 * Standalone maintenance page — rendered without any site layout so no
 * navbar, footer or navigation leaks while the app is down.
 */
export default function Maintenance() {
    return (
        <>
            <Head title="Maintenance" />

            <div
                className="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-6 py-16 text-center"
                style={{ background: 'var(--sn-bg)' }}
            >
                <div
                    aria-hidden
                    className="pointer-events-none absolute -top-32 left-1/2 h-[420px] w-[640px] -translate-x-1/2 opacity-[.07]"
                    style={{
                        background:
                            'radial-gradient(closest-side, var(--sn-accent), transparent 70%)',
                    }}
                />

                <div className="sn-fade-up relative">
                    <SiteWordmark logoSize="lg" />
                </div>

                <div
                    className="sn-fade-up relative mt-10"
                    style={{ animationDelay: '.08s' }}
                >
                    <ErrorCode code="503" kind="work" />
                </div>

                <h1
                    className="sn-fade-up relative mt-6 text-[26px] font-semibold tracking-[-0.02em] sm:text-[32px]"
                    style={{ animationDelay: '.14s', color: 'var(--sn-fg)' }}
                >
                    On améliore le site.
                </h1>
                <p
                    className="sn-fade-up relative mx-auto mt-3 max-w-[46ch] text-[15.5px] leading-[1.6]"
                    style={{ animationDelay: '.18s', color: 'var(--sn-muted)' }}
                >
                    Maintenance en cours — on revient dans quelques minutes.
                    Merci pour la patience.
                </p>

                <div
                    className="sn-fade-up relative mt-10 w-full max-w-[560px]"
                    style={{ animationDelay: '.24s' }}
                >
                    <ErrorTerminal
                        file="php artisan down"
                        footerLeft="mode maintenance"
                        footerRight="retour imminent"
                    >
                        <TypedCommand text="php artisan down" />
                        <TerminalLine delay={1.7} color="var(--sn-accent)">
                            Application is now in maintenance mode.
                        </TerminalLine>
                        <TerminalLine delay={2.1} className="my-2">
                            <div className="sn-err-bar">
                                <i />
                            </div>
                        </TerminalLine>
                        <TerminalLine
                            delay={2.4}
                            color="var(--sn-code-comment)"
                        >
                            $ php artisan up{' '}
                            <span style={{ opacity: 0.7 }}>
                                {'// dans quelques minutes'}
                            </span>
                            <TerminalCaret />
                        </TerminalLine>
                    </ErrorTerminal>
                </div>

                <div
                    className="sn-fade-up relative mt-8 flex flex-wrap justify-center gap-2"
                    style={{ animationDelay: '.3s' }}
                >
                    <button
                        type="button"
                        onClick={() => window.location.reload()}
                        className="sn-btn sn-btn-primary"
                    >
                        Réessayer
                    </button>
                    <a
                        href="https://github.com/Laravel-SN-Community"
                        target="_blank"
                        rel="noreferrer"
                        className="sn-btn sn-btn-secondary"
                    >
                        Suivre sur GitHub
                    </a>
                </div>
            </div>
        </>
    );
}
