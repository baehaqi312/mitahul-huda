<script setup>
import {
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from "@tanstack/vue-table"
import { ArrowUpDown, ChevronDown } from "lucide-vue-next"
import { h, ref, watch } from "vue"
import { valueUpdater } from "@/lib/utils"

import { Button } from "@/components/ui/button"
import { Checkbox } from "@/components/ui/checkbox"
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { Input } from "@/components/ui/input"
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"
import DropdownAction from "./DataTableDemoColumn.vue"
import { router } from '@inertiajs/vue3';
import users from "@/routes/users"
import Create from "./Create.vue"
import Update from "./Update.vue"

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
})

const data = props.users;

const columns = [
    {
        accessorKey: "name",
        header: "Name",
        cell: ({ row }) => h("div", { class: "capitalize" }, row.getValue("name")),
    },
    {
        accessorKey: "email",
        header: ({ column }) => h(
            Button,
            {
                variant: "ghost",
                onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
            },
            () => ["Email", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })]
        ),
        cell: ({ row }) => h("div", { class: "lowercase" }, row.getValue("email")),
    },
    {
        accessorKey: "role",
        header: "Role",
        cell: ({ row }) => h("div", { class: "capitalize" }, row.getValue("role")),
    },
    {
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            const payment = row.original
            return h("div", { class: "text-center" }, [
                h(DropdownAction, {
                    payment,
                    onExpand: row.toggleExpanded,
                    // emit event agar parent bisa reload data setelah delete
                    onDeleted: () => {
                        router.reload({ only: ['users'] });
                    },
                    onUpdate: () => {
                        // Reset dialog dulu agar bisa dibuka berkali-kali
                        updateUser.value = false;
                        selectedUser.value = null;
                        setTimeout(() => {
                            selectedUser.value = payment;
                            updateUser.value = true;
                        }, 0);
                    }
                })
            ])
        },
    },
]

const sorting = ref([])
const columnFilters = ref([])
const columnVisibility = ref({})
const rowSelection = ref({})
const expanded = ref({})

const table = useVueTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get expanded() { return expanded.value },
    },
})

const emailFilter = ref(table.getColumn('email')?.getFilterValue() || "")
watch(emailFilter, (val) => {
    table.getColumn('email')?.setFilterValue(val)
})

const addUser = ref(false)
const updateUser = ref(false);
const selectedUser = ref(null);
</script>

<template>
    <Create v-model:open="addUser" />
    <Update v-model:open="updateUser" :user="selectedUser" @close="updateUser = false" />
    <div class="w-full">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between py-4">
            <Input class="max-w-sm" placeholder="Filter emails..." v-model="emailFilter" />
            <div class="ml-auto flex items-center">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-auto">
                            Columns
                            <ChevronDown class="ml-2 h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuCheckboxItem
                            v-for="column in table.getAllColumns().filter(col => col.getCanHide())" :key="column.id"
                            class="capitalize" :model-value="column.getIsVisible()"
                            @update:model-value="value => column.toggleVisibility(!!value)">
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Button class="ms-2" @click="addUser = true">Tambah Pengguna</Button>
            </div>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length">
                                    {{ JSON.stringify(row.original) }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>
                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            No results.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="flex-1 text-sm text-muted-foreground">
                {{ table.getFilteredSelectedRowModel().rows.length }} of
                {{ table.getFilteredRowModel().rows.length }} row(s) selected.
            </div>
            <div class="space-x-2">
                <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()">
                    Previous
                </Button>
                <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                    Next
                </Button>
            </div>
        </div>
    </div>
</template>
