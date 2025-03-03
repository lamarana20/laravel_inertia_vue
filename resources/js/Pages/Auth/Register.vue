<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null,
    
});
const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(form.avatar);
};
const submit = () => {
    form.post(route("register"), {
        onError: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />
    <h1 class="title">Register a new account</h1>
    <div class="w-full md:w-2/4 mx-auto px-4 md:px-0">
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="grid place-items-center">
                <div
                    class="relative w-24 h-24 md:w-28 md:h-28 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600"
                >
                    <label
                        for="avatar"
                        class="absolute bottom-0 w-full text-center bg-black/50 text-white py-1 cursor-pointer"
                    >
                        <span class="text-xs md:text-sm font-medium">Avatar</span>
                    </label>
                    <input id="avatar" type="file" @change="change" hidden />
                    <img
                        class="object-cover w-24 h-24 md:w-28 md:h-28"
                        :src="form.preview ?? '/storage/avatars/default.png'"
                        alt="Avatar"
                    />
                </div>
                <p v-if="form.errors.avatar" class="text-red-500 mt-2 text-sm md:text-base">
                    {{ form.errors.avatar }}
                </p>
            </div>

            <TextInput
                name="Name"
                v-model="form.name"
                :message="form.errors.name"
            />
            <TextInput
                name="Email"
                type="email"
                v-model="form.email"
                :message="form.errors.email"
            />
            <TextInput
                name="Password"
                type="password"
                v-model="form.password"
                :message="form.errors.password"
            />
            <TextInput
                name="Password Confirmation"
                v-model="form.password_confirmation"
                type="password"
            />
            <div>
                <p class="text-slate-600 mb-2 text-sm md:text-base">
                    already a user?
                    <a :href="route('login')" class="text-link">Login</a>
                </p>
                <button class="primary-btn" :disabled="form.processing">
                    Register
                </button>
            </div>
        </form>
    </div>
</template>
