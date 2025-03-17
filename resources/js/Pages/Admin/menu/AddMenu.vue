<script setup>
import { shallowRef, watchEffect, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    products: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: "",
    desc: "",
    image: "",
    price: "",
    type: "",
    taste: "",
    nutritionNeeds: "",
    preferences: "",
    products: [],
    occasion: "",
    meal_time: "",
    diners: ""
});
const handleImageChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    form.post(route("menu.store"));
};
const search = shallowRef("");
const headers = [
    {
        title: "Tên món",
        align: "start",
        key: "name",
    },
    { title: "Danh mục", align: "center", key: "categories.name" },
    { title: "Giá", align: "end", key: "price" },
];

watchEffect(() => {
  form.price = form.products.reduce((total, product) => {
    return total + (parseFloat(product.price) || 0);
  }, 0);
});

</script>

<template>
    <Head title="Add" />
    <div class="max-w-6xl mt-2 p-4">
        <form @submit.prevent="submit" class="bg-white px-8 pt-6 pb-8 mb-4">
            <v-row>
                <v-col>
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
                            label="Tên Thực đơn"
                            v-model="form.name"
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
                            rows="2"
                            variant="outlined"
                            prepend-icon="mdi-text-long"
                            v-model="form.desc"
                            required
                            autofocus
                        ></v-textarea>
                    </div>
                    <div class="mb-4">
                        <v-select
                            :items="['REQ', 'Tùy chọn']"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Chọn Loại món"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.type"
                            variant="outlined"
                        ></v-select>
                    </div>
                    <div class="mb-4">
                        <v-select
                            :items="['2', '3', '4', '5', '6']"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Chọn Số Người Ăn"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.diners"
                            variant="outlined"
                        ></v-select>
                    </div>
                </v-col>
                <v-col>
                    <div class="mb-4">
                        <v-select
                            :items="[
                                'Ngọt',
                                'Cay',
                                'Mặn',
                                'Đắng',
                                'Chua',
                                'Cân đối',
                            ]"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Khẩu vị"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.taste"
                            variant="outlined"
                        ></v-select>
                    </div>
                    <div class="mb-4">
                        <v-select
                            :items="[
                                'Giảm cân',
                                'Nhiều protein',
                                'Nhiều đạm',
                                'Chất xơ',
                                'Chất béo',
                                'Cân đối',
                            ]"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Nhu Cầu dinh dưỡng"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.nutritionNeeds"
                            variant="outlined"
                        ></v-select>
                    </div>

                    <div class="mb-4">
                        <v-select
                            :items="[
                                'Hải sản',
                                'Nướng',
                                'Kho',
                                'Chiên',
                                'Canh',
                                'Cay',
                                'Chay',
                                'Có cồn',
                                'Món Ý',
                                'Món Trung',
                                'Món Nhật',
                            ]"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Sở thích"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.preferences"
                            variant="outlined"
                            multiple
                        ></v-select>
                    </div>

                    <div class="mb-4">
                        <v-select
                            :items="['Sinh nhật', 'Kỷ niệm', 'Thường ngày']"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Dịp ăn uống"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.occasion"
                            variant="outlined"
                        ></v-select>
                    </div>
                    <div class="mb-4">
                        <v-select
                            :items="['SÁNG', 'TRƯA', 'CHIỀU', 'TỐI']"
                            item-title="name"
                            item-value="name"
                            density="compact"
                            label="Buổi ăn"
                            prepend-icon="mdi-format-list-bulleted-type"
                            v-model="form.meal_time"
                            variant="outlined"
                        ></v-select>
                    </div>
                </v-col>
            </v-row>

            <div class="mb-4 border rounded">
                <v-card>
                    <v-card-title>
                        Chọn Món cho Thực đơn
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Tìm món .."
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="products"
                        :search="search"
                        items-per-page="4"
                        show-select
                        v-model="form.products"
                        :item-value="item =>({ id: item.id, price: item.price })"
                    ></v-data-table>
                </v-card>
            </div>
            <v-text-field
                type="number"
                prepend-icon="mdi-calendar-range"
                density="compact"
                label="Giá"
                v-model="form.price"
                required
                autofocus
                variant="outlined"
            ></v-text-field>

            <div class="flex items-center justify-end">
                <v-btn color="primary" @click="submit">Thêm</v-btn>
            </div>
        </form>
    </div>
</template>