<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    selectedCartItem: {
        type: Object,
        required: true,
    },
});
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`; // Thay thế bằng đường dẫn đến thư mục lưu trữ hình ảnh
};

const totalToppingPrice = computed(() => {
    let totalPrice = 0;

    for (const topping of props.selectedCartItem.toppings) {
        totalPrice += parseFloat(topping.price);
    }

    return totalPrice;
});
</script>

<template>
    <div>
        <div class="">
            <div class="">
                <div class="">
                    <div class="">
                        <p class="p-5">
                            MÓN THÊM ĐÃ CHỌN
                        </p>
                     
                            <v-table height="470px" fixed-header>
                                <thead>
                                    <tr>
                                        <th class="text-center">Ảnh</th>
                                        <th class="text-center">Tên</th>
                                        <th class="text-center">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="topping in selectedCartItem.toppings"
                                        :key="topping.id"
                                        class="text-center"
                                    >
                                        <td class="">
                                            <v-img
                                                cover
                                                class="p-1 rounded-lg mt-2 mb-2 shadow-lg"
                                                width="45"
                                                height="45"
                                                :src="getImageUrl(topping.img)"
                                            ></v-img>
                                        </td>
                                        <td>{{ topping.name }}</td>
                                        <td><span class="text-green-500">{{ topping.price }} đ</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Tổng giá: <span class="text-green-500">{{ totalToppingPrice }} đ</span></td>
                                    </tr>
                                </tbody>
                            </v-table>
         
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
