import React from "react";
import { Icon } from "./icon";
import { Pen, Trash } from "lucide-react";
import { ActionItem } from "./tailwind-table";
import { Head, Link } from "@inertiajs/react";
import { Button } from "./button";

type TableActionsProps = {
    // children: React.ReactNode;
    row: any,
    actionsList: ActionItem[]
};

function TableActions({ row, actionsList, ...props }: TableActionsProps) {
    const actionsIconsNode = {
        edit: Pen,
        delete: Trash,
    };

    return (
    
        <div className="flex align-center gap-4">
            {actionsList.map(actionItem => {
                const actionLink  = actionItem.link.replaceAll(':id', row.id);
                const actionIcon = actionsIconsNode[actionItem.type];
                if(actionItem.onClick) {
                    return (
                        <Icon key={actionItem.type} onClick={() => actionItem.onClick(row)} iconNode={actionIcon} className="ml-1 h-4 w-4" />
                    )
                }
                return (
                    <Link href={actionLink} key={actionItem.type}>
                        <Icon iconNode={actionIcon} className="ml-1 h-4 w-4" />
                    </Link>
                )
            })}
        </div>
    );
}

export { TableActions };
