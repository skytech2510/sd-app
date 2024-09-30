<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import TextInput from "@/Components/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import InputLabel from "@/Components/InputLabel.vue";

const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 1, name: "Mensagens Rápidas", url: "/messagem-rapida" },
});
const form = useForm({
  name: null,
  manufacturer_id: null,
  price: 0,
  observation: null,
  annotation: null,
});
const props = defineProps({
  manufacturers: Object,
});
function storeMessage() {
  form.post("/optionals/add");
}
</script>
<template>
  <Head title="Messagens Rápidas" />

  <AuthenticatedLayout>
    <div class="pt-4 mx-auto max-w-7xl sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="storeMessage">
              <div class="pb-6 border-b border-slate-900/10">
                <h2 class="text-base font-semibold leading-7 text-sky-900">OPTIONALS</h2>
                <div class="grid grid-cols-1 mt-3">
                  <TextInput
                    textLabel="Nome"
                    type="text"
                    v-model="form.name"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                    {{ form.errors.name }}
                  </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mt-3">
                  <div>
                    <Inputlabel
                      for="Fabricação"
                      class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                      >Fabricação
                    </Inputlabel>
                    <select
                      v-model="manufacturer_id"
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option :value="null">Selecione</option>
                      <option
                        v-for="manufacturer in manufacturers"
                        :key="manufacturer.id"
                        :value="`${manufacturer.id}`"
                      >
                        {{ manufacturer.name }}
                      </option>
                    </select>
                    <div
                      v-if="form.errors.manufacturer_id"
                      class="mt-2 text-sm text-red-500"
                    >
                      {{ form.errors.manufacturer_id }}
                    </div>
                  </div>
                  <div>
                    <Inputlabel
                      for="Fabricação"
                      class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                      >Fabricação
                    </Inputlabel>
                    <select
                      v-model="form.manufacturer_id"
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option :value="null">Selecione</option>
                      <option
                        v-for="manufacturer in manufacturers"
                        :key="manufacturer.id"
                        :value="`${manufacturer.id}`"
                      >
                        {{ manufacturer.name }}
                      </option>
                    </select>
                    <div
                      v-if="form.errors.manufacturer_id"
                      class="mt-2 text-sm text-red-500"
                    >
                      {{ form.errors.manufacturer_id }}
                    </div>
                  </div>
                  <div>
                    <TextInput
                      textLabel="preço"
                      type="number"
                      name="price"
                      v-model="form.price"
                    />
                    <div v-if="form.errors.price" class="mt-2 text-sm text-red-500">
                      {{ form.errors.price }}
                    </div>
                  </div>
                </div>
                <h1 class="text-base font-semibold leading-7 text-sky-900">
                  observações
                </h1>
                <div class="flex flex-col gap-3">
                  <div class="grid grid-cols-1 mt-3">
                    <TextInput
                      textLabel="observações"
                      type="text"
                      v-model="form.observation"
                      name="name"
                      class="w-full"
                      placeholder=""
                    />
                    <div v-if="form.errors.observation" class="mt-2 text-sm text-red-500">
                      {{ form.errors.observation }}
                    </div>
                  </div>
                  <div>
                    <InputLabel>Anotações</InputLabel>
                    <textarea
                      class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                      v-model="form.annotation"
                    ></textarea>
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
                  <ButtonLink variant="default" class="" value="/messagem-rapida"
                    >VOLTAR
                  </ButtonLink>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
