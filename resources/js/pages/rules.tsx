import { Head } from '@inertiajs/react';
import StaticPage from '@/components/site/static-page';

const SECTIONS = [
    {
        h: 'Notre engagement',
        body: [
            "La communauté Laravel Sénégal s'engage à offrir un environnement accueillant, respectueux et inclusif à tou·te·s. Quel que soit ton niveau, ton genre, ta langue maternelle, ton origine, ton orientation, ta religion ou ton handicap : tu as ta place ici.",
            'Ndank ndank — pas à pas. On apprend mieux ensemble que seul·e.',
        ],
    },
    {
        h: 'Comportements attendus',
        body: ["Pour rendre l'espace agréable à tout le monde :"],
        bullets: [
            "Sois bienveillant·e. Une question « bête » n'existe pas — on a tou·te·s commencé quelque part.",
            "Donne du crédit. Si tu reprends le code de quelqu'un, mentionne-le.",
            '« Ce bout de code a un souci » plutôt que « tu codes mal ».',
            'Préviens si tu enregistres ou photographies un évènement.',
            "Le wolof, le français et l'anglais sont les bienvenus. Mais évite l'argot trop fermé.",
        ],
    },
    {
        h: 'Comportements inacceptables',
        body: [
            'Les comportements suivants entraînent un avertissement, voire une exclusion immédiate :',
        ],
        bullets: [
            'Harcèlement, insultes, attaques personnelles.',
            'Propos racistes, sexistes, homophobes, transphobes ou capacitistes.',
            "Doxxing, partage d'informations privées sans consentement.",
            'Spam, sollicitation commerciale non sollicitée dans les espaces communs.',
            "Plagiat de code ou d'articles présentés comme un travail original.",
        ],
    },
    {
        h: 'Signaler un incident',
        body: [
            "Si tu es témoin ou victime d'un comportement inacceptable, écris-nous à conduct@laravel-sn.community. Le message va à 3 personnes (Aïssatou, Omar, Khady) qui appliquent une stricte confidentialité.",
            "Tu peux aussi nous parler en privé pendant un meetup — on garde toujours quelqu'un de l'équipe disponible pour ça.",
        ],
    },
    {
        h: 'Conséquences',
        body: ['Selon la gravité :'],
        bullets: [
            'Avertissement privé.',
            'Avertissement public.',
            'Exclusion temporaire des espaces de la communauté (Slack, meetups).',
            'Exclusion permanente.',
        ],
    },
    {
        h: 'Inspirations',
        body: [
            "Ce code s'inspire de Contributor Covenant 2.1, du code Laracon EU, et a été adapté au contexte sénégalais avec l'aide de la communauté.",
        ],
    },
];

export default function Rules() {
    return (
        <>
            <Head title="Code de conduite" />
            <StaticPage
                title="Code de conduite"
                updated="01 janvier 2026"
                sections={SECTIONS}
            />
        </>
    );
}
