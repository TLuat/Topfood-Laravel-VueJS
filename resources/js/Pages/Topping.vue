<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    toppings: {
        type: Object,
        required: true,
    },
});

console.log(props.toppings);

const quantity = ref(1);

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};

// const toppings = computed(() => {
//     return props.toppings.filter(
//         (topping) => topping.category_id === props.category
//     );
// });

const selectedToppings = ref([]);

const toggleToppingSelection = (topping) => {
    const index = selectedToppings.value.findIndex(
        (selected) => selected.id === topping.id
    );

    if (index === -1) {
        selectedToppings.value.push(topping);
    } else {
        selectedToppings.value.splice(index, 1);
    }
};

const isToppingSelected = (topping) => {
    return selectedToppings.value.some(
        (selected) => selected.id === topping.id
    );
};

const totalToppingsPrice = computed(() => {
    const toppingsPrice = selectedToppings.value.reduce(
        (total, topping) => total + parseFloat(topping.price),
        0
    );
    return (parseFloat(props.product.price) + toppingsPrice) * quantity.value;
});
const note = ref(null);
const snackbar = ref(false);
const snackbarText = ref("");
const snackbarColor = ref("");
const placeOrder = () => {
    snackbar.value = true;
    snackbarText.value = "Đã thêm vào giỏ";
    snackbarColor.value = "success";
};
</script>

<template>
    <div>
        <v-snackbar
            v-model="snackbar"
            :timeout="2500"
            height="12px"
            location="top"
            :color="snackbarColor"
        >
            <p class="text-lg font-bold">
                <span class="mdi mdi-check"></span> {{ snackbarText }}
            </p>
        </v-snackbar>

        <div class="mx-auto p-6 lg:p-15">
            <div class="">
                <div class="grid grid-rows-3 grid-flow-col gap-4 bg-white border-2 border-green-500">
                    <div class="col-span-1 row-span-3 border-r">
                        <p class="p-5">
                            MÓN THÊM
                            <span class="text-gray-700 text-sm"
                                >Không bắt buộc, tối đa
                                {{ toppings.length }}</span
                            >
                        </p>
                        <v-card>
                            <v-table height="470px" fixed-header>
                                <thead>
                                    <tr>
                                        <th class="text-left">Ảnh</th>
                                        <th class="text-left">Tên</th>
                                        <th class="text-left">Giá</th>
                                        <th class="text-left">Chọn</th>
                                        <th class="text-left"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="topping in toppings"
                                        :key="topping.id"
                                    >
                                        <td>
                                            <v-img
                                                cover
                                                class="p-1 rounded-lg mt-2 mb-2 shadow-lg"
                                                width="45"
                                                height="45"
                                                :src="getImageUrl(topping.img)"
                                            ></v-img>
                                        </td>
                                        <td>{{ topping.name }}</td>
                                        <td class="text-green-500">+{{ parseFloat(topping.price).toFixed(0) }} đ</td>

                                        <td>
                                            <v-checkbox
                                                label=""
                                                color="success"
                                                @change="
                                                    toggleToppingSelection(
                                                        topping
                                                    )
                                                "
                                                :model-value="
                                                    isToppingSelected(topping)
                                                "
                                            ></v-checkbox>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </div>
                    <div class="row-span-3">
                        <p>
                            Việc thực hiện yêu cầu còn tùy thuộc vào khả năng
                            quán
                        </p>

                        <v-card height="220" class="mb-6">
                            <v-timeline density="compact">
                                <v-timeline-item
                                    dot-color="white"
                                    size="x-small"
                                    v-for="selectedTopping in selectedToppings"
                                    :key="selectedTopping.id"
                                    icon="mdi-food-apple-outline"
                                    icon-color="green"
                                    fill-dot
                                >
                                    <div class="">
                                        <div class="font-weight-normal d-flex">
                                            <img
                                                :src="
                                                    getImageUrl(
                                                        selectedTopping.img
                                                    )
                                                "
                                                alt="product image"
                                                class="w-8 h-8 rounded"
                                            />
                                            <span class="ml-2">{{ selectedTopping.name }} <span class="text-green-500">+{{ parseFloat(selectedTopping.price).toFixed(0)}} đ</span></span>
                                        </div>
                                    </div>
                                </v-timeline-item>
                            </v-timeline>
                        </v-card>

                        <v-row class="w-80 mx-auto">
                            <v-textarea
                            bg-color="amber-lighten-4"
                            color="orange orange-darken-4"
                            label="Ghi chú (không bắt buộc)"
                            clearable
                            density="compact"
                            rows="2"
                            rounded="lg"
                            v-model="note"
                            prepend-icon="mdi-gas-burner"
                            ></v-textarea>
                        </v-row>

                        <v-row>
                            <div class="mx-auto text-center">
                            <div class="mb-2">
                                <label for="">Chọn số lượng: </label>
                                <input
                                    type="number"
                                    v-model="quantity"
                                    min="0"
                                    class="bg-gray-50 border text-center border-gray-300 rounded-lg w-20 h-9"
                                />
                                <input type="hidden" />
                            </div>
                            <div>
                                <div class="mb-2">
                                    <p>Tổng giá: <span class="text-green-500">{{ totalToppingsPrice }} đ</span></p>
                                </div>
                                <Link
                                    :href="route('cart.store')"
                                    method="post"
                                    :data="{
                                        productId: product.id,
                                        toppings: selectedToppings,
                                        quantity: quantity,
                                        totalPrice: totalToppingsPrice,
                                        note: note
                                    }"
                                    as="button"
                                    @click="placeOrder"
                                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                    >THÊM VÀO GIỎ HÀNG</Link
                                >
                            </div>
                        </div>
                        </v-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
