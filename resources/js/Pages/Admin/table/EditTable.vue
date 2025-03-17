<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    table: {
        type: Array,
        required: true,
    }
});

</script>

<template>
    <Head title="Sửa Bàn" />
    <div class="max-w-6xl mt-2 p-4">
        
        <form
            @submit.prevent="submit"
            class="bg-white px-8 pt-6 pb-8 mb-4"
        >
            <div class="mb-4">
                <v-text-field
                    type="text"
                    prepend-icon="mdi-calendar-range"
                    density="compact"
                    label="Tên Bàn"
                    v-model="table.name"
                    required
                    autofocus
                    variant="outlined"
                ></v-text-field>
            </div>
            <div class="mb-4">
                <v-text-field
                    type="number"
                    prepend-icon="mdi-account-group-outline"
                    density="compact"
                    label="Số Khách"
                    v-model="table.guest_number"
                    required
                    autofocus
                    variant="outlined"
                ></v-text-field>
            </div>

            <div class="mb-4">
                <v-select
               :items="['Còn Trống','Đang Chờ', 'Đã Đặt']"
                item-title="name"
                item-value="name"
                density="compact"
                label="Trạng Thái"
                prepend-icon="mdi-format-list-bulleted-type"
                v-model="table.status"
                variant="outlined"
               ></v-select>
            </div>

            <div class="flex items-center justify-end">
                <Link
                            :href="
                                route('table.update', {
                                    id: table.id,
                                })
                            "
                            :data="{name: table.name,
                                    guest_number: table.guest_number,
                                    status: table.status,
                                    }"
                            method="put"
                            as="button"
                        >
                        <v-btn color="primary"
                                >Cập nhật</v-btn>
                 </Link>
                
            </div>
        </form>
    </div>
</template>
