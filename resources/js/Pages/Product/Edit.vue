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
  link: { id: 1, name: "Produto", url: "/produto" },
});
const props = defineProps({
  product: {
    type: Object,
    default: () => ({}),
  },
});

const form = useForm({
  name: props.product.name,
});

function updateProduct() {
  form.put(route("product.update", props.product.id));
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
              <div class="grid grid-cols-4 gap-3 mt-3">
                <div class="grid grid-cols-1 col-span-1 gap-3">
                  <div>
                    <TextInput
                      textLabel="Cod. Fornecedor"
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
                  <div>
                    <InputLabel
                      for="fabricante"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Fabricante</InputLabel
                    >
                    <select
                      name="fabricante"
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option value="">None</option>
                      <option value="">12</option>
                      <option value="">242</option>
                    </select>
                    <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                      {{ form.errors.name }}
                    </div>
                  </div>
                  <div>
                    <TextInput
                      textLabel="Cor"
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
                  <div>
                    <TextInput
                      textLabel="Custo"
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
                </div>
                <div class="grid grid-cols-1 col-span-2 gap-3">
                  <div>
                    <TextInput
                      textLabel="Nome/Descrição"
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
                  <div>
                    <InputLabel
                      for="fabricante"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Fabricante</InputLabel
                    >
                    <select
                      name="fabricante"
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option value="">None</option>
                      <option value="">12</option>
                      <option value="">242</option>
                    </select>
                    <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                      {{ form.errors.name }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <TextInput
                        textLabel="Nome/Descrição"
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
                    <div>
                      <TextInput
                        textLabel="Nome/Descrição"
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
                  </div>
                  <div class="grid grid-cols-6 gap-5">
                    <div class="col-span-1">
                      <TextInput
                        textLabel="Desc.:"
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
                    <div cclass=" col-span-1">
                      <TextInput
                        textLabel="ST(%):"
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
                    <div class="col-span-1">
                      <TextInput
                        textLabel="IPI(%):"
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
                    <div class="col-span-1">
                      <TextInput
                        textLabel="Frete(%):"
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
                    <div class="col-span-2">
                      <TextInput
                        textLabel="Markup"
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
                  </div>
                </div>
                <div class="grid grid-cols-1 col-span-1 gap-3">
                  <div>
                    <InputLabel
                      for="solução"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Solução</InputLabel
                    >
                    <select
                      name="solução"
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option value="">None</option>
                      <option value="">12</option>
                      <option value="">242</option>
                    </select>
                    <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                      {{ form.errors.name }}
                    </div>
                  </div>
                  <div>
                    <InputLabel
                      for="Unid"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Unid.</InputLabel
                    >
                    <select
                      name="Unid."
                      class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                    >
                      <option value="">None</option>
                      <option value="">12</option>
                      <option value="">242</option>
                    </select>
                    <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                      {{ form.errors.name }}
                    </div>
                  </div>
                  <div>
                    <TextInput
                      textLabel="CFOP:"
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
                  <div>
                    <TextInput
                      textLabel="Preço:"
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
                <ButtonLink variant="default" class="" value="/produto"
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
