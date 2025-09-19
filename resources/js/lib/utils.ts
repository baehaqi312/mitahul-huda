import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
) {
    return toUrl(urlToCheck) === currentUrl;
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function valueUpdater<T>(
    updaterOrValue: T | ((prev: T) => T),
    targetRef: { value: T }
) {
    if (typeof updaterOrValue === "function") {
        targetRef.value = (updaterOrValue as (prev: T) => T)(targetRef.value)
    } else {
        targetRef.value = updaterOrValue
    }
}
