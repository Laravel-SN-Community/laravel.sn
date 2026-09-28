import { Form, Head } from '@inertiajs/react';
import { ShieldCheck } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import SecurityController from '@/actions/App/Http/Controllers/Settings/SecurityController';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import DashSidebar from '@/components/site/dashboard-sidebar';
import TwoFactorRecoveryCodes from '@/components/two-factor-recovery-codes';
import TwoFactorSetupModal from '@/components/two-factor-setup-modal';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/hooks/use-two-factor-auth';
import { disable, enable } from '@/routes/two-factor';

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

type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

export default function Security({
    canManageTwoFactor = false,
    requiresConfirmation = false,
    twoFactorEnabled = false,
}: Props) {
    const passwordInput = useRef<HTMLInputElement>(null);
    const currentPasswordInput = useRef<HTMLInputElement>(null);

    const {
        qrCodeSvg,
        hasSetupData,
        manualSetupKey,
        clearSetupData,
        clearTwoFactorAuthData,
        fetchSetupData,
        recoveryCodesList,
        fetchRecoveryCodes,
        errors,
    } = useTwoFactorAuth();
    const [showSetupModal, setShowSetupModal] = useState(false);
    const prevTwoFactorEnabled = useRef(twoFactorEnabled);

    useEffect(() => {
        if (prevTwoFactorEnabled.current && !twoFactorEnabled) {
            clearTwoFactorAuthData();
        }

        prevTwoFactorEnabled.current = twoFactorEnabled;
    }, [twoFactorEnabled, clearTwoFactorAuthData]);

    return (
        <>
            <Head title="Sécurité" />

            <div className="mx-auto max-w-[1300px] px-6 py-8 lg:px-10">
                <div className="grid gap-8 lg:grid-cols-[240px_1fr]">
                    <DashSidebar section="settings" />

                    <main className="min-w-0 space-y-6">
                        <h1
                            className="text-[32px] font-semibold tracking-[-0.02em]"
                            style={{ color: 'var(--sn-fg)' }}
                        >
                            Sécurité
                        </h1>

                        <DashCard
                            eyebrow="// mot de passe"
                            title="Changer le mot de passe"
                        >
                            <Form
                                action={SecurityController.update()}
                                options={{ preserveScroll: true }}
                                resetOnError={[
                                    'password',
                                    'password_confirmation',
                                    'current_password',
                                ]}
                                resetOnSuccess
                                onError={(errs) => {
                                    if (errs.password) {
                                        passwordInput.current?.focus();
                                    }

                                    if (errs.current_password) {
                                        currentPasswordInput.current?.focus();
                                    }
                                }}
                                className="space-y-4"
                            >
                                {({ errors, processing }) => (
                                    <>
                                        <div>
                                            <FieldLabel>
                                                Mot de passe actuel
                                            </FieldLabel>
                                            <PasswordInput
                                                id="current_password"
                                                ref={currentPasswordInput}
                                                name="current_password"
                                                className="mt-1.5 block w-full"
                                                autoComplete="current-password"
                                                placeholder="••••••••••"
                                            />
                                            <InputError
                                                message={
                                                    errors.current_password
                                                }
                                            />
                                        </div>

                                        <div>
                                            <FieldLabel>
                                                Nouveau mot de passe
                                            </FieldLabel>
                                            <PasswordInput
                                                id="password"
                                                ref={passwordInput}
                                                name="password"
                                                className="mt-1.5 block w-full"
                                                autoComplete="new-password"
                                                placeholder="••••••••••"
                                            />
                                            <InputError
                                                message={errors.password}
                                            />
                                        </div>

                                        <div>
                                            <FieldLabel>
                                                Confirmer le mot de passe
                                            </FieldLabel>
                                            <PasswordInput
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                className="mt-1.5 block w-full"
                                                autoComplete="new-password"
                                                placeholder="••••••••••"
                                            />
                                            <InputError
                                                message={
                                                    errors.password_confirmation
                                                }
                                            />
                                        </div>

                                        <div className="flex justify-end">
                                            <button
                                                type="submit"
                                                disabled={processing}
                                                className="sn-btn sn-btn-primary"
                                                data-test="update-password-button"
                                            >
                                                Enregistrer
                                            </button>
                                        </div>
                                    </>
                                )}
                            </Form>
                        </DashCard>

                        {canManageTwoFactor && (
                            <DashCard
                                eyebrow="// authentification"
                                title="Double authentification (2FA)"
                            >
                                {twoFactorEnabled ? (
                                    <div className="space-y-4">
                                        <p
                                            className="text-[13.5px] leading-relaxed"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            La double authentification est
                                            activée. Tu seras invité·e à entrer
                                            un code lors de la connexion.
                                        </p>
                                        <Form action={disable()}>
                                            {({ processing }) => (
                                                <Button
                                                    variant="destructive"
                                                    type="submit"
                                                    disabled={processing}
                                                >
                                                    Désactiver la 2FA
                                                </Button>
                                            )}
                                        </Form>
                                        <TwoFactorRecoveryCodes
                                            recoveryCodesList={
                                                recoveryCodesList
                                            }
                                            fetchRecoveryCodes={
                                                fetchRecoveryCodes
                                            }
                                            errors={errors}
                                        />
                                    </div>
                                ) : (
                                    <div className="space-y-4">
                                        <p
                                            className="text-[13.5px] leading-relaxed"
                                            style={{ color: 'var(--sn-muted)' }}
                                        >
                                            Ajoute une couche de sécurité
                                            supplémentaire. Un code TOTP te sera
                                            demandé à chaque connexion.
                                        </p>
                                        {hasSetupData ? (
                                            <button
                                                onClick={() =>
                                                    setShowSetupModal(true)
                                                }
                                                className="sn-btn sn-btn-primary"
                                            >
                                                <ShieldCheck size={14} />
                                                Continuer la configuration
                                            </button>
                                        ) : (
                                            <Form
                                                action={enable()}
                                                onSuccess={() =>
                                                    setShowSetupModal(true)
                                                }
                                            >
                                                {({ processing }) => (
                                                    <button
                                                        type="submit"
                                                        disabled={processing}
                                                        className="sn-btn sn-btn-primary"
                                                    >
                                                        Activer la 2FA
                                                    </button>
                                                )}
                                            </Form>
                                        )}
                                    </div>
                                )}

                                <TwoFactorSetupModal
                                    isOpen={showSetupModal}
                                    onClose={() => setShowSetupModal(false)}
                                    requiresConfirmation={requiresConfirmation}
                                    twoFactorEnabled={twoFactorEnabled}
                                    qrCodeSvg={qrCodeSvg}
                                    manualSetupKey={manualSetupKey}
                                    clearSetupData={clearSetupData}
                                    fetchSetupData={fetchSetupData}
                                    errors={errors}
                                />
                            </DashCard>
                        )}
                    </main>
                </div>
            </div>
        </>
    );
}
