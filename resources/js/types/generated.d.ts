export type AnonTokenDto = {
    id: number;
    token: string;
};
export type AnonUserDto = {
    id: number;
    email: string;
};
export type MediaDto = {
    id: number;
    humanReadableSize: string;
    filename: string;
    mimetype: string;
    url: string;
    createdAt: string;
    updatedAt: string;
};
export type TextDto = {
    id: number;
    content: string;
    createdAt: string;
    updatedAt: string;
};
