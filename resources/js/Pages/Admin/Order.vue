<script setup>
import { Link } from "@inertiajs/vue3";
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { computed } from "vue";

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
});

const tab = ref(null);
const tab_one = ref(null);

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
const groupToppings = computed(() => {
    const groupedToppings = {};
    props.orders.forEach((order) => {
        order.toppings.forEach((topping) => {
            const key = topping.name;
            if (!groupedToppings[key]) {
                groupedToppings[key] = {
                    quantity: 1,
                    topping: topping,
                };
            } else {
                groupedToppings[key].quantity += 1;
            }
        });
    });
    return Object.values(groupedToppings);
});
</script>

<template>
    <Head title="Đơn hàng" />
    <div>
        <div>
            <v-tabs
                v-model="tab"
                color="deep-purple-accent-4"
                align-tabs="center"
                class="bg-white"
            >
                <v-tab :value="One"
                    >Đơn hàng ({{
                        orders.filter((order) => order.status === "pending")
                            .length || "0"
                    }})</v-tab
                >
                <v-tab :value="Two"
                    >giao hàng ({{
                        orders.filter((order) => order.status === "processing")
                            .length || "0"
                    }})</v-tab
                >
                <v-tab :value="Three"
                    >Đã giao ({{
                        orders.filter(
                            (order) =>
                                order.status === "shipped" ||
                                order.status === "shipping"
                        ).length || "0"
                    }})</v-tab
                >
            </v-tabs>

            <v-window v-model="tab">
                <v-window-item value="One">
                    <v-tabs
                        v-model="tab_one"
                        color="deep-purple-accent-4"
                        align-tabs="right"
                        class="bg-white mt-6"
                    >
                        <v-tab :value="One_One">Chờ duyệt</v-tab>
                        <v-tab :value="One_Two">Đã Hủy</v-tab>
                    </v-tabs>

                    <v-window v-model="tab_one">
                        <v-window-item value="One_One">
                            <v-table class="border-b border-t">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th colspan="3" class="text-center">
                                            Mô tả
                                        </th>

                                        <th class="text-center">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(order, index) in orders"
                                        :key="order.id"
                                    >
                                        <tr
                                            v-if="order.status === 'pending'"
                                            class="text-left"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td colspan="3">
                                                <v-expansion-panels
                                                    variant="accordion"
                                                >
                                                    <v-expansion-panel>
                                                        <v-expansion-panel-title
                                                            class="border-b"
                                                        >
                                                            <span
                                                                v-for="product in order.products"
                                                                :key="
                                                                    product.id
                                                                "
                                                            >
                                                                {{
                                                                    product.name
                                                                }}
                                                                -
                                                                {{
                                                                    product
                                                                        .pivot
                                                                        .quantity
                                                                }}
                                                            </span>
                                                            <template
                                                                v-slot:actions="{
                                                                    expanded,
                                                                }"
                                                            >
                                                                <p
                                                                    v-if="
                                                                        order.status ===
                                                                        'pending'
                                                                    "
                                                                >
                                                                    Chưa duyệt
                                                                </p>
                                                                <v-icon
                                                                    :color="
                                                                        !expanded
                                                                            ? 'teal'
                                                                            : ''
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
                                                                    Thời gian
                                                                    đặt món:
                                                                    {{
                                                                        formatDate(
                                                                            order.created_at
                                                                        )
                                                                    }}
                                                                </p>
                                                                <v-row
                                                                    class="mx-auto my-auto"
                                                                >
                                                                    <v-col>
                                                                        <p>
                                                                            Đã
                                                                            đặt:
                                                                        </p>
                                                                        <ul>
                                                                            <v-timeline
                                                                                density="compact"
                                                                            >
                                                                                <v-timeline-item
                                                                                    dot-color="white"
                                                                                    size="x-small"
                                                                                    v-for="product in order.products"
                                                                                    :key="
                                                                                        product.id
                                                                                    "
                                                                                    icon="mdi-food-apple-outline"
                                                                                    icon-color="green"
                                                                                    fill-dot
                                                                                >
                                                                                    <div
                                                                                        class=""
                                                                                    >
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
                                                                                                -
                                                                                                {{
                                                                                                    product
                                                                                                        .pivot
                                                                                                        .quantity
                                                                                                }}</span
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </v-timeline-item>
                                                                            </v-timeline>
                                                                        </ul>

                                                                        <p
                                                                            class="text-center"
                                                                        >
                                                                            Tổng
                                                                            số
                                                                            lượng
                                                                            món:
                                                                            {{
                                                                                order.total_quantity
                                                                            }}
                                                                        </p>
                                                                    </v-col>
                                                                    <v-col>
                                                                        <p
                                                                            class="mt-3"
                                                                        >
                                                                            Gọi
                                                                            thêm:
                                                                        </p>
                                                                        <ul>
                                                                            <v-timeline
                                                                                density="compact"
                                                                            >
                                                                                <v-timeline-item
                                                                                    dot-color="white"
                                                                                    size="x-small"
                                                                                    v-for="groupedTopping in groupToppings"
                                                                                    :key="
                                                                                        groupedTopping
                                                                                            .topping
                                                                                            .id
                                                                                    "
                                                                                    icon="mdi-food-apple-outline"
                                                                                    icon-color="green"
                                                                                    fill-dot
                                                                                >
                                                                                    <div
                                                                                        class=""
                                                                                    >
                                                                                        <div
                                                                                            class="font-weight-normal d-flex"
                                                                                        >
                                                                                            <img
                                                                                                :src="
                                                                                                    getImageUrl(
                                                                                                        groupedTopping
                                                                                                            .topping
                                                                                                            .img
                                                                                                    )
                                                                                                "
                                                                                                alt="topping image"
                                                                                                class="w-8 h-8 rounded"
                                                                                            />
                                                                                            <span
                                                                                                class="ml-2"
                                                                                            >
                                                                                                {{
                                                                                                    groupedTopping
                                                                                                        .topping
                                                                                                        .name
                                                                                                }}
                                                                                                <span
                                                                                                    v-if="
                                                                                                        groupedTopping.quantity >
                                                                                                        1
                                                                                                    "
                                                                                                >
                                                                                                    (x{{
                                                                                                        groupedTopping.quantity
                                                                                                    }})
                                                                                                </span>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </v-timeline-item>
                                                                            </v-timeline>
                                                                        </ul>
                                                                    </v-col>
                                                                </v-row>

                                                                <hr />
                                                                <v-row>
                                                                    <v-col>
                                                                        <p
                                                                            class="mt-3"
                                                                        >
                                                                            Thông
                                                                            tin
                                                                            khách
                                                                            hàng:
                                                                        </p>
                                                                        <p>
                                                                            Email:
                                                                            {{
                                                                                order.email
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Tên
                                                                            người
                                                                            đặt:
                                                                            {{
                                                                                order.recipient_name
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Số
                                                                            điện
                                                                            thoại:
                                                                            {{
                                                                                order.phone_number
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Địa
                                                                            chỉ
                                                                            giao
                                                                            hàng:
                                                                            {{
                                                                                order.shipping_address
                                                                            }}
                                                                        </p>
                                                                    </v-col>
                                                                    <v-col>
                                                                        Lời nhắn
                                                                        của
                                                                        khách:
                                                                        {{
                                                                            order.note
                                                                        }}
                                                                    </v-col>
                                                                </v-row>
                                                            </li>
                                                        </v-expansion-panel-text>
                                                    </v-expansion-panel>
                                                </v-expansion-panels>
                                            </td>
                                            <td class="text-center">
                                                <Link
                                                    :href="
                                                        route('order.update', {
                                                            id: order.id,
                                                        })
                                                    "
                                                    method="put"
                                                    :data="{
                                                        status: 'processing',
                                                    }"
                                                    as="button"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                                >
                                                    Duyệt
                                                </Link>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </v-table>
                        </v-window-item>
                        <v-window-item value="One_Two">
                            <v-table class="border-b border-t">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th colspan="3" class="text-center">
                                            Mô tả
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(order, index) in orders"
                                        :key="order.id"
                                    >
                                        <tr
                                            v-if="order.status === 'cancel'"
                                            class="text-left"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td colspan="3">
                                                <v-expansion-panels
                                                    variant="accordion"
                                                >
                                                    <v-expansion-panel>
                                                        <v-expansion-panel-title
                                                            class="border-b"
                                                        >
                                                            <span
                                                                v-for="product in order.products"
                                                                :key="
                                                                    product.id
                                                                "
                                                            >
                                                                {{
                                                                    product.name
                                                                }}
                                                                -
                                                                {{
                                                                    product
                                                                        .pivot
                                                                        .quantity
                                                                }}
                                                            </span>
                                                            <template
                                                                v-slot:actions="{
                                                                    expanded,
                                                                }"
                                                            >
                                                                <p
                                                                    v-if="
                                                                        order.status ===
                                                                        'pending'
                                                                    "
                                                                >
                                                                    Chưa duyệt
                                                                </p>
                                                                <v-icon
                                                                    :color="
                                                                        !expanded
                                                                            ? 'teal'
                                                                            : ''
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
                                                                    Thời gian
                                                                    đặt món:
                                                                    {{
                                                                        formatDate(
                                                                            order.created_at
                                                                        )
                                                                    }}
                                                                </p>
                                                                <v-row
                                                                    class="mx-auto my-auto"
                                                                >
                                                                    <v-col>
                                                                        <p>
                                                                            Đã
                                                                            đặt:
                                                                        </p>
                                                                        <ul>
                                                                            <v-timeline
                                                                                density="compact"
                                                                            >
                                                                                <v-timeline-item
                                                                                    dot-color="white"
                                                                                    size="x-small"
                                                                                    v-for="product in order.products"
                                                                                    :key="
                                                                                        product.id
                                                                                    "
                                                                                    icon="mdi-food-apple-outline"
                                                                                    icon-color="green"
                                                                                    fill-dot
                                                                                >
                                                                                    <div
                                                                                        class=""
                                                                                    >
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
                                                                                                -
                                                                                                {{
                                                                                                    product
                                                                                                        .pivot
                                                                                                        .quantity
                                                                                                }}</span
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </v-timeline-item>
                                                                            </v-timeline>
                                                                        </ul>

                                                                        <p
                                                                            class="text-center"
                                                                        >
                                                                            Tổng
                                                                            số
                                                                            lượng
                                                                            món:
                                                                            {{
                                                                                order.total_quantity
                                                                            }}
                                                                        </p>
                                                                    </v-col>
                                                                    <v-col>
                                                                        <p
                                                                            class="mt-3"
                                                                        >
                                                                            Gọi
                                                                            thêm:
                                                                        </p>
                                                                        <ul>
                                                                            <v-timeline
                                                                                density="compact"
                                                                            >
                                                                                <v-timeline-item
                                                                                    dot-color="white"
                                                                                    size="x-small"
                                                                                    v-for="groupedTopping in groupToppings"
                                                                                    :key="
                                                                                        groupedTopping
                                                                                            .topping
                                                                                            .id
                                                                                    "
                                                                                    icon="mdi-food-apple-outline"
                                                                                    icon-color="green"
                                                                                    fill-dot
                                                                                >
                                                                                    <div
                                                                                        class=""
                                                                                    >
                                                                                        <div
                                                                                            class="font-weight-normal d-flex"
                                                                                        >
                                                                                            <img
                                                                                                :src="
                                                                                                    getImageUrl(
                                                                                                        groupedTopping
                                                                                                            .topping
                                                                                                            .img
                                                                                                    )
                                                                                                "
                                                                                                alt="topping image"
                                                                                                class="w-8 h-8 rounded"
                                                                                            />
                                                                                            <span
                                                                                                class="ml-2"
                                                                                            >
                                                                                                {{
                                                                                                    groupedTopping
                                                                                                        .topping
                                                                                                        .name
                                                                                                }}
                                                                                                <span
                                                                                                    v-if="
                                                                                                        groupedTopping.quantity >
                                                                                                        1
                                                                                                    "
                                                                                                >
                                                                                                    (x{{
                                                                                                        groupedTopping.quantity
                                                                                                    }})
                                                                                                </span>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </v-timeline-item>
                                                                            </v-timeline>
                                                                        </ul>
                                                                    </v-col>
                                                                </v-row>

                                                                <hr />
                                                                <v-row>
                                                                    <v-col>
                                                                        <p
                                                                            class="mt-3"
                                                                        >
                                                                            Thông
                                                                            tin
                                                                            khách
                                                                            hàng:
                                                                        </p>
                                                                        <p>
                                                                            Email:
                                                                            {{
                                                                                order.email
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Tên
                                                                            người
                                                                            đặt:
                                                                            {{
                                                                                order.recipient_name
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Số
                                                                            điện
                                                                            thoại:
                                                                            {{
                                                                                order.phone_number
                                                                            }}
                                                                        </p>
                                                                        <p>
                                                                            Địa
                                                                            chỉ
                                                                            giao
                                                                            hàng:
                                                                            {{
                                                                                order.shipping_address
                                                                            }}
                                                                        </p>
                                                                    </v-col>
                                                                    <v-col>
                                                                        Lời nhắn
                                                                        của
                                                                        khách:
                                                                        {{
                                                                            order.note
                                                                        }}
                                                                    </v-col>
                                                                </v-row>
                                                            </li>
                                                        </v-expansion-panel-text>
                                                    </v-expansion-panel>
                                                </v-expansion-panels>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </v-table>
                        </v-window-item>
                    </v-window>
                </v-window-item>

                <v-window-item value="Two">
                    <v-table class="border-b border-t">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th colspan="3" class="text-center">Mô tả</th>

                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template
                                v-for="(order, index) in orders"
                                :key="order.id"
                            >
                                <tr
                                    v-if="order.status === 'processing'"
                                    class="text-center"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td colspan="3">
                                        <v-expansion-panels variant="accordion">
                                            <v-expansion-panel>
                                                <v-expansion-panel-title
                                                    class="border-b"
                                                >
                                                    <span
                                                        v-for="product in order.products"
                                                        :key="product.id"
                                                    >
                                                        {{ product.name }} -
                                                        {{
                                                            product.pivot
                                                                .quantity
                                                        }}
                                                    </span>
                                                    <template
                                                        v-slot:actions="{
                                                            expanded,
                                                        }"
                                                    >
                                                        <p
                                                            v-if="
                                                                order.status ===
                                                                'processing'
                                                            "
                                                        >
                                                            Đã duyệt
                                                        </p>
                                                        <v-icon
                                                            :color="
                                                                !expanded
                                                                    ? 'teal'
                                                                    : ''
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
                                                                order.created_at
                                                            }}
                                                        </p>
                                                        <ul>
                                                            <li
                                                                v-for="product in order.products"
                                                                :key="
                                                                    product.id
                                                                "
                                                            >
                                                                {{
                                                                    product.name
                                                                }}
                                                                -
                                                                {{
                                                                    product
                                                                        .pivot
                                                                        .quantity
                                                                }}
                                                            </li>
                                                        </ul>
                                                        <p>
                                                            Tổng số lượng:
                                                            {{
                                                                order.total_quantity
                                                            }}
                                                        </p>
                                                        <v-row>
                                                            <v-col>
                                                                <p class="mt-3">
                                                                    Thông tin
                                                                    khách hàng:
                                                                </p>
                                                                <p>
                                                                    Email:
                                                                    {{
                                                                        order.email
                                                                    }}
                                                                </p>
                                                                <p>
                                                                    Tên người
                                                                    đặt:
                                                                    {{
                                                                        order.recipient_name
                                                                    }}
                                                                </p>
                                                                <p>
                                                                    Số điện
                                                                    thoại:
                                                                    {{
                                                                        order.phone_number
                                                                    }}
                                                                </p>
                                                                <p>
                                                                    Địa chỉ giao
                                                                    hàng:
                                                                    {{
                                                                        order.shipping_address
                                                                    }}
                                                                </p>
                                                            </v-col>
                                                            <v-col>
                                                                Lời nhắn của
                                                                khách:
                                                                {{ order.note }}
                                                            </v-col>
                                                        </v-row>
                                                    </li>
                                                </v-expansion-panel-text>
                                            </v-expansion-panel>
                                        </v-expansion-panels>
                                    </td>
                                    <td>
                                        <Link
                                            :href="
                                                route('order.update', {
                                                    id: order.id,
                                                })
                                            "
                                            method="put"
                                            :data="{ status: 'shipping' }"
                                            as="button"
                                            class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                        >
                                            Giao
                                        </Link>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </v-table>
                </v-window-item>
                <v-window-item value="Three">
                    <v-table class="border-b border-t">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th colspan="3" class="text-center">Mô tả</th>

                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template
                                v-for="(order, index) in orders"
                                :key="order.id"
                            >
                                <tr
                                    v-if="
                                        order.status === 'shipped' ||
                                        order.status === 'shipping'
                                    "
                                    class="text-center"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td colspan="3">
                                        <v-expansion-panels variant="accordion">
                                            <v-expansion-panel>
                                                <v-expansion-panel-title
                                                    class="border-b"
                                                >
                                                    <span
                                                        v-for="product in order.products"
                                                        :key="product.id"
                                                    >
                                                        {{ product.name }} -
                                                        {{
                                                            product.pivot
                                                                .quantity
                                                        }}
                                                    </span>
                                                    <template
                                                        v-slot:actions="{
                                                            expanded,
                                                        }"
                                                    >
                                                        <p
                                                            v-if="
                                                                order.status ===
                                                                'shipping'
                                                            "
                                                        >
                                                            Đã giao
                                                        </p>
                                                        <p
                                                            v-if="
                                                                order.status ===
                                                                'shipped'
                                                            "
                                                        >
                                                            Đã nhận
                                                        </p>
                                                        <v-icon
                                                            :color="
                                                                !expanded
                                                                    ? 'teal'
                                                                    : ''
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
                                                                order.created_at
                                                            }}
                                                        </p>
                                                        <ul>
                                                            <li
                                                                v-for="product in order.products"
                                                                :key="
                                                                    product.id
                                                                "
                                                            >
                                                                {{
                                                                    product.name
                                                                }}
                                                                -
                                                                {{
                                                                    product
                                                                        .pivot
                                                                        .quantity
                                                                }}
                                                            </li>
                                                        </ul>
                                                        <p>
                                                            Tổng số lượng:
                                                            {{
                                                                order.total_quantity
                                                            }}
                                                        </p>
                                                        <p>
                                                            Tên người đặt:
                                                            {{
                                                                order.recipient_name
                                                            }}
                                                        </p>
                                                        <p
                                                            v-if="
                                                                order.status ===
                                                                'shipping'
                                                            "
                                                        >
                                                            Đang giao
                                                        </p>
                                                        <p
                                                            v-if="
                                                                order.status ===
                                                                'shipped'
                                                            "
                                                        >
                                                            Đã nhận
                                                        </p>
                                                    </li>
                                                </v-expansion-panel-text>
                                            </v-expansion-panel>
                                        </v-expansion-panels>
                                    </td>
                                    <td>
                                        <Link
                                            :href="
                                                route('order.update', {
                                                    id: order.id,
                                                })
                                            "
                                            method="put"
                                            :data="{ status: 'shipping' }"
                                            as="button"
                                            class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                        >
                                            Xóa
                                        </Link>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </v-table>
                </v-window-item>
            </v-window>
        </div>
    </div>
</template>
