import { Form, Head, usePage } from '@inertiajs/react';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import InputError from '@/components/input-error';
import DashSidebar from '@/components/site/dashboard-sidebar';

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

function FieldLabel({ children }: { children: React.ReactNode }) {
    return (
        <div
            className="font-mono text-[10.5px] tracking-[0.18em] uppercase"
            style={{ color: 'var(--sn-muted)' }}
        >
            {children}
        </div>
    );
}

function FieldInput(props: React.InputHTMLAttributes<HTMLInputElement>) {
    return (
        <input
            {...props}
            className="mt-1.5 w-full rounded-md px-3 py-2 text-[14px] transition-colors focus:outline-none"
            style={{
                background: 'var(--sn-bg)',
                border: '1px solid var(--sn-border)',
                color: 'var(--sn-fg)',
            }}
            onFocus={(e) => {
                e.currentTarget.style.borderColor = 'var(--sn-accent)';
            }}
            onBlur={(e) => {
                e.currentTarget.style.borderColor = 'var(--sn-border)';
            }}
        />
    );
}

export default function Profile() {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Mon profil" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="profile" />

                    <main className="min-w-0 space-y-6">
                        <h1
                            className="text-[32px] font-semibold tracking-[-0.02em]"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Mon profil
                        </h1>

                        <DashCard
                            eyebrow="// infos publiques"
                            title="Informations"
                        >
                            <Form
                                action={ProfileController.update()}
                                options={{ preserveScroll: true }}
                                className="space-y-0"
                            >
                                {({ processing, errors }) => (
                                    <>
                                        <div className="grid gap-4 sm:grid-cols-2">
                                            <div>
                                                <FieldLabel>
                                                    Nom complet
                                                </FieldLabel>
                                                <FieldInput
                                                    name="name"
                                                    defaultValue={
                                                        auth.user.name
                                                    }
                                                    required
                                                    autoComplete="name"
                                                    placeholder="Aïssatou Diop"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={errors.name}
                                                />
                                            </div>

                                            <div>
                                                <FieldLabel>
                                                    Nom d'utilisateur
                                                </FieldLabel>
                                                <FieldInput
                                                    name="username"
                                                    defaultValue={
                                                        (
                                                            auth.user as {
                                                                username?: string;
                                                            }
                                                        ).username ?? ''
                                                    }
                                                    required
                                                    autoComplete="username"
                                                    placeholder="aissatou_diop"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={errors.username}
                                                />
                                            </div>

                                            <div className="sm:col-span-2">
                                                <FieldLabel>
                                                    Adresse email
                                                </FieldLabel>
                                                <FieldInput
                                                    type="email"
                                                    name="email"
                                                    defaultValue={
                                                        auth.user.email
                                                    }
                                                    required
                                                    autoComplete="email"
                                                    placeholder="aissatou@wave.com"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={errors.email}
                                                />
                                            </div>
                                        </div>

                                        {/* {mustVerifyEmail &&
                                            auth.user.email_verified_at ===
                                                null && (
                                                <div
                                                    className="mt-3 rounded-md px-3 py-2 font-mono text-[12px]"
                                                    style={{
                                                        background:
                                                            'var(--sn-surface-2)',
                                                        color: 'var(--sn-muted)',
                                                    }}
                                                >
                                                    Ton adresse email n'est pas
                                                    vérifiée.{' '}
                                                    <Link
                                                        href={send()}
                                                        as="button"
                                                        className="underline"
                                                        style={{
                                                            color: 'var(--sn-fg)',
                                                        }}
                                                    >
                                                        Renvoyer l'email de
                                                        vérification.
                                                    </Link>
                                                    {status ===
                                                        'verification-link-sent' && (
                                                        <div
                                                            className="mt-1"
                                                            style={{
                                                                color: 'var(--sn-600)',
                                                            }}
                                                        >
                                                            Un nouveau lien a
                                                            été envoyé.
                                                        </div>
                                                    )}
                                                </div>
                                            )} */}

                                        <div className="mt-5 flex justify-end gap-2">
                                            <button
                                                type="submit"
                                                disabled={processing}
                                                className="sn-btn sn-btn-primary"
                                                data-test="update-profile-button"
                                            >
                                                Enregistrer
                                            </button>
                                        </div>
                                    </>
                                )}
                            </Form>
                        </DashCard>
                    </main>
                </div>
            </div>
        </>
    );
}
