
export type TopicItem = {
    id: number;
    name: string;
    description: string;
    url: string | null;
    parent?: {
        id: number;
        name: string;
    } | null;
    parent_id: string | null;
}
