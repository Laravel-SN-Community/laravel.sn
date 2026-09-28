import { ArrowRight, ExternalLink } from 'lucide-react';

interface Repo {
    name: string;
    desc: string;
    href: string;
}

const REPOS: Repo[] = [
    {
        name: 'wolof-validator',
        desc: 'Règles de validation Laravel localisées pour les formats sénégalais : numéros Orange/Free/Expresso, NINEA, RCCM, dates en wolof.',
        href: 'github.com/laravel-sn/wolof-validator',
    },
    {
        name: 'teranga-ui',
        desc: "Kit de composants Blade + Tailwind inspiré du design sénégalais — boutons, cartes, formulaires prêts pour l'emploi.",
        href: 'github.com/laravel-sn/teranga-ui',
    },
    {
        name: 'mobile-money-php',
        desc: 'SDK unifié pour Wave, Orange Money et Free Money. Une seule API, trois providers, webhooks signés, sandbox incluse.',
        href: 'github.com/laravel-sn/mobile-money-php',
    },
    {
        name: 'laravel-fr-starter',
        desc: 'Template Laravel configuré en français : timezone Africa/Dakar, locale fr_SN, Inertia + Breeze, CI GitHub Actions.',
        href: 'github.com/laravel-sn/laravel-fr-starter',
    },
    {
        name: 'sn-geo',
        desc: 'Données géographiques du Sénégal : régions, départements, communes. Migrations, seeders, helpers Eloquent.',
        href: 'github.com/laravel-sn/sn-geo',
    },
    {
        name: 'ndank-queue',
        desc: 'Driver de queue Laravel tolérant aux coupures réseau — persistance locale, reprise automatique, idéal connexions instables.',
        href: 'github.com/laravel-sn/ndank-queue',
    },
];

function RepoCard({ name, desc, href }: Repo) {
    return (
        <a
            href={`https://${href}`}
            target="_blank"
            rel="noopener noreferrer"
            className="group flex h-full flex-col p-7 transition-colors hover:bg-[color:var(--sn-surface-2)]"
        >
            {/* GitHub icon */}
            <svg
                width="28"
                height="28"
                viewBox="0 0 16 16"
                fill="currentColor"
                aria-hidden
                style={{ color: 'var(--sn-fg)', opacity: 0.9 }}
            >
                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8Z" />
            </svg>

            {/* Repo name */}
            <div className="mt-6 flex items-center gap-1.5">
                <span
                    className="text-[15px] font-semibold tracking-tight"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    {name}
                </span>
                <ExternalLink
                    size={14}
                    className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                    style={{ color: 'var(--sn-muted)' }}
                />
            </div>

            <p
                className="mt-3 text-[13.5px] leading-relaxed"
                style={{ color: 'var(--sn-muted)' }}
            >
                {desc}
            </p>
        </a>
    );
}

export default function OpenSourceSection() {
    return (
        <section className="mx-auto mt-24 max-w-[1400px] px-6 lg:px-10">
            <div className="mb-10 max-w-[56ch]">
                <h2
                    className="mt-2 text-[30px] font-semibold tracking-tight"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    Notre écosystème open source
                </h2>
                <p
                    className="mt-3 text-[14px] leading-relaxed"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Des outils construits par la communauté, pour la communauté.
                    Contributions, issues et PR bienvenues.
                </p>
            </div>

            <div
                className="overflow-hidden rounded-[12px]"
                style={{
                    border: '1px solid var(--sn-border)',
                    background: 'var(--sn-surface)',
                }}
            >
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    {REPOS.map((r, i) => {
                        const col = i % 3;
                        const row = Math.floor(i / 3);
                        const lastRow =
                            row === Math.floor((REPOS.length - 1) / 3);

                        return (
                            <div
                                key={r.name}
                                className="flex flex-col"
                                style={{
                                    borderRight:
                                        col !== 2
                                            ? '1px solid var(--sn-border)'
                                            : 'none',
                                    borderBottom: !lastRow
                                        ? '1px solid var(--sn-border)'
                                        : 'none',
                                }}
                            >
                                <RepoCard {...r} />
                            </div>
                        );
                    })}
                </div>
            </div>

            <div className="mt-6 flex justify-end">
                <a
                    href="https://github.com/laravel-sn"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="sn-btn sn-btn-ghost sn-btn-sm"
                >
                    Proposer un projet <ArrowRight size={13} />
                </a>
            </div>
        </section>
    );
}
