import { Form, Head, usePage } from '@inertiajs/react';
import { Camera } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import InputError from '@/components/input-error';
import DashSidebar from '@/components/site/dashboard-sidebar';
import { useInitials } from '@/hooks/use-initials';
// import { send } from '@/routes/verification';

function FieldLabel({ children }: { children: React.ReactNode }) {
    return (
        <div
            className="mb-1.5 font-mono text-[10.5px] tracking-[0.18em] uppercase"
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
            className="w-full rounded-md px-3 py-2 text-[14px] transition-colors focus:outline-none"
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

function FieldTextarea(
    props: React.TextareaHTMLAttributes<HTMLTextAreaElement>,
) {
    return (
        <textarea
            {...props}
            rows={3}
            className="w-full resize-none rounded-md px-3 py-2 text-[14px] transition-colors focus:outline-none"
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

type ExtendedUser = {
    name: string;
    username?: string;
    email: string;
    email_verified_at: string | null;
    avatar?: string;
    bio?: string;
    location?: string;
    github_handle?: string;
    twitter_handle?: string;
    linkedin_handle?: string;
    website_url?: string;
};

const TINTS = ['#0f7b4d', '#188a5c', '#0b6640', '#3ea777'];
function getTint(name: string): string {
    let hash = 0;

    for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }

    return TINTS[Math.abs(hash) % TINTS.length];
}

export default function DashboardProfile() {
    const { auth } = usePage().props;
    const user = auth.user as ExtendedUser;
    const getInitials = useInitials();

    const fileInputRef = useRef<HTMLInputElement>(null);
    const [avatarPreview, setAvatarPreview] = useState<string | null>(
        user.avatar ?? null,
    );
    const [hovering, setHovering] = useState(false);
    const [prevAvatar, setPrevAvatar] = useState(user.avatar);

    if (prevAvatar !== user.avatar) {
        setPrevAvatar(user.avatar);
        setAvatarPreview(user.avatar ?? null);
    }

    useEffect(() => {
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    }, [user.avatar]);

    const tint = getTint(user.name);
    const initials = getInitials(user.name);

    function handleAvatarChange(e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0];

        if (file) {
            setAvatarPreview(URL.createObjectURL(file));
        }
    }

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

                        <Form
                            action={ProfileController.update()}
                            options={{ preserveScroll: true }}
                            encType="multipart/form-data"
                        >
                            {({ processing, errors }) => (
                                <div
                                    className="space-y-6 rounded-xl p-6"
                                    style={{
                                        background: 'var(--sn-surface)',
                                        border: '1px solid var(--sn-border)',
                                    }}
                                >
                                    {/* Avatar */}
                                    <div className="flex items-center gap-5">
                                        <button
                                            type="button"
                                            className="relative shrink-0 rounded-full focus:outline-none"
                                            onClick={() =>
                                                fileInputRef.current?.click()
                                            }
                                            onMouseEnter={() =>
                                                setHovering(true)
                                            }
                                            onMouseLeave={() =>
                                                setHovering(false)
                                            }
                                            aria-label="Changer la photo de profil"
                                        >
                                            <div
                                                className="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full text-[22px] font-bold"
                                                style={{
                                                    background: avatarPreview
                                                        ? 'transparent'
                                                        : tint,
                                                    color: '#fff',
                                                }}
                                            >
                                                {avatarPreview ? (
                                                    <img
                                                        src={avatarPreview}
                                                        alt={user.name}
                                                        className="h-full w-full object-cover"
                                                    />
                                                ) : (
                                                    initials
                                                )}
                                            </div>
                                            <div
                                                className="absolute inset-0 flex items-center justify-center rounded-full transition-opacity"
                                                style={{
                                                    background:
                                                        'rgba(0,0,0,0.45)',
                                                    opacity: hovering ? 1 : 0,
                                                }}
                                            >
                                                <Camera
                                                    size={20}
                                                    color="#fff"
                                                    strokeWidth={1.75}
                                                />
                                            </div>
                                        </button>

                                        <input
                                            ref={fileInputRef}
                                            type="file"
                                            name="avatar"
                                            accept="image/*"
                                            className="hidden"
                                            onChange={handleAvatarChange}
                                        />

                                        <div>
                                            <div
                                                className="text-[14px] font-medium"
                                                style={{
                                                    color: 'var(--sn-fg)',
                                                }}
                                            >
                                                {user.name}
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    fileInputRef.current?.click()
                                                }
                                                className="mt-1 font-mono text-[11.5px] underline underline-offset-2 transition-colors"
                                                style={{
                                                    color: 'var(--sn-muted)',
                                                }}
                                                onMouseEnter={(e) => {
                                                    e.currentTarget.style.color =
                                                        'var(--sn-fg)';
                                                }}
                                                onMouseLeave={(e) => {
                                                    e.currentTarget.style.color =
                                                        'var(--sn-muted)';
                                                }}
                                            >
                                                Changer la photo
                                            </button>
                                            {avatarPreview &&
                                                avatarPreview !==
                                                    user.avatar && (
                                                    <button
                                                        type="button"
                                                        onClick={() => {
                                                            setAvatarPreview(
                                                                user.avatar ??
                                                                    null,
                                                            );

                                                            if (
                                                                fileInputRef.current
                                                            ) {
                                                                fileInputRef.current.value =
                                                                    '';
                                                            }
                                                        }}
                                                        className="ml-3 font-mono text-[11.5px] underline underline-offset-2"
                                                        style={{
                                                            color: 'var(--sn-muted)',
                                                        }}
                                                    >
                                                        Annuler
                                                    </button>
                                                )}
                                            {errors.avatar && (
                                                <InputError
                                                    className="mt-2"
                                                    message={errors.avatar}
                                                />
                                            )}
                                        </div>
                                    </div>

                                    <div
                                        className="border-t"
                                        style={{
                                            borderColor: 'var(--sn-border)',
                                        }}
                                    />

                                    {/* Main info */}
                                    <div className="grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <FieldLabel>Nom complet</FieldLabel>
                                            <FieldInput
                                                name="name"
                                                defaultValue={user.name}
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
                                                    user.username ?? ''
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
                                            <FieldLabel>Biographie</FieldLabel>
                                            <FieldTextarea
                                                name="bio"
                                                defaultValue={user.bio ?? ''}
                                                placeholder="Développeur·se passionné·e par le web, basé·e à Dakar..."
                                            />
                                            <InputError
                                                className="mt-1"
                                                message={errors.bio}
                                            />
                                        </div>

                                        <div>
                                            <FieldLabel>Ville</FieldLabel>
                                            <FieldInput
                                                name="location"
                                                defaultValue={
                                                    user.location ?? ''
                                                }
                                                placeholder="Dakar"
                                            />
                                            <InputError
                                                className="mt-1"
                                                message={errors.location}
                                            />
                                        </div>

                                        <div>
                                            <FieldLabel>Email</FieldLabel>
                                            <FieldInput
                                                type="email"
                                                name="email"
                                                defaultValue={user.email}
                                                required
                                                autoComplete="email"
                                                placeholder="aissatou@wave.com"
                                            />
                                            <InputError
                                                className="mt-1"
                                                message={errors.email}
                                            />
                                        </div>

                                        {/* {mustVerifyEmail &&
                                            user.email_verified_at === null && (
                                                <div
                                                    className="rounded-md px-3 py-2 font-mono text-[12px] sm:col-span-2"
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
                                    </div>

                                    <div
                                        className="border-t"
                                        style={{
                                            borderColor: 'var(--sn-border)',
                                        }}
                                    />

                                    {/* Social links */}
                                    <div>
                                        <div
                                            className="mb-3 font-mono text-[10.5px] tracking-[0.18em] uppercase"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            Réseaux &amp; liens
                                        </div>
                                        <div className="grid gap-4 sm:grid-cols-2">
                                            <div>
                                                <FieldLabel>GitHub</FieldLabel>
                                                <FieldInput
                                                    name="github_handle"
                                                    defaultValue={
                                                        user.github_handle ?? ''
                                                    }
                                                    placeholder="github_username"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={
                                                        errors.github_handle
                                                    }
                                                />
                                            </div>

                                            <div>
                                                <FieldLabel>
                                                    Twitter / X
                                                </FieldLabel>
                                                <FieldInput
                                                    name="twitter_handle"
                                                    defaultValue={
                                                        user.twitter_handle ??
                                                        ''
                                                    }
                                                    placeholder="@handle"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={
                                                        errors.twitter_handle
                                                    }
                                                />
                                            </div>

                                            <div>
                                                <FieldLabel>
                                                    LinkedIn
                                                </FieldLabel>
                                                <FieldInput
                                                    name="linkedin_handle"
                                                    defaultValue={
                                                        user.linkedin_handle ??
                                                        ''
                                                    }
                                                    placeholder="linkedin_username"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={
                                                        errors.linkedin_handle
                                                    }
                                                />
                                            </div>

                                            <div>
                                                <FieldLabel>
                                                    Site web
                                                </FieldLabel>
                                                <FieldInput
                                                    name="website_url"
                                                    type="url"
                                                    defaultValue={
                                                        user.website_url ?? ''
                                                    }
                                                    placeholder="https://monsite.com"
                                                />
                                                <InputError
                                                    className="mt-1"
                                                    message={errors.website_url}
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div className="flex justify-end">
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="sn-btn sn-btn-primary"
                                            data-test="update-profile-button"
                                        >
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                            )}
                        </Form>
                    </main>
                </div>
            </div>
        </>
    );
}
