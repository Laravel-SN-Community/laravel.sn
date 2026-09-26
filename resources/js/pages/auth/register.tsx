import { Head, Link } from '@inertiajs/react';
import { GithubIcon, GoogleIcon } from '@/components/site/brand-icons';
// import { Form } from '@inertiajs/react';
// import InputError from '@/components/input-error';
// import PasswordInput from '@/components/password-input';
// import { store } from '@/routes/register';
import { login } from '@/routes';

export default function Register() {
    return (
        <>
            <Head title="Inscription" />

            <div className="flex flex-col gap-3">
                <a
                    href="/auth/github/redirect"
                    className="sn-btn sn-btn-secondary w-full justify-center gap-2.5 py-3 text-[13.5px]"
                >
                    <GithubIcon size={15} />
                    S'inscrire avec GitHub
                </a>
                <a
                    href="/auth/google/redirect"
                    className="sn-btn sn-btn-secondary w-full justify-center gap-2.5 py-3 text-[13.5px]"
                >
                    <GoogleIcon size={15} />
                    S'inscrire avec Google
                </a>
            </div>

            {/* Registration form (temporarily hidden) */}
            {/*
            <Form action={store()} resetOnSuccess={['password', 'password_confirmation']} disableWhileProcessing>
                {({ processing, errors }) => (
                    <div className="flex flex-col gap-4">
                        <div className="grid gap-1.5">
                            <label htmlFor="name" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Nom complet</label>
                            <input id="name" type="text" name="name" required autoFocus autoComplete="name" placeholder="Aminata Diallo" className="w-full rounded-md px-3 py-2.5 text-[14px] outline-none" style={inputStyle} />
                            <InputError message={errors.name} />
                        </div>
                        <div className="grid gap-1.5">
                            <label htmlFor="username" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Nom d'utilisateur</label>
                            <div className="relative">
                                <span className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[13px]" style={{ color: 'var(--sn-muted)' }}>@</span>
                                <input id="username" type="text" name="username" required autoComplete="username" placeholder="aminata_dev" className="w-full rounded-md py-2.5 pr-3 pl-7 text-[14px] outline-none" style={inputStyle} />
                            </div>
                            <InputError message={errors.username} />
                        </div>
                        <div className="grid gap-1.5">
                            <label htmlFor="email" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Email</label>
                            <input id="email" type="email" name="email" required autoComplete="email" placeholder="toi@example.com" className="w-full rounded-md px-3 py-2.5 text-[14px] outline-none" style={inputStyle} />
                            <InputError message={errors.email} />
                        </div>
                        <div className="grid gap-1.5">
                            <label htmlFor="password" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Mot de passe</label>
                            <PasswordInput id="password" name="password" required autoComplete="new-password" placeholder="••••••••" className="text-[14px]" style={inputStyle} />
                            <InputError message={errors.password} />
                        </div>
                        <div className="grid gap-1.5">
                            <label htmlFor="password_confirmation" className="text-[13px] font-medium" style={{ color: 'var(--sn-fg)' }}>Confirmer le mot de passe</label>
                            <PasswordInput id="password_confirmation" name="password_confirmation" required autoComplete="new-password" placeholder="••••••••" className="text-[14px]" style={inputStyle} />
                            <InputError message={errors.password_confirmation} />
                        </div>
                        <button type="submit" disabled={processing} className="sn-btn sn-btn-primary mt-1 w-full justify-center" data-test="register-user-button">
                            {processing ? 'Création…' : 'Créer mon compte'}
                        </button>
                    </div>
                )}
            </Form>
            */}

            <p
                className="mt-4 text-center text-[12px]"
                style={{ color: 'var(--sn-muted)' }}
            >
                Déjà membre ?{' '}
                <Link
                    href={login()}
                    className="font-medium hover:underline"
                    style={{ color: 'var(--sn-fg)' }}
                >
                    Se connecter
                </Link>
            </p>
        </>
    );
}

Register.layout = {
    title: 'Créer un compte',
    description: 'Rejoins la communauté des développeurs Laravel au Sénégal.',
    eyebrow: 'nouveau compte',
};
