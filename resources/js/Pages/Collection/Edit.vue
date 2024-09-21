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
  link: { id: 2, name: "Coleção", url: "/colecao" },
});

const props = defineProps({
  collection: Object,
  suppliers: Object,
  solutions: Object,
});

const form = useForm({
  name: props.collection.name,
  supplier_id: props.collection.supplier_id,
  solution_id: props.collection.solution_id,
});

function update() {
  form.put(route("collection.update", props.collection.id));
}
</script>

<template>
  <Head title="Coleção" />
  <AuthenticatedLayout>
    <div class="pt-4 max-w-7xl mx-auto sm:px-4 lg:px-6">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="update">
            <div class="border-b border-slate-900/10 pb-12">
              <h2 class="text-base font-semibold leading-7 text-sky-900">
                Informações da Coleção
              </h2>
              <div class="mt-3 grid sm:grid-cols-12 gap-2">
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
                <div class="sm:col-span-6 mb-3">
                  <Inputlabel
                    for="supplier_id"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Fornecedores
                  </Inputlabel>
                  <select
                    v-model="form.supplier_id"
                    name="supplier_id"
                    class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option
                      v-for="supplier in suppliers"
                      :key="supplier.id"
                      :value="`${supplier.id}`"
                    >
                      {{ supplier.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.supplier_id" class="text-sm text-red-600">
                    {{ form.errors.supplier_id }}
                  </div>
                </div>
              </div>
              <div class="sm:col-span-6">
                <Inputlabel
                  for="Estado"
                  class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                  >Solução
                </Inputlabel>
                <select
                  v-model="form.solution_id"
                  name="state"
                  class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                >
                  <option :value="null">Selecione</option>
                  <option
                    v-for="solution in solutions"
                    :key="solution.id"
                    :value="`${solution.id}`"
                  >
                    {{ solution.name }}
                  </option>
                </select>
                <div v-if="form.errors.solution_id" class="text-sm text-red-600">
                  {{ form.errors.solution_id }}
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
                <ButtonLink variant="default" class="" value="/canal">VOLTAR </ButtonLink>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="flex justify-end mt-2"></div>
    </div>
  </AuthenticatedLayout>
</template>
