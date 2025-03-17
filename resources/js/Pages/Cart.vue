<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import ToppingCart from "./ToppingCart.vue";


const props = defineProps({
    carts: {
        type: Object,
        required: true,
    },
});
const getImageUrl = (imageName) => {
    return `/storage/${imageName}`;
};
const note = ref(null);

const updateQuantity = async (cart) => {
    const response = await router.post(`/cart/${cart.id}`, {
        _method: "put",
        new_quantity: cart.quantity,
    });
};

const toggleSelection = (cart) => {
    cart.selected = !cart.selected;
};

const selectedProductCount = computed(() => {
    return props.carts.filter((cart) => cart.selected).length;
});

const totalSum = computed(() => {
    return props.carts.reduce((total, cart) => {
        if (cart.selected) {
            let itemTotal = parseFloat(cart.products.price) * cart.quantity;

            // Add the price of selected toppings
            if (cart.toppings && cart.toppings.length > 0) {
                itemTotal += cart.toppings.reduce((toppingsTotal, topping) => {
                    return toppingsTotal + parseFloat(topping.price);
                }, 0);
            }

            return total + itemTotal;
        }
        return total;
    }, 0);
});

const selectedProducts = computed(() => {
    return props.carts.filter((cart) => cart.selected);
});

const dialog = ref(false);
const search = ref("");

const filteredCarts = computed(() => {
    if (!search.value) {
        return props.carts;
    }

    const searchTerm = search.value.toLowerCase();
    return props.carts.filter((cart) => {
        const product = cart.products;
        return product.name.toLowerCase().includes(searchTerm);
    });
});

const selectedAddress = ref(null);
const addressOptions = [
    usePage().props.auth.user.address_line1,
    usePage().props.auth.user.address_line2,
];
onMounted(() => (selectedAddress.value = addressOptions[0]));

const paymentMethod = ref("Thanh toán khi nhận hàng");
const paymentMethods = [
    "Thanh toán khi nhận hàng",
    "Ví momo",
    "Ví paypal",
    "Ví VnPay",
];

const snackbar = ref(false);
const snackbarText = ref("");
const snackbarColor = ref("");
const placeOrder = () => {
    snackbar.value = true;
    snackbarText.value = "Đặt hàng thành công!";
    snackbarColor.value = "success";
};

const selectedCartItem = ref(null);
const openToppingsDialog = (cart) => {
    selectedCartItem.value = cart;
    dialog.value = true;
};

</script>

