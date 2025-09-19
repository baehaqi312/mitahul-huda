<script setup>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { Button } from "@/components/ui/button"
import { MoreHorizontal } from "lucide-vue-next"
import { useForm, router } from "@inertiajs/vue3"

const form = useForm({})

const emit = defineEmits(['deleted'])
const props = defineProps({
    payment: {
        type: Object,
        required: true,
    },
    onDeleted: {
        type: Function,
        default: null,
    },
    onUpdate: {
        type: Function,
        default: null,
    }
})

function handleEdit() {
    if (props.onUpdate) {
        props.onUpdate(props.payment)
    }
}

function handleDelete() {
    if (confirm(`Yakin ingin menghapus data dengan ID ${props.payment.id}?`)) {
        form.delete(`/users/${props.payment.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Emit event ke parent agar parent reload data
                if (props.onDeleted) {
                    props.onDeleted();
                }
                emit('deleted');
            },
            onError: () => {
                // Optional: tampilkan notifikasi error
            }
        })
    }
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem @click="handleEdit">Edit</DropdownMenuItem>
            <DropdownMenuItem @click="handleDelete">Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
