<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import DropdownButton from '@/Components/DropdownButton.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import Button from '@/Components/Button.vue';
import { replace } from 'lodash';
import moment from "moment";

const props = defineProps({
    lead: Object,
});

const favoriteForm = useForm({
    favorite: null,
});

const archiveForm = useForm({
    status: null,
});

const form = useForm({
    id: null,
});

function setArchive(lead){
    if (confirm("Confirma o arquivamento do lead?")) {
        archiveForm.status = 8;
        archiveForm.put(route("lead.archive", lead.id));
    }
}

function setFavorite(lead){
   favoriteForm.favorite = !lead.favorite;
   favoriteForm.put(route("lead.favorite", lead.id));
}

function destroyLead(lead) {
    if (confirm("Confirma a exclusão do usuário?")) {
        form.delete(route("lead.destroy", lead.id));
    }
}

const whatsappLink = computed(() => {
    var cel = props.lead.celular.replace(/^(\+)|\D/g,'');
    var currentHour = parseInt(moment(new Date()).format("HH"));
    
    if(currentHour < 12)
        var saudacao = "bom dia";
    else if(currentHour < 18)
        var saudacao = "bom tarde";
    else if(currentHour < 23)
        var saudacao = "boa noite";

    if(window.innerWidth > 640)
        var link = "https://web.whatsapp.com/send?phone=+55"+cel+"&text=Olá "+ props.lead.name +", "+saudacao+"!";
    else
        var link = "https://wa.me/+55"+cel+"?text=Olá "+ props.lead.name +", "+saudacao+"!";;

   return link;   
});

</script>
<template>
    <a
        :href="whatsappLink"
        class="text-slate-600 hover:text-sky-500 pt-2.5 pr-1"
        title="Whatsapp"
        target="_blank">    
        <span class="text-sm"><font-awesome-icon class="w-5 h-5" icon="fa-brands fa-whatsapp" /></span>
    </a>
    <Dropdown>
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-0 py-2 border border-transparent text-xs leading-4 font-medium rounded-md text-slate-500 bg-white hover:text-slate-700 focus:outline-none transition ease-in-out duration-150"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                    </svg>
                </button>
            </span>
        </template>
        <template #content>
            <DropdownLink v-if="lead.status_id != 8 && lead.status_id != 9" class="text-xs" href="" @click="setArchive(lead)"> Arquivar Lead </DropdownLink>
            <DropdownLink class="text-xs" :href="`/lead/${lead.id}/editar`"> Editar Lead </DropdownLink>
            <DropdownLink class="text-xs" :href="route('lead.view', lead.id)"> 
                Histórico </DropdownLink>
            <DropdownButton v-if="lead.status_id != 9" class="text-xs" type="button" @click="$emit('openProposal', lead)"> Cadastrar Proposta </DropdownButton>
            <DropdownLink v-if="$page.props.user.roles[0] === 'admin'" class="text-xs" href="" @click="destroyLead(lead)"> Excluir Lead </DropdownLink>
        </template>
    </Dropdown>
</template>

