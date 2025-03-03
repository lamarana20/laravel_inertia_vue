<script setup>
defineProps({
    paginator: {
        type: Object,
        required: true
    }
});

const makeLabel = (label) => {
    if (label.includes('Previous')) {
        return '<<';
    }
    if (label.includes('Next')) {
        return '>>';
    }
    return label;
}
</script>

<template>
   <div class="flex justify-between items-start">
       <div class="flex items-center rounded-md overflow-hidden shadow-lg">
           <div v-for="link in paginator.links" :key="link.label">
               <Link 
                   v-if="link.url"
                   :href="link.url"
                   class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white"
                   v-html="makeLabel(link.label)"
                   :class="{
                       'hover:bg-slate-300': link.url,
                       'text-zinc-400': !link.url,
                       'font-bold text-blue-400': link.active,
                   }"
               />
               <span
                   v-else
                   class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white"
                   v-html="makeLabel(link.label)"
                   :class="{
                       'hover:bg-slate-300': link.url,
                       'text-zinc-400': !link.url,
                       'font-bold text-blue-400': link.active,
                   }"
               />
           </div>
       </div>
       <p class="text-slate-400 text-sm">
           Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
       </p>
   </div>
</template>