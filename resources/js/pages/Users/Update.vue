<script setup>
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog"
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button"
import { useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        default: null,
        required: false,
    },
    open: {
        type: Boolean,
        default: false,
    },
    onClose: {
        type: Function,
        default: () => { },
    }
})

const showDialog = ref(props.open);
watch(() => props.open, (val) => showDialog.value = val);

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '', // kosongkan, hanya isi jika ingin ganti password
    role: props.user?.role || '',
});

// Reset form setiap kali user yang diedit berubah
watch(() => props.user, (newUser) => {
    form.defaults({
        name: newUser?.name || '',
        email: newUser?.email || '',
        password: '',
        role: newUser?.role || '',
    });
    form.reset();
});

const roles = [
    { label: 'Admin', value: 'admin' },
    { label: 'User', value: 'user' }
];

const submit = () => {
    form.put(`/users/${props.user.id}`, {
        onSuccess: () => {
            form.reset('password');
            showDialog.value = false;
            props.onClose();
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
                <DialogTitle>Edit Pengguna</DialogTitle>
            </DialogHeader>
            <template v-if="props.user">
                <form @submit.prevent="submit" class="space-y-4">
                    <Input v-model="form.name" placeholder="Nama" required />
                    <Input v-model="form.email" placeholder="Email" type="email" required />
                    <Input v-model="form.password" placeholder="Password (isi jika ingin ganti)" type="password" />
                    <p v-if="form.errors.password" class="text-red-500 text-xs">{{ form.errors.password }}</p>
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

                    <Button type="submit" class="w-full">Simpan Perubahan</Button>
                </form>
            </template>
        </DialogContent>
    </Dialog>
</template>
