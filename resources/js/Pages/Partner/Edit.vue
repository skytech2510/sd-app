<script setup>
import { ref, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import Button from "@/Components/Button.vue";
import TextInput from "@/Components/TextInput.vue";

const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 1, name: "Especificadores", url: "/especificadores" },
});
const props = defineProps({
  states: {
    type: Object,
    default: {},
  },
  cities: {
    type: Object,
    default: {},
  },
  partner: {
    type: Object,
  },
});

const form = useForm({
  name: props.partner.name,
  type: props.partner.type,
  CPF: props.partner.CPF,
  birthday: props.partner.birthday,
  gender: props.partner.gender,
  CEP: props.partner.CEP,
  address: props.partner.address,
  number_address: props.partner.number_address,
  complement_address: props.partner.complement_address,
  region: props.partner.region,
  city_id: props.partner.city_id,
  state_id: props.partner.state_id,
  accountable_name: props.partner.accountable_name,
  phone: props.partner.phone,
  cellphone: props.partner.cellphone,
  email: props.partner.email,
  site: props.partner.site,
  social_network: props.partner.social_network,
  bank: props.partner.bank,
  agency: props.partner.agency,
  account_number: props.partner.account_number,
  pix_key: props.partner.pix_key,
  consultant: props.partner.consultant,
  id: props.partner.id,
});
function updateProduct() {
  form.post(route("partner.update"));
}
</script>
<template>
  <Head title="Produto" />
  <AuthenticatedLayout>
    <div class="pt-4 mx-auto max-w-7xl sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="updateProduct">
            <div class="pb-12 border-b border-slate-900/10">
              <h2 class="text-base font-semibold leading-7 text-sky-900">Produtos</h2>
              <div class="flex flex-col gap-3">
                <div>
                  <h2 class="text-[#777] py-4">DADOS CADASTRAIS</h2>
                  <hr />
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-[4]">
                        <TextInput
                          textLabel="Nome"
                          v-model="form.name"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                          {{ form.errors.name }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <InputLabel
                          for="type"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Tipo</InputLabel
                        >
                        <select
                          name="type"
                          v-model="form.type"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option value="AAAA">AAAA</option>
                          <option value="BBBB">BBBB</option>
                          <option value="CCCC">CCCC</option>
                          <option value="DDDD">DDDD</option>
                        </select>
                        <div v-if="form.errors.type" class="mt-2 text-sm text-red-500">
                          {{ form.errors.type }}
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-1">
                        <InputLabel
                          for="type"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Tipo</InputLabel
                        >
                        <select
                          name="type"
                          v-model="form.type"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option value="AAAA">AAAA</option>
                          <option value="BBBB">BBBB</option>
                          <option value="CCCC">CCCC</option>
                          <option value="DDDD">DDDD</option>
                        </select>
                        <div v-if="form.errors.type" class="mt-2 text-sm text-red-500">
                          {{ form.errors.type }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="CPF"
                          v-model="form.CPF"
                          type="text"
                          mask="XXX.XXX.XXX-XX"
                        ></TextInput>
                        <div v-if="form.errors.CPF" class="mt-2 text-sm text-red-500">
                          {{ form.errors.CPF }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Data Nascimento"
                          v-model="form.birthday"
                          type="date"
                        ></TextInput>
                        <div
                          v-if="form.errors.birthday"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.birthday }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <InputLabel
                          for="gender"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Tipo</InputLabel
                        >
                        <select
                          name="Sexo"
                          v-model="form.gender"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option value="female">fêmea</option>
                          <option value="male">macho</option>
                        </select>
                        <div v-if="form.errors.gender" class="mt-2 text-sm text-red-500">
                          {{ form.errors.gender }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <h2 class="text-[#777] py-4">ENDERECO</h2>
                  <hr />
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-[2]">
                        <TextInput
                          textLabel="CEP:"
                          v-model="form.CEP"
                          type="text"
                          mask="XXXXX-XXX"
                        ></TextInput>
                        <div v-if="form.errors.CEP" class="mt-2 text-sm text-red-500">
                          {{ form.errors.CEP }}
                        </div>
                      </div>
                      <div class="flex-[8]">
                        <TextInput
                          textLabel="Endereco"
                          v-model="form.address"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.address" class="mt-2 text-sm text-red-500">
                          {{ form.errors.address }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Número"
                          v-model="form.number_address"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.number_address"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.number_address }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Complem"
                          v-model="form.complement_address"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.complement_address"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.complement_address }}
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-[6]">
                        <TextInput
                          textLabel="Bairro"
                          v-model="form.region"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.region" class="mt-2 text-sm text-red-500">
                          {{ form.errors.region }}
                        </div>
                      </div>
                      <div class="flex-[3]">
                        <InputLabel
                          for="city"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Cidade</InputLabel
                        >
                        <select
                          name="city"
                          v-model="form.city_id"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option
                            v-for="(item, index) in cities"
                            :key="item.id"
                            :value="item.id"
                          >
                            {{ item.nome }}
                          </option>
                        </select>
                        <div v-if="form.errors.city_id" class="mt-2 text-sm text-red-500">
                          {{ form.errors.city_id }}
                        </div>
                      </div>
                      <div class="flex-[3]">
                        <InputLabel
                          for="state"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Estado</InputLabel
                        >
                        <select
                          name="state"
                          v-model="form.state_id"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option
                            v-for="(item, index) in states"
                            :key="index"
                            :value="item.id"
                          >
                            {{ item.nome }}
                          </option>
                        </select>
                        <div
                          v-if="form.errors.state_id"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.state_id }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <h2 class="text-[#777] py-4">CONTATOS</h2>
                  <hr />
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-1">
                        <TextInput
                          textLabel="Contato:"
                          v-model="form.accountable_name"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.accountable_name"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.accountable_name }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Email"
                          v-model="form.email"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.email" class="mt-2 text-sm text-red-500">
                          {{ form.errors.email }}
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-1">
                        <TextInput
                          textLabel="telefone"
                          v-model="form.phone"
                          type="text"
                          mask="(XX)XXXXX-XXXX"
                        ></TextInput>
                        <div v-if="form.errors.phone" class="mt-2 text-sm text-red-500">
                          {{ form.errors.phone }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Celular"
                          v-model="form.cellphone"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.cellphone"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.cellphone }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Site"
                          v-model="form.site"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.site" class="mt-2 text-sm text-red-500">
                          {{ form.errors.site }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Rede Social"
                          v-model="form.social_network"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.social_network"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.social_network }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <h2 class="text-[#777] py-4">DADOS BANCÁRIOS</h2>
                  <hr />
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-1">
                        <TextInput
                          textLabel="Baco:"
                          v-model="form.bank"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.bank" class="mt-2 text-sm text-red-500">
                          {{ form.errors.bank }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Agência"
                          v-model="form.agency"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.agency" class="mt-2 text-sm text-red-500">
                          {{ form.errors.agency }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Número de Conta"
                          v-model="form.account_number"
                          type="text"
                        ></TextInput>
                        <div
                          v-if="form.errors.account_number"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.account_number }}
                        </div>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Chave pix"
                          v-model="form.pix_key"
                          type="text"
                        ></TextInput>
                        <div v-if="form.errors.pix_key" class="mt-2 text-sm text-red-500">
                          {{ form.errors.pix_key }}
                        </div>
                      </div>
                      <div class="flex-[2]"></div>
                    </div>
                  </div>
                </div>
                <div>
                  <h2 class="text-[#777] py-4">DADOS BANCÁRIOS</h2>
                  <hr />
                  <div class="flex flex-col gap-3">
                    <div class="flex flex-row flex-wrap gap-3 pt-2">
                      <div class="flex-1">
                        <InputLabel
                          for="type"
                          class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                          >Consultor(a):</InputLabel
                        >
                        <select
                          name="type"
                          v-model="form.consultant"
                          class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                        >
                          <option value="Julia">Julia</option>
                          <option value="John">John</option>
                        </select>
                        <div
                          v-if="form.errors.consultant"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.consultant }}
                        </div>
                      </div>

                      <div class="flex-[3]"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-1 pt-6 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="space-x-2 sm:col-span-4">
                <Button
                  variant="primary"
                  type="submit"
                  class=""
                  :disabled="form.processing"
                  :class="{ 'opacity-25': form.processing }"
                >
                  SALVAR
                </Button>
                <ButtonLink variant="default" class="" value="/especificadores"
                  >VOLTAR
                </ButtonLink>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="flex justify-end mt-2"></div>
    </div>
  </AuthenticatedLayout>
</template>
