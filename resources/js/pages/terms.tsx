import { Head } from '@inertiajs/react';
import StaticPage from '@/components/site/static-page';

const SECTIONS = [
    {
        h: 'Objet',
        body: [
            "Les présentes conditions régissent l'utilisation du site laravel.sn et de ses espaces communautaires (forum, commentaires, profil). En accédant au site, tu acceptes ces conditions dans leur intégralité.",
            "Le site est édité par l'association Laravel Sénégal, à but non lucratif, enregistrée à Dakar.",
        ],
    },
    {
        h: 'Création de compte',
        body: [
            "Pour accéder aux fonctionnalités communautaires, tu dois créer un compte. Tu t'engages à :",
        ],
        bullets: [
            'Fournir des informations exactes lors de ton inscription.',
            'Garder ton mot de passe confidentiel et ne pas partager ton compte.',
            'Être âgé·e de 13 ans ou plus.',
            'Notifier immédiatement toute utilisation non autorisée de ton compte.',
        ],
    },
    {
        h: 'Contenu publié',
        body: [
            "Tu restes propriétaire du contenu que tu publies (articles, réponses au forum, commentaires). En le publiant sur laravel.sn, tu accordes à l'association une licence non exclusive et gratuite pour le diffuser sur le site.",
            'Tout contenu publié doit respecter le code de conduite. Nous nous réservons le droit de supprimer tout contenu qui violerait ces conditions, sans préavis.',
        ],
    },
    {
        h: 'Propriété intellectuelle',
        body: [
            "Le code source du site est disponible sous licence MIT. Le contenu éditorial (articles, ressources) est publié sous Creative Commons BY-SA 4.0, sauf mention contraire explicite de l'auteur·e.",
            "Le nom, le logo et la marque « Laravel Sénégal » sont la propriété de l'association. Toute reproduction à des fins commerciales est interdite sans accord préalable.",
        ],
    },
    {
        h: 'Limitation de responsabilité',
        body: [
            "Le site est fourni « en l'état », sans garantie de disponibilité continue. L'association ne saurait être tenue responsable de dommages directs ou indirects résultant de l'utilisation du site ou de son indisponibilité.",
            "Les liens externes présents sur le site pointent vers des ressources tierces sur lesquelles nous n'avons aucun contrôle.",
        ],
    },
    {
        h: 'Modifications',
        body: [
            "Nous pouvons modifier ces conditions à tout moment. Les utilisateurs enregistrés seront notifiés par email en cas de changement substantiel. La poursuite de l'utilisation du site après modification vaut acceptation des nouvelles conditions.",
        ],
    },
    {
        h: 'Contact',
        body: [
            'Pour toute question relative à ces conditions, écris-nous à contact@laravel.sn.',
        ],
    },
];

export default function Conditions() {
    return (
        <>
            <Head title="Conditions d'utilisation" />
            <StaticPage
                title="Conditions d'utilisation"
                updated="01 janvier 2026"
                sections={SECTIONS}
            />
        </>
    );
}
