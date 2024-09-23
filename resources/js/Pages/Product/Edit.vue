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
  manufacturers: {
    type: Object,
  },
  suppliers: {
    type: Object,
  },
  solutions: {
    type: Object,
  },
});

const form = useForm({
  name: props.product.name,
  supplier_code: props.product.supplier_code,
  solution_id: props.product.solution_id,
  manufacturer_id: props.product.manufacturer_id,
  supplier_id: props.product.supplier_id,
  item: props.product.item,
  color: props.product.color,
  cost: props.product.cost,
  size: props.product.size,
  NCM: props.product.NCM,
  CFOP: props.product.CFOP,
  discount: props.product.discount,
  ST: props.product.ST,
  IPI: props.product.IPI,
  freight: props.product.freight,
  markup: props.product.markup,
  price: props.product.price,
  observation: props.product.observation,
  id: props.product.id,
});
function updateProduct() {
  form.post(route("product.update"));
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
                <div class="grid grid-cols-4 gap-3 mt-3">
                  <div class="grid grid-cols-1 col-span-1 gap-3">
                    <div>
                      <TextInput
                        textLabel="Cod. Fornecedor"
                        type="text"
                        v-model="form.supplier_code"
                        name="supplier_code"
                        class="w-full"
                        placeholder=""
                      />
                      <div
                        v-if="form.errors.supplier_code"
                        class="mt-2 text-sm text-red-500"
                      >
                        {{ form.errors.supplier_code }}
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
                        v-model="form.manufacturer_id"
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                      >
                        <option value="">Selecione</option>
                        <option
                          v-for="(item, index) in manufacturers"
                          :key="item.id"
                          :value="item.id"
                        >
                          {{ item.name }}
                        </option>
                      </select>
                      <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                        {{ form.errors.name }}
                      </div>
                    </div>
                    <div>
                      <TextInput
                        textLabel="Cor"
                        type="text"
                        v-model="form.color"
                        name="name"
                        class="w-full"
                        placeholder=""
                      />
                      <div v-if="form.errors.color" class="mt-2 text-sm text-red-500">
                        {{ form.errors.color }}
                      </div>
                    </div>
                    <div>
                      <TextInput
                        textLabel="Custo"
                        type="number"
                        v-model="form.cost"
                        name="name"
                        class="w-full"
                        placeholder=""
                      />
                      <div v-if="form.errors.cost" class="mt-2 text-sm text-red-500">
                        {{ form.errors.cost }}
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
                        for="fornecedor"
                        class="block mb-2 text-sm font-mecold dium text-slate-600 dark:text-slate-300"
                        >Fornecedor</InputLabel
                      >
                      <select
                        v-model="form.supplier_id"
                        name="fornecedor"
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                      >
                        <option value="">Selecione</option>
                        <option
                          v-for="(item, index) in suppliers"
                          :key="item.id"
                          :value="item.id"
                        >
                          {{ item.name }}
                        </option>
                      </select>
                      <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                        {{ form.errors.name }}
                      </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                      <div>
                        <TextInput
                          textLabel="Tamanho"
                          type="text"
                          v-model="form.size"
                          name="size"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.size" class="mt-2 text-sm text-red-500">
                          {{ form.errors.size }}
                        </div>
                      </div>
                      <div>
                        <TextInput
                          textLabel="NCM"
                          type="text"
                          v-model="form.NCM"
                          name="NCM"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.NCM" class="mt-2 text-sm text-red-500">
                          {{ form.errors.NCM }}
                        </div>
                      </div>
                    </div>
                    <div class="grid grid-cols-6 gap-5">
                      <div class="col-span-1">
                        <TextInput
                          textLabel="Desc.:"
                          type="number"
                          v-model="form.discount"
                          name="discount"
                          class="w-full"
                          placeholder=""
                        />
                        <div
                          v-if="form.errors.discount"
                          class="mt-2 text-sm text-red-500"
                        >
                          {{ form.errors.discount }}
                        </div>
                      </div>
                      <div cclass=" col-span-1">
                        <TextInput
                          textLabel="ST(%):"
                          type="number"
                          v-model="form.ST"
                          name="ST"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.ST" class="mt-2 text-sm text-red-500">
                          {{ form.errors.ST }}
                        </div>
                      </div>
                      <div class="col-span-1">
                        <TextInput
                          textLabel="IPI(%):"
                          type="number"
                          v-model="form.IPI"
                          name="IPI"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.IPI" class="mt-2 text-sm text-red-500">
                          {{ form.errors.IPI }}
                        </div>
                      </div>
                      <div class="col-span-1">
                        <TextInput
                          textLabel="Frete(%):"
                          type="number"
                          v-model="form.freight"
                          name="freight"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.freight" class="mt-2 text-sm text-red-500">
                          {{ form.errors.freight }}
                        </div>
                      </div>
                      <div class="col-span-2">
                        <TextInput
                          textLabel="Markup"
                          type="number"
                          v-model="form.markup"
                          name="name"
                          class="w-full"
                          placeholder=""
                        />
                        <div v-if="form.errors.markup" class="mt-2 text-sm text-red-500">
                          {{ form.errors.markup }}
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
                        v-model="form.solution_id"
                        name="solução"
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                      >
                        <option value="">Selecione</option>
                        <option
                          v-for="(item, index) in solutions"
                          :key="item.id"
                          :value="item.id"
                        >
                          {{ item.name }}
                        </option>
                      </select>
                      <div
                        v-if="form.errors.solution_id"
                        class="mt-2 text-sm text-red-500"
                      >
                        {{ form.errors.solution_id }}
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
                        v-model="form.item"
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-indigo-500"
                      >
                        <option value="">Selecione</option>
                        <option value="111">111</option>
                        <option value="222">222</option>
                      </select>
                      <div v-if="form.errors.item" class="mt-2 text-sm text-red-500">
                        {{ form.errors.item }}
                      </div>
                    </div>
                    <div>
                      <TextInput
                        textLabel="CFOP:"
                        type="text"
                        v-model="form.CFOP"
                        name="name"
                        class="w-full"
                        placeholder=""
                      />
                      <div v-if="form.errors.CFOP" class="mt-2 text-sm text-red-500">
                        {{ form.errors.CFOP }}
                      </div>
                    </div>
                    <div>
                      <TextInput
                        textLabel="Preço:"
                        type="number"
                        v-model="form.price"
                        name="name"
                        class="w-full"
                        placeholder=""
                      />
                      <div v-if="form.errors.price" class="mt-2 text-sm text-red-500">
                        {{ form.errors.price }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="w-full">
                  <textarea class="w-full" v-model="form.observation"></textarea>
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
