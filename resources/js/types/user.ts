export type UserRole = 'user' | 'moderator' | 'admin';

export type ManageUser = {
    id: number;
    name: string;
    username: string;
    email: string;
    avatar: string | null;
    location: string | null;
    role: UserRole;
    email_verified_at: string | null;
    created_at: string | null;
    last_active_at: string | null;
    is_suspended: boolean;
    suspended_at: string | null;
    suspended_until: string | null;
    suspension_reason: string | null;
    suspended_by: { id: number; name: string; username: string } | null;
};

export type ManageUserStats = {
    total: number;
    moderators: number;
    suspended: number;
    recent: number;
};

export type RoleMatrixRow = {
    id: number;
    name: string;
    users_count: number;
    permissions: string[];
};
