<?php

use App\Models\Category;
use App\Models\Technology;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tags:seed', function () {
    $technologies = [
        ['name' => 'Symfony', 'slug' => 'symfony'],
        ['name' => 'Python', 'slug' => 'python'],
        ['name' => 'Django', 'slug' => 'django'],
        ['name' => 'FastAPI', 'slug' => 'fastapi'],
        ['name' => 'Java', 'slug' => 'java'],
        ['name' => 'Spring Boot', 'slug' => 'spring-boot'],
        ['name' => 'Node.js', 'slug' => 'nodejs'],
        ['name' => 'Express.js', 'slug' => 'expressjs'],
        ['name' => 'Go', 'slug' => 'go'],
        ['name' => 'Ruby', 'slug' => 'ruby'],
        ['name' => 'Ruby on Rails', 'slug' => 'ruby-on-rails'],
        ['name' => 'JavaScript', 'slug' => 'javascript'],
        ['name' => 'TypeScript', 'slug' => 'typescript'],
        ['name' => 'HTML5', 'slug' => 'html5'],
        ['name' => 'CSS3', 'slug' => 'css3'],
        ['name' => 'Kotlin', 'slug' => 'kotlin'],
        ['name' => 'Swift', 'slug' => 'swift'],
        ['name' => 'Flutter', 'slug' => 'flutter'],
        ['name' => 'Dart', 'slug' => 'dart'],
        ['name' => 'React Native', 'slug' => 'react-native'],
        ['name' => 'React.js', 'slug' => 'reactjs'],
        ['name' => 'Vue.js', 'slug' => 'vuejs'],
        ['name' => 'Angular', 'slug' => 'angular'],
        ['name' => 'Svelte', 'slug' => 'svelte'],
        ['name' => 'Tailwind CSS', 'slug' => 'tailwind-css'],
        ['name' => 'Bootstrap', 'slug' => 'bootstrap'],
        ['name' => 'Chakra UI', 'slug' => 'chakra-ui'],
        ['name' => 'Material UI', 'slug' => 'material-ui'],
        ['name' => 'ShadCN/UI', 'slug' => 'shadcn-ui'],
        ['name' => 'AWS', 'slug' => 'aws'],
        ['name' => 'Google Cloud', 'slug' => 'google-cloud'],
        ['name' => 'Azure', 'slug' => 'azure'],
        ['name' => 'DigitalOcean', 'slug' => 'digitalocean'],
        ['name' => 'Docker', 'slug' => 'docker'],
        ['name' => 'Kubernetes', 'slug' => 'kubernetes'],
        ['name' => 'GitHub Actions', 'slug' => 'github-actions'],
        ['name' => 'GitLab CI', 'slug' => 'gitlab-ci'],
        ['name' => 'Jenkins', 'slug' => 'jenkins'],
        ['name' => 'CircleCI', 'slug' => 'circleci'],
        ['name' => 'Terraform', 'slug' => 'terraform'],
        ['name' => 'Ansible', 'slug' => 'ansible'],
        ['name' => 'MySQL', 'slug' => 'mysql'],
        ['name' => 'PostgreSQL', 'slug' => 'postgresql'],
        ['name' => 'MariaDB', 'slug' => 'mariadb'],
        ['name' => 'SQLite', 'slug' => 'sqlite'],
        ['name' => 'MongoDB', 'slug' => 'mongodb'],
        ['name' => 'Redis', 'slug' => 'redis'],
        ['name' => 'Cassandra', 'slug' => 'cassandra'],
        ['name' => 'Firebase Firestore', 'slug' => 'firebase-firestore'],
        ['name' => 'Pinecone', 'slug' => 'pinecone'],
        ['name' => 'Weaviate', 'slug' => 'weaviate'],
        ['name' => 'pgVector', 'slug' => 'pgvector'],
        ['name' => 'Chroma', 'slug' => 'chroma'],
        ['name' => 'TensorFlow', 'slug' => 'tensorflow'],
        ['name' => 'PyTorch', 'slug' => 'pytorch'],
        ['name' => 'scikit-learn', 'slug' => 'scikit-learn'],
        ['name' => 'LangChain', 'slug' => 'langchain'],
        ['name' => 'Pandas', 'slug' => 'pandas'],
        ['name' => 'NumPy', 'slug' => 'numpy'],
        ['name' => 'Jupyter Notebook', 'slug' => 'jupyter-notebook'],
        ['name' => 'OpenAI GPT', 'slug' => 'openai-gpt'],
        ['name' => 'Claude', 'slug' => 'claude'],
        ['name' => 'Hugging Face', 'slug' => 'hugging-face'],
        ['name' => 'Ollama', 'slug' => 'ollama'],
        ['name' => 'Airflow', 'slug' => 'airflow'],
        ['name' => 'Kafka', 'slug' => 'kafka'],
        ['name' => 'Spark', 'slug' => 'spark'],
        ['name' => 'OAuth2', 'slug' => 'oauth2'],
        ['name' => 'JWT', 'slug' => 'jwt'],
        ['name' => 'OpenID Connect', 'slug' => 'openid-connect'],
        ['name' => 'Auth0', 'slug' => 'auth0'],
        ['name' => 'Keycloak', 'slug' => 'keycloak'],
        ['name' => 'Laravel Sanctum', 'slug' => 'laravel-sanctum'],
        ['name' => 'OWASP', 'slug' => 'owasp'],
        ['name' => 'SSL/TLS', 'slug' => 'ssl-tls'],
        ['name' => 'HashiCorp Vault', 'slug' => 'hashicorp-vault'],
        ['name' => 'Git', 'slug' => 'git'],
        ['name' => 'GitHub', 'slug' => 'github'],
        ['name' => 'GitLab', 'slug' => 'gitlab'],
        ['name' => 'Bitbucket', 'slug' => 'bitbucket'],
        ['name' => 'VS Code', 'slug' => 'vs-code'],
        ['name' => 'PhpStorm', 'slug' => 'phpstorm'],
        ['name' => 'PyCharm', 'slug' => 'pycharm'],
        ['name' => 'IntelliJ IDEA', 'slug' => 'intellij-idea'],
        ['name' => 'Sentry', 'slug' => 'sentry'],
        ['name' => 'Grafana', 'slug' => 'grafana'],
        ['name' => 'Prometheus', 'slug' => 'prometheus'],
        ['name' => 'Datadog', 'slug' => 'datadog'],
        ['name' => 'Slack', 'slug' => 'slack'],
        ['name' => 'Notion', 'slug' => 'notion'],
        ['name' => 'Trello', 'slug' => 'trello'],
        ['name' => 'Jira', 'slug' => 'jira'],
        ['name' => 'Linear', 'slug' => 'linear'],
        ['name' => 'Figma', 'slug' => 'figma'],
        ['name' => 'Canva', 'slug' => 'canva'],
        ['name' => 'Miro', 'slug' => 'miro'],
        ['name' => 'Postman', 'slug' => 'postman'],
    ];

    foreach ($technologies as $tech) {
        Tag::firstOrCreate(
            ['name' => $tech['name'], 'slug' => $tech['slug']],
            ['type' => 'project']
        );
    }
})->purpose('Seed the technologies table with predefined data');

