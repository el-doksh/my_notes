
export type TopicDetailItem = {
    id: number;
    topic_id: number | null;
    name: string;
    description: string;
    details_html: string | null;
    parent?: {
        id: number;
        name: string;
    } | null;
}
