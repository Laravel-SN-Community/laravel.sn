import { Head, Link, usePage } from '@inertiajs/react';
import { AlertCircle } from 'lucide-react';
import { useState } from 'react';
import { GithubIcon, GoogleIcon } from '@/components/site/brand-icons';
import { Spinner } from '@/components/ui/spinner';
// import { Form } from '@inertiajs/react';
// import InputError from '@/components/input-error';
// import PasswordInput from '@/components/password-input';
// import { store } from '@/routes/login';
// import { request } from '@/routes/password';
import { register } from '@/routes';

type Props = {
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
};

type Provider = 'github' | 'google';

export default function Login({ status, canRegister }: Props) {
    const { errors } = usePage().props as unknown as {
        errors: Record<string, string>;
    };
    const [pending, setPending] = useState<Provider | null>(null);

    // The OAuth round-trip is a full page navigation, so without a pending
    // state the button just sits there looking dead while the browser works.
    function startSocial(provider: Provider) {
        setPending(provider);
        window.location.href = `/auth/${provider}/redirect`;
    }

    const loginError = errors?.email;

    return (
        <>
            <Head title="Connexion" />

            {loginError && (
                <div
                    className="mb-5 flex items-start gap-2 rounded-md p-3 text-[12.5px]"
                    style={{
                        background:
                            'color-mix(in oklch, var(--destructive) 8%, transparent)',
                        color: 'var(--destructive)',
                    }}
                    role="alert"
                >
                    <AlertCircle size={15} className="mt-px shrink-0" />
                    <span>{loginError}</span>
                </div>
            )}

            {status && (
                <div
                    className="mb-5 rounded-md p-3 text-[12.5px]"
                    style={{
                        background:
                            'color-mix(in oklch, var(--sn-accent) 12%, transparent)',
                        color: 'var(--sn-accent)',
                    }}
                >
                    {status}
                </div>
            )}

            <div className="flex flex-col gap-3">
                <button
                    type="button"
                    onClick={() => startSocial('github')}
                    disabled={pending !== null}
                    className="sn-btn sn-btn-secondary w-full justify-center gap-2.5 py-3 text-[13.5px] disabled:opacity-60"
                >
                    {pending === 'github' ? (
                        <Spinner className="size-[15px]" />
                    ) : (
                        <GithubIcon size={15} />
                    )}
                    {pending === 'github'
                        ? 'Redirection vers GitHub…'
                        : 'Continuer avec GitHub'}
                </button>
                <button
                    type="button"
                    onClick={() => startSocial('google')}
                    disabled={pending !== null}
                    className="sn-btn sn-btn-secondary w-full justify-center gap-2.5 py-3 text-[13.5px] disabled:opacity-60"
                >
                    {pending === 'google' ? (
                        <Spinner className="size-[15px]" />
                    ) : (
                        <GoogleIcon size={15} />
                    )}
                    {pending === 'google'
                        ? 'Redirection vers Google…'
                        : 'Continuer avec Google'}
                </button>
            </div>

            {/* Email / password form (temporarily hidden) */}
            {/*
            <div className="my-5 flex items-center gap-3">
                <div className="h-px flex-1" style={{ background: 'var(--sn-border)' }} />
                <span className="text-[11.5px]" style={{ color: 'var(--sn-muted)' }}>ou</span>
                <div className="h-px flex-1" style={{ background: 'var(--sn-border)' }} />
            </div>

            <Form action={store()} resetOnSuccess={['password']}>
                {({ processing, errors }) => (
                    <div className="flex flex-col gap-4">
                        <div className="grid gap-1.5">
                            <label htmlFor="email" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Email</label>
                            <input id="email" type="email" name="email" required autoFocus autoComplete="email" placeholder="toi@example.com" className="w-full rounded-md px-3 py-2.5 text-[14px] outline-none" style={inputStyle} />
                            <InputError message={errors.email} />
                        </div>
                        <div className="grid gap-1.5">
                            <div className="flex items-center justify-between">
                                <label htmlFor="password" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Mot de passe</label>
                                {canResetPassword && (
                                    <Link href={request()} className="text-[11.5px] hover:underline" style={{ color: 'var(--sn-muted)' }}>Oublié ?</Link>
                                )}
                            </div>
                            <PasswordInput id="password" name="password" required autoComplete="current-password" placeholder="••••••••" className="text-[14px]" style={inputStyle} />
                            <InputError message={errors.password} />
                        </div>
                        <label className="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" className="h-4 w-4 rounded accent-[color:var(--sn-accent)]" />
                            <span className="text-[13px]" style={{ color: 'var(--sn-muted)' }}>Se souvenir de moi</span>
                        </label>
                        <button type="submit" disabled={processing} className="sn-btn sn-btn-primary mt-1 w-full justify-center" data-test="login-button">
                            {processing ? 'Connexion…' : 'Se connecter'}
                        </button>
                    </div>
                )}
            </Form>
            */}

            {canRegister && (
                <p
                    className="mt-4 text-center text-[12px]"
                    style={{ color: 'var(--sn-muted)' }}
                >
                    Pas encore membre ?{' '}
                    <Link
                        href={register()}
                        className="font-medium hover:underline"
                        style={{ color: 'var(--sn-fg)' }}
                    >
                        Rejoindre
                    </Link>
                </p>
            )}
        </>
    );
}

Login.layout = {
    title: 'Connexion',
    description: 'Heureux de te revoir dans la communauté.',
    eyebrow: 'retour parmi nous',
};
