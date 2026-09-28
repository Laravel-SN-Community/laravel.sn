import { Link } from '@inertiajs/react';
import type { FormEvent } from 'react';
import SiteWordmark from '@/components/site/site-wordmark';

type FooterItem = [label: string, href: string, soon?: boolean];

const footerCols: { title: string; items: FooterItem[] }[] = [
    {
        title: 'Ressources',
        items: [
            ['Changelog', '/changelog', true],
            ['Sponsors', '/sponsors', true],
        ],
    },
    {
        title: 'Legal',
        items: [
            ['Code de conduite', '/rules'],
            ["Conditions d'utilisation", '/terms'],
            ['Confidentialité', '/privacy'],
        ],
    },
];

const socialLinks = [
    {
        label: 'X / Twitter',
        href: 'https://x.com/laravel_sn',
        icon: (
            <svg viewBox="0 0 24 24" className="h-4 w-4" fill="currentColor">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.629L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z" />
            </svg>
        ),
    },
    {
        label: 'GitHub',
        href: 'https://github.com/laravel-sn/laravel.sn',
        icon: (
            <svg viewBox="0 0 24 24" className="h-4 w-4" fill="currentColor">
                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844a9.59 9.59 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2z" />
            </svg>
        ),
    },
    {
        label: 'WhatsApp',
        href: 'https://chat.whatsapp.com/Cjeivt4kyDmFx3L8QB7rFE',
        icon: (
            <svg viewBox="0 0 24 24" className="h-4 w-4" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
        ),
    },
    {
        label: 'LinkedIn',
        href: 'https://www.linkedin.com/company/laravel-senegal/',
        icon: (
            <svg viewBox="0 0 24 24" className="h-4 w-4" fill="currentColor">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
            </svg>
        ),
    },
];

export default function SiteFooter() {
    const handleNewsletter = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
    };

    return (
        <footer
            className="mt-20 border-t"
            style={{
                borderColor: 'var(--sn-border)',
                background: 'var(--sn-bg)',
            }}
        >
            <div className="mx-auto grid max-w-350 gap-10 px-6 pt-14 pb-10 md:grid-cols-12 lg:px-10">
                {/* Brand column */}
                <div className="md:col-span-5">
                    <Link href="/">
                        <SiteWordmark logoSize="lg" />
                    </Link>

                    <p
                        className="mt-4 max-w-[42ch] text-[13.5px] leading-relaxed"
                        style={{ color: 'var(--sn-muted)' }}
                    >
                        La communauté francophone ouest-africaine des
                        développeurs Laravel.
                    </p>

                    <form
                        onSubmit={handleNewsletter}
                        className="mt-3 flex max-w-sm gap-2"
                    >
                        <input
                            type="email"
                            placeholder="ton@email.com"
                            aria-label="Email pour la newsletter"
                            className="flex-1 rounded-md border px-3 py-2 text-[14px] transition-[border-color,box-shadow] outline-none placeholder:text-(--sn-muted) focus:border-(--sn-accent) focus:[box-shadow:0_0_0_3px_color-mix(in_oklch,var(--sn-accent)_22%,transparent)]"
                            style={{
                                background: 'var(--sn-surface)',
                                border: '1px solid var(--sn-border)',
                                color: 'var(--sn-fg)',
                            }}
                        />
                        <button type="submit" className="sn-btn sn-btn-primary">
                            S'abonner
                        </button>
                    </form>

                    {/*<div*/}
                    {/*    className="mt-3 font-mono text-[11.5px]"*/}
                    {/*    style={{ color: 'var(--sn-muted)' }}*/}
                    {/*>*/}
                    {/*    1 newsletter par mois. zéro spam.*/}
                    {/*</div>*/}
                </div>

                {/* Link columns */}
                <div className="grid grid-cols-2 gap-6 md:col-span-7">
                    {footerCols.map((col) => (
                        <div key={col.title}>
                            <div
                                className="mb-3 text-[10.5px] font-bold tracking-[0.2em] uppercase"
                                style={{ color: 'var(--sn-fg)' }}
                            >
                                {col.title}
                            </div>
                            <ul className="space-y-2">
                                {col.items.map(([label, href, soon]) => (
                                    <li key={label}>
                                        {soon ? (
                                            <span
                                                className="inline-flex items-center gap-2 text-[13.5px]"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                    opacity: 0.5,
                                                    cursor: 'default',
                                                }}
                                            >
                                                {label}
                                                <span
                                                    className="rounded px-1.5 py-0.5 text-[9.5px] font-bold tracking-wide uppercase"
                                                    style={{
                                                        background:
                                                            'color-mix(in oklch, var(--sn-accent) 12%, transparent)',
                                                        color: 'var(--sn-accent)',
                                                    }}
                                                >
                                                    soon
                                                </span>
                                            </span>
                                        ) : href.startsWith('http') ? (
                                            <a
                                                href={href}
                                                className="sn-navlink text-[13.5px]"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                {label}
                                            </a>
                                        ) : (
                                            <Link
                                                href={href}
                                                className="sn-navlink text-[13.5px]"
                                            >
                                                {label}
                                            </Link>
                                        )}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    ))}
                </div>
            </div>

            {/* Bottom bar */}
            <div
                className="border-t"
                style={{ borderColor: 'var(--sn-border)' }}
            >
                <div
                    className="mx-auto flex max-w-350 flex-wrap items-center justify-between gap-3 px-6 py-5 text-[11.5px] font-semibold lg:px-10"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    <span>
                        © 2021 - 2026 Laravel Sénégal. Tous droits réservés.
                    </span>
                    {/*<a href="/mentions-legales" className="sn-navlink">*/}
                    {/*    Mentions légales*/}
                    {/*</a>*/}
                    <div className="flex items-center gap-3">
                        {socialLinks.map(({ label, href, icon }) => (
                            <a
                                key={label}
                                href={href}
                                aria-label={label}
                                target={
                                    href.startsWith('http')
                                        ? '_blank'
                                        : undefined
                                }
                                rel={
                                    href.startsWith('http')
                                        ? 'noopener noreferrer'
                                        : undefined
                                }
                                className="transition-colors hover:text-(--sn-fg)"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                {icon}
                            </a>
                        ))}
                    </div>
                </div>
            </div>
        </footer>
    );
}
