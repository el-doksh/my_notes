import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem } from '@/types';
import React, { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    rightActions?: React.ReactNode;
}

export default ({ children, breadcrumbs, rightActions, ...props }: AppLayoutProps) => (
    <AppLayoutTemplate breadcrumbs={breadcrumbs} rightActions={rightActions} {...props}>
        {children}
    </AppLayoutTemplate>
);
