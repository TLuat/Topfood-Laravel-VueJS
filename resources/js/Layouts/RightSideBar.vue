<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Ship from "../Pages/Ship.vue";
import Cart from "../Pages/Cart.vue";

import { ref } from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    orders: {
        type: Object,
        required: true,
    },
    carts: {
        type: Object,
        required: true,
    },
    products: {
        type: Array,
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
const dialog = ref(false);
const ship_dialog = ref(false);
const overlay = ref(false);
const drawer = ref(false);

const watchGroup = () => {
    drawer.value = false;
};

</script>
<template>
    <div>
        <v-overlay v-model="overlay">
            <div class="bg-white h-96 w-96"></div>
        </v-overlay>

        <v-divider></v-divider>

        <div v-if="ship_dialog" class="shipping pr-2">
            <div class="">
                <div class="flex justify-between bg-purple-100">
                    <div class="flex justify-between my-auto ml-3">
                        <img
                            src="../../../public/images/shipping.png"
                            class="w-10"
                        />
                        <span class="my-auto ml-3">Đơn hàng</span>
                    </div>
                    <v-btn
                        variant="text"
                        append-icon="mdi-chevron-right"
                        @click.stop="ship_dialog = !ship_dialog"
                    >
                        Đóng</v-btn
                    >
                </div>
                <Ship :orders="orders" :products="products" :comments="comments" :ratings="ratings" :toppings="toppings" class="mb-5" />
            </div>
        </div>

        <!-- <v-dialog
            v-model="ship_dialog"
            fullscreen
            :scrim="false"
            transition="dialog-top-transition"
        >
            <v-card>
                <v-toolbar dark color="primary" class="fixed top-0 w-full">
                    <v-btn icon dark @click="ship_dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Giao hàng</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn variant="text" @click="ship_dialog = false">
                            Đóng
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <Ship :orders="orders" class="mb-5" />
                <v-divider></v-divider>
            </v-card>
        </v-dialog> -->

        <v-list density="compact" nav>
            <Link :href="route('profile.edit')">
                <v-list-item
                    prepend-icon="mdi-account"
                    title="Thông tin cá nhân"
                    value="user"
                    class=""
                    color="#FF3D00"
                ></v-list-item>
            </Link>
            <hr />
            <v-list-item
                value="bell"
                class=""
                color="#FF3D00"
                prepend-icon="mdi-bell-outline"
            >
                <v-list-item-title class="flex">
                    <span class="justify-self-center my-auto"> Thông báo</span>
                </v-list-item-title>
            </v-list-item>
            <hr />
            <v-list-item
                value="cart"
                class=""
                color="#FF3D00"
                @click="dialog = true"
            >
                <v-list-item-title class="flex"
                    ><img
                        src="../../../public/images/shopping.png"
                        class="w-10"
                    />
                    <span class="justify-self-center ml-5 my-auto">
                        Giỏ hàng</span
                    >
                </v-list-item-title>
            </v-list-item>
            <hr />
            <v-list-item
                value="shipping"
                class=""
                @click.stop="ship_dialog = !ship_dialog"
                color="#FF3D00"
            >
                <v-list-item-title class="flex"
                    ><img
                        src="../../../public/images/shipping.png"
                        class="w-10"
                    />
                    <span class="justify-self-center ml-5 my-auto">
                        Đơn hàng</span
                    >
                </v-list-item-title>
            </v-list-item>
        </v-list>

        <v-dialog
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
                <cart :carts="carts" :products="products" />
                <v-divider></v-divider>
            </v-card>
        </v-dialog>
    </div>
</template>
<style scoped>
.shipping {
    width: 1100px;
    top: 15px;
    left: -1100px;
    border: 5px solid rgba(4, 253, 253, 0.822);
    height: 500px;
}
</style>
