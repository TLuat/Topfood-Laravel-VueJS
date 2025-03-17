<script setup>
import { Link } from "@inertiajs/vue3";
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { computed } from "vue";
import ShipOrdered from "./ShipOrdered.vue";

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    },
    comments: {
        type: Object,
        required: true,
    },
    ratings: {
        type: Object,
        required: true,
    },
    toppings: {
        type: Object,
        required: true,
    },
});

const tab = ref(null);

const One = "One";
const Two = "Two";
const Three = "Three";

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString("en-GB");
};

const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
</script>

<template>
    <div>
        <div class="">
            <v-toolbar class="bg-purple-900" height="10" rounded>
                <template v-slot:extension>
                    <v-tabs v-model="tab" align-tabs="title" color="#FF3D00">
                        <v-tab :value="One"
                            >Đơn hàng ({{
                                orders.filter(
                                    (order) =>
                                        order.status === "pending" ||
                                        order.status === "processing"
                                ).length || "0"
                            }})</v-tab
                        >
                        <v-tab :value="Two"
                            >Vận chuyển ({{
                                orders.filter(
                                    (order) => order.status === "shipping"
                                ).length || "0"
                            }})</v-tab
                        >
                        <v-tab :value="Three"
                            >Lịch sử mua ({{
                                orders.filter(
                                    (order) => order.status === "shipped"
                                ).length || "0"
                            }})</v-tab
                        >
                        <v-tab :value="Four"
                            >Món đã mua ({{
                                orders.filter(
                                    (order) => order.status === "shipped"
                                ).length || "0"
                            }})</v-tab
                        >
                    </v-tabs>
                </template>
            </v-toolbar>

            <v-window v-model="tab" class="h-96">
                <v-window-item value="One">
                    <v-table height="500px" fixed-header>
                        <div>
                            <v-expansion-panels class="bg-slate-200">
                                <v-expansion-panel
                                    v-for="order in orders"
                                    :key="order.id"
                                >
                                    <div
                                        v-if="
                                            order.status === 'pending' ||
                                            order.status === 'processing'
                                        "
                                        class=""
                                    >
                                        <v-expansion-panel-title class="">
                                            [
                                            {{ formatDate(order.created_at) }} ]
                                            - Đã đặt
                                            {{ order.total_quantity }} món
                                            <template
                                                v-slot:actions="{ expanded }"
                                            >
                                                <p
                                                    v-if="
                                                        order.status ===
                                                        'pending'
                                                    "
                                                >
                                                    Chưa Duyệt
                                                </p>
                                                <p v-else>Đã Duyệt</p>
                                                <v-icon
                                                    :color="
                                                        !expanded ? 'teal' : ''
                                                    "
                                                    :icon="
                                                        expanded
                                                            ? 'mdi-pencil'
                                                            : 'mdi-check'
                                                    "
                                                ></v-icon>
                                            </template>
                                        </v-expansion-panel-title>
                                        <v-expansion-panel-text class="">
                                            <p>
                                                Thời gian đặt món:
                                                {{
                                                    formatDate(order.created_at)
                                                }}
                                            </p>
                                            <v-row class="mx-auto my-auto">
                                                <v-col>
                                                    <p>Đã đặt:</p>
                                                    <ul>
                                                        <v-timeline
                                                            density="compact"
                                                            v-for="product in order.products"
                                                            :key="product.id"
                                                        >
                                                            <v-timeline-item
                                                                dot-color="white"
                                                                size="x-small"
                                                                icon="mdi-food-apple-outline"
                                                                icon-color="green"
                                                                fill-dot
                                                            >
                                                                <div class="">
                                                                    <div
                                                                        class="font-weight-normal d-flex"
                                                                    >
                                                                        <img
                                                                            :src="
                                                                                getImageUrl(
                                                                                    product.image
                                                                                )
                                                                            "
                                                                            alt="product image"
                                                                            class="w-8 h-8 rounded"
                                                                        />
                                                                        <span
                                                                            class="ml-2"
                                                                            >{{
                                                                                product.name
                                                                            }}

                                                                            x{{
                                                                                product
                                                                                    .pivot
                                                                                    .quantity
                                                                            }}</span
                                                                        >
                                                                    </div>
                                                                    <div class="">
                                                                        <div
                                                                            v-for="topping in product.toppings"
                                                                            :key="
                                                                                topping.id
                                                                            "
                                                                        >
                                                                            - {{
                                                                                topping.name
                                                                            }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </v-timeline-item>
                                                        </v-timeline>
                                                    </ul>
                                                </v-col>
                                                <v-col></v-col>
                                                <v-col class="my-auto ml-auto">
                                                    <Link
                                                        v-if="
                                                            order.status ===
                                                            'pending'
                                                        "
                                                        :href="
                                                            route(
                                                                'order.update',
                                                                {
                                                                    id: order.id,
                                                                }
                                                            )
                                                        "
                                                        method="put"
                                                        :data="{
                                                            status: 'cancel',
                                                        }"
                                                        as="button"
                                                        class="ml-auto bg-red-400 hover:bg-red-500 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                                    >
                                                        Hủy đơn
                                                    </Link>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-text>
                                    </div>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </v-table>
                </v-window-item>

                <v-window-item value="Two" class="h-96">
                    <v-table height="500px" fixed-header>
                        <div>
                            <v-expansion-panels>
                                <v-expansion-panel
                                    v-for="order in orders"
                                    :key="order.id"
                                >
                                    <div v-if="order.status === 'shipping'">
                                        <v-expansion-panel-title
                                            class="border-b"
                                        >
                                            [
                                            {{ formatDate(order.created_at) }} ]
                                            - Đã đặt
                                            {{ order.total_quantity }} món
                                            <template
                                                v-slot:actions="{ expanded }"
                                            >
                                                <p
                                                    v-if="
                                                        order.status ===
                                                        'shipping'
                                                    "
                                                >
                                                    Đang giao
                                                </p>
                                                <v-icon
                                                    :color="
                                                        !expanded ? 'teal' : ''
                                                    "
                                                    :icon="
                                                        expanded
                                                            ? 'mdi-pencil'
                                                            : 'mdi-check'
                                                    "
                                                ></v-icon>
                                            </template>
                                        </v-expansion-panel-title>
                                        <v-expansion-panel-text>
                                            <li>
                                                <p>
                                                    {{
                                                        formatDate(
                                                            order.created_at
                                                        )
                                                    }}
                                                </p>
                                                <ul>
                                                    <li
                                                        v-for="product in order.products"
                                                        :key="product.id"
                                                    >
                                                        {{ product.name }} -
                                                        {{
                                                            product.pivot
                                                                .quantity
                                                        }}
                                                    </li>
                                                </ul>
                                                <p>
                                                    Tổng số lượng:
                                                    {{ order.total_quantity }}
                                                </p>
                                                <p>
                                                    Tên người đặt:
                                                    {{ order.recipient_name }}
                                                </p>
                                                <p
                                                    v-if="
                                                        order.status ===
                                                        'shipping'
                                                    "
                                                >
                                                    Đang giao
                                                </p>

                                                <Link
                                                    :href="
                                                        route('order.update', {
                                                            id: order.id,
                                                        })
                                                    "
                                                    method="put"
                                                    :data="{
                                                        status: 'shipped',
                                                    }"
                                                    as="button"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                                >
                                                    Đã nhận
                                                </Link>
                                            </li>
                                        </v-expansion-panel-text>
                                    </div>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </v-table>
                </v-window-item>

                <v-window-item value="Three">
                    <v-expansion-panels>
                        <v-expansion-panel
                            v-for="order in orders"
                            :key="order.id"
                        >
                            <div v-if="order.status === 'shipped'">
                                <v-expansion-panel-title class="border-b">
                                    Số lượng: {{ order.total_quantity }}
                                    <template v-slot:actions="{ expanded }">
                                        <p v-if="order.status === 'shipped'">
                                            Đã nhận
                                        </p>
                                        <v-icon
                                            :color="!expanded ? 'teal' : ''"
                                            :icon="
                                                expanded
                                                    ? 'mdi-pencil'
                                                    : 'mdi-check'
                                            "
                                        ></v-icon>
                                    </template>
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <li>
                                        <p>
                                            {{ formatDate(order.created_at) }}
                                        </p>
                                        <ul>
                                            <li
                                                v-for="product in order.products"
                                                :key="product.id"
                                            >
                                                {{ product.name }} -
                                                {{ product.pivot.quantity }}
                                            </li>
                                        </ul>
                                        <p>
                                            Tổng số lượng:
                                            {{ order.total_quantity }}
                                        </p>
                                        <p>
                                            Tên người đặt:
                                            {{ order.recipient_name }}
                                        </p>
                                        <p v-if="order.status === 'shipped'">
                                            Đã nhận
                                        </p>
                                    </li>
                                </v-expansion-panel-text>
                            </div>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-window-item>

                <v-window-item value="Four">
                    <ShipOrdered
                        :orders="orders"
                        :products="products"
                        :comments="comments"
                        :ratings="ratings"
                        :toppings="toppings"
                    />
                </v-window-item>
            </v-window>
        </div>
    </div>
</template>
