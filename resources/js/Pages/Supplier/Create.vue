<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import TextInput from "@/Components/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 2, name: "Fornecedor", url: "/fornecedor" },
});

const props = defineProps({ cities: Object, states: Object });

const form = useForm({
  name: null,
  fantasy_name: null,
  document: null,
  ie: null,
  zip_code: null,
  address: null,
  number_address: null,
  complement_address: null,
  region: null,
  city_id: null,
  state_id: null,
  accountable_name: null,
  phone: null,
  cellphone: null,
  email: null,
  site: null,
});

function store() {
  form.post("/fornecedor");
}
</script>

<template>
  <Head title="Fornecedor" />

  <AuthenticatedLayout>
    <div class="pt-4 max-w-7xl mx-auto sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="store">
            <div class="border-b border-slate-900/10 pb-12">
              <section>
                <h2 class="text-base font-semibold leading-7 text-sky-900">
                  DADOS CADASTRAIS
                </h2>
                <hr class="my-3" />
                <div class="mt-3 grid sm:grid-cols-2 gap-2">
                  <div>
                    <TextInput
                      textLabel="Razão Social"
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
                  <div>
                    <TextInput
                      textLabel="Nome Fantasia"
                      type="text"
                      v-model="form.fantasy_name"
                      name="fantasy_name"
                      class="w-full"
                      placeholder=""
                    />
                    <div
                      v-if="form.errors.fantasy_name"
                      class="text-sm text-red-500 mt-2"
                    >
                      {{ form.errors.fantasy_name }}
                    </div>
                  </div>
                  <div>
                    <TextInput
                      textLabel="CNPJ"
                      type="text"
                      v-model="form.document"
                      name="document"
                      class="w-full"
                      mask="XX.XXX.XXX/XXXX-XX"
                      placeholder=""
                    />
                    <div v-if="form.errors.document" class="text-sm text-red-500 mt-2">
                      {{ form.errors.document }}
                    </div>
                  </div>
                  <div>
                    <TextInput
                      textLabel="Inscrição Estadual"
                      type="text"
                      v-model="form.ie"
                      name="ie"
                      class="w-full"
                      placeholder=""
                      mask="XXXXXXXXXXXX"
                    />
                    <div v-if="form.errors.ie" class="text-sm text-red-500 mt-2">
                      {{ form.errors.ie }}
                    </div>
                  </div>
                </div>
              </section>
              <section>
                <h2 class="text-base font-semibold leading-7 text-sky-900 mt-5">
                  ENDEREÇO
                </h2>
                <hr class="my-3" />
                <div class="mt-3 grid sm:grid-cols-6 gap-2">
                  <div>
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
                  <div class="sm:col-span-3">
                    <TextInput
                      textLabel="Endereço"
                      type="text"
                      v-model="form.address"
                      name="address"
                      class="w-full"
                      placeholder=""
                    />
                    <div v-if="form.errors.address" class="text-sm text-red-500 mt-2">
                      {{ form.errors.address }}
                    </div>
                  </div>
                  <div>
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
                  <div>
                    <TextInput
                      textLabel="Complemento"
                      type="text"
                      v-model="form.complement_address"
                      name="complement_address"
                      class="w-full"
                      placeholder=""
                    />
                    <div
                      v-if="form.errors.complement_address"
                      class="text-sm text-red-500 mt-2"
                    >
                      {{ form.errors.complement_address }}
                    </div>
                  </div>
                </div>
                <div class="mt-3 grid sm:grid-cols-6 gap-2">
                  <div>
                    <TextInput
                      textLabel="Bairro"
                      type="text"
                      v-model="form.region"
                      name="region"
                      class="w-full"
                      placeholder=""
                    />
                    <div v-if="form.errors.region" class="text-sm text-red-500 mt-2">
                      {{ form.errors.region }}
                    </div>
                  </div>
                  <div class="sm:col-span-3">
                    <Inputlabel
                      for="Estado"
                      class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                      >Cidade
                    </Inputlabel>
                    <select
                      v-model="form.city_id"
                      name="state"
                      class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                    >
                      <option :value="null">Selecione</option>
                      <option v-for="city in cities" :key="city.id" :value="`${city.id}`">
                        {{ city.nome }}
                      </option>
                    </select>
                    <div v-if="form.errors.city_id" class="text-sm text-red-600">
                      {{ form.errors.city_id }}
                    </div>
                  </div>
                  <div class="sm:col-span-2">
                    <Inputlabel
                      for="Estado"
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
                    <div v-if="form.errors.state_id" class="text-sm text-red-600">
                      {{ form.errors.state_id }}
                    </div>
                  </div>
                </div>
              </section>
              <section>
                <h2 class="text-base font-semibold leading-7 text-sky-900 mt-5">
                  CONTATOS
                </h2>
                <hr class="my-3" />
                <div class="mt-3 grid sm:grid-cols-2 gap-2">
                  <div>
                    <TextInput
                      textLabel="Contato"
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
                  <div>
                    <TextInput
                      textLabel="Email"
                      type="text"
                      v-model="form.email"
                      name="email"
                      class="w-full"
                      placeholder=""
                    />
                    <div v-if="form.errors.email" class="text-sm text-red-500 mt-2">
                      {{ form.errors.email }}
                    </div>
                  </div>
                </div>
                <div class="mt-3 grid sm:grid-cols-12 gap-2">
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
                  <div class="sm:col-span-6">
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
                </div>
              </section>
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
                <ButtonLink variant="default" class="" value="/fornecedor"
                  >VOLTAR
                </ButtonLink>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
