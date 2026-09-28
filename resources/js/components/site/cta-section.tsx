export default function CtaSection() {
    return (
        <section className="mx-auto mt-24 max-w-[1400px] px-6 lg:px-10">
            <div
                className="sn-cta-bg relative overflow-hidden rounded-[16px] p-10 md:p-14"
                style={{ color: '#fff' }}
            >
                {/* Grid overlay */}
                <div
                    className="bg-sn-grid pointer-events-none absolute inset-0 opacity-[0.07]"
                    aria-hidden
                />

                {/* Glow */}
                <div
                    className="pointer-events-none absolute -top-24 -right-24 h-[420px] w-[420px] rounded-full opacity-30 blur-3xl"
                    aria-hidden
                    style={{
                        background:
                            'radial-gradient(closest-side, var(--sn-400), transparent 70%)',
                    }}
                />

                <div className="relative grid items-center gap-8 lg:grid-cols-12">
                    {/* Copy */}
                    <div className="lg:col-span-8">
                        <h2 className="mt-5 max-w-[22ch] text-[34px] leading-[1.05] font-semibold tracking-[-0.02em] sm:text-[42px]">
                            Apprends, partage, construis — avec la{' '}
                            <span style={{ color: 'var(--sn-400)' }}>
                                communauté
                            </span>
                            .
                        </h2>

                        <p
                            className="mt-4 max-w-[52ch] text-[15px] leading-relaxed"
                            style={{ color: 'rgba(255,255,255,.72)' }}
                        >
                            Rejoins 500+ développeurs sur WhatsApp. Événements
                            mensuels, code reviews, offres d'emploi, entraide —
                            le tout en français.
                        </p>
                    </div>

                    {/* CTAs */}
                    <div className="flex flex-col gap-3 lg:col-span-4">
                        <a
                            href="https://chat.whatsapp.com/Cjeivt4kyDmFx3L8QB7rFE"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="sn-btn sn-btn-primary w-full justify-center"
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.534 5.856L.057 23.625a.375.375 0 0 0 .458.464l5.884-1.543A11.947 11.947 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.72 9.72 0 0 1-4.95-1.352l-.353-.21-3.65.957.975-3.563-.232-.366A9.694 9.694 0 0 1 2.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z" />
                            </svg>
                            Rejoindre WhatsApp
                        </a>

                        <span
                            className="text-center font-mono text-[11px]"
                            style={{ color: 'rgba(255,255,255,.5)' }}
                        >
                            ou ·{' '}
                            <a
                                href="https://github.com/laravel-sn/laravel.sn"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="underline hover:text-white"
                            >
                                GitHub
                            </a>{' '}
                            ·{' '}
                            <a
                                href="/newsletter"
                                className="underline hover:text-white"
                            >
                                Newsletter
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </section>
    );
}
