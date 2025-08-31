import { Button } from "@/components/ui/button";
import { TailwindTable } from "@/components/ui/tailwind-table";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, Link } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { TopicDetailItem } from "./topic-detail";
import { TopicItem } from "../topics/topic";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'topics',
        href: '/details',
    },
];


type topicsData = {
    topic : TopicItem;
    topics: topicDetailItem[];
}

const topicsList = ({topics , topic } : topicsData ) => {
    const [tableRows, setTableRows] = useState<topicDetailItem[]>([]);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [deletedtopicDetail, setDeletetopicDetail] = useState<topicDetailItem | null>(null);

    const tableHeaders = [
        {
            key: 'name',
            title: "Name", 
        },
        {
            key: 'description',
            title: "Description", 
        },
        {
            key: 'parent_name',
            title: "Parent", 
        },
        {
            key: 'actions',
            title: 'Actions',
        }
    ];

    
    useEffect(() => {
        setTableRows(
            topics.map(topicDetail => ({
                ...topicDetail,
                parent_name: topicDetail.parent ? topicDetail.parent.name : 'N/A',
                key: topicDetail.id,
            }))
        )
    }, [topics]);

    const RightActions = <Link href={`/details/${topic.url}/create`} className="flex items-center space-x-2 font-medium">
                            <Button>
                                Create Topic
                            </Button>
                        </Link>

    const actionsList = [
        {
            type: 'edit',
            link :'/details/:id/edit',
        },
        {
            type: 'delete',
            link :'/details/:id',
            onClick: (row: any) => {
                setDeletetopicDetail(row);
                setShowDeleteModal(true);
            },
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs} rightActions={RightActions}>
            <Head title="topics" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <TailwindTable 
                    headers={tableHeaders}
                    rows={tableRows}
                    renderActions={true}
                    actionsList={actionsList}
                >
                </TailwindTable>
            </div>
        </AppLayout>
    );
}

export default topicsList;