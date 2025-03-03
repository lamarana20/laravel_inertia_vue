<script setup>
import { ref } from "vue";

const isOpen = ref(false);
</script>

<template>
    <Head>
        <meta head-key="Desc" name="description" content="My app description" />
    </Head>

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-slate-800 shadow-md">
            <nav class="container mx-auto p-4 flex items-center justify-between">
                <!-- Logo -->
                <Link :href="route('home')" class="text-2xl font-bold text-white">
                    MyApp
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 items-center">
                    <Link
                        :href="route('home')"
                        class="nav-link"
                        :class="{ 'bg-slate-600 text-white': route().current('home') }"
                        >Home</Link
                    >

                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="nav-link"
                            :class="{ 'bg-slate-600 text-white': route().current('dashboard') }"
                            >Dashboard</Link
                        >
                        <button
                            @click="$inertia.post(route('logout'))"
                            class="nav-link bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition"
                        >
                            Logout
                        </button>
                        <img
                            :src="
                                $page.props.auth.user.avatar
                                    ? '/storage/' + $page.props.auth.user.avatar
                                    : '/avatars/default.png'
                            "
                            class="w-10 h-10 rounded-full cursor-pointer border-2 border-white hover:scale-105 transition"
                            @click="$inertia.get('/profile')"
                        />
                    </template>

                    <template v-else>
                        <Link
                            :href="route('register')"
                            class="nav-link"
                            :class="{ 'bg-slate-600 text-white': route().current('register') }"
                            >Register</Link
                        >
                        <Link
                            :href="route('login')"
                            class="nav-link"
                            :class="{ 'bg-slate-600 text-white': route().current('login') }"
                            >Login</Link
                        >
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden focus:outline-none text-white" @click="isOpen = !isOpen">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path v-if="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </nav>

            <!-- Mobile Menu -->
            <transition name="fade">
                <div v-if="isOpen" class="md:hidden bg-slate-900 shadow-md p-4 space-y-4 flex flex-col items-center text-white">
                    <img
                         :src="
                                $page.props.auth.user.avatar
                                    ? '/storage/' + $page.props.auth.user.avatar
                                    : '/avatars/default.png'
                            "
                        class="w-12 h-12 rounded-full border-2 border-white cursor-pointer hover:scale-105 transition"
                        @click="$inertia.get('/profile')"
                    />

                    <Link
                        :href="route('home')"
                        class="block nav-link w-full text-center"
                        :class="{ 'bg-slate-600 text-white': route().current('home') }"
                        >Home</Link
                    >

                    <template v-if="$page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="block nav-link w-full text-center"
                            :class="{ 'bg-slate-600 text-white': route().current('dashboard') }"
                            >Dashboard</Link
                        >
                        <button
                            @click="$inertia.post(route('logout'))"
                            class="block w-full text-center nav-link bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition"
                        >
                            Logout
                        </button>
                    </template>

                    <template v-else>
                        <Link
                            :href="route('register')"
                            class="block nav-link w-full text-center"
                            :class="{ 'bg-slate-600 text-white': route().current('register') }"
                            >Register</Link
                        >
                        <Link
                            :href="route('login')"
                            class="block nav-link w-full text-center"
                            :class="{ 'bg-slate-600 text-white': route().current('login') }"
                            >Login</Link
                        >
                    </template>
                </div>
            </transition>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto p-4">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.nav-link {
    @apply text-gray-300 hover:text-white px-4 py-2 rounded-md transition;
}

/* Animation pour le menu mobile */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease-in-out;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
