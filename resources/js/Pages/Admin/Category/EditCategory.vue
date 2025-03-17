<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    category: {
        type: Array,
        required: true,
    }
});

const handleImageChange = (event) => {
        form.image = event.target.files[0];
};

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
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
                    label="Tên Loại món ăn"
                    v-model="category.name"
                    required
                    autofocus
                    variant="outlined"
                ></v-text-field>
            </div>
            <div class="mb-4">
                <v-textarea
                    name="input-7-1"
                    label="Nhập mô tả"
                    auto-grow
                    variant="outlined"
                    prepend-icon="mdi-text-long"
                    v-model="category.desc"
                    required
                    autofocus
                ></v-textarea>
            </div>

            <div class="flex items-center justify-end">
                <Link
                            :href="
                                route('category.update', {
                                    id: category.id,
                                })
                            "
                            :data="{name: category.name,
                                    img: category.image,
                                    desc: category.desc,}"
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
