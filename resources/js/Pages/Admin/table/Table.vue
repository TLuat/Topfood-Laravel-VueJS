<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { shallowRef } from "vue";
import AddTable from "./AddTable.vue";
import EditTable from "./EditTable.vue";

const dialog = shallowRef(false);
const dialogEdit = shallowRef(false);
const props = defineProps({
    tables: {
        type: Array,
        required: true,
    },
});
const search = shallowRef("");
const headers = [
    { key: "name", title: "Tên Bàn" },
    { key: "guest_number", title: "Số Khách" },
    { key: "status", title: "Trạng thái"},
    { key: "action", title: "Hành động", sortable: false },
    { key: "id", sortable: false  },
];

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const selectedTable = shallowRef(null);
const openEditDialog = (Table) => {
  selectedTable.value = Table;
  dialogEdit.value = true;
};
</script>

<template>
    <Head title="Quản lý món ăn" />
    <div class="p-20">
        <v-row class="w-full">
            <v-col class="mx-auto">
                <v-btn color="primary" @click="dialog = true">Thêm Mới</v-btn>
                <v-dialog
                    v-model="dialog"
                    :scrim="false"
                    transition="dialog-bottom-transition"
                    width="600"
                >
                    <v-card-item class="bg-cyan-darken-1 rounded-t-lg">
                        <v-card-title>
                            <span class="text-h5 my-auto uppercase">
                                Thêm Bàn
                            </span>
                        </v-card-title>

                        <template v-slot:append>
                            <v-defaults-provider
                                :defaults="{
                                    VBtn: {
                                        variant: 'text',
                                        density: 'comfortable',
                                    },
                                }"
                            >
                                <v-btn
                                    icon="mdi mdi-close-thick"
                                    @click="dialog = false"
                                ></v-btn>
                            </v-defaults-provider>
                        </template>
                    </v-card-item>

                    <v-card>
                        <AddTable />
                    </v-card>
                </v-dialog>
            </v-col>
        </v-row>
        <v-row>
            <v-card width="2000">
                <v-card-title>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="props.tables"
                    :search="search"
                >
                    <template #item.id="{ item }">
                    </template>
                    <template #item.name="{ item }">
                        {{ item.columns.name }}
                    </template>
                    <template #item.status="{ item }">
                        <span v-if="item.columns.status ==='Còn Trống'" class="">Còn Trống</span>
                        <span v-else-if="item.columns.status === 'Đã Đặt'" class="">Đã Đặt</span>
                        <span v-else>Đang Chờ</span>
                    </template>
                    <template #item.action="{ item }">
                        <v-icon
                            small
                            color="green"
                            @click="openEditDialog(item.columns)"
                            class="mr-6"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-dialog
                            v-model="dialogEdit"
                            transition="dialog-bottom-transition"
                            width="500"
                            :scrim="false"
                        >
                            <v-card-item class="bg-cyan-darken-1 rounded-t-lg">
                                <v-card-title>
                                    <span class="text-h5 my-auto uppercase">
                                        Chỉnh sửa: {{ selectedTable.name }}
                                    </span>
                                </v-card-title>

                                <template v-slot:append>
                                    <v-defaults-provider
                                        :defaults="{
                                            VBtn: {
                                                variant: 'text',
                                                density: 'comfortable',
                                            },
                                        }"
                                    >
                                        <v-btn
                                            icon="mdi mdi-close-thick"
                                            @click="dialogEdit = false"
                                        ></v-btn>
                                    </v-defaults-provider>
                                </template>
                            </v-card-item>

                            <v-card>
                                <EditTable :table="selectedTable"/>
                            </v-card>
                        </v-dialog>
                        <Link
                            :href="
                                route('table.destroy', {
                                    id: item.columns.id,
                                })
                            "
                            method="delete"
                            as="button"
                        >
                            <v-icon small color="red"> mdi-delete </v-icon>
                        </Link>
                    </template>
                </v-data-table>
            </v-card>
        </v-row>
    </div>
</template>
