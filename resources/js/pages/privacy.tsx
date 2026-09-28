import { Head } from '@inertiajs/react';
import StaticPage from '@/components/site/static-page';

const SECTIONS = [
    {
        h: 'Données collectées',
        body: [
            'Nous collectons uniquement ce qui est nécessaire au bon fonctionnement de la communauté :',
        ],
        bullets: [
            "Informations de compte : nom, nom d'utilisateur, adresse email.",
            'Contenu publié : articles, réponses au forum, commentaires.',
            'Données de session : cookie de connexion, préférence de thème.',
            "Logs serveur : adresse IP, navigateur, date d'accès — conservés 30 jours.",
        ],
    },
    {
        h: 'Utilisation des données',
        body: ['Tes données sont utilisées exclusivement pour :'],
        bullets: [
            "Gérer ton compte et t'authentifier.",
            'Afficher ton profil et tes contributions sur le site.',
            "T'envoyer des notifications liées à ta participation (réponses, mentions).",
            'Envoyer la newsletter mensuelle si tu y es inscrit·e.',
            'Améliorer le site (statistiques anonymisées, sans outil tiers).',
        ],
    },
    {
        h: 'Cookies',
        body: [
            'Nous utilisons deux cookies : un cookie de session pour maintenir ta connexion, et un cookie de préférence pour mémoriser ton choix de thème (clair/sombre).',
            'Pas de cookies publicitaires, pas de tracking tiers, pas de Google Analytics.',
        ],
    },
    {
        h: 'Partage des données',
        body: [
            'Nous ne vendons pas tes données et ne les partageons pas avec des tiers à des fins commerciales. Tes informations publiques (nom, profil, articles) sont visibles par tous les visiteurs du site.',
            "En cas d'obligation légale, nous pourrions être amenés à communiquer certaines données aux autorités compétentes.",
        ],
    },
    {
        h: 'Tes droits',
        body: [
            'Conformément à la loi sénégalaise 2008-12 sur la protection des données personnelles et au RGPD, tu disposes des droits suivants :',
        ],
        bullets: [
            'Accès : obtenir une copie de tes données.',
            'Rectification : corriger des informations inexactes.',
            'Suppression : demander la suppression de ton compte et de tes données.',
            'Opposition : te désinscrire de la newsletter à tout moment.',
            'Portabilité : recevoir tes données dans un format lisible par machine.',
        ],
    },
    {
        h: 'Sécurité',
        body: [
            'Les mots de passe sont hachés avec bcrypt. Les communications sont chiffrées via HTTPS. Nous appliquons les bonnes pratiques Laravel pour la sécurité des sessions et la protection contre les injections.',
            "En cas de violation de données affectant tes informations, nous t'en informerons dans les 72 heures.",
        ],
    },
    {
        h: 'Contact',
        body: [
            'Pour exercer tes droits ou pour toute question relative à ta vie privée, écris-nous à privacy@laravel-sn.community. Nous répondons dans un délai de 30 jours.',
        ],
    },
];

export default function Confidentialite() {
    return (
        <>
            <Head title="Confidentialité" />
            <StaticPage
                title="Confidentialité"
                updated="01 janvier 2026"
                sections={SECTIONS}
            />
        </>
    );
}
