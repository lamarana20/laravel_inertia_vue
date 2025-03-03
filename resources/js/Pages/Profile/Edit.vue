<script setup>
import { ref, computed } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import TextInput from "../Components/TextInput.vue";

// Get connected user
const user = computed(() => usePage().props.auth.user);
const avatarPreview = ref(
    user.value.avatar
        ? `/storage/${user.value.avatar}`
        : "/storage/avatars/default.png"
);

// Edit mode
const editMode = ref(false);

// Profile update form
const form = useForm({
    name: user.value.name,
    email: user.value.email,
    current_password: "",
    password: "",
    password_confirmation: "",
    avatar: null,
});

// Handle avatar upload
const handleAvatarChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.avatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
};

// Submit form
const submit = () => {
    form.post(route("profile.update"), {
        forceFormData: true,
        onSuccess: () => {
            form.reset("current_password", "password", "password_confirmation");
            router.reload({ only: ["auth"] });
            editMode.value = false; // Return to profile display after update
        },
    });
};

// Enable edit mode
const enableEdit = () => {
    editMode.value = true;
};

// Cancel edit
const cancelEdit = () => {
    editMode.value = false;
    form.reset();
};
</script>

<template>
    <Head title="My Profile" />
    <div
        class="max-w-2xl mx-auto mt-6 sm:mt-12 p-6 sm:p-8 bg-white shadow-xl rounded-2xl"
    >
        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">
            My Profile
        </h1>

        <!-- Flash Messages -->
        <transition name="fade">
            <div
                v-if="$page.props.flash.success"
                class="bg-green-500 text-white text-center p-3 rounded-lg mb-4"
            >
                {{ $page.props.flash.success }}
            </div>
        </transition>
        <transition name="fade">
            <div
                v-if="$page.props.flash.error"
                class="bg-red-500 text-white text-center p-3 rounded-lg mb-4"
            >
                {{ $page.props.flash.error }}
            </div>
        </transition>

        <!-- Profile info display -->
        <div v-if="!editMode" class="text-center space-y-4">
            <div class="flex justify-center">
                <img
                    :src="avatarPreview"
                    class="w-28 h-28 rounded-full shadow-md border-2 border-gray-300"
                    alt="Avatar"
                />
            </div>
            <p class="text-lg font-semibold text-gray-700">{{ user.name }}</p>
            
            <p class="text-gray-500">{{ user.email }}</p>
            <button
                @click="enableEdit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition"
            >
                Edit
            </button>
        </div>

        <!-- Edit form -->
        <form
            v-else
            @submit.prevent="submit"
            enctype="multipart/form-data"
            class="mt-6 space-y-4"
        >
            <div class="flex flex-col items-center">
                <div class="relative w-28 h-28">
                    <label
                        for="avatar"
                        class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-1 rounded-b cursor-pointer"
                    >
                        <span class="text-sm font-medium">Change</span>
                    </label>
                    <input
                        id="avatar"
                        type="file"
                        @change="handleAvatarChange"
                        hidden
                    />
                    <img
                        class="object-cover w-full h-full rounded-full shadow-md"
                        :src="avatarPreview"
                        alt="Avatar"
                    />
                </div>
                <p v-if="form.errors.avatar" class="text-red-500 text-sm mt-2">
                    {{ form.errors.avatar }}
                </p>
            </div>

            <TextInput
                name="Name"
                v-model="form.name"
                :message="form.errors.name"
                class="w-full"
            />
            <TextInput
                name="Email"
                type="email"
                v-model="form.email"
                :message="form.errors.email"
                class="w-full"
            />
            <TextInput
                name="Current password"
                type="password"
                v-model="form.current_password"
                :message="form.errors.current_password"
                class="w-full"
            />
            <TextInput
                name="New password"
                type="password"
                v-model="form.password"
                :message="form.errors.password"
                class="w-full"
            />
            <TextInput
                name="Confirm password"
                type="password"
                v-model="form.password_confirmation"
                class="w-full"
            />

            <div class="flex justify-between mt-6">
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition"
                >
                    Save
                </button>
                <button
                    type="button"
                    @click="cancelEdit"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
/* Fade animation */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
