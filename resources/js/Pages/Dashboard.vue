<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {ref, watch, computed, onMounted,reactive } from 'vue';
import { throttle, pickBy } from 'lodash';
import { router } from '@inertiajs/vue3';
import moment from "moment";
import { Head } from '@inertiajs/vue3';
import Badge from '@/Components/Badge.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import Button from '@/Components/Button.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SlideOver from '@/Components/SlideOver.vue';
import ChartBar from '@/Components/ChartBar.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import Multiselect from '@vueform/multiselect';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
    dashboard: Object,
    filters: Object,
    companies: Object,
    users: Object,
});

const currentDate = moment(new Date()).format("YYYY-MM-DD");
const endDate = new Date(currentDate +" 23:59:50");
const startDate = new Date(currentDate +" 00:00:00");
const filterTab = ref(false);

const filter = reactive({
    date: props.filters.date,
    companies: props.filters.companies,
    users: props.filters.users,
});

watch(filter,
    throttle( ()=>{
        let query = pickBy(filter);
        let queryRoute = route('dashboard', Object.keys(query).length ? query : {
            remember: 'forget',
        });

        router.get(
            queryRoute,
            {},
            {
            preserveState:true,
            replace:true
        });
    }, 500),
    {
        deep: true,
    }
);

function today(p){
    if(new Date(p) > startDate && new Date(p) < endDate){
        return true;
    }else{
        return false;
    }
}

function openFilter(){
    filterTab.value = true;
}

function closeFilter(){
    filterTab.value = false;
}

const userRanking = computed(() => {
    var data = "";
    let ranking = props.dashboard[0]['ranking'];

    data = ranking.slice().sort((a, b) => (parseFloat(a.dealsOpenTotal) > parseFloat(b.dealsOpenTotal) ? -1 : 1));
    data = data.slice().sort((a, b) => (parseFloat(a.dealsTotal) > parseFloat(b.dealsTotal) ? -1 : 1));
    return data;
});

const waitingRanking = computed(() => {
    var data = "";
    let ranking = props.dashboard[0]['waiting'];
    data = ranking.slice().sort((a, b) => (a.total > b.total ? -1 : 1));
    return data;
});

const formRanking = computed(() => {
    var data = "";
    let ranking = props.dashboard[0]['forms'];
    data = ranking.slice().sort((a, b) => (a.views > b.views ? -1 : 1));
    data = data.slice().sort((a, b) => (a.deals > b.deals ? -1 : 1));
    return data;
});

</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
    .multiselect-tag{
        background: #38bdf8 !important;
    }
