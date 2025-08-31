import { Button } from "@/components/ui/button";
import { Head, Link, useForm } from "@inertiajs/react";
import { TopicItem } from "./topic";

type DeleteTopicModalProps = {
    topic: TopicItem | null;
    onCancel: () => void;
    onConfirm: () => void;
};

const DeleteTopicModal = ({ topic, onCancel, onConfirm }: DeleteTopicModalProps) => {

    const {delete: del , data, setData } = useForm<TopicItem>({
        id: topic?.id ?? null,
        name: topic?.name ?? "",
        description: topic?.description ?? "",
        parent_id: topic?.parent_id ? String(topic.parent_id) : null,
    });
    const onConfirmHandler = ()  => {  
        del(route('topics.destroy', { id: data.id }));          
        onConfirm()
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div className="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 className="text-lg font-bold mb-4">Delete Topic</h2>
                <p>
                    Are you sure you want to delete <span className="font-semibold">{topic.name}</span>?
                </p>
                <div className="mt-6 flex justify-end gap-2">
                    <Button variant="outline" onClick={onCancel}>
                        Cancel
                    </Button>
                    <Button variant="destructive" onClick={onConfirmHandler}>
                        Delete
                    </Button>
                </div>
            </div>
        </div>
    );
};

export default DeleteTopicModal;