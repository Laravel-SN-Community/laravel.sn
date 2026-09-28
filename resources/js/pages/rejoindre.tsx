import { Head } from '@inertiajs/react';
import { ArrowRight, Check } from 'lucide-react';

const BENEFITS = [
    "Groupe WhatsApp actif — 500+ développeurs, réponses en moins d'une heure",
    'Accès aux meetups mensuels à Dakar avec replay vidéo',
    "Newsletter mensuelle : liens, tutos, offres d'emploi curatés",
    'Accès aux repos open source de la communauté (laravel-sn)',
    'Mise en relation pour missions freelance et recrutements CDI',
];

const TOPICS = [
    'Laravel & PHP',
    'Code reviews',
    "Offres d'emploi",
    'Projets & freelance',
    'Événements',
    'Ressources',
    'Open source',
    'Entraide',
];

const WhatsAppIcon = () => (
    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.534 5.856L.057 23.625a.375.375 0 0 0 .458.464l5.884-1.543A11.947 11.947 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.72 9.72 0 0 1-4.95-1.352l-.353-.21-3.65.957.975-3.563-.232-.366A9.694 9.694 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z" />
    </svg>
);

export default function Rejoindre() {
    return (
        <>
            <Head title="Rejoindre" />

            <div className="mx-auto max-w-[1400px] px-6 pt-16 pb-24 lg:px-10">
                {/* Hero */}
                <div className="mb-14 max-w-[660px]">
                    <h1
                        className="text-[38px] leading-[1.05] font-semibold tracking-[-0.025em] sm:text-[48px]"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        La communauté{' '}
                        <span style={{ color: 'var(--sn-accent)' }}>
                            Laravel
                        </span>{' '}
                        du Sénégal t'attend.
                    </h1>
                    <p
                        className="mt-4 text-[16px] leading-[1.65]"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        500+ développeurs Laravel au Sénégal et en diaspora.
                        Entraide, événements, code reviews et offres d'emploi —
                        en français, gratuitement.
                    </p>

                    {/* Stats */}
                    <div
                        className="mt-8 flex flex-wrap gap-8 border-t pt-6"
                        style={{ borderColor: 'var(--sn-border)' }}
                    >
                        {[
                            ['500+', 'développeurs'],
                            ['8', 'meetups organisés'],
                            ['2021', 'année de création'],
                            ['6', 'packages open source'],
                        ].map(([n, l]) => (
                            <div key={l}>
                                <div
                                    className="font-mono text-[26px] font-medium tracking-tight"
                                    style={{ color: 'var(--sn-fg)' }}
                                >
                                    {n}
                                </div>
                                <div
                                    className="mt-0.5 text-[11.5px] tracking-wide uppercase"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {l}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* WhatsApp CTA — full width prominent card */}
                <div
                    className="overflow-hidden rounded-2xl"
                    style={{ background: 'var(--sn-700)' }}
                >
                    <div className="grid lg:grid-cols-[1fr_380px]">
                        {/* Left */}
                        <div className="flex flex-col justify-between gap-8 p-8 lg:p-10">
                            <div>
                                <div className="flex items-center gap-3">
                                    <div
                                        className="flex h-10 w-10 items-center justify-center rounded-xl"
                                        style={{
                                            background:
                                                'rgba(255,255,255,0.15)',
                                        }}
                                    >
                                        <span style={{ color: '#fff' }}>
                                            <WhatsAppIcon />
                                        </span>
                                    </div>
                                    <div>
                                        <div className="font-semibold text-white">
                                            WhatsApp
                                        </div>
                                        <div
                                            className="text-[12.5px]"
                                            style={{
                                                color: 'rgba(255,255,255,0.6)',
                                            }}
                                        >
                                            500+ membres actifs
                                        </div>
                                    </div>
                                </div>

                                <p
                                    className="mt-6 max-w-[46ch] text-[15px] leading-[1.7]"
                                    style={{ color: 'rgba(255,255,255,0.75)' }}
                                >
                                    Le canal principal de la communauté.
                                    Discussions en temps réel, partage de liens,
                                    annonces d'événements et entraide
                                    quotidienne — des réponses en moins d'une
                                    heure.
                                </p>
                            </div>

                            <a
                                href="https://chat.whatsapp.com/Cjeivt4kyDmFx3L8QB7rFE"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex w-fit items-center gap-2 rounded-xl px-6 py-3 text-[14px] font-semibold transition-opacity hover:opacity-90"
                                style={{
                                    background: '#fff',
                                    color: 'var(--sn-700)',
                                }}
                            >
                                Rejoindre le groupe WhatsApp
                                <ArrowRight size={15} />
                            </a>
                        </div>

                        {/* Right — topics */}
                        <div
                            className="flex flex-col justify-center gap-4 p-8 lg:border-l lg:p-10"
                            style={{ borderColor: 'rgba(255,255,255,0.1)' }}
                        >
                            <div
                                className="text-[11px] font-semibold tracking-widest uppercase"
                                style={{ color: 'rgba(255,255,255,0.45)' }}
                            >
                                Ce qu'on y discute
                            </div>
                            <div className="flex flex-wrap gap-2">
                                {TOPICS.map((t) => (
                                    <span
                                        key={t}
                                        className="rounded-full px-3 py-1 text-[12.5px] font-medium"
                                        style={{
                                            background: 'rgba(255,255,255,0.1)',
                                            color: 'rgba(255,255,255,0.8)',
                                        }}
                                    >
                                        {t}
                                    </span>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Benefits */}
                <div
                    className="mt-8 rounded-2xl p-8"
                    style={{
                        background: 'var(--sn-surface)',
                        border: '1px solid var(--sn-border)',
                    }}
                >
                    <h2
                        className="mb-6 text-[17px] font-semibold tracking-tight"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        Ce que tu obtiens
                    </h2>
                    <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        {BENEFITS.map((b, i) => (
                            <div key={i} className="flex items-start gap-3">
                                <span
                                    className="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full"
                                    style={{
                                        background:
                                            'color-mix(in oklch, var(--sn-accent) 14%, transparent)',
                                        color: 'var(--sn-accent)',
                                    }}
                                >
                                    <Check size={11} />
                                </span>
                                <span
                                    className="text-[13.5px] leading-relaxed"
                                    style={{ color: 'var(--sn-muted)' }}
                                >
                                    {b}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </>
    );
}
