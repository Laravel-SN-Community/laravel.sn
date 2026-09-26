export type ArticleTag = { id: number; name: string; slug: string };

export type ArticleAuthor = {
    id: number;
    name: string;
    username: string;
    avatar: string | null;
    bio?: string | null;
    github_handle?: string | null;
    location?: string | null;
};

export type ArticleCoverSrcset = {
    sm: string | null;
    md: string | null;
    full: string | null;
};

export type ArticleSummary = {
    id: number;
    slug: string;
    title: string;
    excerpt: string;
    cover_url: string | null;
    cover_srcset: ArticleCoverSrcset | null;
    locale: string;
    published_at: string | null;
    reading_time_minutes: number;
    views_count: number;
    is_featured: boolean;
    author: ArticleAuthor;
    tags: ArticleTag[];
};

export type ArticleFull = ArticleSummary & {
    body: string;
    likes_count: number;
    content_updated_at: string | null;
    was_revised: boolean;
    updated_at: string;
};

export type PaginatedArticles = {
    data: ArticleSummary[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
};
