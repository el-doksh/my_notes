import { TableActions } from "./table-actions";

type TableHeader = {
    key: string;
    title: string;
};

export type ActionItem = {
    type: string;
    link: string;
    onClick?: (id: number) => void;
}

type TailwindTableProps = {
    headers: TableHeader[];
    rows: any[]; // Can be strongly typed if you know the row structure
    renderActions: boolean;
    actionsList: ActionItem[];
    className?: string;
};

function TailwindTable({ headers, rows, renderActions, actionsList, className, ...props }: TailwindTableProps) {
    
    return (
        <div className="overflow-x-auto shadow">
            <table className={`min-w-full text-sm text-left text-gray-700 ${className}`}>
                <thead className="bg-gray-100 text-gray-900 uppercase text-xs tracking-wider border-b">         
                    <tr className="h-8" >
                    {headers.map((header) => (
                        <th key={header.key} scope="col">
                            {header.title}
                        </th>
                    ))}
                    </tr>
                </thead>
                <tbody className=" divide-y divide-gray-200 bg-white">
                    {rows.map((row, rowIndex) => (
                        <tr className="h-12" key={rowIndex}>
                            {headers.map((header) =>
                                <>
                                    {row[header.key] !== undefined && <td key={header.key}>{row[header.key]}</td>}
                                </>
                            )}
                            {renderActions && (
                                <td className="">
                                    <TableActions row={row} actionsList={actionsList} />
                                </td>
                            )}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export { TailwindTable };
