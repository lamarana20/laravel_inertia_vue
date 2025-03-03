<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onError: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="flex justify-center items-center min-h-screenpx-4">
        <div
            class="w-full max-w-sm md:max-w-md lg:max-w-lg bg-white p-6 md:p-8 rounded-xl shadow-md"
        >
            <h1
                class="text-2xl md:text-3xl font-bold text-center text-blue-600 mb-4"
            >
                Login
            </h1>
            <p class="text-center text-gray-600 mb-6 text-sm md:text-base">
                Sign in to continue.
            </p>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Email Field -->
                <TextInput
                    name="Email"
                    type="email"
                    v-model="form.email"
                    :message="form.errors.email"
                    class="w-full"
                />

                <!-- Password Field -->
                <TextInput
                    name="Password"
                    type="password"
                    v-model="form.password"
                    :message="form.errors.password"
                    class="w-full"
                />

                <!-- Remember Me Option and Forgot Password Link -->
                <div
                    class="flex flex-col md:flex-row justify-between items-center text-sm space-y-2 md:space-y-0"
                >
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="form-checkbox"
                        />
                        <span>Remember me</span>
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg text-lg transition duration-300"
                    :disabled="form.processing"
                >
                    Login
                </button>

                <!-- Separator Line -->
                <div class="border-t my-4"></div>

                <!-- Register Link -->
                <p class="text-center text-gray-700 text-sm md:text-base">
                    Don't have an account?
                    <a
                        :href="route('register')"
                        class="text-blue-600 font-semibold hover:underline"
                        >Create account</a
                    >
                </p>
            </form>
        </div>
    </div>
</template>
