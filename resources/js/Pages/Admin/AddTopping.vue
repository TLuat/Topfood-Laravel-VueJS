<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
});

const form = useForm({
    name: "",
    image: "",
    price: "",
});
const handleImageChange = (event) => {
        form.image = event.target.files[0];
};

const submit = () => {
    form.post(route('topping.store'));
};
</script>

<template>
    <Head title="Add" />
    <div class="max-w-6xl mt-2 p-4">
        <form
            @submit.prevent="submit"
            class="bg-white px-8 pt-6 pb-8 mb-4"
        >
           
            <v-file-input
                multiple
                label="Chọn Hình ảnh"
                @change="handleImageChange"
                variant="filled"
                prepend-icon="mdi-camera"
            ></v-file-input>

            <div class="mb-4">
                <v-text-field
                    type="text"
                    prepend-icon="mdi-calendar-range"
                    density="compact"
                    label="Tên Món Kèm"
                    v-model="form.name"
                    required
                    autofocus
                    variant="outlined"
                ></v-text-field>
            </div>

            <div class="flex items-center justify-end">
                <v-btn color="primary" @click="submit"
                                >Thêm</v-btn>
            </div>
        </form>
    </div>
</template>
