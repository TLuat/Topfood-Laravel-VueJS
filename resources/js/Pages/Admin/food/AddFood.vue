<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    categories: {
        type: Array,
        required: true,
    },
    toppings: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    desc: "",
    price: "",
    image: "",
    categories: "",
    meal_time: "",
    toppings: []
});
const handleImageChange = (event) => {
        form.image = event.target.files[0];
};
const submit = () => {
    form.post(route('product.store'));
};
</script>

<template>
    <Head title="Thêm Món ăn" />
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
                    label="Tên món ăn"
                    v-model="form.name"
                    required
                    autofocus
                    variant="outlined"
                ></v-text-field>
            </div>
            <div class="mb-4">
                <v-text-field
                    type="text"
                    prepend-icon="mdi-cash"
                    density="compact"
                    label="Nhập giá"
                    v-model="form.price"
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
                    v-model="form.desc"
                    required
                    autofocus
                ></v-textarea>
            </div>
            
            <div class="mb-4">
               <v-select
               :items="categories"
                item-title="name"
                item-value="id"
                density="compact"
                label="Chọn Loại Món"
                prepend-icon="mdi-format-list-bulleted-type"
                v-model="form.categories"
               ></v-select>
            </div>

            <div class="mb-4">
               <v-select
               :items="toppings"
                item-title="name"
                item-value="id"
                density="compact"
                label="Chọn Món đi kèm"
                prepend-icon="mdi-format-list-bulleted-type"
                v-model="form.toppings"
                multiple
               ></v-select>
            </div>

            <div class="mb-4">
               <v-select
               :items="['SÁNG', 'TRƯA', 'CHIỀU', 'TỐI']"
                density="compact"
                label="Giờ Ăn"
                prepend-icon="mdi-format-list-bulleted-type"
                v-model="form.meal_time"
               ></v-select>
            </div>

            <!-- <div>
                <label for="categories" class="block text-sm font-medium text-gray-700">Danh mục</label>
                <div>
                    <select id="categories" v-model="form.categories" class="form-multiselect block w-full mt-1"
                        >               
                            <option v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                            >{{ category.name }}</option>
                    </select>
                </div>
            </div> -->
            <!-- <div>
                <label for="toppings" class="block text-sm font-medium text-gray-700">Món thêm</label>
                <div>
                    <select id="toppings" v-model="form.toppings" class="form-multiselect block w-full mt-1"
                        multiple>               
                            <option v-for="topping in toppings"
                                    :key="topping.id"
                                    :value="topping.id"
                            >{{ topping.name }}</option>
                    </select>
                </div>
            </div> -->
            <div class="flex items-center justify-end">
                <v-btn color="primary" @click="submit"
                                >Thêm</v-btn>
            </div>
        </form>
    </div>
</template>