<template>
    <Head title="Giỏ hàng" />
    <div>
        <div class="max-w-7xl mx-auto p-6 lg:p-10">
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

            <div class="">

                <v-text-field
                    v-model="search"
                    label="Tìm kiếm"
                    placeholder="Nhập tên sản phẩm hoặc giá"
                    clearable
                    prepend-inner-icon="mdi-magnify"
                    density="compact"
                    variant="solo"
                    single-line
                    hide-details
                    rounded=""
                    class="my-8"
                ></v-text-field>

                <v-data-iterator :items="filteredCarts" :search="search">
                    <div class="grid grid-rows-3 grid-flow-col gap-4">\
          

                        <div class="col-span-1 row-span-3 border-r">
                            <v-table height="470px" fixed-header>
                                <thead>
                                    <tr>
                                        <th class="text-center">Ảnh</th>
                                        <th class="text-center">Tên</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Món thêm</th>
                                        <th class="text-center">Tổng giá</th>
                                        <th class="text-center">Chọn</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="cart in filteredCarts"
                                        :key="cart.id"
                                        class="text-center"
                                    >
                                        <td>
                                            <v-img
                                                cover
                                                class="p-10 rounded-lg mt-2 mb-2 shadow-lg"
                                                width="10"
                                                height="10"
                                                :src="
                                                    getImageUrl(
                                                        cart.products.image
                                                    )
                                                "
                                                alt="product image"
                                            ></v-img>
                                        </td>
                                        <td>{{ cart.products.name }}</td>
                                        <td class="text-green-500">{{ cart.products.price }} đ</td>
                                        <td>
                                            <input
                                                type="number"
                                                v-model.number="cart.quantity"
                                                @input="updateQuantity(cart)"
                                                class="bg-gray-50 border text-center border-gray-300 rounded-lg w-20 h-9"
                                            />
                                        </td>

                                        <td>
                                            <v-btn
                                                @click="
                                                    openToppingsDialog(cart)
                                                "
                                                class="bg-white hover:bg-green-600 text-green-500 font-semibold py-2 px-4 rounded-lg shadow"
                                            >
                                                <span
                                                    class="mdi mdi-table-eye text-green-500 text-lg"
                                                ></span>
                                            </v-btn>
                                        </td>

                                        <td class="text-green-500">
                                            {{
                                                (
                                                    parseFloat(
                                                        cart.products.price
                                                    ) *
                                                        cart.quantity +
                                                    (cart.toppings
                                                        ? cart.toppings.reduce(
                                                              (
                                                                  toppingsTotal,
                                                                  topping
                                                              ) => {
                                                                  return (
                                                                      toppingsTotal +
                                                                      parseFloat(
                                                                          topping.price
                                                                      )
                                                                  );
                                                              },
                                                              0
                                                          )
                                                        : 0)
                                                ).toFixed(3)
                                            }}
                                            đ
                                        </td>

                                        <td>
                                            <v-checkbox
                                                label=""
                                                color="success"
                                                :checked="cart.selected"
                                                @change="toggleSelection(cart)"
                                            ></v-checkbox>
                                        </td>

                                        <td>
                                            <Link
                                                :href="
                                                    route('cart.destroy', {
                                                        id: cart.id,
                                                    })
                                                "
                                                method="delete"
                                                as="button"
                                                class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-lg shadow"
                                            >
                                                Xóa
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </div>
                        <div class="row-span-3">
                            <v-card-text>
                                <div
                                    class="font-weight-bold ms-1 mb-2 text-base"
                                >
                                    Đã chọn: {{ selectedProductCount }} sản phẩm
                                </div>

                                <v-timeline density="compact" align="start">
                                    <v-timeline-item
                                        v-for="product in selectedProducts"
                                        :key="product.id"
                                        dot-color="teal-lighten-3"
                                        size="x-small"
                                    >
                                        <div class="mb-2">
                                            <div
                                                class="font-weight-normal d-flex"
                                            >
                                                <img
                                                    :src="
                                                        getImageUrl(
                                                            product.products
                                                                .image
                                                        )
                                                    "
                                                    alt="product image"
                                                    class="w-8 h-8 rounded"
                                                />
                                                <span class="text-base">
                                                    {{ product.products.name }}
                                                    <span
                                                        class="text-xs font-weight-bold"
                                                        >x</span
                                                    >{{
                                                        product.quantity
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                    </v-timeline-item>
                                </v-timeline>
                            </v-card-text>

                            <div>Tổng giá: <span class="text-green-500">{{ totalSum.toFixed(3) }} đ</span> </div>

                            <div
                                v-if="selectedProductCount > 0"
                                class="text-center"
                            >
                                <v-card class="p-5 mx-auto">
                                    <template v-slot:title>
                                        Thông tin nhận hàng
                                        <span class="mdi mdi-pencil"></span>
                                    </template>
                                    <v-text-field
                                        prepend-icon="mdi-email"
                                        label="email"
                                        v-model="$page.props.auth.user.email"
                                        readonly
                                        rounded="lg"
                                    ></v-text-field>
                                    <v-text-field
                                        prepend-icon="mdi-clipboard-account-outline"
                                        label="Tên người nhận"
                                        v-model="$page.props.auth.user.name"
                                        clearable
                                        rounded="lg"
                                    ></v-text-field>

                                    <v-text-field
                                        prepend-icon="mdi-phone"
                                        label="Số điện thoại"
                                        v-model="$page.props.auth.user.phone"
                                        clearable
                                    ></v-text-field>

                                    <v-select
                                        prepend-icon="mdi-map-marker"
                                        v-model="selectedAddress"
                                        :items="addressOptions"
                                        label="Chọn Địa Chỉ"
                                    ></v-select>

                                    <v-text-field
                                        prepend-icon="mdi-note-edit-outline"
                                        label="Ghi chú (không bắt buộc)"
                                        v-model="note"
                                        clearable
                                    ></v-text-field>

                                    <v-select
                                        prepend-icon="mdi-credit-card-outline"
                                        v-model="paymentMethod"
                                        :items="paymentMethods"
                                        label="Chọn Phương thức thanh toán"
                                    ></v-select>

                                    <Link
                                        :href="route('order.store')"
                                        method="post"
                                        as="button"
                                        class="text-none mb-4 rounded-lg bg-indigo-darken-3 text-white py-3 px-6"
                                        :data="{
                                            selectedProducts:
                                                selectedProducts.map(
                                                    (product) => {
                                                        return {
                                                            productId:
                                                                product.id,
                                                            quantity:
                                                                product.quantity,
                                                            toppings:
                                                                product.toppings.map(
                                                                    (
                                                                        topping
                                                                    ) => {
                                                                        return {
                                                                            toppingId:
                                                                                topping.id,
                                                                            name: topping.name,
                                                                            price: topping.price,
                                                                        };
                                                                    }
                                                                ),
                                                        };
                                                    }
                                                ),
                                            totalSum: totalSum,
                                            email: $page.props.auth.user.email,
                                            userName:
                                                $page.props.auth.user.name,
                                            numberPhone:
                                                $page.props.auth.user.phone,
                                            selectedAddress: selectedAddress,
                                            note:note,
                                            paymentMethod: paymentMethod,
                                            selectedProducts: selectedProducts,
                                            totalSum: totalSum,
                                            status: 'pending',
                                        }"
                                        @click="placeOrder"
                                    >
                                        Đặt món
                                    </Link>
                                </v-card>
                            </div>
                        </div>
                    </div>
                </v-data-iterator>
            </div>
        </div>

        <v-dialog v-model="dialog" persistent width="800">
            <v-card>
                <v-card-actions class="flex items-center justify-end">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog = false"
                        class="flex items-center justify-end"
                    >
                        Tắt
                    </v-btn>
                </v-card-actions>
                <!-- <div v-if="selectedCartItem">
                    <p v-for="topping in selectedCartItem.toppings" :key="topping.id">
                        {{ topping.name }} {{ topping.price }}
                    </p>
                </div> -->
                <ToppingCart :selectedCartItem="selectedCartItem" />
            </v-card>
        </v-dialog>
    </div>
</template>
