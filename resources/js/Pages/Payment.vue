<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { defineProps } from "vue";
const props = defineProps({
    selectedProducts: {
        type: Array,
        require: true,
    },
    totalSum: {
        type: Number,
        require: true,
    },
});
const tab = ref(null);
const inline = ref(null);

const form = useForm({
    recipient_name: "",
    phone_number: "",
    shipping_address: "",
    selectedProducts: props.selectedProducts,
    totalSum: props.totalSum,
    status: "pending",
});

const One = "One";
const Two = "Two";
const Three = "Three";

const submit = () => {
    const formData = {
        recipient_name: form.recipient_name,
        phone_number: form.phone_number,
        shipping_address: form.shipping_address,
    };

    form.post(route('order.store'), formData);   
};
</script>

<template>
    <Head title="Thanh Toán" />

    <div>
        <div>
            <h1>Thông tin đơn hàng</h1>
            <ul>
                <li v-for="product in selectedProducts" :key="product.id">
                    {{ product.products.name }} ({{ product.quantity }} items)
                </li>
            </ul>
            <div>Tổng giá: {{ totalSum }}</div>
        </div>

        <v-card-title>
            <span class="text-h5">Thanh Toán</span>
        </v-card-title>

        <v-card>
            <v-tabs
                v-model="tab"
                color="deep-purple-accent-4"
                align-tabs="center"
            >
                <v-tab :value="One">Thanh toán khi nhận hàng</v-tab>
                <v-tab :value="Two">Ví điện tử</v-tab>
                <v-tab :value="Three">Thẻ Ngân hàng</v-tab>
            </v-tabs>
            <v-window v-model="tab">
                <v-window-item :value="One">
                    <form @submit.prevent="submit">
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Họ tên*"
                                            required
                                            v-model="form.recipient_name"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-text-field
                                            label="Số điện thoại*"
                                            type="text"
                                            required
                                            v-model="form.phone_number"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Địa chỉ nhận hàng*"
                                            required
                                            v-model="form.shipping_address"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <small class="text-red-600"
                                >*vui lòng điền đầy đủ thông tin</small
                            >
                            <div class="flex items-center justify-end">
                                <button
                                    class="bg-cyan-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    type="submit"
                                    
                                >
                                    Xác nhận
                                </button>
                            </div>
                        </v-card-text>
                    </form>
                </v-window-item>

                <v-window-item :value="Two">
                    <v-col cols="12">
                        <v-text-field label="Họ tên*" required></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Địa chỉ nhận hàng*"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Số điện thoại*"
                            type="text"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-radio-group v-model="inline" inline>
                        <v-radio label="Momo" value="radio-1"></v-radio>
                        <v-radio label="Paypal" value="radio-2"></v-radio>
                    </v-radio-group>
                </v-window-item>

                <v-window-item :value="Three"> </v-window-item>
            </v-window>
        </v-card>
    </div>
</template>
