<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import UsersDataTable from './DataTable.vue';
import { dashboard } from '@/routes';
import { Button } from '@/components/ui/button';

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Users',
        href: '#',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <UsersDataTable :users="users" :key="users.length + JSON.stringify(users.map(u => u.id))" />
        </div>
    </AppLayout>
</template>
