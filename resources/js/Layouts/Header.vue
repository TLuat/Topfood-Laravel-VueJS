<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Ship from "../Pages/Ship.vue";
import Cart from "../Pages/Cart.vue";
import { ref } from "vue";

defineProps({
    // canLogin: {
    //     type: Boolean,
    // },
    // canRegister: {
    //     type: Boolean,
    // },
    // carts: {
    //     type: Object,
    //     required: true,
    // },
    // orders: {
    //     type: Object,
    //     required: true,
    // },
    // products: {
    //     type: Object,
    //     required: true,
    // },
});
const dialog = ref(false);
const ship_dialog = ref(false);
const drawer = ref(false);

const watchGroup = () => {
    drawer.value = false;
};
</script>
<template>
    <div>
        <div class="absolute top-4 inset-x-72 drop-shadow-lg z-50">
            <nav class="border-gray-200 bg-cyan-500 rounded-full">
                <div
                    class="max-w-screen-xl flex flex-wrap items-center justify-between bg-cyan-500 rounded-full mx-auto pb-2"
                >
                    <a href="#" class="flex items-center logo">
                        <img
                            src="../../../public/images/logo.png"
                            class="mr-3 h-3 logo-img"
                            alt="Logo"
                        />
                        <span
                            class="logo-text mt-2 self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
                            >Top Food</span
                        >
                    </a>
                    <div class="flex items-center md:order-2">
                        <!-- <div v-if="canLogin" class="">
                            <div
                                v-if="$page.props.auth.user"
                                class="font-semibold"
                            >
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 mr-4 mt-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="font-semibold"
                                    >Log in</Link
                                >

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ml-4 font-semibold"
                                    >Register</Link
                                >
                            </template>
                        </div> -->
                    </div>
                    <div
                        class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 ml-10"
                        id="navbar-user"
                    >
                        <ul
                            class="flex flex-col font-medium p-2 md:p-0 mt-2 border rounded-lg  md:flex-row md:space-x-5 md:mt-0 md:border-0  bg-cyan-700 border-cyan-900"
                        >
                            <li>
                                <Link
                                    :href="route('product.index')"
                                    class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-500 md:p-0 dark:text-white md:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                    >Trang chủ
                                    </Link>
                            </li>
                            <li>
                                <Link :href="route('reservation.index')"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-500 md:p-0 dark:text-white md:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                >Đặt Bàn</Link>
                                
                            </li>
                            <li>
                                <Link :href="route('menu.index')"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-500 md:p-0 dark:text-white md:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                >Thực Đơn</Link>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-500 md:p-0 dark:text-white md:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                    >Giới thiệu</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-yellow-500 md:p-0 dark:text-white md:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                    >Liên hệ</a
                                >
                            </li>
                        </ul>
                        <!-- cart ne -->

                        <!-- <div @click="dialog = true">
                            <div
                                class="number rounded-full bg-white pl-3 pr-3 shadow-lg"
                            >
                                <span class="text-red-600 font-bold text-lg">{{
                                    carts.length
                                }}</span>
                            </div>
                            <a href="#" class="flex items-center cart">
                                <img
                                    src="../../../public/images/shopping.png"
                                    class="cart"
                                    alt="Logo"
                                />
                                <v-tooltip
                                    activator="parent"
                                    location="end"
                                >Giỏ hàng</v-tooltip>
                            </a>
                        </div>

                        <div @click.stop="drawer = !drawer">
                            <div
                                class="number2 rounded-full bg-white pl-3 pr-3 shadow-lg"
                            >
                                <span class="text-red-600 font-bold text-lg"></span>
                            </div>
                            <a href="#" class="flex items-center shipping">
                                <img
                                    src="../../../public/images/shipping.png"
                                    class="cart"
                                    alt="Logo"
                                />
                                <v-tooltip
                                    activator="parent"
                                    location="start"
                                    offset="-120"
                                >Đơn hàng</v-tooltip>
                            </a>
                        </div> -->
                    </div>
                </div>
            </nav>

            <!-- <v-dialog
                v-model="dialog"
                fullscreen
                :scrim="false"
                transition="dialog-top-transition"
            >
                <v-card>
                    <v-toolbar dark color="primary" class="fixed top-0 w-full">
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Giỏ hàng</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn variant="text" @click="dialog = false">
                                Đóng
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <cart :carts="carts" :products="products"/>
                    <v-divider></v-divider>
                </v-card>
            </v-dialog> -->

            <!-- shipping -->
        </div>
   
            <!-- <v-layout>
                <v-navigation-drawer
                    v-model="drawer"
                    location="right"
                    temporary
                    :width="500"
                >
                <Ship :orders="orders" />
                </v-navigation-drawer>
            </v-layout> -->

    </div>
</template>

<style scope>
.fixed {
    position: fixed;
    z-index: 1000;
}
.logo-img {
    position: absolute;
    left: -33px;
    width: 125px;
    height: 125px;
}
.logo-text {
    position: relative;
    left: 70px;
}

.cart {
    position: absolute;
    width: 47px;
    right: -20px;
    top: 10px;
    background-color: white;
    border-radius: 10px;
    border-left: 1px solid cyan;
    box-shadow: 2px 2px orange;
}
.cart img {
    padding: 1px;
}

.number {
    position: absolute;
    right: -60px;
    top: 0px;
    z-index: 75;
}

/* shipping */
.shipping {
    position: absolute;
    width: 47px;
    right: -100px;
    top: 13px;
    background-color: white;
    border-radius: 10px;
    border-left: 2px solid cyan;
    box-shadow: 2px 2px 2px rgb(0, 19, 19);
}
.number2 {
    position: absolute;
    right: -140px;
    top: 0px;
    z-index: 75;
}

</style>
