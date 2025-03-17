<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { shallowRef } from "vue";

const dialog = shallowRef(false);
const props = defineProps({
    reservations: {
        type: Object,
        required: true,
    },
});
const search = shallowRef("");

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const selectedTable = shallowRef(null);

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
                <v-data-iterator :items="props.reservations" :search="search"
                >
                <div class="grid grid-rows-3 grid-flow-col gap-4">
                        <div class="col-span-1 row-span-3 border-r">
                            <v-table height="470px" fixed-header>
                                <thead>
                                    <tr>
                                        <th class="text-center">Tên Bàn</th>
                                        <th class="text-center">Tên</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Tổng giá</th>
                                        <th class="text-center">Chỉnh sửa</th>
                                        <th class="text-center">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="reservation in reservations"
                                        :key="reservation.id"
                                        class="text-center"
                                    >
                                        <td>
                                            {{ reservation.tables.name }}
                                        </td>
                                        <td>{{ reservation.name }}</td>
                                        <td>{{ reservation.email }}</td>
                                        <td>{{ reservation.total_price }} đ</td>
                                        <td>
                                            <Link
                                                :href="
                                                    route('reservation.destroy', {
                                                        id: reservation.id,
                                                    })
                                                "
                                                method="delete"
                                                as="button"
                                            >
                                            <v-icon small color="primary"> mdi-pencil </v-icon>
                                            </Link>
                                        </td>
                                        <td>
                                            <Link
                                                :href="
                                                    route('reservation.destroy', {
                                                        id: reservation.id,
                                                    })
                                                "
                                                method="delete"
                                                as="button"
                                            >
                                            <v-icon small color="red"> mdi-delete </v-icon>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </div>
                    </div>
                </v-data-iterator>
            </v-card>
        </v-row>
    </div>
</template>
