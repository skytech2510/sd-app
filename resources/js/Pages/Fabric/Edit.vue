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
  link: { id: 2, name: "Tecido", url: "/tecido" },
});
const form = useForm({
  fabric_cod: props.fabric.fabric_cod,
  name: props.fabric.name,
  fabric_width: props.fabric.fabric_width,
  composition: props.fabric.composition,
  colors: props.fabric.colors,
  collection_id: props.fabric.collection_id,
  cost: props.fabric.cost,
  discount: props.fabric.discount,
  ST: props.fabric.ST,
  IPI: props.fabric.IPI,
  shipping: props.fabric.shipping,
  price: props.fabric.price,
});

const props = defineProps({
  fabric: Object,
  collections: Object,
});

const config = {
  thousands: ".",
  decimal: ",",
  precision: 2,
  disableNegative: false,
  disabled: false,
  allowBlank: false,
  minimumNumberOfCharacters: 0,
  shouldRound: false,
  focusOnRight: false,
  modelModifiers: {
    number: true,
  },
};

function update() {
  form.put(route("fabric.update", props.fabric.id));
}

function sum() {
  console.log('ASDASD');
}
</script>

<template>
  <Head title="Tecido" />
  <AuthenticatedLayout>
    <div class="pt-4 max-w-7xl mx-auto sm:px-4 lg:px-6">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="update">
            <div class="border-b border-slate-900/10 pb-12">
              <h2 class="text-base font-semibold leading-7 text-sky-900">TECIDOS</h2>
              <hr class="my-3" />
              <div class="mt-3 grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-2">
                  <TextInput
                    textLabel="Cód. Fornecedor"
                    type="text"
                    v-model="form.fabric_cod"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.fabric_cod" class="text-sm text-red-500 mt-2">
                    {{ form.errors.fabric_cod }}
                  </div>
                </div>
                <div class="sm:col-span-10">
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
                <div class="sm:col-span-2">
                  <TextInput
                    textLabel="Largura"
                    type="text"
                    v-model="form.fabric_width"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.name" class="text-sm text-red-500 mt-2">
                    {{ form.errors.name }}
                  </div>
                </div>
                <div class="sm:col-span-8">
                  <TextInput
                    textLabel="Composição"
                    type="text"
                    v-model="form.composition"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.composition" class="text-sm text-red-500 mt-2">
                    {{ form.errors.composition }}
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <TextInput
                    textLabel="Cor(es)"
                    type="text"
                    v-model="form.colors"
                    name="name"
                    class="w-full"
                    placeholder=""
                  />
                  <div v-if="form.errors.colors" class="text-sm text-red-500 mt-2">
                    {{ form.errors.colors }}
                  </div>
                </div>
              </div>
              <div class="mt-3 grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-12">
                  <Inputlabel
                    for="collection_id"
                    class="block mb-2 text-sm font-mecold dium text-slate-900 dark:text-slate-300"
                    >Coleção
                  </Inputlabel>
                  <select
                    v-model="form.collection_id"
                    name="state"
                    class="border-slate-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm text-sm w-full"
                  >
                    <option :value="null">Selecione</option>
                    <option
                      v-for="collection in collections"
                      :key="collection.id"
                      :value="`${collection.id}`"
                    >
                      {{ collection.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.collection_id" class="text-sm text-red-600">
                    {{ form.errors.collection_id }}
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="cost"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Custo. (%)
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.cost"
                      name="cost"
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.cost" class="text-sm text-red-500 mt-2">
                      {{ form.errors.cost }}
                    </div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="discount"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Desc. (%)
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.discount"
                      name="discount"
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.discount" class="text-sm text-red-500 mt-2">
                      {{ form.errors.discount }}
                    </div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="ST"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >ST (%)
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.ST"
                      name="ST"
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.ST" class="text-sm text-red-500 mt-2">
                      {{ form.errors.ST }}
                    </div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="IPI"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >IPI (%)
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.IPI"
                      name="IPI"
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.IPI" class="text-sm text-red-500 mt-2">
                      {{ form.errors.IPI }}
                    </div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="price"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Frete (%)
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.shipping"
                      name="price"
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.shipping" class="text-sm text-red-500 mt-2">
                      {{ form.errors.shipping }}
                    </div>
                  </div>
                </div>
                <div class="sm:col-span-2">
                  <div>
                    <label
                      for="textLabel"
                      class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                      >Preço
                    </label>
                    <input
                      class="border border-slate-300 px-1.5 py-2 rounded-md focus:outline-none focus:border-sky-500 focus:border-2 focus:ring-sky-500 w-full text-sm text-slate-700 placeholder:text-slate-400"
                      v-model.lazy="form.price"
                      name="price"
                      disabled
                      v-money3="config"
                      placeholder="0,00"
                    />
                    <div v-if="form.errors.price" class="text-sm text-red-500 mt-2">
                      {{ form.errors.price }}
                    </div>
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
                <ButtonLink variant="default" class="" value="/tecido"
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
