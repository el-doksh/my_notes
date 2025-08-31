import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import InputGroup from "@/components/ui/input-group";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, Link, useForm } from "@inertiajs/react";
import { LoaderCircle, LogIn } from "lucide-react";
import { FormEventHandler } from "react";
import { TopicItem } from "./topic";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Topics',
        href: '/topics',
    },
    {
        title: 'Edit',
        href: '/topics/edit',
    },
];

type TopicEditProps = {
    topic?: TopicItem,
    topics: TopicItem[],
}

const TopicsEdit = ({ topic, topics }: TopicEditProps ) => {
    
    const { data, setData, post, put, processing, errors, reset } = useForm<TopicItem>({
        id: topic?.id ?? null,
        name: topic?.name ?? "",
        description: topic?.description ?? "",
        parent_id: topic?.parent_id ? String(topic.parent_id) : null,
        url: topic?.url ? topic.url : null,
    });

    const onSubmitHandler: FormEventHandler = (e)  => {
        e.preventDefault();
        if(data.id === null) {
            post(route('topics.store'));
            return;
        }
        
        put(route('topics.update', { id: data.id }));
    }

    const onNameChangeHanlder = (e: React.ChangeEvent<HTMLInputElement>) => {
        const name = e.target.value;
        setData('name', name);
        setData('url', name.toLowerCase().replace(/\s+/g, '-'));
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Topics" />

            <form method={data.id ? "put" : 'post'}  onSubmit={onSubmitHandler}>
                <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <InputGroup>
                        <Label>Name:</Label>
                        <Input 
                            type="text"
                            name="name" 
                            onChange={onNameChangeHanlder}
                            placeholder="Topic name..."
                            value={data.name ?? ""}
                        />
                        {errors.name && <div className="text-red-500 text-xs">{errors.name}</div>}
                    </InputGroup>
                    <InputGroup>
                        <Label>Description:</Label>
                        <Input 
                            type="text"
                            name="description" 
                            onChange={(e) => setData('description', e.target.value)} 
                            placeholder="Topic description..."
                            value={data.description ?? ""}
                        />
                        {errors.description && <div className="text-red-500 text-xs">{errors.description}</div>}
                    </InputGroup>
                    <InputGroup>
                        <Label>Parent Topic</Label>
                        <Select
                            name="parent_id"
                            value={data.parent_id ?? ""}
                            onValueChange={val => setData('parent_id', val ? String(val) : null)}
                        >
                            <SelectTrigger>
                                <SelectValue placeholder="Select parent topic" />
                            </SelectTrigger>

                            <SelectContent>
                                <SelectItem key={"-1"} value={null}>None</SelectItem>

                                {topics.map(topic => (
                                    <SelectItem key={topic.id} value={String(topic.id)}>{topic.name}</SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.parent_id && <div className="text-red-500 text-xs">{errors.parent_id}</div>}
                    </InputGroup>
                    <InputGroup>
                        <Label>URL:</Label>
                        <Input 
                            type="text"
                            name="url" 
                            onChange={(e) => setData('url', e.target.value)}
                            placeholder="Topic url..."
                            value={data.url ?? ""}
                        />
                        {errors.url && <div className="text-red-500 text-xs">{errors.url}</div>}
                    </InputGroup>
                    
                    <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Save
                    </Button>
                </div>
            </form>
        </AppLayout>
    );
}

export default TopicsEdit;