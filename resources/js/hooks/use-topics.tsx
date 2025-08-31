import { TopicItem } from "@/pages/topics/topic";
import axios from "axios";
import { useEffect, useState } from "react";

export const useTopics = () => {
    const [topics, setTopics] = useState<TopicItem[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    const fetchTopics = async () => {
        try {
            setLoading(true);
            const response = await axios.get<{ topics: TopicItem[] }>(route('api.topics.index'));
            setTopics(response.data.topics);
            setError(null);
        } catch (err) {
            setError('Failed to fetch topics');
            console.error('Error fetching topics:', err);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchTopics();
    }, []);

    const refreshTopics = () => {
        fetchTopics();
    };

    return {
        topics,
        loading,
        error,
        refreshTopics
    };
};

export default useTopics;