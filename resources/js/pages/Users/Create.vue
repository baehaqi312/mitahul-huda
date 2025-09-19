<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button"
import { useForm, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const showDialog = ref(true);
const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
});

const roles = [
    { label: 'Admin', value: 'admin' },
    { label: 'User', value: 'user' }
];

const submit = () => {
    form.post('/users', {
        onSuccess: () => {
            form.reset();
            showDialog.value = false;
            router.reload({ only: ['users'] });
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
                <DialogTitle>Tambah Pengguna</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <Input v-model="form.name" placeholder="Nama" required />
                <Input v-model="form.email" placeholder="Email" type="email" required />
                <Input v-model="form.password" placeholder="Password" type="password" required />
                <Select v-model="form.role" required>
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Pilih Role" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem v-for="role in roles" :key="role.value" :value="role.value">
                                {{ role.label }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button type="submit" class="w-full">Simpan</Button>
            </form>
        </DialogContent>
    </Dialog>
</template>
