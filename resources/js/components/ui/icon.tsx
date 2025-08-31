import { LucideIcon } from 'lucide-react';
import '@/../css/icon.scss';

interface IconProps {
    iconNode?: LucideIcon | null;
    className?: string;
}

export function Icon({ iconNode: IconComponent, className, ...props }: IconProps) {
    if (!IconComponent) {
        return null;
    }

    return <IconComponent className={className} {...props} />;
}
