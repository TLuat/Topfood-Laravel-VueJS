<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    
});

const form = useForm({
    name: "",
    guest_number: Number,
    location: "",
    status: "Còn Trống",
});

const submit = () => {
    form.post(route("table.store"));
};
</script>

<template>
    <Head title="Thêm Bàn" />
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
                    v-model="form.name"
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
                    v-model="form.guest_number"
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
                v-model="form.status"
                variant="outlined"
               ></v-select>
            </div>
            
            <div class="flex items-center justify-end">
                <v-btn color="primary" @click="submit"
                                >Thêm</v-btn>
            </div>
        </form>
    </div>
</template>
