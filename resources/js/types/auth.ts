export type User = {
    id: number;
    username: string;
    account_type: string;
    avatar?: string;
    created_on?: string | null;
    updated_on?: string | null;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
