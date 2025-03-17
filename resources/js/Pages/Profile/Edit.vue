<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const tab = ref(null);
const One = "One";
const Two = "Two";
const goBack = () => {
  window.history.back();
};
</script>

<template>
    <Head title="Hồ sơ" />
    
    <AuthenticatedLayout>
        <div class="py-1 bg-gradient-to-r from-purple-500 to-pink-500">
            <div class="flex justify-between mb-4 mx-8">
                <h2 class="text-white font-bold bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                    TÀI KHOẢN
                </h2>
               
                    <button @click="goBack" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-bold rounded-lg text-sm px-4 py-2 text-center mr-2 mb-2"><span class="mdi mdi-menu-left text-base"></span> Quay lại</button>
                
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 shadow-2xl rounded-lg bg-white">
                <div class="fixed bottom-0 left-0 z-5">
                    <p class="h-10 bg-black w-20">Absolute child</p>
                </div>
                <v-tabs
                    v-model="tab"
                    show-arrows
                    color="blue-darken-2"
                    class="text-gray-600"
                >
                    <v-tab :value="One">
                        <v-icon
                            start
                            size="large"
                            icon="mdi-account-outline"
                        ></v-icon>
                        Tài khoản
                    </v-tab>
                    <v-tab :value="Two">
                        <v-icon
                            size="large"
                            start
                            icon="mdi-shield-lock-outline"
                        />
                        Bảo mật
                    </v-tab>
                </v-tabs>
                <hr class=" mt-0 bg-slate-950">
                <v-window v-model="tab" class="mt-1 disable-tab-transition">
                    <v-window-item value="One">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <v-col cols="12">
                                
                                    <v-card-text class="d-flex">
                                        <v-avatar
                                            size="150"
                                            class="me-6 border p-5 rounded-full shadow"
                                            image="https://img.freepik.com/premium-vector/cute-orange-robot-cat-avatar_79416-86.jpg?w=2000"
                                        ></v-avatar>
                                        <form
                                            class="d-flex flex-column justify-center gap-5"
                                        >
                                            <div class="d-flex flex-wrap gap-2">
                                                <VBtn
                                                    color="primary"
                                                    @click="refInputEl?.click()"
                                                >
                                                    <VIcon
                                                        icon="mdi-cloud-upload-outline"
                                                        class="d-sm-none"
                                                    />
                                                    <span
                                                        class="d-none d-sm-block"
                                                        >Cập nhật ảnh đại
                                                        diện</span
                                                    >
                                                </VBtn>

                                                <input
                                                    ref="refInputEl"
                                                    type="file"
                                                    name="file"
                                                    accept=".jpeg,.png,.jpg,GIF"
                                                    hidden
                                                    @input="changeAvatar"
                                                />
                                            </div>

                                            <p class="text-body-1 mb-0">
                                                Cho phép định dạng ảnh JPG, GIF or
                                                PNG. Kích thước tối đa 800Kb
                                            </p>
                                        </form>
                                    </v-card-text>
                                    <hr class=" mt-0 bg-slate-950">
                                    <v-card-text>
                                        <UpdateProfileInformationForm
                                            :must-verify-email="mustVerifyEmail"
                                            :status="status"
                                            class="max-w-xl"
                                        />
                                    </v-card-text>                      
                            </v-col>
                        </div>
                        <v-select
      :items="items"
      density="compact"
      label="Compact"
    ></v-select>
                    </v-window-item>
                    <v-window-item value="Two">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <UpdatePasswordForm class="max-w-xl" />
                        </div>
                        <div class="p-4 sm:p-8 bg-white shadow-xl sm:rounded-lg">
                            <DeleteUserForm class="max-w-xl" />
                        </div>
                    </v-window-item>
                </v-window>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
