<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed, shallowRef } from "vue";
import Header from "../Layouts/Header.vue";
import RightSideBar from "../Layouts/RightSideBar.vue";


const props = defineProps({
    carts: {
        type: Object,
        required: true,
    },
    orders: {
        type: Object,
        required: true,
    },
});
const drawer = shallowRef(true);
const rail = shallowRef(true);
</script>

<template>
    <Head title="Thông báo" />
    <v-layout class="">
            <v-navigation-drawer
                location="right"
                temporary
                v-model="drawer"
                :rail="rail"
                @click.stop="rail = false"
                permanent
            >
                <div class="flex-col justify-self-center">
                    <v-list-item
                        prepend-avatar="https://img.freepik.com/premium-vector/cute-orange-robot-cat-avatar_79416-86.jpg?w=2000"
                        :title="$page.props.auth.user.name"
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
                    <hr />
                    <v-divider color="black" class="bg-black"></v-divider>
                    <RightSideBar :orders="orders" :carts="carts"/>
                    <v-divider></v-divider>
                    <hr />
                    <Link :href="route('logout')" method="post" as="button">
                        <v-list-item
                            title="Đăng xuất"
                            value="logout"
                            color="#FF3D00"
                            class=""
                            prepend-icon="mdi-logout"
                        >
                        </v-list-item>
                    </Link>
                </div>
            </v-navigation-drawer>
        </v-layout>
        <Header></Header>
        <div class="container mx-auto py-8 mt-13">
            <header class="bg-green-500 p-4 text-white">
                <h1 class="text-3xl">Thanh toán thành công</h1>
            </header>
            <div class="bg-white p-4 rounded shadow-md text-center">
                <h2 class="text-2xl mb-4">
                    Vui lòng kiểm tra thông tin nhận hàng phần Đơn hàng 
                </h2>
                <div id="menu-form" class="space-y-4">
                </div>
            </div>
        </div>
</template>
