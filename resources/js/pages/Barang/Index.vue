<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, watch } from 'vue'
import { dashboard } from '@/routes';
import DataTable from './DataTable.vue'
const props = defineProps({
    items: {
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
        title: 'Barang',
        href: '#',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <DataTable
                :items="items"
                :key="items.length"
            />
        </div>
    </AppLayout>
</template>

