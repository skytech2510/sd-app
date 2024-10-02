<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "@/Components/Button.vue";
import TextInput from "@/Components/TextInput.vue";
import ButtonLink from "@/Components/ButtonLink.vue";

const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 2, name: "Cliente", url: "/cliente" },
});
const form = useForm({
  name: props.client.name,
  spouse: props.client.spouse,
  person_type: props.client.person_type,
  document: props.client.document,
  extra_document: props.client.extra_document,
  birth_date: props.client.birth_date,
  gender: props.client.gender,
  marital_status: props.client.marital_status,
  zip_code: props.client.zip_code,
  address: props.client.address,
  number_address: props.client.number_address,
  complement_address: props.client.complement_address,
  extra_address: props.client.extra_address,
  region: props.client.region,
  city_id: props.client.city_id,
  state_id: props.client.state_id,
  accountable_name: props.client.accountable_name,
  phone: props.client.phone,
  cellphone: props.client.cellphone,
  email: props.client.email,
  site: props.client.site,
  social_network: props.client.social_network,
});

const props = defineProps({
  client: Object,
  cities: Object,
  states: Object,
});

function update() {
  form.put(route("client.update", props.client.id));
}
</script>

<template>
  <Head title="Cliente" />
  <AuthenticatedLayout>
    <div class="pt-4 max-w-7xl mx-auto sm:px-4 lg:px-6">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="update">
            <div class="border-b border-slate-900/10 pb-12">
              <h2 class="text-base font-semibold leading-7 text-sky-900">
                DADOS CADASTRAIS
              </h2>
              <hr class="my-3" />
              <div class="mt-3 grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-3">
                  <Inputlabel
                    for="stage"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Tipo
                  </Inputlabel>
                  <select
                    v-model="form.person_type"
                    name="person_type"
                    class="border-gray-300 focus:border-blue-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option value="1">Pessoa Física</option>
                    <option value="2">Pessoa Jurídica</option>
                  </select>
                  <div v-if="form.errors.person_type" class="text-sm text-red-600">
                    {{ form.errors.person_type }}
                  </div>
                </div>
                <div class="sm:col-span-6">
                  <TextInput
                    textLabel="Nome"
                    type="text"
                    v-model="form.name"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                    {{ form.errors.name }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Conjuge"
                    type="text"
                    v-model="form.spouse"
                    name="spouse"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.spouse" class="text-sm text-red-500 mt-2">
                    {{ form.errors.spouse }}
                  </div>
                </div>
                <div class="sm:col-span-3" v-if="form.person_type == 1">
                  <TextInput
                    textLabel="CPF"
                    type="text"
                    v-model="form.document"
                    name="document"
                    class="w-full"
                    placeholder=""
                    mask="XXX.XXX.XXX-XX"
                  />
                  <div v-if="form.errors.document" class="text-sm text-red-500 mt-2">
                    {{ form.errors.document }}
                  </div>
                </div>
                <div class="sm:col-span-3" v-if="form.person_type == 2">
                  <TextInput
                    textLabel="CNPJ"
                    type="text"
                    v-model="form.document"
                    name="document"
                    class="w-full"
                    placeholder=""
                    mask="XX.XXX.XXX/XXXX-XX"
                  />
                  <div v-if="form.errors.document" class="text-sm text-red-500 mt-2">
                    {{ form.errors.document }}
                  </div>
                </div>
                <div class="sm:col-span-3" v-if="form.person_type == 1">
                  <TextInput
                    textLabel="RG"
                    type="text"
                    v-model="form.extra_document"
                    name="extra_document"
                    class="w-full"
                    placeholder=""
                    mask="XX.XXX.XXX-X"
                  />
                  <div
                    v-if="form.errors.extra_document"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.extra_document }}
                  </div>
                </div>
                <div class="sm:col-span-3" v-if="form.person_type == 2">
                  <TextInput
                    textLabel="Inscrição Estadual"
                    type="text"
                    v-model="form.extra_document"
                    name="extra_document"
                    class="w-full"
                    placeholder=""
                    mask="XXXXXXXXXXXX"
                  />
                  <div
                    v-if="form.errors.extra_document"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.extra_document }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Data de Nascimento"
                    type="date"
                    v-model="form.birth_date"
                    name="birth_date"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.birth_date" class="text-sm text-red-500 mt-2">
                    {{ form.errors.birth_date }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <Inputlabel
                    for="stage"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Sexo
                  </Inputlabel>
                  <select
                    v-model="form.gender"
                    name="gender"
                    class="border-gray-300 focus:border-blue-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                  </select>
                  <div v-if="form.errors.gender" class="text-sm text-red-600">
                    {{ form.errors.gender }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <Inputlabel
                    for="stage"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Estado Civíl
                  </Inputlabel>
                  <select
                    v-model="form.marital_status"
                    name="marital_status"
                    class="border-gray-300 focus:border-blue-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option value="Casado">Casado</option>
                    <option value="Solteiro">Solteiro</option>
                    <option value="Separado">Separado</option>
                    <option value="Viuvo">Viuvo</option>
                  </select>
                  <div v-if="form.errors.marital_status" class="text-sm text-red-600">
                    {{ form.errors.marital_status }}
                  </div>
                </div>
              </div>
              <h2 class="text-base font-semibold leading-7 text-sky-900 mt-6">
                ENDEREÇO
              </h2>
              <hr class="my-3" />
              <div class="mt-3 grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="CEP"
                    type="text"
                    v-model="form.zip_code"
                    name="zip_code"
                    class="w-full"
                    placeholder=""
                    mask="XXXXX-XXX"
                  />
                  <div v-if="form.errors.zip_code" class="text-sm text-red-500 mt-2">
                    {{ form.errors.zip_code }}
                  </div>
                </div>
                <div class="sm:col-span-5">
                  <TextInput
                    textLabel="Endereço"
                    type="text"
                    v-model="form.address"
                    name="address"
                    class="w-full"
                    placeholder=""
                    mask="XXXXX-XXX"
                  />
                  <div v-if="form.errors.address" class="text-sm text-red-500 mt-2">
                    {{ form.errors.address }}
                  </div>
                </div>
                <div class="sm:col-span-1">
                  <TextInput
                    textLabel="Número"
                    type="text"
                    v-model="form.number_address"
                    name="number_address"
                    class="w-full"
                    placeholder=""
                  />
                  <div
                    v-if="form.errors.number_address"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.number_address }}
                  </div>
                </div>
                <div class="sm:col-span-1">
                  <TextInput
                    textLabel="Complement."
                    type="text"
                    v-model="form.complement_address"
                    name="complement_address"
                    class="w-full"
                    placeholder=""
                    mask="XXXXX-XXX"
                  />
                  <div
                    v-if="form.errors.complement_address"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.complement_address }}
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <TextInput
                    textLabel="Condominio"
                    type="text"
                    v-model="form.extra_address"
                    name="extra_address"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.extra_address" class="text-sm text-red-500 mt-2">
                    {{ form.errors.extra_address }}
                  </div>
                </div>
                <div class="sm:col-span-4">
                  <TextInput
                    textLabel="Bairro"
                    type="text"
                    v-model="form.region"
                    name="region"
                    class="w-full"
                    placeholder=""
                    mask="XXXXX-XXX"
                  />
                  <div v-if="form.errors.region" class="text-sm text-red-500 mt-2">
                    {{ form.errors.region }}
                  </div>
                </div>
                <div class="sm:col-span-4">
                  <Inputlabel
                    for="Cidade"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Cidade
                  </Inputlabel>
                  <select
                    v-model="form.city_id"
                    name="city"
                    class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option v-for="city in cities" :key="city.id" :value="`${city.id}`">
                      {{ city.nome }}
                    </option>
                  </select>
                  <div v-if="form.errors.city" class="text-sm text-red-600">
                    {{ form.errors.city }}
                  </div>
                </div>
                <div class="sm:col-span-4">
                  <Inputlabel
                    for="state"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Estado
                  </Inputlabel>
                  <select
                    v-model="form.state_id"
                    name="state"
                    class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option
                      v-for="state in states"
                      :key="state.id"
                      :value="`${state.id}`"
                    >
                      {{ state.nome }}
                    </option>
                  </select>
                  <div v-if="form.errors.state" class="text-sm text-red-600">
                    {{ form.errors.state }}
                  </div>
                </div>
              </div>
              <h2 class="text-base font-semibold leading-7 text-sky-900 mt-6">CONTATO</h2>
              <hr class="my-3" />
              <div class="mt-3 grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-6">
                  <TextInput
                    textLabel="Responsável"
                    type="text"
                    v-model="form.accountable_name"
                    name="accountable_name"
                    class="w-full"
                    placeholder=""
                  />
                  <div
                    v-if="form.errors.accountable_name"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.accountable_name }}
                  </div>
                </div>
                <div class="sm:col-span-6">
                  <TextInput
                    textLabel="Email"
                    type="email"
                    v-model="form.email"
                    name="email"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.email" class="text-sm text-red-500 mt-2">
                    {{ form.errors.email }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Telefone"
                    type="text"
                    v-model="form.phone"
                    name="phone"
                    class="w-full"
                    placeholder=""
                    mask="(XX) XXXXX-XXXX"
                  />
                  <div v-if="form.errors.phone" class="text-sm text-red-500 mt-2">
                    {{ form.errors.phone }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Celular"
                    type="text"
                    v-model="form.cellphone"
                    name="cellphone"
                    class="w-full"
                    placeholder=""
                    mask="(XX) XXXXX-XXXX"
                  />
                  <div v-if="form.errors.cellphone" class="text-sm text-red-500 mt-2">
                    {{ form.errors.cellphone }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Site"
                    type="text"
                    v-model="form.site"
                    name="site"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.site" class="text-sm text-red-500 mt-2">
                    {{ form.errors.site }}
                  </div>
                </div>
                <div class="sm:col-span-3">
                  <TextInput
                    textLabel="Rede Social"
                    type="text"
                    v-model="form.social_network"
                    name="social_network"
                    class="w-full"
                    placeholder=""
                  />
                  <div
                    v-if="form.errors.social_network"
                    class="text-sm text-red-500 mt-2"
                  >
                    {{ form.errors.social_network }}
                  </div>
                </div>
              </div>
            </div>
            <div class="pt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="sm:col-span-4 space-x-2">
                <Button
                  variant="primary"
                  type="submit"
                  class=""
                  :disabled="form.processing"
                  :class="{ 'opacity-25': form.processing }"
                >
                  SALVAR
                </Button>
                <ButtonLink variant="default" class="" value="/cliente"
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
