<script setup>
import PaginationLinks from "./Components/PaginationLinks.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

import debounce from "lodash/debounce";

const props = defineProps({
    users: Object,
    filters: String,
    can: Object,
});
//format date
const getDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};
const search = ref(props.filters);
watch(
    search,
    debounce((m) => {
        router.get(route("home", { search: m }), { preserveState: true });
    }, 1000)
);
</script>

<template>
    <Head :title="$page.component" />

    <h1>Welcome to United States of America</h1>

    <div>
        <div class="flex justify-end mb-2">
            <div class="w-full md:w-1/4">
                <input
                    type="search"
                    placeholder="Search"
                    class="border-2 border-gray-300 p-2 rounded-lg w-full"
                    v-model="search"
                    preserveScroll
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-slate-100">
                        <th class="p-2">Avatar</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Registration date</th>
                        <th v-if="can.deleteUser" class="p-2">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td class="p-2">
                            <img
                                class="object-cover w-10 h-10"
                                :src="
                                    user.avatar
                                        ? 'storage/' + user.avatar
                                        : 'storage/avatars/default.png'
                                "
                                alt="Avatar"
                            />
                        </td>
                        <td class="p-2">{{ user.name }}</td>
                        <td class="p-2">{{ user.email }}</td>
                        <td class="p-2">{{ getDate(user.created_at) }}</td>
                        <td class="p-2"> 
                        <button v-if="can.deleteUser" class="bg-red-500 w-6 h-6 rounded-full"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination links-->
        <div class="mt-4">
            <PaginationLinks :paginator="users" />
        </div>
    </div>
</template>
