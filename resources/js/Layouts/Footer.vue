<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({});
</script>
<template>
    <div class="p-5 rounded-lg text-white mt-16 bg-slate-900">
        <v-layout class="">
            <v-footer class="text-center d-flex flex-column">
            <div>
                <v-btn
                    v-for="icon in icons"
                    :key="icon"
                    class="mx-4"
                    :icon="icon"
                    variant="text"
                ></v-btn>
            </div>

            <div class="pt-0 flex mt-2">
                <div class="">
                    <h3 class="font-bold text-left">Nhà hàng / quán ăn</h3>
                    <ul class="text-left underline">
                        <li><a href="">Giới thiệu</a></li>
                        <li><a href="">Trung tâm Trợ giúp</a></li>
                        <li><a href="">Quy chế</a></li>
                        <li><a href="">Điều khoản sử dụng</a></li>
                        <li><a href="">Bảo mật thông tin</a></li>
                        <li><a href="">Giải quyết khiếu nại</a></li>
                        <li><a href="">Liên hệ</a></li>
                        <li><a href="">Hợp tác nhân viên giao nhận</a></li>
                        <li><a href="">Đăng ký quán</a></li>
                        <li><a href="">ShopeeFood Uni</a></li>
                        <li><a href="">Shopee Blog</a></li>
                    </ul>
                </div>
                <div>
                    <img
                            src="../../../public/images/logo.png"
                            class="mr-3 inline-block"
                            alt="Logo"
                            style="width: 350px;"
                    />
                </div>
                <div>
                    <h3 class="font-bold text-right">Địa chỉ Nhà hàng / quán ăn</h3>
                    <ul class="text-right">
                        <li>
                            <p>Công Ty Cổ Phần Foody</p>
                        </li>
                        <li>
                            <p>Lầu G, Tòa nhà Jabes 1,</p>
                        </li>
                        <li>
                            <p>số 244 đường Cống Quỳnh, phường Phạm Ngũ Lão, Quận 1, TPHCM</p>
                        </li>
                        <li>
                            <p>Giấy CN ĐKDN số: 0311828036</p>
                        </li>
                        <li>
                            <p>do Sở Kế hoạch và Đầu tư TP.HCM cấp ngày 11/6/2012,</p>
                        </li>
                        <li>
                            <p>sửa đổi lần thứ 23, ngày 10/12/2020</p>
                        </li>
                        <li>
                            <p>Chịu trách nhiệm quản lý nội dung: Nguyễn Hồ Quảng Giang</p>
                        </li>
                        <li>
                            <p>Điện thoại liên hệ: 028 71096879</p>
                        </li>
                        <li>Email: <a href="">support@shopeefood.vn</a></li>
                    </ul>
                </div>
            </div>

            <p class="mt-15">&copy; 2023 Top Food (Luận văn tốt nghiệp)</p>

            <v-divider></v-divider>

            <div>
                <!-- {{ new Date().getFullYear() }} — <strong>Vuetify</strong> -->
            </div>
        </v-footer>
        </v-layout>
    </div>
</template>
<script>
export default {
    data: () => ({
        icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
    }),
};
</script>