</style>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>
        <template  v-for="data in dashboard"
            :key="data.id">
            <div class="py-1">
                <div class="mx-auto mt-4 space-y-6 max-w-7xl sm:px-4 md:px-10">
                    <div class="flex justify-end">
                        <div>
                            <VueDatePicker
                                v-model="filter.date"
                                format="dd/MM/yyyy"
                                locale="pt-br"
                                cancelText="cancelar"
                                selectText="selecione"
                                :enable-time-picker="false"
                                :partial-range="false"
                                max-range="31"
                                range
                                utc>
                            </VueDatePicker>
                        </div>
                        <div class="flex" v-if="$page.props.user.roles[0] === 'admin'">
                            <Button
                                variant="default"
                                type="button"
                                class="ml-2 py-2.5"
                                @click="openFilter">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-sky-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                </svg>
                            </Button>
                        </div>
                    </div>


                    <!-- dashboard admin-->
                    <div v-if="$page.props.user.roles[0] != 'consultor'" class="space-y-6">
                        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-6">
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">LEADS NO PERÍODO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.total }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">AGUARDANDO NA FILA</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.pendings }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">EM ATENDIMENTO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.inprogress }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">PROPOSTA CRIADA</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.proposals }}</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat(data.dealsOpenTotal, { prefix: '' }) }}</span>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIO FECHADO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.deals }}</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat((data.dealsTotal), { prefix: '' }) }}</span>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIO APROPRIADO </span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-5xl sm:py-1 md:py-0">{{ data.appropriated }}</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat(data.dealsAppropriated, { prefix: '' }) }}</span>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">ATENDIMENTOS POR DIA</span>
                                <div class="mt-6 overflow-x-auto lg:h-72">
                                    <ChartBar :data="data.chartLeads[0]"/>
                                </div>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIOS FECHADOS POR DIA</span>
                                <div class="mt-6 overflow-x-auto lg:h-72">
                                    <ChartBar :data="data.chartDeals[0]"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard consultor-->
                    <div v-if="$page.props.user.roles[0] === 'consultor'" class="space-y-6">
                        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-6">
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">LEADS NO PERÍODO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">{{ data.total }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">EM ATENDIMENTO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">{{ data.inprogress }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">PENDENTE</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">{{ data.pendings }}</h1>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">PROPOSTA CRIADA</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">{{ data.proposals }}</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat(data.dealsOpenTotal, { prefix: '' }) }}</span>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIO FECHADO</span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">{{ data.deals }}</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat(data.dealsTotal, { prefix: '' }) }}</span>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIO APROPRIADO </span>
                                <h1 class="font-semibold tracking-tighter text-sky-500 sm:text-3xl md:text-6xl sm:py-1 md:py-0">0</h1>
                                <span class="flex w-full px-2 py-1 text-xs text-slate-500 bg-slate-100">R$ {{ vueNumberFormat(data.dealsAppropriated, { prefix: '' }) }}</span>
                            </div>
                        </div>


                        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">ATENDIMENTOS POR DIA</span>
                                <div class="mt-6 overflow-x-auto lg:h-72">
                                    <ChartBar :data="data.chartLeads[0]"/>
                                </div>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">NEGÓCIOS FECHADOS POR DIA</span>
                                <div class="mt-6 overflow-x-auto lg:h-72">
                                    <ChartBar :data="data.chartDeals[0]"/>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2 sm:grid-cols-1" >
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-2 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">
                                    AGUARDANDO ATENDIMENTO <Badge v-if="data.waiting.length">{{ data.waiting.length }}</Badge>
                                </span>
                                <div class="mt-6 overflow-x-auto md:h-72 sm:h-72">
                                    <ul class="space-y-3">
                                        <li
                                            v-for="msg in data.waiting"
                                            :key="msg.id"
                                            class="px-3 py-1 text-xs border border-l-2 shadow-sm border-slate-200 border-l-red-500 text-slate-600 whitespace-break-spaces">
                                            <div class="py-2 font-semibold">{{ msg.name }}</div>

                                            <div class="flex justify-between">
                                                <p class="flex mb-1">Recebido: {{ moment(msg.created_at).format("DD/MM/YYYY HH:mm") }}</p>
                                                <ButtonLink
                                                    variant="basic"
                                                    class=""
                                                    :value="`/lead/${msg.id}/`"
                                                    >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                                    </svg>
                                                </ButtonLink>
                                            </div>
                                        </li>
                                    </ul>
                                    <div v-if="!data.waiting.length" class="flex sm:text-xxs md:text-sm text-slate-600">
                                        🕛 Nenhum lead aguardando atendimento
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-2 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">
                                    AGENDAMENTOS DA SEMANA
                                    <Badge v-if="data.schedules.length">{{ data.schedules.length }}</Badge>
                                </span>
                                <div class="mt-6 overflow-x-auto md:h-72 sm:h-72">
                                    <ul class="space-y-3">
                                        <li
                                            v-for="msg in data.schedules"
                                            :key="msg.id"
                                            :class="today(msg.schedule_date) ? 'bg-sky-500 text-white' : 'bg-slate-50 text-sky-500 border border-slate-300'"
                                            class="px-3 py-1 text-xs font-semibold rounded-md shadow-sm whitespace-break-spaces">
                                            <div class="py-2 text-xs">{{ msg.name }}</div>
                                            <div class="flex justify-between mb-1">
                                                <div class="flex space-x-1">
                                                    <svg aria-hidden="true" :class="today(msg.schedule_date) ? 'text-white' : 'text-sky-500'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                                    <span v-if="today(msg.schedule_date)">Hoje às {{ moment(msg.schedule_date).format("HH:mm") }}</span>
                                                    <span v-else>{{ moment(msg.schedule_date).format("DD/MM/YYYY HH:mm") }}</span>
                                                </div>
                                                <div>
                                                    <ButtonLink
                                                        variant="basic"
                                                        class=""
                                                        :value="`/lead/${msg.id}/`"
                                                        >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="today(msg.schedule_date) ? 'text-white' : 'text-sky-500'" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                                        </svg>
                                                    </ButtonLink>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div v-if="!data.schedules.length" class="flex sm:text-xxs md:text-sm text-slate-600">
                                        🕛 Nenhum agendamento criado até o momento
                                    </div>
                                </div>
                            </div>
                            <div v-if="data.funnels.length" class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                                <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">FUNIL</span>
                                <div class="flex space-x-2">
                                    <div class="w-4/5 mt-6 space-y-3">
                                        <div class="flex justify-center">
                                            <div class="w-full py-4 text-center text-white shadow-md text-xxs" style="background: rgb(255, 80, 80);">{{ data.funnels[0].name}} = <span class="px-2 text-red-500 bg-white">{{ data.funnels[0].total}}</span></div>
                                        </div>
                                        <div class="flex justify-center">
                                            <div class="w-2/3 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(255, 192, 0);">{{ data.funnels[1].name}} = <span class="px-2 bg-white text-amber-500">{{ data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count }}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count) / data.funnels[0].total)*100, { prefix: '' }) }}%</span></div>
                                            <div class="py-4 pl-2 text-xxs">100%</div>
                                        </div>
                                        <div class="flex justify-center">
                                            <div class="w-1/2 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 32, 96);">{{ data.funnels[2].name}} = <span class="px-2 text-blue-800 bg-white">{{ (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count )}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count + data.funnels[2].count) / (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count ))*100, { prefix: '' }) }}%</span></div>
                                            <div class="py-4 pl-2 text-xxs">50%</div>
                                        </div>
                                        <div class="flex justify-center">
                                            <div class="w-1/3 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 176, 240);">{{ data.funnels[3].name}} = <span class="px-2 bg-white text-sky-500">{{(data.funnels[4].count + data.funnels[3].count)}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count) / (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count ))*100, { prefix: '' }) }}%</span></div>
                                            <div class="py-4 pl-2 text-xxs">13%</div>
                                        </div>
                                        <div class="flex justify-center">
                                            <div class="w-1/4 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 176, 80);">{{ data.funnels[4].name}} = <span class="px-2 text-green-800 bg-white">{{ data.funnels[4].count}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat((data.funnels[4].count / (data.funnels[4].count + data.funnels[3].count))*100, { prefix: '' }) }}%</span></div>
                                            <div class="py-6 pl-2 text-xxs">31%</div>
                                        </div>
                                    </div>
                                    <div class="w-1/5 mt-6 space-y-3">
                                        <div class="w-full h-12 py-4 text-center text-white text-xxs "></div>
                                        <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                        <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                        <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                        <div class="flex w-full h-12 space-x-2 "><div class="inline-block w-2/3 h-16 py-2 font-bold text-center text-white align-middle shadow-md text-xxs" style="background: rgb(0, 176, 80);"><span class="inline-block font-light">Conversão Geral</span><span class="pt-0.5 pl-2 block">{{ vueNumberFormat((data.funnels[4].count / data.funnels[4].total)*100, { prefix: '' }) }}%</span></div><div class="w-1/3 py-6 text-xxs">2%</div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.props.user.roles[0] === 'admin'" class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
                        <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                            <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">AGUARDANDO ATENDIMENTO</span>
                            <div class="mt-6 overflow-x-auto lg:h-72">
                                <table class="w-full text-sm text-left text-white whitespace-nowrap">
                                    <thead class="text-xs font-bold">
                                        <tr class="shadow-sm bg-sky-700">
                                            <th scope="col" class="px-2 py-2.5 w-full">
                                                Consultor
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 text-center">
                                                Leads
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 text-center">
                                                Último Lead
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs font-normal text-slate-500">
                                        <tr
                                            v-for="ranking in waitingRanking"
                                            :key="ranking.id"
                                            class="even:bg-slate-50 odd:bg-white"
                                        >
                                            <td class="px-2 py-2.5">{{ ranking.user[0].name }}</td>
                                            <td class="px-2 py-2.5 text-center">{{ ranking.total }}</td>
                                            <td class="px-2 py-2.5 text-center">{{ moment(ranking.user[0].last_interaction).format("DD/MM/YYYY HH:mm") }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div v-if="data.funnels.length" class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                            <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">FUNIL</span>
                            <div class="flex space-x-2">
                                <div class="w-4/5 mt-6 space-y-3">
                                    <div class="flex justify-center">
                                        <div class="w-full py-4 text-center text-white shadow-md text-xxs" style="background: rgb(255, 80, 80);">{{ data.funnels[0].name}} = <span class="px-2 text-red-500 bg-white">{{ data.funnels[0].total}}</span></div>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="w-2/3 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(255, 192, 0);">{{ data.funnels[1].name}} = <span class="px-2 bg-white text-amber-500">{{ data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count }}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count) / data.funnels[0].total)*100, { prefix: '' }) }}%</span></div>
                                        <div class="py-4 pl-2 text-xxs">100%</div>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="w-1/2 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 32, 96);">{{ data.funnels[2].name}} = <span class="px-2 text-blue-800 bg-white">{{ (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count )}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count + data.funnels[2].count) / (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count + data.funnels[1].count ))*100, { prefix: '' }) }}%</span></div>
                                        <div class="py-4 pl-2 text-xxs">50%</div>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="w-1/3 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 176, 240);">{{ data.funnels[3].name}} = <span class="px-2 bg-white text-sky-500">{{(data.funnels[4].count + data.funnels[3].count)}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat(((data.funnels[4].count + data.funnels[3].count) / (data.funnels[4].count + data.funnels[3].count + data.funnels[2].count ))*100, { prefix: '' }) }}%</span></div>
                                        <div class="py-4 pl-2 text-xxs">13%</div>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="w-1/4 py-2 text-center text-white shadow-md text-xxs" style="background: rgb(0, 176, 80);">{{ data.funnels[4].name}} = <span class="px-2 text-green-800 bg-white">{{ data.funnels[4].count}}</span><br><span class="py-2 pl-2 text-xxs">{{ vueNumberFormat((data.funnels[4].count / (data.funnels[4].count + data.funnels[3].count))*100, { prefix: '' }) }}%</span></div>
                                        <div class="py-6 pl-2 text-xxs">31%</div>
                                    </div>
                                </div>
                                <div class="w-1/5 mt-6 space-y-3">
                                    <div class="w-full h-12 py-4 text-center text-white text-xxs "></div>
                                    <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                    <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                    <div class="w-full h-12 py-2 text-center text-white text-xxs "></div>
                                    <div class="flex w-full h-12 space-x-2 "><div class="inline-block w-2/3 h-16 py-2 font-bold text-center text-white align-middle shadow-md text-xxs" style="background: rgb(0, 176, 80);"><span class="inline-block font-light">Conversão Geral</span><span class="pt-0.5 pl-2 block">{{ vueNumberFormat((data.funnels[4].count / data.funnels[4].total)*100, { prefix: '' }) }}%</span></div><div class="w-1/3 py-6 text-xxs">2%</div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.props.user.roles[0] === 'admin'" class="grid gap-4 sm:grid-cols-1 md:grid-cols-1">
                        <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                            <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">RANKING DE CONSULTORES</span>
                            <div class="mt-6 overflow-x-auto lg:h-72">
                                <table class="w-full text-sm text-left text-white table-auto whitespace-nowrap">
                                    <thead class="text-xs font-bold">
                                        <tr class="shadow-sm bg-sky-700">
                                            <th scope="col" class="px-2 py-2.5">
                                                Consultor
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 text-center">
                                                Leads
                                            </th>
                                            <th colspan="2" scope="col" class="px-2 py-2.5">
                                                Propostas Criadas
                                            </th>
                                            <th colspan="2" scope="col" class="px-2 py-2.5">
                                                Negócios Fechados
                                            </th>

                                            <th scope="col" class="px-2 py-2.5 text-right">
                                                Conversão
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs font-normal text-slate-500">
                                        <tr
                                            v-for="ranking in userRanking"
                                            :key="ranking.id"
                                            class="even:bg-slate-50 odd:bg-white"
                                        >
                                            <td class="px-2 py-2.5">{{ ranking.user[0].name }}</td>
                                            <td class="px-2 py-2.5 text-center">{{ ranking.total }}</td>
                                            <td class="px-2 py-2.5 w-8">{{ranking.proposals }}</td>
                                            <td class="px-2 py-2.5 w-1/6">{{vueNumberFormat(ranking.dealsOpenTotal) }}</td>
                                            <td class="px-2 py-2.5 w-8">{{ ranking.deals }}</td>
                                            <td class="px-2 py-2.5 w-1/6">{{vueNumberFormat(ranking.dealsTotal) }}</td>
                                            <td class="px-2 py-2.5 w-1/12 text-right">{{ vueNumberFormat(((ranking.deals / ranking.total))*100, { prefix: '' }) }}%</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div v-if="$page.props.user.roles[0] === 'admin'" class="grid gap-4 sm:grid-cols-1 md:grid-cols-1">
                        <div class="px-6 py-3 bg-white border shadow-sm border-slate-200">
                            <span class="pb-1 font-light leading-6 border-b-2 text-slate-500 text-xxs border-sky-800">LEADS POR FORMULÁRIO</span>
                            <div class="mt-6 overflow-x-auto lg:h-72">
                                <table class="w-full text-sm text-left text-white whitespace-nowrap">
                                    <thead class="text-xs font-bold">
                                        <tr class="shadow-sm bg-sky-700">
                                            <th scope="col" class="px-2 py-2.5 w-2">
                                                Formulário
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 w-2 text-center">
                                                Leads
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 w-2 text-center">
                                                Negócios
                                            </th>
                                            <th scope="col" class="px-2 py-2.5 w-2 text-right">
                                                Conversão
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-xs font-normal text-slate-500">
                                        <tr
                                            v-for="ranking in formRanking"
                                            :key="ranking.id"
                                            class="even:bg-slate-50 odd:bg-white"
                                        >
                                            <td class="px-2 py-2.5">{{ ranking.name }}</td>
                                            <td class="px-2 py-2.5 text-center w-1/6">{{ ranking.total }}</td>
                                            <td class="px-2 py-2.5 text-center w-1/6">{{ ranking.deals }}</td>
                                            <td class="px-2 py-2.5 text-right w-1/6">{{ vueNumberFormat((ranking.deals / ranking.total)*100, { prefix: '' }) }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>

             <!-- FILTER -->
            <SlideOver :showSlide="filterTab" title="Filtro Avançado" @close="closeFilter()">
                <div>
                    <div class="bg-white">
                        <form @submit.prevent="filterLeads">
                            <div class="p-5 py-5 space-y-5">
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="col-span-3">
                                        <InputLabel class="text-xs">Empresa</InputLabel>
                                        <Multiselect
                                            v-model="filter.companies"
                                            :options="companies"
                                            mode="tags"
                                            placeholder="Selecione"
                                        />
                                    </div>
                                    <div class="col-span-3">
                                        <InputLabel class="text-xs">Usuários</InputLabel>
                                        <Multiselect
                                            v-model="filter.users"
                                            :options="data.users"
                                            mode="tags"
                                            placeholder="Selecione"
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </Slideover>
        </template>
    </AuthenticatedLayout>
</template>
