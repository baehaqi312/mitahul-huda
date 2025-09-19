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
        required: false,
    },
    open: {
        type: Boolean,
        default: false,
    },
})

const showDialog = ref(props.open);
watch(() => props.open, (val) => showDialog.value = val);

const form = useForm({
    name: props.item?.name || '',
    jumlah: props.item?.jumlah || '',
    status: props.item?.status || 'Dipinjam',
});

watch(() => props.item, (newItem) => {
    form.defaults({
        name: newItem?.name || '',
        jumlah: newItem?.jumlah || '',
        status: newItem?.status || 'Dipinjam',
    });
    form.reset();
});

const submit = () => {
    form.put(`/barang/${props.item.id}`, {
        onSuccess: () => {
            form.reset();
            showDialog.value = false;
            router.reload({ only: ['barang'] });
        },
        onError: (err) => {
            console.error(err);
        }
    });
};
</script>

<template>
    <Dialog v-model:open="showDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Edit Peminjaman Barang</DialogTitle>
            </DialogHeader>
            <template v-if="props.item">
                <form @submit.prevent="submit" class="space-y-4">
                    <Input v-model="form.name" placeholder="Nama Peminjam" required />
                    <Input v-model="form.jumlah" placeholder="Jumlah Barang" type="number" min="1" required />
                    <Button type="submit" class="w-full" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Simpan
                    </Button>
                </form>
            </template>
        </DialogContent>
    </Dialog>
</template>
