<script setup>
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog"
import { Input } from '@/components/ui/input';
import { Button } from "@/components/ui/button"
import { useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps({
    item: {
        type: Object,
        default: null,
        required: true,
    },
    open: {
        type: Boolean,
        default: false,
    },
})

const showDialog = ref(props.open);
watch(() => props.open, (val) => showDialog.value = val);
const form = useForm({});

const submit = () => {
    form.post(`/barang/${props.item.id}/return`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            showDialog.value = false;
            router.reload({ only: ['barang'] });
        },
    })
};

</script>

<template>
    <Dialog v-model:open="showDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Tambah Peminjaman Barang</DialogTitle>
            </DialogHeader>
            <h1>Apakah {{props.item.name}} sudah mengembalikan Ember?</h1>
            <Button @click="submit" class="w-full" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Konfirmasi Pengembalian
            </Button>
        </DialogContent>
    </Dialog>
</template>
