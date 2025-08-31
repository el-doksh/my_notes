import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import useTopics from '@/hooks/use-topics';
import { type BreadcrumbItem } from '@/types';
import { useEffect, type PropsWithChildren } from 'react';

export default function AppSidebarLayout({ children, breadcrumbs = [], rightActions }: PropsWithChildren<{ breadcrumbs?: BreadcrumbItem[], rightActions: React.ReactNode }>) {

    // useEffect(()    => {
    // }, []);

    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar">
                <AppSidebarHeader breadcrumbs={breadcrumbs} rightActions={rightActions} />
                {children}
            </AppContent>
        </AppShell>
    );
}
