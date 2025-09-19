<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { MoreHorizontal } from 'lucide-vue-next';

import {
    Card,
    CardContent,
    CardDescription,
    CardAction,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'

const props = defineProps<{
    // Define any props if needed
    totalBarang: number;
    totalDipinjam: number;
    totalDikembalikan: number;
}>();

console.log(props.totalBarang);
console.log(props.totalDipinjam);
console.log(props.totalDikembalikan);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <!-- <CardTitle>Jumlah Ember</CardTitle> -->
                        <CardDescription>Jumlah Barang</CardDescription>
                        <CardAction>
                            <Button variant="ghost" size="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </Button>
                        </CardAction>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">Total: {{ props.totalBarang }}</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <!-- <CardTitle>Jumlah Ember</CardTitle> -->
                        <CardDescription>Diberikan</CardDescription>
                        <CardAction>
                            <Button variant="ghost" size="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </Button>
                        </CardAction>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">Total: {{ props.totalDipinjam }}</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <!-- <CardTitle>Jumlah Ember</CardTitle> -->
                        <CardDescription>Dikembalikan</CardDescription>
                        <CardAction>
                            <Button variant="ghost" size="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </Button>
                        </CardAction>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">Total: {{ props.totalDikembalikan }}</p>
                    </CardContent>
                </Card>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