Artisan::command('categories:seed', function () {
    $categories = [
        ['name' => 'Education & Learning', 'slug' => 'education-learning'],
        ['name' => 'E-commerce', 'slug' => 'e-commerce'],
        ['name' => 'Fintech & Payments', 'slug' => 'fintech-payments'],
        ['name' => 'Mobility & Transport', 'slug' => 'mobility-transport'],
        ['name' => 'Health & Pharmacy', 'slug' => 'health-pharmacy'],
        ['name' => 'Food & Delivery', 'slug' => 'food-delivery'],
        ['name' => 'Real Estate', 'slug' => 'real-estate'],
        ['name' => 'Social Networks & Communities', 'slug' => 'social-networks-communities'],
        ['name' => 'Recruitment & Jobs', 'slug' => 'recruitment-jobs'],
        ['name' => 'Productivity & Collaboration', 'slug' => 'productivity-collaboration'],
        ['name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence'],
        ['name' => 'Entrepreneurship & Startups', 'slug' => 'entrepreneurship-startups'],
        ['name' => 'Media & Entertainment', 'slug' => 'media-entertainment'],
        ['name' => 'Travel & Tourism', 'slug' => 'travel-tourism'],
        ['name' => 'Communication & Networking', 'slug' => 'communication-networking'],
        ['name' => 'Business Management', 'slug' => 'business-management'],
        ['name' => 'Environment & Energy', 'slug' => 'environment-energy'],
        ['name' => 'Software Development', 'slug' => 'software-development'],
        ['name' => 'Public Administration', 'slug' => 'public-administration'],
        ['name' => 'Sports & Wellness', 'slug' => 'sports-wellness'],
    ];

    foreach ($categories as $category) {
        Category::firstOrCreate(
            ['slug' => $category['slug']],
            ['name' => $category['name']]
        );
    }
})->purpose('Seed the categories table with predefined data');
