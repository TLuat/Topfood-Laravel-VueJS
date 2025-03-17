<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone,
    address_line1: user.address_line1,
    address_line2: user.address_line2,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Thông tin cá nhân</h2>

            <p class="mt-1 text-sm text-gray-600">
                Cập nhật tài khoản cá nhân và địa chỉ email.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <v-row>
                <v-col  
                md="6"
                cols="12">
                    <v-text-field 
                    label="Họ Tên"
                     v-model="form.name" 
                     base-color="black" 
                     variant="outlined"
                     color="purple-darken-2"
                     counter-value="10"  
                     density="comfortable" 
                     class=""
                     >
                    </v-text-field>
                </v-col>
                <v-col  
                md="6"
                cols="12">
                    <v-text-field 
                    label="Địa chỉ 1" 
                    v-model="form.address_line1"
                    base-color="black" 
                     variant="outlined"
                     color="purple-darken-2"
                     counter-value="10"  
                     density="comfortable" 
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col  
                md="6"
                cols="12">
                    <v-text-field label="Email" id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    base-color="black" 
                     variant="outlined"
                     color="purple-darken-2"
                     counter-value="10"  
                     density="comfortable" 
                    >
                    </v-text-field>
                </v-col>
                <v-col  
                md="6"
                cols="12">
                    <v-text-field 
                    label="Địa chỉ 2" 
                    v-model="form.address_line2"
                    base-color="black" 
                     variant="outlined"
                     color="purple-darken-2"
                     counter-value="10"  
                     density="comfortable" 
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <v-row>
                <v-col  
                md="6"
                cols="12">
                    <v-text-field label="Số điện thoại" id="phone"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    base-color="black" 
                     variant="outlined"
                     color="purple-darken-2"
                     counter-value="10"  
                     density="comfortable" 
                    >
                    </v-text-field>
                </v-col>
            </v-row>

            <div class="flex items-center gap-4 justify-end">
                <PrimaryButton class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 " :disabled="form.processing">Lưu</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Đã lưu.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
