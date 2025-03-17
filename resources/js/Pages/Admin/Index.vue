<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { shallowRef } from "vue";
import Order from "../Admin/Order.vue";
import Dashboard from "../Admin/Dashboard.vue";
import Reservation from "../Admin/Reservation.vue";
import Category from "../Admin/Category/Category.vue";
import Food from "../Admin/food/Food.vue";
import Topping from "../Admin/toppingFood/Topping.vue";
import Menu from "../Admin/menu/Menu.vue";
import Table from "../Admin/table/Table.vue";

defineProps({
    products: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    orders: {
        type: Object,
        required: true,
    },
    toppings: {
        type: Array,
        required: true,
    },
    menus: {
        type: Array,
        required: true,
    },
    tables: {
        type: Array,
        required: true,
    },
    reservations: {
        type: Object,
        required: true,
    },
    todayRevenue: Number,
    weeklyRevenue: Number,
    monthlyRevenue: Number,
});

const drawer = shallowRef(true);
const rail = shallowRef(true);
const selectedComponent = shallowRef(null);
const selectComponent = (componentName) => {
    selectedComponent.value = componentName;
};
</script>

<template>
    <Head title="Quản lý" />
    <div>
        <v-layout>
            <v-navigation-drawer
                rail
                location="top"
                class="border-b border-blue-500"
            >
                <template v-slot:append>
                    <div class="bg-slate-200 h-14"></div>
                </template>
            </v-navigation-drawer>

            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                permanent
                location="right"
                @click="rail = false"
            >
                <v-list-item
                    prepend-avatar="https://img.freepik.com/premium-vector/cute-orange-robot-cat-avatar_79416-86.jpg?w=2000"
                    title="John Leider"
                    nav
                >
                    <template v-slot:append>
                        <v-btn
                            variant="text"
                            icon="mdi-chevron-right"
                            @click.stop="rail = !rail"
                        ></v-btn>
                    </template>
                </v-list-item>

                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <a href="#"
                        ><v-list-item
                            prepend-icon="mdi-view-dashboard"
                            title="Tổng quan"
                            value="home"
                        ></v-list-item
                    ></a>
                    <v-list-item
                        prepend-icon="mdi-account"
                        title="Quản lý món ăn"
                        value="account"
                    ></v-list-item>

                    <v-list-item
                        prepend-icon="mdi-account-group-outline"
                        title="Quản lý khách hàng"
                        value="users"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-account-group-outline"
                        title="Thống kê"
                        value="tk"
                    ></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-navigation-drawer permanent>
                <v-divider></v-divider>

                <v-list density="compact" nav>
                    <v-list-item
                        prepend-icon="mdi-home-city"
                        title="Tổng quan"
                        color="blue-darken-2"
                        value="home"
                        @click="selectComponent(Dashboard)"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-clipboard-list-outline"
                        color="blue-darken-2"
                        title="ĐƠN ĐẶT MÓN"
                        value="account"
                        @click="selectComponent(Order)"
                    ></v-list-item>

                    <v-list-item
                        prepend-icon="mdi-clipboard-list-outline"
                        color="blue-darken-2"
                        title="ĐƠN ĐẶT BÀN"
                        value="table"
                        @click="selectComponent(Reservation)"
                    ></v-list-item>

                    <v-expansion-panels>
                        <v-expansion-panel>
                            <v-expansion-panel-title>
                                <v-icon>mdi-food-turkey</v-icon
                                ><span class="ml-2"
                                    >Món ăn</span
                                ></v-expansion-panel-title
                            >
                            <v-expansion-panel-text>
                                <v-list-item
                                    title="Quản lý Loại món"
                                    color="blue-darken-2"
                                    value="categories"
                                    @click="selectComponent(Category)"
                                ></v-list-item>
                                <v-list-item
                                    title="Quản lý Món ăn"
                                    color="blue-darken-2"
                                    value="foods"
                                    @click="selectComponent(Food)"
                                ></v-list-item>
                                <v-list-item
                                    title="Quản lý Topping"
                                    color="blue-darken-2"
                                    @click="selectComponent(Topping)"
                                    value="sdsds"
                                ></v-list-item>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-title>
                                <v-icon>mdi-silverware</v-icon
                                ><span class="ml-2"
                                    >Thực đơn</span
                                ></v-expansion-panel-title
                            >
                            <v-expansion-panel-text>
                                <v-list-item
                                    title="Quản lý Thực đơn"
                                    color="blue-darken-2"
                                    value="sdsds"
                                    @click="selectComponent(Menu)"
                                ></v-list-item>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-title>
                                <v-icon>mdi-table-furniture</v-icon
                                ><span class="ml-2"
                                    >Bàn</span
                                ></v-expansion-panel-title
                            >
                            <v-expansion-panel-text>
                                <v-list-item
                                    title="Quản lý Bàn"
                                    color="blue-darken-2"
                                    @click="selectComponent(Table)"
                                    value="sdsds"
                                ></v-list-item>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                    </v-expansion-panels>

                    <v-list-item
                        prepend-icon="mdi-account-group-outline"
                        title="Khách hàng"
                        color="blue-darken-2"
                        value="users"
                    ></v-list-item>
                </v-list>
            </v-navigation-drawer>
            <v-main class="bg-white h-full pb-8">
                <component
                    :is="selectedComponent"
                    :orders="orders"
                    :weeklyRevenue="weeklyRevenue"
                    :monthlyRevenue="monthlyRevenue"
                    :todayRevenue="todayRevenue"
                    :categories="categories"
                    :products="products"
                    :toppings="toppings"
                    :tables="tables"
                    :menus="menus"
                    :reservations="reservations"
                ></component>
            </v-main>
        </v-layout>
    </div>
</template>
