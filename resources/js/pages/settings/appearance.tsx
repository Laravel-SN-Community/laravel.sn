import { Form, Head } from '@inertiajs/react';
import { useRef, useState } from 'react';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import DashSidebar from '@/components/site/dashboard-sidebar';
import ThemeToggle from '@/components/site/theme-toggle';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

function DashCard({
    eyebrow,
    title,
    children,
}: {
    eyebrow?: string;
    title?: string;
    children: React.ReactNode;
}) {
    return (
        <div
            className="rounded-xl p-6"
            style={{
                background: 'var(--sn-surface)',
                border: '1px solid var(--sn-border)',
            }}
        >
            {eyebrow && (
                <div
                    className="font-mono text-[10.5px] tracking-[0.18em] uppercase"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    {eyebrow}
                </div>
            )}
            {title && (
                <h3
                    className="mt-1 text-[18px] font-semibold tracking-[-0.01em]"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    {title}
                </h3>
            )}
            <div className="mt-4">{children}</div>
        </div>
    );
}

const EMAIL_PREFS = [
    {
        key: 'digest',
        title: 'Digest hebdomadaire',
        desc: 'Tous les vendredis, les meilleurs articles + meetups à venir.',
        defaultOn: true,
    },
    {
        key: 'replies',
        title: 'Réponses à mes commentaires',
        desc: "Quand quelqu'un répond à un commentaire que j'ai posté.",
        defaultOn: true,
    },
    {
        key: 'events',
        title: "Rappels d'évènements",
        desc: '24h avant un évènement où je suis inscrit·e.',
        defaultOn: false,
    },
] as const;

export default function Appearance() {
    const passwordInput = useRef<HTMLInputElement>(null);
    const [emailPrefs, setEmailPrefs] = useState<Record<string, boolean>>({
        digest: true,
        replies: true,
        events: false,
    });

    return (
        <>
            <Head title="Paramètres" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="settings" />

                    <main className="min-w-0 space-y-6">
                        <h1
                            className="text-[32px] font-semibold tracking-[-0.02em]"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Paramètres
                        </h1>

                        <DashCard eyebrow="// apparence" title="Thème">
                            <ThemeToggle />
                        </DashCard>

                        <DashCard eyebrow="// notifications" title="Email">
                            <div className="space-y-1">
                                {EMAIL_PREFS.map((row, i) => (
                                    <div
                                        key={row.key}
                                        className="flex cursor-pointer items-start gap-3 py-3"
                                        style={{
                                            borderTop:
                                                i === 0
                                                    ? 'none'
                                                    : '1px solid var(--sn-border)',
                                        }}
                                        onClick={() =>
                                            setEmailPrefs((p) => ({
                                                ...p,
                                                [row.key]: !p[row.key],
                                            }))
                                        }
                                    >
                                        <button
                                            type="button"
                                            className="mt-0.5 h-5 w-9 shrink-0 rounded-full p-0.5 transition-colors"
                                            style={{
                                                background: emailPrefs[row.key]
                                                    ? 'var(--sn-700)'
                                                    : 'var(--sn-surface-2)',
                                            }}
                                        >
                                            <span
                                                className="block h-4 w-4 rounded-full bg-white transition-transform"
                                                style={{
                                                    transform: emailPrefs[
                                                        row.key
                                                    ]
                                                        ? 'translateX(16px)'
                                                        : 'translateX(0)',
                                                }}
                                            />
                                        </button>
                                        <div className="flex-1">
                                            <div
                                                className="text-[14px] font-medium"
                                                style={{
                                                    color: 'var(--sn-fg)',
                                                }}
                                            >
                                                {row.title}
                                            </div>
                                            <div
                                                className="mt-0.5 font-mono text-[11.5px]"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                            >
                                                {row.desc}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </DashCard>
                        <DashCard
                            eyebrow="// zone dangereuse"
                            title="Supprimer mon compte"
                        >
                            <p
                                className="text-[13.5px]"
                                style={{ color: 'var(--sn-muted)' }}
                            >
                                Cette action est irréversible. Tes articles
                                seront anonymisés mais conservés.
                            </p>

                            <Dialog>
                                <DialogTrigger asChild>
                                    <button
                                        className="mt-3 rounded-md px-4 py-2 font-mono text-[12px] transition-colors"
                                        style={{
                                            background: 'transparent',
                                            border: '1px solid #c0392b',
                                            color: '#c0392b',
                                        }}
                                        data-test="delete-user-button"
                                    >
                                        Supprimer mon compte
                                    </button>
                                </DialogTrigger>
                                <DialogContent>
                                    <DialogTitle>
                                        Supprimer ton compte ?
                                    </DialogTitle>
                                    <DialogDescription>
                                        Cette action est définitive. Toutes tes
                                        données seront supprimées. Entre ton mot
                                        de passe pour confirmer.
                                    </DialogDescription>

                                    <Form
                                        action={ProfileController.destroy()}
                                        options={{ preserveScroll: true }}
                                        onError={() =>
                                            passwordInput.current?.focus()
                                        }
                                        resetOnSuccess
                                        className="space-y-4"
                                    >
                                        {({
                                            resetAndClearErrors,
                                            processing,
                                            errors,
                                        }) => (
                                            <>
                                                <div className="grid gap-2">
                                                    <PasswordInput
                                                        id="password"
                                                        name="password"
                                                        ref={passwordInput}
                                                        placeholder="Mot de passe"
                                                        autoComplete="current-password"
                                                    />
                                                    <InputError
                                                        message={
                                                            errors.password
                                                        }
                                                    />
                                                </div>

                                                <DialogFooter className="gap-2">
                                                    <DialogClose asChild>
                                                        <Button
                                                            variant="secondary"
                                                            onClick={() =>
                                                                resetAndClearErrors()
                                                            }
                                                        >
                                                            Annuler
                                                        </Button>
                                                    </DialogClose>
                                                    <Button
                                                        variant="destructive"
                                                        disabled={processing}
                                                        asChild
                                                    >
                                                        <button
                                                            type="submit"
                                                            data-test="confirm-delete-user-button"
                                                        >
                                                            Supprimer
                                                        </button>
                                                    </Button>
                                                </DialogFooter>
                                            </>
                                        )}
                                    </Form>
                                </DialogContent>
                            </Dialog>
                        </DashCard>
                    </main>
                </div>
            </div>
        </>
    );
}
