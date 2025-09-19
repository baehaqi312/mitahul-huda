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
import { ref } from 'vue';
import { LoaderCircle } from 'lucide-vue-next';

const showDialog = ref(true);
const form = useForm({
    name: '',
    jumlah: '',
    status: 'Dipinjam',
});

const submit = () => {
    form.post('/barang', {
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
                <DialogTitle>Tambah Peminjaman Barang</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <Input v-model="form.name" placeholder="Nama Peminjam" required />
                <Input v-model="form.jumlah" placeholder="Jumlah Barang" type="number" min="1" required />
                <Button type="submit" class="w-full" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />Simpan
                </Button>
            </form>
        </DialogContent>
    </Dialog>
</template>
